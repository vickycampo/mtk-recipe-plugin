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
          if ( isset ( $_POST['edit_post'] ) )
          {
               $input = get_option ( $option_name );
               $value = $input[$_POST['edit_post']][$name];
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
}
