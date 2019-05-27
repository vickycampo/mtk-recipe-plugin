<?php
/*

@package mkt-recipe-plugin

     ===================================
          ADMIN.PHP
     ===================================
*
*
*/
namespace Inc\Base;
use Inc\Base\BaseController;
/**
 * Enqueue - Enqueue the scripts and style files
 */
class Enqueue extends BaseController
{
     public function register()
     {
          //Enqueues the style and script files
          add_action( 'admin_enqueue_scripts' , array( $this , 'enqueue' ) );
     }
     //Enqueue function
     function enqueue()
     {
          /* Built in script of Wordpress */
          wp_enqueue_script ( 'media-upload' );
          wp_enqueue_media ();

          /* Adds My styles */
          wp_enqueue_style( 'mypluginstyle', $this->plugin_url . 'assets/mystyle.css' );
          /* Adds My Sctip */
		wp_enqueue_script( 'mypluginscript', $this->plugin_url . 'assets/myscript.js' );
     }
}
