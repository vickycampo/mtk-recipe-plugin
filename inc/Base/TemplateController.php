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
use Inc\Base\BaseController;

/**
 * Enqueue - Enqueue the scripts and style files
 */
class TemplateController extends BaseController
{
     public $templates;

     public function register ()
     {

          /* Check if it is active */

          if ( ! ( $this->activated( 'templates_manager' ) ) ) return;

          $this->templates = array (
               'page-templates/two-columns-tpl.php' => 'Two Columns Layout'
          );

          /* Tell WP about the templates */
          add_filter ( 'theme_page_templates' , array ( $this , 'custom_templates' ) );
          /* Tell WP to use the template */
          add_filter ( 'template_include' , array( $this , 'load_template' ) );

     }
     public function custom_templates( $templates )
     {
          /* We have to merge the arrays of templates */
          $templates = array_merge( $templates , $this->templates );
          // error_log('Templates Array: ');
          // error_log(print_r($templates, true));
          // error_log('--------------------------------------------');
          return ( $templates );
     }
     public function load_template ( $template )
     {

          global $post;
          /* Check if the post variable is not defined */
          if ( ! $post )
          {
               return ( $template );
          }
          $template_name = get_post_meta( $post->ID , '_wp_page_template' , true);
          /* if this template name is part of our templates load it */
          if ( ! ( $this->templates[$template_name] ) )
          {
               return ( $template );
          }
          $file = $this->plugin_path . $template_name;
          if ( file_exists ( $file ) )
          {
               return ( $file );
          }
          return ($template);
     }
}
