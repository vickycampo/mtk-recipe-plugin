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
     }
}
