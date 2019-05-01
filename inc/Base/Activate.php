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
	}
}
