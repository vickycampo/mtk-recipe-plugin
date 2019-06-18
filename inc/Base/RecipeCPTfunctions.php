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
     public function addIdExtension ( $post_type , $id )
     {
          $i = 0;
          $foundMetas = true;
          unset ($id_value);
          $id_value[0] = $id . '_0';
          while ( $foundMetas )
          {
               /* We are going to use multiple metaboxes for each */

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

          $values = '';
          if ( is_array ( $data ) )
          {
               foreach ( $data as $index => $SingleValue)
               {
                    /* Remove the extension and compare to the FieldId */
                    // echo (__FUNCTION__ . ' - ' . __LINE__ . '<br>data - <pre>');
                    // var_dump ( $index );
                    // var_dump ( $this->removeIdExtension ( $index ) );
                    // var_dump ( $fieldId );
                    // echo ('<pre>');
                    if ($this->removeIdExtension ( $index ) === $fieldId)
                    {
                         $indexExt = str_replace ( $fieldId . '_' , "" , $index );
                         $values = $data[$indexExt];
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
          echo ('<span class="dashicons dashicons-plus-alt add-substract-button addButton" id="'.$fieldName.'[addButton]" ></span>');
          echo ('<span class="dashicons dashicons-dismiss add-substract-button removeButton]" id="'.$fieldName.'[removeButton]" ></span>');
          echo ('<br>');
     }
     public function createTextInputField ( $fieldName , $labelText , $Fieldvalue , $Type , $simpleId )
     {
          echo ('<label class="components-base-control__label " for="'.$fieldName.'">'.$labelText.': </label><input id="'.$fieldName.'" name="'.$fieldName.'" class="components-text-control__input '.$Type.'_field '.$simpleId.'_input" type="text"'. $Fieldvalue .'/>');
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
               $ExtendedId = $this->addIdExtension ( $post_type , $value['field-info']['ID'] );
               /* we add a div for the section */
               /* for each sub section we add a div */
               foreach ( $ExtendedId as $i => $ExtendedIdValue )
               {
                    $fieldName = $this->createFieldName ( $post_type , $parent_id, $ExtendedIdValue );
                    echo ('<div class="SubSection_div '.$value['field-info']['ID'].'_div" id="'.$fieldName.'[main_div]">');
                    echo ('<div class="SubSection_title_div" id="'.$fieldName.'[title_div]">');
                    /* add the title  */
                    echo ('<h3 class=""><span>');
                    echo ( $value['field-info']['Name'] );
                    echo ('</span>');
                    /*Create the varibles to be used in the fields */
                    $className = "";
                    $id = "";
                    if ( $value['field-info']['add_remove_buttons'] )
                    {
                         $this->add_remove_buttons( $fieldName );

                    }
                    /* add remove buttons if needed */
                    echo ('</h3>');
                    echo ('</div><!-- title_div -->');
                    /* add the content   */
                    echo ('<div class="SubSection_content_div '.$value['field-info']['ID'].'_content_div" id="'.$fieldName.'[content_div]">');

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
                                        $kidsData = $this->filterMetadata( $kidsId , $data );
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
     public function SetItemFields ( $post_type , $value , $parent_id , $data)
     {
          /* --------------------------  Definition of Variables -------------------------- */
          // $post_type - The type of post that we are working ok
          // $values - the array that contains the ID / Name / Type / Parent / Show_in_columns / add_remove_buttons
          // $parent_id - The id of the parent $parent_id - general_o
          // $data - is the information previously stored
          /* ------------------------------------------------------------------------------ */

          /* Get the extended id's */
          $ExtendedId = $this->addIdExtension ( $post_type , $value['field-info']['ID'] );
          /* we add a div for the section */
          /* for each sub section we add a div */
          foreach ( $ExtendedId as $i => $ExtendedIdValue )
          {

               /* We are at the last item in the chain  */
               if ( count ( $value ) == 1 )
               {
                    if ( isset ( $value['field-info'] ) )
                    {
                         $fieldName = $this->createFieldName ( $post_type , $parent_id, $ExtendedIdValue );
                         $Fieldvalue = '';
                         if ( ( isset ($data[$ExtendedIdValue]) ) && ($data[$ExtendedIdValue] != ''))
                         {
                              $Fieldvalue = ' value="' . $data . '" ';
                         }
                         $labelText = $value['field-info']['Name'];

                         $this->createTextInputField ( $fieldName , $labelText , $Fieldvalue , $value['field-info']['Type']  , $value['field-info']['ID'] );

                         if ( $value['field-info']['add_remove_buttons'] )
                         {
                              $this->add_remove_buttons( $fieldName );

                         }
                    }
               }
               else
               {
                    // echo ('<br>value - <pre>');
                    // print_r ($value);
                    // echo ('<pre>');
                    if ( isset ( $value['field-info'] ) )
                    {
                         /*since it has kids we start by adding a div for the kids */
                         $fieldName = $this->createFieldName ( $post_type , $parent_id, $ExtendedIdValue );
                         echo ('<div class="Item_div '.$value['field-info']['ID'].'_main_div" id="'.$fieldName.'[main_div]">');
                              echo ('<div class="Item_title_div '.$value['field-info']['ID'].'_title_div" id="'.$fieldName.'_title_div">');
                              /* add the title  */
                              echo ('<h4 class=""><span>');
                              echo ( $value['field-info']['Name'] );
                              echo ('</span></h4>');
                              echo ('</div><!-- Item_title_div -->');
                              echo ('<div class="Item_div '.$value['field-info']['ID'].'_content_div" id="'.$fieldName.'[content_div]">');
                              /* add subitems */
                              foreach ( $value as $kidsId => $kidsFields )
                              {
                                   if ($kidsId != 'field-info')
                                   {

                                        /* Generate the kids fields */
                                        /* Type? */
                                        if ( isset ( $kidsFields['field-info'] ) )
                                        {
                                             echo ('<div class="SubItem '.$value['field-info']['Type'].'_single  '.$value['field-info']['ID'].'">');
                                             $kidsData = $this->filterMetadata( $kidsId , $data );
                                             $this->SetItemFields ( $post_type , $kidsFields , $fieldName , $kidsData);
                                             echo ('</div><!-- SubItem -->');
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
                              if ( $value['field-info']['add_remove_buttons'] )
                              {

                                   $this->add_remove_buttons( $fieldName );


                              }
                              echo ('</div><!-- content_div -->');
                         echo ('</div><!-- main_div -->');

                    }
               }
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
