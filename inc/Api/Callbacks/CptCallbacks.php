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

     public function cptSectionManager ()
     {
          echo ("Manage your custom post Types");
     }
     public function cptSanitize ( $input )
     {
          error_log('input');
          error_log(print_r($input, true));
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
}
