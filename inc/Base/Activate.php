<?php
/*

@package mkt-recipe-plugin

     ===================================
          ACTIVATE.PHP
     ===================================
*
*
*/
namespace Inc\Base;
/**
 *  Active - The activation function for the plugin
**/
class Activate
{
	public static function activate() {
		flush_rewrite_rules();
		/* We can use this method to set a default data */
		/* Check if the plugin manager exists */
		if ( get_option ( 'mtk_plugin' ) )
		{
			return;
		}
		/* Now we can create the default data */
		$default = array ();
		update_option ( 'mtk_plugin' , $default );
	}
}
