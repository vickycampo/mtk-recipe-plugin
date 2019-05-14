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
          $output = get_option ( 'mtk_plugin_cpt' );
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
          return ( $output );
     }
     public function textField ( $args )
     {
          // var_dump ( $args );
          $name = $args['label_for'];
          $option_name = $args['option_name'];
          $input = get_option ( $option_name );
          // $value = $input[$name];
          $value = '';
          echo (
               '<input type="text" class="regular-text" id"' . $name . ' name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '">'
          );
          //return input
     }
     public function checkboxField ( $args )
     {
          /* Wwith the args that we recieve we can generate the check box */

          $name = $args['label_for'];
          $classes = $args['class'];
          $option_name = $args['option_name'];
          $checkbox = get_option ( $option_name );

          $checked = isset ($checkbox[$name]) ? ( $checkbox[$name] ? true : false ) : false;
          echo ('<div class="' . $classes . '">
                    <input type="checkbox" id="' . $name . '" name="' . $option_name . '[' . $name . ']' .  '" value="1" class="' . $classes . '"' . ( $checked ? 'checked' : '' ) . '>
                    <label for="' . $name . '">
                         <div>
                         </div>
                    </label>
               </div>');
     }
}
