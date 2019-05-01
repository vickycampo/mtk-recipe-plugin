<?php
/*

@package mkt-recipe-plugin

     ===================================
          UNINSTALL.PHP
     ===================================
*
* trigger this file when plugin uninstall
*/

/* Security Check - Make sure is wp uninstalling */
if ( ! defined ( 'WP_UNINSTALL_PLUGIN' ) )
{
     die;
}

/* Clear Database stored data */

// delete the CPT
// get all the recipes
/* Does exactly as the second method, that is why I have commented this code
     $args = array (
          'post_type' => 'recipe',
          'numberposts' => -1 //meaning all the posts

     );
     $recipes = get_posts ( $args );
     foreach ($recipes as $recipe)
     {
          wp_delete_posts ( $recipe->ID , true );
     }
*/

/* Access the database via SQL */
global $wpdb;
//we directly erase the posts
$wpdb->query( "DELETE FROM wp_posts WHERE post_type = 'recipe'" );
//we delete the metadata of the id's that were erase previously
$wpdb->query( "DELETE FROM wp_postmeta WHERE post_id NOT IN (SELECT id FROM wp_posts)" );
