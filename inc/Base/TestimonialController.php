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
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

/**
 * Enqueue - Enqueue the scripts and style files
 */
class TestimonialController extends BaseController
{

     public function register ()
     {
          /* Check if it is active */
          if ( ! ( $this->activated( 'testimonial_manager' ) ) ) return;
          /* Trigger the generation of a custom post type */
          add_action ( 'init' , array ( $this , 'testimonial_cpt' ) );

     }
     public function testimonial_cpt ()
     {
          /* Trigger the build in function to create a custom post type */
          $labels = array (
               'name' => 'Testimonails',
               'singular_name' => 'Testimonial',


          );
          $args = array(
               'labels' => $labels,
               'public' => true,
               'has_archive' => false,
               'menu_icon' => 'dashicons-testimonial',
               'exclude_from_search' => true,
               'publicly_queryable' => false,
               'supports' => array ('title' , 'editor') 
          );
          register_post_type ( 'testimonial' , $args );
     }

}
