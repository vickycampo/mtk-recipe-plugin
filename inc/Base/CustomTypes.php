<?php
/*

@package mkt-recipe-plugin

     ===================================
          CUSTOM POST TYPES .PHP
     ===================================
*
*
*/
namespace Inc\Base;
/**
 *  CustomTypes - Create the CPT and Custom Taxonomies
**/
class CustomTypes
{

     public function register()
     {
          //Creates the custom post type
          add_action ( 'init' , array( $this , 'custom_post_type' ) );
          add_action ( 'init' , array( $this , 'custom_taxonomy_type' ) );
     }
     function custom_post_type ()
     {
          $post_type = 'mtk_recipe_cpt';

          $args ['labels'] = array (
               'name' => 'Recipes',
               'singular-name' => 'Recipe',

          );
          $args ['description'] = 'Recipes Plugin';
          $args ['public'] = true;
          $args ['has_archive'] = true;
          $args ['publicly_queryable'] = true;
          $args ['exclude_from_search'] = false;
          $args ['show_in_nav_menus'] = false;
          $args ['show_in_admin_bar'] = true;


          register_post_type ( $post_type , $args  );
     }
     function custom_taxonomy_type ()
     {
          /*** MTK categories ***/

          /* Name should only contain lowercase letters and the underscore character, and not be more than 32 characters long */
          $taxonomy = 'mtk_bycountryoforigin';
          /* Name of the object type for the taxonomy object. */
          //$object_type = 'mtk_recipe_cpt';
          $object_type = 'mtk_recipe_cpt';
          /* An array of Arguments.  */
          $args = array (
               'label' => __( 'By Country of origin' , 'wpTheme'),
               'rewrite' => array ( 'slug' => 'mtk_bycountryoforigin' ),
               'hierarchical'      => true
          );
          register_taxonomy( $taxonomy, $object_type, $args );

     }

}
