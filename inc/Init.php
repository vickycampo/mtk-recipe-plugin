<?php
/*

@package mkt-recipe-plugin

     ===================================
          INIT.PHP
     ===================================
*
*
*/
namespace Inc;

/**
 * Init
 */
final class Init //final - cannot be extended
{
     /*** Gets all the clases that I have created in an array ***/
     public static function get_services ()
     {
          return [

               Pages\Dashboard::class,
               Base\Enqueue::class,
               Base\SettingsLinks::class,
               Base\CustomPostTypeController::class

          ];
     }
     /*** Initialize the class, and call the register method if it exists ***/
     public static function register_services()
	{
		foreach ( self::get_services() as $class )
          {
			$service = self::instantiate( $class );
			if ( method_exists( $service , 'register' ) )
               {
				$service->register();
			}
		}
	}
     /*** Initialize the class ***/
     private static function instantiate( $class )
	{
		$service = new $class();
		return $service;
	}

}
