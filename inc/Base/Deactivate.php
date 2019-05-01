<?php
/*

@package mkt-recipe-plugin

     ===================================
          DEACTIVATE.PHP
     ===================================
*
*
*/
namespace Inc\Base;
/**
 *  Deactive - The deactivation function for the plugin
**/
class Deactivate
{
     public static function deactivate ()
     {
          flush_rewrite_rules();
     }
}
