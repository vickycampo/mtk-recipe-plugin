<?php
/*

@package mkt-recipe-plugin

     ===================================
          DASHBOARD.PHP
     ===================================
*
*
*/
namespace Inc\Pages;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;
use Inc\Api\Callbacks\ManagerCallbacks;
/**
*
*/
class Dashboard extends BaseController
{
	public $settings;
	public $callbacks;
	public $callbacks_mngr;
	public $pages = array();
	// public $subpages = array();


	public function register()
	{
		/* Initialize the class that will actually generate the menu pages and subpages */
		$this->settings = new SettingsApi();
		/* Initialize the class that manages the */
		$this->callbacks = new AdminCallbacks();
		$this->callbacks_mngr = new ManagerCallbacks();
		/* Create the pages and Subpages arrays*/
		$this->setPages();
		// $this->setSubpages();
		/* Create the pages and subpages */
		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->register();
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
			)		,
		);
	}
	// public function setSubpages()
	// {
	// 	$this->subpages = array(
	// 		array(
	// 			'parent_slug' => 'mtk_plugin',
	// 			'page_title' => 'Custom Post Types',
	// 			'menu_title' => 'CPT',
	// 			'capability' => 'manage_options',
	// 			'menu_slug' => 'mtk_cpt',
	// 			'callback' => array( $this->callbacks, 'adminCpt' )
	// 		),
	// 		array(
	// 			'parent_slug' => 'mtk_plugin',
	// 			'page_title' => 'Custom Taxonomies',
	// 			'menu_title' => 'Taxonomies',
	// 			'capability' => 'manage_options',
	// 			'menu_slug' => 'mtk_taxonomies',
	// 			'callback' => array( $this->callbacks, 'adminTaxonomy' )
	// 		),
	// 		array(
	// 			'parent_slug' => 'mtk_plugin',
	// 			'page_title' => 'Custom Widgets',
	// 			'menu_title' => 'Widgets',
	// 			'capability' => 'manage_options',
	// 			'menu_slug' => 'mtk_widgets',
	// 			'callback' => array( $this->callbacks, 'adminWidget' )
	// 		)
	// 	);
	// }
	/* Create the settings */
	public function setSettings()
	{

		$args = array(
			array(
				'option_group' => 'mtk_plugin_settings',
				'option_name' => 'mtk_plugin', //same name as the page slug
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' ),
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
				'callback' => array( $this->callbacks_mngr, 'adminSectionManager' ),
				'page' => 'mtk_plugin' //The slug of the page where
			)
		);
		$this->settings->setSections( $args );
	}
	/* Create the fields */
	public function setFields()
	{
		/* Create the Fields with the features list */
		/*
			$this->features
		*/
		foreach ($this->managers as $key => $value)
		{
			$args[] = array(
				'id' => $key,
				'title' => $value,
				'callback' => array ($this->callbacks_mngr , 'checkboxField'),
				'page' => 'mtk_plugin', //The slug of the page
				'section' => 'mtk_admin_index', // The id of the seciton
				'args' => array(
					'option_name' => 'mtk_plugin',
					'label_for' => $key, /* The label should always match the id, that is the way we are sending the information to the callback function */
					'class' => 'ui-toggle'

				)
			);

		}
		$this->settings->setFields( $args );
	}
}
