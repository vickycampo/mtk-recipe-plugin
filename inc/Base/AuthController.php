<?php
/*

@package mkt-recipe-plugin

     ===================================
          CUSTOMPOSTTYPECONTROLLER.PHP
     ===================================
*
*
*/
namespace Inc\Base;
use Inc\Api\Callbacks\AdminCallbacks;

/**
 * Enqueue - Enqueue the scripts and style files
 */
 class AuthController extends BaseController
 {
 	public function register()
 	{
 		if ( ! $this->activated( 'login_manager' ) ) return;
          /* load the script */
          add_action( 'wp_enqueue_scritps' , array( $this , 'enqueue' ) );
          /* Add an action that will get the login button */
          add_action ( 'wp_head' , array( $this , 'add_auth_template' ) );
     }
     public function enqueue ()
     {
          if ( is_user_logged_in() ) return;
          wp_enqueue_tyle ( 'authStyle' , $this->plugin_url . 'assets/auth.css');
          wp_enqueue_scritp ( 'authScript' , $this->plugin_url . 'assets/auth.js');
     }
     public function add_auth_template()
     {
          /* Check if logged in */
          if ( is_user_logged_in() ) return;
          $file = $this->plugin_path . 'templates/auth.php';
          if ( file_exists ( $file ) )
          {
               load_template ( $file , true );
          }
     }
}
