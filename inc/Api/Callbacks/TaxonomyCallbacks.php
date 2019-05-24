<?php
/*

@package mkt-recipe-plugin

     ===================================
          TAXONOMY CALLBACKS
     ===================================
*
*
*/
namespace Inc\Api\Callbacks;
use \Inc\Base\BaseController;
/**
*  AdminCallbacks - Manages all the callback functions of the Admin Pages
*/
class TaxonomyCallbacks
{
     public function taxSectionManager()
     {
          echo ('Create as many Custom Taxonomies as you want');
     }
     public function taxSanitize ( $input )
     {
          /* We get the options that are stored in the database */
          $output = get_option ( 'mtk_plugin_tax' );
          if ( isset ( $_POST['remove'] ) )
          {
               /* we unset the key that we want to remove */
               unset ( $output[$_POST['remove']] );
               return ( $output );
          }

          /* We have to check if the array is empty, if it is we simply add the new tax */
          if ( count( $output ) == 0 )
          {
               $output[$input['taxonomy']] = $input;
               return ($output);
          }
          /* The array was not empty we check if the key exists */
          foreach ( $output as $key => $value )
          {
               if ($input['taxonomy'] === $key)
               {
                    $output[$key] = $input;
               }
               else
               {
                    $output[$input['taxonomy']] = $input;
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
          if ( isset ( $_POST['edit_taxonomy'] ) )
          {
               $input = get_option ( $option_name );
               $value = $input[$_POST['edit_taxonomy']][$name];
               if ('post_type' === $name)
               {
                    $extra_information = 'disabled';
               }
          }

          echo (
               '<input type="text" class="regular-text" id"' . $name . ' name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" ' . $extra_information . '>'
          );
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
          if ( isset ( $_POST['edit_taxonomy'] ) )
          {
               $checkbox = get_option ( $option_name );
               $checked = isset ( $checkbox[$_POST['edit_taxonomy']][$name] ) ?: false;
          }


          echo ('<div class="' . $classes . '">
                    <input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']' .  '" value="1" class="' . $classes . '"' . ( $checked ? 'checked' : '' ) . '>
                    <label for="' . $name . '">
                         <div>
                         </div>
                    </label>
               </div>');
     }
     public function checkboxPostTypesField ( $args )
     {
          /* populate the values */
          if ( isset ( $_POST['edit_taxonomy'] ) )
          {
               $checkbox = get_option ( $option_name );
               $checked = isset ( $checkbox[$_POST['edit_taxonomy']][$name] ) ?: false;
          }
          /* Arrange the values that we got with the args */
          $name = $args['label_for'];
          $classes = $args['class'];
          $option_name = $args['option_name'];
          $checked = false;
          /* Wwith the args that we recieve we can generate the check box */
          $output = '';
          /* Get all the post types */
          $post_types = get_post_types ( array(
               'show_ui' => true
          ) );
          foreach ($post_types as $post)
          {

               $output .= '<div class="' . $classes . ' mb-10">';
               $output .= '<input type="checkbox" id="' . $post . '" name="' . $option_name . '[' . $name . ']['. $post .']';
               $output .= '" value="1" class="' . $classes . '"' . ( $checked ? 'checked' : '' ) . '>';
               $output .= '<label for="' . $name . '">';
               $output .= '<div>';
               $output .= '</div>';
               $output .= '</label>';
               $output .= '<strong>'. $post .'</strong>';
               $output .= '</div>';
          }
          echo ('<pre>');
          print_r ($output);
          echo ('</pre>');






     }

}
