<?php
/*

@package mkt-recipe-plugin

     ======================================================================
          Extra funtcions to make the RecipeCPTController more readable
     ======================================================================
*
*
*/
namespace Inc\Base;

/**
 * Enqueue - Enqueue the scripts and style files
*/
class RecipeCPTFunctions extends BaseController
{
     public function getThisPostId ( $post_id )
     {

          if (isset ( $_POST['post_type'] ))
          {
               $post_type = $_POST['post_type'];
          }
          else
          {
               $post_type = get_post_type( $post_id );
          }
          return ( $post_type );
     }
     public function save_meta_box_authorization( $post_type , $post_id )
     {
          /**/

          /* We check if Wordpress is doing an autosave we interrupt the script */

          if ( ! ( isset ( $_POST ) ) || ( count ( $_POST ) == 0 ) )
          {
               return ( false );
          }
          if ( defined ('DOING_AUTOSAVE') && DOING_AUTOSAVE)
          {
               error_log (__FUNCTION__ . ' - ' . __LINE__) . '<pre>';
               error_log (print_r ( DOING_AUTOSAVE , true));
               error_log ('<br>----------------------------</pre>');
               return ( false );
          }
          if ( ! ( isset( $_POST['mtk_'.$post_type.'_nonce'] ) && wp_verify_nonce( $_POST['mtk_'.$post_type.'_nonce'], 'mtk_'.$post_type.'_nonce_' . $post_id ) ))
          {
               /**/
               /* If the another post is saved, not the testimonial type then we just return the post id*/
               echo (__FUNCTION__ . ' - ' . __LINE__) . '<pre>';
               print_r ( 'mtk_'.$post_type.'_nonce - not found');
               print_r ( $_POST );
               echo ('<br>----------------------------</pre>');
               return ( false );
          }
          /* Check it the user has the ability to edit the post */
          if ( ! ( current_user_can ( 'edit_post' , $post_id ) ) )
          {
               error_log (__FUNCTION__ . ' - ' . __LINE__) . '<pre>';
               error_log (print_r ( 'user Cant edit' , true));
               echo ('<br>----------------------------</pre>');
               return ( false );
          }
          return true;
     }
     public function orderForSaveMeta ( $index )
     {    $data = [];
          if (isset ($_POST[$index]))
          {
               foreach ($_POST[$index] as $i => $value)
               {
                    if ( is_array ($value) )
                    {
                         foreach ($value as $j => $SubValue)
                         {
                              if ( is_array ($SubValue) )
                              {
                                   foreach ($SubValue as $k => $SubSubValue)
                                   {
                                        if ( is_array ($SubSubValue) )
                                        {
                                             foreach ($SubSubValue as $l => $SubSubSubValue)
                                             {
                                                  if ( sanitize_text_field( $SubSubSubValue ) != '' )
                                                  {
                                                       $data[$i][$j][$k][$l] = sanitize_text_field( $SubSubSubValue );
                                                  }

                                             }
                                        }
                                        else
                                        {
                                             if ( sanitize_text_field( $SubSubValue ) != '' )
                                             {
                                                  $data[$i][$j][$k] = sanitize_text_field( $SubSubValue );
                                             }


                                        }
                                   }
                              }
                              else
                              {
                                   if ( sanitize_text_field( $SubValue ) != '' )
                                   {
                                        $data[$i][$j] = sanitize_text_field( $SubValue );
                                   }

                              }
                         }
                    }
                    else
                    {
                         if ( sanitize_text_field( $value ) != '' )
                         {
                              $data[$i] = sanitize_text_field( $value );
                         }

                    }
               }
          }

          return ( $data );
     }
     public function addIdExtension ( $post_type , $id , $PreviousData='' )
     {
          $i = 0;
          $foundMetas = true;
          unset ($id_value);
          $id_value[0] = $id . '_0';
          while ( $foundMetas )
          {
               /* We are going to use multiple metaboxes for each */
               if ( $PreviousData == '' )
               {
                    unset ($data);
                    $data  = get_post_meta ( get_the_ID() , '_mtk_' . $post_type . '_'.$id . '_'. $i , true );
                    if ( is_array ( $data ) )
                    {
                         $id_value[$i] = $id . '_'. $i;
                         $i ++;
                    }
                    else
                    {
                         $foundMetas = false;
                    }
               }
               else
               {
                    if ( isset ( $PreviousData[$id . '_'. $i] ) )
                    {
                         $id_value[$i] = $id . '_'. $i;
                         $i ++;
                    }
                    else
                    {
                         $foundMetas = false;
                    }
               }


          }
          return ( $id_value );
     }
     public function removeIdExtension ( $id )
     {
          /* Look for the index */
          $timesFound = substr_count ( $id , '_' );
          $simpleId = $id;
          for ( $i = 0 ; $i< $timesFound ; $i++ )
          {

               /* If there is no ordered we see if it is because we altered the id */
               if (strpos($id,"_") > -1)
               {
                    $simpleId = substr( $simpleId , strpos($simpleId , "_")+1 , strlen($simpleId) - strpos($simpleId , "_") );
               }
          }
          if ( is_numeric ($simpleId) )
          {
               /* now that we have the index, we remove it from the id */
               $simpleId = str_replace ( '_'.$simpleId , "" , $id );
               return ( $simpleId );
          }
          else
          {
               return ( $id );
          }


     }
     public function filterMetadata ($fieldId , $data )
     {

          // $values = '';
          if ( is_array ( $data ) )
          {
               $values = [];
               foreach ( $data as $index => $SingleValue)
               {

                    if ($this->removeIdExtension ( $index ) === $fieldId)
                    {
                         /* Remove the extension and compare to the FieldId */
                         // echo (__FUNCTION__ . ' - ' . __LINE__ . '<br><pre>');
                         // var_dump ( $index );
                         // var_dump ( $this->removeIdExtension ( $index ) );
                         // var_dump ( $fieldId );
                         // echo ('<pre>');
                         $indexExt = str_replace ( $fieldId . '_' , "" , $index );
                         // echo ('line 198 - <pre><br>' .$fieldId . ' - ' .$index. '<br>');
                         // print_r ($data);
                         // echo ('<pre>');
                         $values[$index] = $data[$index];
                    }
               }

          }
          else
          {
               $values = '';
          }
          return ( $values );
     }
     public function createFieldName ( $post_type , $parent_id, $thisId )
     {
          /* Add the gerarchy */

          if ( strpos ( $parent_id ,"mtk_") > -1 )
          {
               $fieldName = $parent_id;
          }
          else
          {
               $fieldName = 'mtk_' . $post_type;
               if ( is_array ( $parent_id ) )
               {
                    foreach ($parent_id as $key => $value)
                    {
                         $fieldName .= '['.$value.']';
                    }
               }
               else if ($parent_id != '')
               {
                    $fieldName .= '['.$parent_id.']';
               }
          }


          /* add the id of this field */
          $fieldName .= '['. $thisId.']';
          return ( $fieldName );
     }
     public function add_remove_buttons(  $fieldName  )
     {
          $textForId = $fieldName.'[addButton]';
          $textForId = str_replace( "[" , "-" , $textForId );
          $textForId = str_replace( "]" , "-" , $textForId );
          echo ('<span class="dashicons dashicons-plus-alt add-substract-button addButton" id="'.$textForId.'" ></span>');

          $textForId = $fieldName.'[removeButton]';
          $textForId = str_replace( "[" , "-" , $textForId );
          $textForId = str_replace( "]" , "-" , $textForId );
          echo ('<span class="dashicons dashicons-dismiss add-substract-button removeButton" id="'.$textForId.'" ></span>');

     }

     /* We create the fields depending on the field type */
     public function SetSectionsFields ( $post_type , $value , $parent_id , $data)
     {
          // error_log (__FUNCTION__ . ' - ' . __LINE__);
          // error_log ( print_r ( $values , true ) );
          // error_log ('----------------------------');
     }
     public function SetSubSectionFields ( $post_type , $value , $parent_id , $data)
     {
          /* --------------------------  Definition of Variables -------------------------- */
          // $post_type - The type of post that we are working ok
          // $values - the array that contains the ID / Name / Type / Parent / Show_in_columns / add_remove_buttons
          // $parent_id - The id of the parent $parent_id - general_o
          // $data - is the information previously stored
          /* ------------------------------------------------------------------------------ */

          if ( ( count ( $value ) == 1 ) && ( isset ( $value['field-info'] ) ) )
          {
               /* Means we only heve one item */
               echo (__FUNCTION__ . ' - ' . __LINE__ . '<br><pre>');
               var_dump ($value);
               echo ('we have a section with no kids');

          }
          if ( isset ( $value['field-info'] ) )
          {
               /* Get the extended id's */
               $ExtendedId = $this->addIdExtension ( $post_type , $value['field-info']['ID'] , $data );
               /* we add a div for the section */
               /* for each sub section we add a div */

               foreach ( $ExtendedId as $i => $ExtendedIdValue )
               {

                    $fieldName = $this->createFieldName ( $post_type , $parent_id, $ExtendedIdValue );

                    $textForId = $fieldName.'[main_div]';
                    $textForId = str_replace( "[" , "-" , $textForId );
                    $textForId = str_replace( "]" , "-" , $textForId );
                    echo ('<div class="'.$value['field-info']['Type'].'_main_div '.$value['field-info']['ID'].'_main_div"  id="'.$textForId.'">');
                    $textForId = $fieldName.'[title_div]';
                    $textForId = str_replace( "[" , "-" , $textForId );
                    $textForId = str_replace( "]" , "-" , $textForId );
                    echo ('<div class="'.$value['field-info']['Type'].'_title_div '.$value['field-info']['ID'].'_title_div" id="'.$textForId.'">');
                    /* add the title  */
                    echo ('<h3 class="'.$value['field-info']['Type'].'_title_h3"><span>');
                    echo ( $value['field-info']['Name'] );
                    echo ('</span>');
                    /*Create the varibles to be used in the fields */
                    $className = "";
                    $id = "";
                    if ( isset ( ( $value['field-info']['add_remove_buttons'] ) ) && ( $value['field-info']['add_remove_buttons'] ) )
                    {
                         $this->add_remove_buttons( $fieldName );

                    }
                    /* add remove buttons if needed */
                    echo ('</h3>');
                    echo ('</div><!-- title_div -->');
                    /* add the content   */
                    $textForId = $fieldName.'[content_div]';
                    $textForId = str_replace( "[" , "-" , $textForId );
                    $textForId = str_replace( "]" , "-" , $textForId );
                    echo ('<div class="'.$value['field-info']['Type'].'_content_div '.$value['field-info']['ID'].'_content_div" id="'. $textForId .'">');

                    /* add the kids */

                    foreach ( $value as $kidsId => $kidsFields )
                    {
                         if ($kidsId != 'field-info')
                         {
                              /* Generate the kids fields */
                              /* Type? */
                              if ( isset ( $kidsFields['field-info'] ) )
                              {
                                   if ( $kidsFields['field-info']['Type'] == 'Item')
                                   {
                                        // echo ('<br>' . __FUNCTION__ . ' - ' . __LINE__) . '<pre>';
                                        // echo ('<br> ' . $ExtendedIdValue . ' <br>');
                                        // print_r ( $data);
                                        if ( isset ( $data[$ExtendedIdValue] ) )
                                        {
                                             $kidsData = $this->filterMetadata( $kidsId , $data[$ExtendedIdValue] );
                                        }
                                        else
                                        {
                                             $kidsData = [];
                                        }
                                        // echo ('<br>' . __FUNCTION__ . ' - ' . __LINE__) . '<pre>';
                                        // echo ('<br> ' . $kidsId . ' <br>');
                                        // print_r ( $kidsData);
                                        $this->SetItemFields ( $post_type , $kidsFields , $fieldName , $kidsData);
                                   }

                              }
                              else
                              {

                              }
                         }
                         else
                         {


                         }
                    }

                    echo ('</div><!-- content_div -->');
                    echo ('</div><!-- main_div -->');
                    // echo ('<br>value - ');
                    // var_dump ($value);
                    // echo ('<br>parent_id - ');
                    // var_dump ($parent_id);
                    // echo ('<br>data - ');
                    // var_dump ($data);
                    // echo ('</pre>');

               }

          }

     }
     public function SetItemFields ( $post_type , $value , $parent_id , $data, $table=false)
     {
          /* --------------------------  Definition of Variables -------------------------- */
          // $post_type - The type of post that we are working ok
          // $values - the array that contains the ID / Name / Type / Parent / Show_in_columns / add_remove_buttons
          // $parent_id - The id of the parent $parent_id - general_o
          // $data - is the information previously stored
          /* ------------------------------------------------------------------------------ */

          /* Get the extended id's */

          $ExtendedId = $this->addIdExtension ( $post_type , $value['field-info']['ID'] , $data);
          /* we add a div for the section */
          /* for each sub section we add a div */
          // echo ('<pre>');
          // var_dump  ($data);
          // echo ('</pre>');
          // echo ('<pre>');
          // var_dump  ($ExtendedId);
          // echo ('</pre>');
          if ( count ( $value ) > 1 )
          {
               /* add the title  */
               echo ('<h4 class="'.$value['field-info']['Type'].'_title_td '.$value['field-info']['ID'].'_title_td"><span>');
               echo ( $value['field-info']['Name'] );
               echo ('</span></h4>');

               $textForId = $parent_id.'[table]';
               $textForId = str_replace( "[" , "-" , $textForId );
               $textForId = str_replace( "]" , "-" , $textForId );
               /* if we have kids we add the table */
               echo ('<table class="'.$value['field-info']['Type'].'_table '.$value['field-info']['ID'].'_table" id="'.$textForId.'">');
               /* add the column titles */
               echo ('<tr class="'.$value['field-info']['Type'].'_columnTitle_tr '.$value['field-info']['ID'].'_columnTitle_tr">');

               foreach ( $value as $kidsId => $kidsFields )
               {
                    if (isset ($kidsFields['field-info']) )
                    {
                         echo ('<td class="'.$kidsFields['field-info']['Type'].'_columnTitle_td '.$kidsFields['field-info']['ID'].'_columnTitle_td">');
                         echo ($kidsFields['field-info']['Name']);
                         echo ('</td>');
                    }

               }

               echo ('</tr>');
          }
          foreach ( $ExtendedId as $i => $ExtendedIdValue )
          {
               $fieldName = $this->createFieldName ( $post_type , $parent_id, $ExtendedIdValue );


               /* We are at the last item in the chain  */
               if ( count ( $value ) == 1 )
               {
                    if ( isset ( $value['field-info'] ) )
                    {
                         $textForId = $fieldName.'[input_div]';
                         $textForId = str_replace( "[" , "-" , $textForId );
                         $textForId = str_replace( "]" , "-" , $textForId );
                         // echo ($textForId);
                         if ( ! $table )
                         {
                              echo ('<div class="'.$value['field-info']['Type'].'_input_div '.$value['field-info']['ID'].'_input_div" id="'.$textForId.'">');
                         }

                         /* we create a table that holds the subItems */

                              $Fieldvalue = '';
                              if ( ( isset ($data[$ExtendedIdValue]) ) && ($data[$ExtendedIdValue] != ''))
                              {
                                   $Fieldvalue = ' value="' . $data[$ExtendedIdValue] . '" ';
                              }
                              $labelText = $value['field-info']['Name'];
                              $textForId = $fieldName.'[input]';
                              $textForId = str_replace( "[" , "-" , $textForId );
                              $textForId = str_replace( "]" , "-" , $textForId );

                              if ( $table )
                              {
                                   $textForId = $fieldName.'[label_td]';
                                   $textForId = str_replace( "[" , "-" , $textForId );
                                   $textForId = str_replace( "]" , "-" , $textForId );
                                   echo ('<td class="'.$value['field-info']['Type'].'_label_td '.$value['field-info']['ID'].'_label_td" id="'.$textForId.'">');
                              }

                              $textForIdLabel = $fieldName.'[label]';
                              $textForIdLabel = str_replace( "[" , "-" , $textForIdLabel );
                              $textForIdLabel = str_replace( "]" , "-" , $textForIdLabel );

                              $textForIdInput = $fieldName.'[input]';
                              $textForIdInput = str_replace( "[" , "-" , $textForIdInput );
                              $textForIdInput = str_replace( "]" , "-" , $textForIdInput );
                              echo ('<label class="'.$value['field-info']['Type'].'_label '.$value['field-info']['ID'].'_label" id="'.$textForIdLabel.'" for="'.$textForIdInput.'">'.$labelText.': </label>');

                              if ( $table )
                              {
                                   echo ('</td>');
                                   $textForIdTd = $fieldName.'[field_td]';
                                   $textForIdTd = str_replace( "[" , "-" , $textForIdTd );
                                   $textForIdTd = str_replace( "]" , "-" , $textForIdTd );
                                   echo ('<td class="'.$value['field-info']['Type'].'_input_td '.$value['field-info']['ID'].'_input_td" id="'.$textForIdTd.'">');
                              }

                              if ( strpos($value['field-info']['ID'] ,"image_file")  )
                              {
                                   /* <p>
                                        <label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_attr_e( 'Image:', 'mtk_recipe_plugin' ); ?></label>
                                        <input class="widefat image-upload" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="text" value="<?php echo esc_url( $image ); ?>">

                                        <button type="button" class="button button-primary js-image-upload">Select Image</button>
                                   </p> */
                                   echo ('<input id="'.$textForIdInput.'" name="'.$fieldName.'" class="image-upload '.$value['field-info']['Type'].'_input '.$value['field-info']['ID'].'_input " type="text"'. $Fieldvalue .'/>');
                                   echo ('<button type="button" class="button button-primary js-image-upload">Select Image</button>');

                              }
                              else if ( strpos($value['field-info']['ID'] ,"video_file")  )
                              {

                              }
                              else
                              {
                                   echo ('<input id="'.$textForIdInput.'" name="'.$fieldName.'" class="'.$value['field-info']['Type'].'_input '.$value['field-info']['ID'].'_input " type="text"'. $Fieldvalue .'/>');
                              }

                              if ( $table )
                              {
                                   echo ('</td>');
                              }
                              if ( ( isset ( $value['field-info']['add_remove_buttons'] ) ) && ( $value['field-info']['add_remove_buttons'] ) )
                              {
                                   // echo ($fieldName . '<br>');
                                   $this->add_remove_buttons( $fieldName );
                              }
                         if ( ! $table )
                         {
                              // echo ('closing the div<br>');
                              echo ('</div>');
                         }


                    }
               }
               else
               {
                    if ( isset ( $value['field-info'] ) )
                    {
                         /*since it has kids we start by adding a div for the kids */
                         $fieldName = $this->createFieldName ( $post_type , $parent_id, $ExtendedIdValue );
                         $textForId = $fieldName.'[content_div]';
                         $textForId = str_replace( "[" , "-" , $textForId );
                         $textForId = str_replace( "]" , "-" , $textForId );
                         echo ('<tr class="'.$value['field-info']['Type'].'_content_tr '.$value['field-info']['ID'].'_content_tr" id="'.$textForId.'">');
                         /* add subitems */
                         /* we add a table for the subItems */

                         foreach ( $value as $kidsId => $kidsFields )
                         {
                              if ($kidsId != 'field-info')
                              {

                                   /* Generate the kids fields */
                                   /* Type? */
                                   if ( isset ( $kidsFields['field-info'] ) )
                                   {
                                        $textForId = $fieldName.'[SubItem_td]';
                                        $textForId = str_replace( "[" , "-" , $textForId );
                                        $textForId = str_replace( "]" , "-" , $textForId );


                                        if (isset ( $data[$ExtendedIdValue] ))
                                        {
                                             $kidsData = $this->filterMetadata( $kidsId , $data[$ExtendedIdValue] );
                                        }
                                        else
                                        {
                                             $kidsData = [];
                                        }
                                        $this->SetItemFields ( $post_type , $kidsFields , $fieldName , $kidsData , true);


                                   }
                                   else
                                   {

                                   }
                              }
                              else
                              {


                              }
                         }
                         /* Do we add the add remove button? */
                         echo ('<td class="'.$value['field-info']['Type'].'_sub_td '.$value['field-info']['ID'].'_sub_td" id="'.$textForId.'">');
                         if ( isset ( $value['field-info']['add_remove_buttons'] ))
                         {
                              if ( $value['field-info']['add_remove_buttons'] )
                              {

                                   $this->add_remove_buttons( $fieldName );


                              }
                         }
                         echo ('</td>');
                         echo ('</tr><!-- content_div -->');


                    }
               }

          }
          if ( count ( $value ) > 1 )
          {
               /* if we have kids we close the table */
               echo ('</table>');
          }



     }
     public function SetSubItemFields ( $post_type , $value , $parent_id , $data)
     {
          echo ('<br>' . __FUNCTION__ . ' - ' . __LINE__) . '<pre>';
          echo ('<br> $post_type <br>');
          print_r ( $post_type);
          echo ('<br> $value <br>');
          print_r ( $value);
          echo ('<br> $id <br>');
          print_r ( $id);
          echo ('<br> $data <br>');
          print_r ( $data);

          echo ('<br>----------------------------</pre>');

     }
}
