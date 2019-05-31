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
          $this->plugin = plugin_basename ( dirname ( __FILE__ , 3 ) ) . '/mtk-recipe-plugin.php';

          /* Array with all the managers that we will add to the Dashboard page */
          $this->managers = array (
               'cpt_manager' => 'Activate CPT manager',
               'taxonomy_manager' => 'Activate Taxonomy manager',
               'media_widget' => 'Activate Media Widgets',
               'gallery_manager' => 'Activate Gallery Manager',
               'testimonial_manager' => 'Activate Testimonial Manager',
               'templates_manager' => 'Activate Template Manager',
               'login_manager' => 'Activate Login Manager',
               'membership_manager' => 'Activate Membership Manager',
               'chat_manager' => 'Activate Chat Manager',

          );
     }
     /* Checks if the Manager is active or not */
     public function activated ( string $key )
     {
          $option = get_option ( 'mtk_plugin' );
          return ( isset ( $option[ $key ] ) ? $option[ $key ] : false );
     }
}
