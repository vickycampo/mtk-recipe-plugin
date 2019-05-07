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
class AdminCallbacks extends BaseController
{
     public function adminDashboard ()
     {
          return require_once ( "$this->plugin_path/templates/admin.php" ) ;
     }
     public function adminCPT ()
     {
          return require_once ( "$this->plugin_path/templates/cpt.php" ) ;
     }
     public function adminTaxonomy ()
     {
          return require_once ( "$this->plugin_path/templates/taxonomy.php" ) ;
     }
     public function adminWidgets ()
     {
          return require_once ( "$this->plugin_path/templates/widget.php" ) ;
     }
     // public function mtkOptionsGroup ( $input )
     // {
     //      return ($input) ;
     // }
     // public function mtkAdminSection (  )
     // {
     //      echo ('Check this section.');
     // }
     public function mtkTextExample ()
     {
          $value = esc_attr( get_option( 'text_example' ) );
		echo '<input type="text" class="regular-text" name="text_example" value="' . $value . '" placeholder="Write Something Here!">';
     }
     public function mtkFirstName()
	{
		$value = esc_attr( get_option( 'first_name' ) );
		echo '<input type="text" class="regular-text" name="first_name" value="' . $value . '" placeholder="Write your First Name">';
	}
}
