<?php
/*

@package mkt-recipe-plugin

     ===================================
          SETTINGSAPI.PHP
     ===================================
*
*
*/
namespace Inc\Api\Callbacks;

use \Inc\Base\BaseController;
/**
*  AdminCallbacks - Manages all the callback functions of the Admin Pages
*/
class ManagerCallbacks extends BaseController
{
     public function checkboxSanitize ( $input )
     {
          /* Filter the check box */
          $output = array ();
          foreach ($this->managers as $key => $value)
          {
               $output[$key] = isset ( $input[$key] ) ? true : false ;
          }

          return ($output);
          //return ( isset ( $input ) ? true : false );
     }
     public function adminSectionManager ()
     {
          echo ("Manage the Sections and Features of this Plugin by activating the checkboxes from the following list.");
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
