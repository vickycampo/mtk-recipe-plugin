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
          if ( ! ( isset( $_POST['mtk_'.$post_type.'_nonce'] ) && wp_verify_nonce( $_POST['mtk_'.$post_type.'_nonce'], 'mtk_'.$post_type.'_nonce_' . $post_id ) ))
          {
               /**/
               /* If the another post is saved, not the testimonial type then we just return the post id*/
               echo (__FUNCTION__ . ' - ' . __LINE__) . '<pre>';
               print_r ( 'mtk_'.$post_type.'_author_nonce - not found');
               echo ('<br>----------------------------</pre>');
               return ( false );
          }
          /* We check if Wordpress is doing an autosave we interrupt the script */
          if ( defined ('DOING_AUTOSAVE') && DOING_AUTOSAVE)
          {
               error_log (__FUNCTION__ . ' - ' . __LINE__) . '<pre>';
               error_log (print_r ( DOING_AUTOSAVE , true));
               error_log ('<br>----------------------------</pre>');
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
     public function createFieldName ( $post_type , $id, $thisId )
     {
          /* Add the gerarchy */
          $fieldName = 'mtk_' . $post_type;
          if ( is_array ( $id ) )
          {
               foreach ($id as $key => $value)
               {
                    $fieldName .= '['.$value.']';
               }
          }
          else
          {
               $fieldName .= '['.$id.']';
          }

          /* add the id of this field */
          $fieldName .= '['. $thisId.']';
          return ( $fieldName );
     }

     /* We create the fields depending on the field type */
     public function SetSectionsFields ( $post_type , $value , $parent_id , $data)
     {
          // error_log (__FUNCTION__ . ' - ' . __LINE__);
          // error_log ( print_r ( $values , true ) );
          // error_log ('----------------------------');
     }
     public function SetSubSectionFields ( $post_type , $value , $parent_id , $data , $multiple)
     {
          if ( ( count ( $value ) == 1 ) && ( isset ( $value['field-info'] ) ) )
          {
               /* Means we only heve one item */
               echo (__FUNCTION__ . ' - ' . __LINE__ . '<br><pre>');
               var_dump ($value);
               echo ('we have a section with no kids');

          }
          else if ( isset ( $value['field-info'] ) )
          {
               /* we add a div for the section */
               /* for each sub section we add a div */
               $fieldName = $this->createFieldName ( $post_type , $parent_id, $value['field-info']['ID'] );
               echo ('<div class="" id="'.$fieldName.'">');
               /* add the title  */
               echo ('<h3 class=""><span>');
               echo ( $value['field-info']['Name'] );
               echo ('</span>');
               /*Create the varibles to be used in the fields */
               $className = "";
               $id = "";
               echo ('<span class="dashicons dashicons-plus-alt add-substract-button _addButton" id="" ></span>');
               echo ('<span class="dashicons dashicons-dismiss add-substract-button _removeButton" id=""></span>');
               /* add remove buttons if needed */
               echo ('</h3>');








               echo ('<h1>ADDING THE SUBSECTION </h1>');
               echo (__FUNCTION__ . ' - ' . __LINE__ . '<br><pre>');
               echo ('<br>post_type - ');
               var_dump ($post_type);
               echo ('<br>value - ');
               var_dump ($value);
               echo ('<br>parent_id - ');
               var_dump ($parent_id);
               echo ('<br>data - ');
               var_dump ($data);
               echo ('</pre>');
               echo ('</div>');
          }

     }
     public function SetItemFields ( $post_type , $value , $parent_id , $data)
     {
          /* We are at the last item in the chain  */
          if ( count ( $value ) == 1 )
          {
               if ( isset ( $value['field-info'] ) )
               {
                    $fieldName = $this->createFieldName ( $post_type , $parent_id, $value['field-info']['ID'] );
                    $Fieldvalue = '';
                    if ($data != '')
                    {
                         $Fieldvalue = ' value="' . $data . '" ';
                    }
                    echo ('<label class="components-base-control__label" for="'.$value['field-info']['ID'].'">'.$value['field-info']['Name'].'</label><input id="'.$value['field-info']['ID'].'" name="'.$fieldName.'" class="components-text-control__input" type="text"'. $Fieldvalue .'/><br>');
               }
          }
          else
          {

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
