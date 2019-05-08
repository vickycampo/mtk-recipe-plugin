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
class CustomPostTypeController extends BaseController
{
     public $callbacks;
     public $subpages = array();
     public function register ()
     {

          $option = get_option ( 'mtk_plugin' );
          $activated = isset ($option['cpt_manager']) ? $option['cpt_manager'] : false;
          if ( ! $activated )
          {
               return;
          }

          /* Initialize the class that will actually generate the menu pages and subpages */
		$this->settings = new SettingsApi();
          /* Initialize the class that manages the */
		$this->callbacks = new AdminCallbacks();
          /* Call the subpages method */
          $this->setSubpages();
          $this->settings->addSubPages( $this->subpages )->register();
          add_action ( 'init' , array ( $this , 'activate') );
     }
     public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'mtk_plugin',
				'page_title' => 'Custom Post Types',
				'menu_title' => 'CPT Manager',
				'capability' => 'manage_options',
				'menu_slug' => 'mtk_cpt',
				'callback' => array( $this->callbacks, 'adminCpt' )
			)
		);
	}
     public function activate ()
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
}
