<?php
/*

@package mkt-recipe-plugin

     ===================================
          SETTINGSLINKS.PHP
     ===================================
*
*
*/
namespace Inc\Base;
use \Inc\Base\BaseController;
/**
 *  SettingsLinks - Add the links at the plugin page for settings...
**/
class SettingsLinks extends BaseController
{
	public function register()
     {
          add_filter ( "plugin_action_links_$this->plugin" , array ( $this , 'settings_link' ) );
	}
     public function settings_link ( $links )
     {

          $settings_link = '<a href="admin.php?page=mtk_recipe_plugin">Settings</a>';
          array_push ( $links, $settings_link );
          return ( $links );
     }
}
