<?php
/*

@package mkt-recipe-plugin

     ===================================
          ADMIN.PHP
     ===================================
*
*
*/
namespace Inc\Pages;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
/**
*
*/
class Admin extends BaseController
{
	public $settings;
	public $callbacks;
	public $pages = array();
	public $subpages = array();

	public function register()
	{
		/* Initialize the class that will actually generate the menu pages and subpages */
		$this->settings = new SettingsApi();
		/* Initialize the class that manages the */
		$this->callbacks = new AdminCallbacks();
		/* Create the pages and Subpages arrays*/
		$this->setPages();
		$this->setSubpages();
		/* Create the pages and subpages */
		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->addSubPages( $this->subpages )->register();
	}
	public function setPages()
	{
		$this->pages = array(
			array(
				'page_title' => 'MTK Recipe Plugin',
				'menu_title' => 'MTK Recipe',
				'capability' => 'manage_options',
				'menu_slug' => 'mtk_plugin',
				'callback' => array( $this->callbacks, 'adminDashboard' ),
				'icon_url' => 'dashicons-carrot',
				'position' => 110
			)
		);
	}
	public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'mtk_plugin',
				'page_title' => 'Custom Post Types',
				'menu_title' => 'CPT',
				'capability' => 'manage_options',
				'menu_slug' => 'mtk_cpt',
				'callback' => array( $this->callbacks, 'adminCpt' )
			),
			array(
				'parent_slug' => 'mtk_plugin',
				'page_title' => 'Custom Taxonomies',
				'menu_title' => 'Taxonomies',
				'capability' => 'manage_options',
				'menu_slug' => 'mtk_taxonomies',
				'callback' => array( $this->callbacks, 'adminTaxonomy' )
			),
			array(
				'parent_slug' => 'mtk_plugin',
				'page_title' => 'Custom Widgets',
				'menu_title' => 'Widgets',
				'capability' => 'manage_options',
				'menu_slug' => 'mtk_widgets',
				'callback' => array( $this->callbacks, 'adminWidget' )
			)
		);
	}
	/* Create the settings */
	public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'mtk_options_group',
				'option_name' => 'text_example',
				'callback' => array( $this->callbacks, 'mtkOptionsGroup' )
			),
			array(
				'option_group' => 'mtk_options_group',
				'option_name' => 'first_name'
			)
		);
		$this->settings->setSettings( $args );
	}
	/* Create the Section */
	public function setSections()
	{
		$args = array(
			array(
				'id' => 'mtk_admin_index',
				'title' => 'Settings',
				'callback' => array( $this->callbacks, 'mtkAdminSection' ),
				'page' => 'mtk_plugin' //The slug of the page where
			)
		);
		$this->settings->setSections( $args );
	}
	/* Create the fields */
	public function setFields()
	{
		$args = array(
			array(
				'id' => 'text_example',
				'title' => 'Text Example',
				'callback' => array( $this->callbacks, 'mtkTextExample' ),
				'page' => 'mtk_plugin', //The slug of the page
				'section' => 'mtk_admin_index', // The id of the seciton 
				'args' => array(
					'label_for' => 'text_example',
					'class' => 'example-class'
				)
			),
			array(
				'id' => 'first_name',
				'title' => 'First Name',
				'callback' => array( $this->callbacks, 'mtkFirstName' ),
				'page' => 'mtk_plugin',
				'section' => 'mtk_admin_index',
				'args' => array(
					'label_for' => 'first_name',
					'class' => 'example-class'
				)
			)
		);
		$this->settings->setFields( $args );
	}
}
