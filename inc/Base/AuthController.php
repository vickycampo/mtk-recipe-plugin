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
          add_action( 'wp_enqueue_scripts' , array( $this , 'enqueue' ) );
          /* Add an action that will get the login button */

          add_action ( 'wp_head' , array( $this , 'add_auth_template' ) );
          /* Add Ajax */
          add_action ( 'wp_ajax_nopriv_mtk_login' , array( $this , 'login' ) );
     }
     public function enqueue ()
     {
          /* If the user is logged in we don't add the login button */
          if ( is_user_logged_in() ) return;
          /* Enqueue the styles and scripts*/
          error_log ('enqueue');
          wp_enqueue_style ( 'authStyle' , $this->plugin_url . 'assets/auth.css');
          wp_enqueue_script ( 'authScript' , $this->plugin_url . 'assets/auth.js');
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
     public function login ()
     {
          check_ajax_referer ( 'aja-login-nonce', 'mtk_auth' );
          $info = array ();
          $info['user_login'] = $_POST['username'];
          $info['user_password'] = $_POST['password'];
          $info['remember'] = true;

          $user_signon = wp_signon ( $info , true );
          if ( is_wp_error ( $$user_signon ) )
          {
               echo (json_encode (
                    array (
                         'status' => false,
                         'message' => 'Wrong username or password.'
                    )
               ));
               die ();
          }
          echo (json_encode (
               array (
                    'status' => true,
                    'message' => 'Login succesful, redirecting...'
               )
          ));
     }
}
