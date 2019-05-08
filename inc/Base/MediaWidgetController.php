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
class MediaWidgetController extends BaseController
{
     public $callbacks;
     public $subpages = array();
     public function register ()
     {

          $option = get_option ( 'mtk_plugin' );
          $activated = isset ($option['media_widget']) ? $option['media_widget'] : false;
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
				'page_title' => 'Media Widgets',
				'menu_title' => 'Media Widgets',
				'capability' => 'manage_options',
				'menu_slug' => 'mtk_media_widget',
				'callback' => array( $this->callbacks, 'adminWidgets' )
			)
		);
	}
     public function activate ()
     {

     }
}
