<?php
/**
* @package mkt-recipe-plugin
*/

namespace Inc\Base;
/**
 *  BaseController - We establish the global values
**/
class BaseController
{
     public $plugin_path;
     public $plugin_url;
     public $plugin;

     public $managers = array ();
     function __construct()
     {

          /* Declarations of variables that will be used on classes that extend this one */
          $this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
          $this->plugin = plugin_basename ( dirname ( __FILE__ , 3 ) ) . '/mtk-plugin.php';

          /* Array with all the managers that we will add to the Dashboard page */
          $this->managers = array (
               'recipe_cpt_manager' => 'Use a Recipe Custom Post Type', //cpt
               'taxonomy_manager' => 'Create your own Taxonomy', //taxonomy
               'media_widget' => 'Add a widget', //media widget
               'recipe_slider_manager' => 'Create a Recipe Slider', //testimonials
               'templates_manager' => 'Use your Custom Template', //templates_manager
               'login_manager' => 'Activate Login Manager' //login

          );
     }
     /* Checks if the Manager is active or not */
     public function activated ( string $key )
     {

          $option = get_option ( 'mtk_plugin' );
          // error_log('$key: ');
          // error_log( $key );
          // error_log(print_r($option, true));
          // error_log('--------------------------------------------');
          return ( isset ( $option[ $key ] ) ? $option[ $key ] : false );
     }
}
