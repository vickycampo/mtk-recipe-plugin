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
          // return filter_var( $input , FILTER_SANITIZE_NUMBER_INT );
          /* Check if the the check box is checked */
          return ( isset ( $input ) ? true : false );
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
          $checkbox = get_option ( $args['label_for'] );
          echo ('<input type="checkbox" name="' . $name . '" value="1" class="' . $classes . '"' . ( $checkbox ? 'checked' : '' ) . '>');
     }
}
