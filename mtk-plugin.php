<?php
/**
* @package mkt-recipe-plugin
*/
/*
Plugin Name: My Tiny Kitchen - Recipe Plugin
Plugin URI: www.virginiacampo.com/mtk-plugin
Description: Plugin to manage the recipes
Version: 1.0.0
Author: Virginia Campo
Author URI: www.virginiacampo.com
License: GPLv2 or later
Text Domain: mtk-plugin
*/

/*Notes: modify the location of the plugins in the default-constans.php
if ( ! defined( 'WP_PLUGIN_DIR' ) ) {
     define( 'WP_PLUGIN_DIR', WP_CONTENT_DIR . '/themes/wpTheme/plugin' ); // full path, no trailing slash
}
*/

/* Blocks external hacks */
defined( 'ABSPATH' ) or die( 'Hey, you can\t access this file, you silly human!' );

/* Add the autoload file (composer) */
if ( file_exists ( dirname( __FILE__ ) . '/vendor/autoload.php' ) )
{
     require_once ( dirname( __FILE__ ) . '/vendor/autoload.php' );
}

/* Create the activation and deactivation hooks */
/* Create the functions */
if ( ! function_exists ( 'activate_mtk_recipe_plugin' ) )
{
     function activate_mtk_recipe_plugin()
     {
          Inc\Base\Activate::activate();
     }
}
register_activation_hook ( __FILE__ , 'activate_mtk_recipe_plugin' );

if ( ! function_exists ( 'deactivate_mtk_recipe_plugin' ) )
{
     function deactivate_mtk_recipe_plugin()
     {
          Inc\Base\Deactivate::deactivate();
     }
}
register_deactivation_hook ( __FILE__ , 'deactivate_mtk_recipe_plugin' );

/* Start working with the init class */
if ( class_exists ( 'Inc\\Init' ) )
{
     Inc\Init::register_services ();
}
