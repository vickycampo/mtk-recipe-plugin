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
class GalleryController extends BaseController
{
     public $callbacks;
     public $subpages = array();
     public function register ()
     {

          /* Check if it is active */
          if ( ! ( $this->activated( 'gallery_manager' ) ) ) return;

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
				'page_title' => 'Gallery Manager',
				'menu_title' => 'Gallery Manager',
				'capability' => 'manage_options',
				'menu_slug' => 'mtk_gallery',
				'callback' => array( $this->callbacks, 'adminGallery' )
			)
		);
	}
     public function activate ()
     {

     }
}
