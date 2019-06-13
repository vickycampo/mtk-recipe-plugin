<?php
/*

@package mkt-recipe-plugin

     ===================================
          CPT CALLBACKS
     ===================================
*
*
*/
namespace Inc\Api\Callbacks;
use \Inc\Base\BaseController;
/**
*  AdminCallbacks - Manages all the callback functions of the Admin Pages
*/
class CptCallbacks
{
     public $inputArray;
     public function cptSectionManager ()
     {
          echo ("Manage your custom post Types");
     }
     public function createInputArray ()
     {
          /* We create the array with the information we need to fill the selects */
          /* Input type */
               $this->inputArray[] = 'Section';
               $this->inputArray[] = 'SubSection';
               $this->inputArray[] = 'button';
               $this->inputArray[] = 'checkbox';
               $this->inputArray[] = 'button';
               $this->inputArray[] = 'checkbox';
               $this->inputArray[] = 'color';
               $this->inputArray[] = 'date';
               $this->inputArray[] = 'datetime-local';
               $this->inputArray[] = 'email';
               $this->inputArray[] = 'file';
               $this->inputArray[] = 'hidden';
               $this->inputArray[] = 'image';
               $this->inputArray[] = 'month';
               $this->inputArray[] = 'number';
               $this->inputArray[] = 'password';
               $this->inputArray[] = 'radio';
               $this->inputArray[] = 'range';
               $this->inputArray[] = 'reset';
               $this->inputArray[] = 'search';
               $this->inputArray[] = 'submit';
               $this->inputArray[] = 'tel';
               $this->inputArray[] = 'text';
               $this->inputArray[] = 'time';
               $this->inputArray[] = 'url';
               $this->inputArray[] = 'week';
     }
     public function cptSanitize ( $input )
     {

          /* We get the options that are stored in the database */
          $output = get_option ( 'mtk_plugin_cpt' );

          if ( isset ( $_POST['remove'] ) )
          {
               /* we unset the key that we want to remove */
               unset ( $output[$_POST['remove']] );
               return ( $output );
          }

          /* We have to check if the array is empty, if it is we simply add the new cpt */
          if ( count( $output ) == 0 )
          {
               $output[$input['post_type']] = $input;
               return ($output);
          }
          /* The array was not empty we check if the key exists */
          foreach ( $output as $key => $value )
          {
               if ($input['post_type'] === $key)
               {
                    $output[$key] = $input;
               }
               else
               {
                    $output[$input['post_type']] = $input;
               }
          }
          /* Sabe the Custom Fields */
          // error_log('input');
          // error_log(print_r($input, true));
          // var_dump( $output );
          return ( $output );
     }
     public function textField ( $args )
     {
          // var_dump ( $args );
          $name = $args['label_for'];
          $option_name = $args['option_name'];
          $value = '';
          $extra_information = 'required';
          /* populate the values */
          $hiddenField = '';
          if ( isset ( $_POST['edit_post'] ) )
          {
               $input = get_option ( $option_name );
               if ( isset ( $input[$_POST['edit_post']][$name] ) )
               {
                    $value = $input[$_POST['edit_post']][$name];
               }
               else
               {
                    $value = '';
               }


               if ('post_type' === $name)
               {
                    $extra_information = 'disabled';
                    $hiddenField = '<input type="hidden"  name="' . $option_name . '[' . $name . ']" value="' . $value . '">';
               }
          }

          echo (
               '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" ' . $extra_information . '>'
          );
          echo ($hiddenField);
          //return input
     }
     public function checkboxField ( $args )
     {
          /* Wwith the args that we recieve we can generate the check box */

          $name = $args['label_for'];
          $classes = $args['class'];
          $option_name = $args['option_name'];
          $checked = false;
          /* populate the values */
          if ( isset ( $_POST['edit_post'] ) )
          {
               $checkbox = get_option ( $option_name );
               $checked = isset ( $checkbox[$_POST['edit_post']][$name] ) ?: false;
          }


          echo ('<div class="' . $classes . '">
                    <input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']' .  '" value="1" class="' . $classes . '"' . ( $checked ? 'checked' : '' ) . '>
                    <label for="' . $name . '">
                         <div>
                         </div>
                    </label>
               </div>');
     }
     /* Check box for the multiple types of taxonomies that the user can select for the post */
     public function checkboxTaxonomiesField ( $args )
     {
          /* Arrange the values that we got with the args */
          $name          = $args['label_for'];
          $classes       = $args['class'];
          $option_name   = $args['option_name'];
          $checked = false;
          /* populate the values */
          if ( isset ( $_POST['edit_post'] ) )
          {
               $checkbox = get_option ( $option_name );
          }

          /* Wwith the args that we recieve we can generate the check box */
          $output = '';
          /* Get all the post types */
          $taxonomies = get_taxonomies ( array(
               'show_ui' => true
          ) );

          foreach ($taxonomies as $taxonomy)
          {
               /* Check if the value should be checked */
               if ( isset ( $_POST['edit_post'] ) )
               {
                    $checked = isset ( $checkbox[$_POST['edit_post']][$name][$taxonomy] ) ?: false;
               }

               $output .= '<div class="' . $classes . ' mb-10">';
               /*
               <input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']' .  '" value="1" class="' . $classes . '"' . ( $checked ? 'checked' : '' ) . '>
               <label for="' . $name . '">
               */
               $output .= '<input type="checkbox" id="' . $taxonomy . '" name="' . $option_name . '[' . $name . ']['. $taxonomy .']';
               $output .= '" value="1" class="' . $classes . '"' . ( $checked ? 'checked' : '' ) . '>';
               $output .= '<label for="' . $taxonomy . '">';
               $output .= '<div>';
               $output .= '</div>';
               $output .= '</label>';
               $output .= '<strong>'. $taxonomy .'</strong>';
               $output .= '</div>';
          }
          echo ($output);

     }
     public function iconPicker ( $args )
     {
          // var_dump ( $args );
          $name = $args['label_for'];
          $option_name = $args['option_name'];
          $value = '';
          $extra_information = 'required';
          /* populate the values */
          $hiddenField = '';
          if ( isset ( $_POST['edit_post'] ) )
          {
               $input = get_option ( $option_name );
               if ( isset ( $input[$_POST['edit_post']][$name] ) )
               {
                    $value = $input[$_POST['edit_post']][$name];
               }
               else
               {
                    $value = '';
               }
          }

          ?>



          <input type="text" class="regular-text" id="<?php echo ($name);?>" name="<?php echo ( $option_name . '[' . $name . ']' );?>" placeholder="<?php echo ($args['placeholder']);?>" value="<?php echo ($value);?>"/>
          <input class="button dashicons-picker" type="button" value="Choose Icon" data-target="#<?php echo ($name);?>" />
          <?php
     }
     public function customFields ( $args )
     {
          $name = $args['label_for'];
          $option_name = $args['option_name'];
          $value = '';
          $extra_information = 'required';
          $placeholder = $args['placeholder'];

          $field_name = $option_name . '[' . $name . ']';
          /* if is an edit we need to get the previous values */
          /* Check if the value should be checked */

          if ( isset ( $_POST['edit_post'] ) )
          {
               /* Retrieve Values */
               $options = get_option ( $option_name );

               if ( isset ( $options[$_POST['edit_post']][$name] ) )
               {
                    /* Holds the values to fill the form */
                    $customFields = $options[$_POST['edit_post']][$name];

               }
          }
          /* Check if we have any infomration in the CustomColumns array, if not we create an empty one to start with */
          if ( ! isset ( $customFields ) )
          {
               $customFields[0] = $placeholder;
          }


          /* Custom Fields */
               foreach ($customFields as $i => $field)
               {
                    $parent_options[$field['ID']] = $field['Name'];
               }


          /*1. add a field to start with */
          /* Keep count of the number of fields we have been adding */
          $i = 0;
          /* We add a container div that will we out target for jquery */
          /* We add a note that if we use the same ids as the existing ones we can override them */
          ?>
          <div class="<?php echo ($name);?>_container">
               <small>
                    You can override any previous fields by using the same identifiers: title / categories / tags
               </small>

               <?php
               foreach ($customFields as $i => $field)
               {

                    ?>
                    <div class="<?php echo ($name);?>_div" id="customFields_container_<?php echo ($i);?>">
                    <?php

                    foreach ($placeholder as $type => $text )
                    {
                         $extra_information = '';
                         $fieldType = $type;
                         $fieldText = isset( $field[$type] ) ? $field[$type] : $text;
                         /* if the field type is type we have to display all the input types */
                         if ( $fieldType === 'Type' )
                         {
                              ?><select class="regular-text <?php echo ($name);?>_input <?php echo ($name);?>_<?php echo ($fieldType);?>_select" name="<?php echo ( $option_name . '[' . $name . '][' . $i . '][' . $fieldType . ']' );?>">
                                   <option value="">Choose input type</option>
                                   <?php
                                   /* Generate the input array if it is empty */
                                   if ( ! $this->inputArray )
                                   {
                                        $this->createInputArray ();
                                   }
                                   foreach ($this->inputArray as $j => $inputType)
                                   {
                                        $extra_information = '';
                                        /* we check if is selected */
                                        if ($fieldText == $inputType)
                                        {
                                             $extra_information = 'selected';
                                        }
                                        ?>
                                        <option value="<?php echo ($inputType);?>" <?php echo ($extra_information);?> ><?php echo ($inputType);?></option>
                                        <?php
                                   }?></select><?php
                         }
                         else if ( $fieldType === 'Parent' )
                         {
                              /* if the field is the parent we are going to add a select but it will be empty and with JS we are going to add the options */
                              /* if is edit we already have some options to start with */
                              if ( ( $field['ID'] != 'title' ) && ( $field['ID'] != 'categories' ) && ( $field['ID'] != 'tags' ))
                              {
                                   ?><select id="<?php echo ($fieldType);?>_<?php echo ($i);?>" class="regular-text <?php echo ($name);?>_input <?php echo ($name);?>_<?php echo ($fieldType);?>_select" name="<?php echo ( $option_name . '[' . $name . '][' . $i . '][' . $fieldType . ']' );?>">
                                        <option value="">Choose parent field</option>
                                        <?php
                                        foreach ($parent_options as $id => $option)
                                        {
                                             /* We remove the title and etc... */
                                             if ( ( $id === 'title' ) && ( $id === 'categories' ) && ( $id === 'tags' ))
                                             {
                                                  $extra_information = '';
                                                  /* we check if is selected */
                                                  if ($fieldText == $id)
                                                  {
                                                       $extra_information = 'selected';
                                                  }
                                                  ?>
                                                  <option value="<?php echo ($id);?>" <?php echo ($extra_information);?> ><?php echo ($option);?></option>
                                                  <?php
                                             }

                                        }
                                        ?></select><?php
                              }

                         }
                         else
                         {
                              /*id is required */
                              $extra_information = '';
                              if ( $i == 'ID' )
                              {
                                   $extra_information = 'required';
                              }
                              /* choose the value for the input field */
                              if ($placeholder[$fieldType] == $fieldText)
                              {
                                   $valueText = '';
                              }
                              else
                              {
                                   $valueText = 'value= "' . $fieldText . '"';
                              }
                              ?><input type="text" class="regular-text <?php echo ($name);?>_input <?php echo ($name);?>_<?php echo ($fieldType);?>_input" name="<?php echo ( $option_name . '[' . $name . '][' . $i . '][' . $fieldType . ']' );?>" placeholder="<?php echo ( $fieldText ); ?>" <?php echo ($valueText);?> <?php echo ($extra_information);?>  /><?php
                         }

                    }
                    /* 2. add the remove button */
                    ?>
                    <span class="dashicons dashicons-plus-alt add-substract-button <?php echo ($name);?>_addButton" id="add_<?php echo ($i);?>" ></span>
                    <span class="dashicons dashicons-dismiss add-substract-button <?php echo ($name);?>_removeButton" id="remove_<?php echo ($i);?>"></span>
                    </div>
                    <?php

               }
               ?>
          </div>
          <?php

          /*2. add a button of add more fields */

     }
}
