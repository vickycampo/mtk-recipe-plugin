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
class ChatController extends BaseController
{
     public $callbacks;
     public $subpages = array();
     public function register ()
     {

          /* Check if it is active */
          if ( ! ( $this->activated( 'chat_manager' ) ) ) return;
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
				'page_title' => 'Chat Manager',
				'menu_title' => 'Chat Manager',
				'capability' => 'manage_options',
				'menu_slug' => 'mtk_chat',
				'callback' => array( $this->callbacks, 'adminChat' )
			)
		);
	}
     public function activate ()
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
