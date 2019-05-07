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
use Inc\Api\Callbacks\ManagerCallbacks;
/**
*
*/
class Admin extends BaseController
{
	public $settings;
	public $callbacks;
	public $callbacks_mngr;
	public $pages = array();
	public $subpages = array();

	public function register()
	{
		/* Initialize the class that will actually generate the menu pages and subpages */
		$this->settings = new SettingsApi();
		/* Initialize the class that manages the */
		$this->callbacks = new AdminCallbacks();
		$this->callbacks_mngr = new ManagerCallbacks();
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
			)		,
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
				'option_group' => 'mtk_plugin_settings',
				'option_name' => 'cpt_manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'mtk_plugin_settings',
				'option_name' => 'taxonomy_manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'mtk_plugin_settings',
				'option_name' => 'media_widgets',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'mtk_plugin_settings',
				'option_name' => 'gallery_manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'mtk_plugin_settings',
				'option_name' => 'testimonial_manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'mtk_plugin_settings',
				'option_name' => 'templates_manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'mtk_plugin_settings',
				'option_name' => 'login_manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'mtk_plugin_settings',
				'option_name' => 'membership_manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
			),
			array(
				'option_group' => 'mtk_plugin_settings',
				'option_name' => 'chat_manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
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
		$args = array(
			array(
				'id' => 'cpt_manager',
				'title' => 'Activate CPT manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'mtk_plugin', //The slug of the page
				'section' => 'mtk_admin_index', // The id of the seciton
				'args' => array(
					'label_for' => 'cpt_manager', /* The label should always match the id, that is the way we are sending the information to the callback function */
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'taxonomy_manager',
				'title' => 'Activate Taxonomy manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'mtk_plugin', //The slug of the page
				'section' => 'mtk_admin_index', // The id of the seciton
				'args' => array(
					'label_for' => 'taxonomy_manager', /* The label should always match the id, that is the way we are sending the information to the callback function */
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'media_widgets',
				'title' => 'Activate Media Widgets',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'mtk_plugin', //The slug of the page
				'section' => 'mtk_admin_index', // The id of the seciton
				'args' => array(
					'label_for' => 'media_widgets', /* The label should always match the id, that is the way we are sending the information to the callback function */
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'gallery_manager',
				'title' => 'Activate Gallery Manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'mtk_plugin', //The slug of the page
				'section' => 'mtk_admin_index', // The id of the seciton
				'args' => array(
					'label_for' => 'gallery_manager', /* The label should always match the id, that is the way we are sending the information to the callback function */
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'testimonial_manager',
				'title' => 'Activate Testimonial Manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'mtk_plugin', //The slug of the page
				'section' => 'mtk_admin_index', // The id of the seciton
				'args' => array(
					'label_for' => 'testimonial_manager', /* The label should always match the id, that is the way we are sending the information to the callback function */
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'templates_manager',
				'title' => 'Activate Template Manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'mtk_plugin', //The slug of the page
				'section' => 'mtk_admin_index', // The id of the seciton
				'args' => array(
					'label_for' => 'templates_manager', /* The label should always match the id, that is the way we are sending the information to the callback function */
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'login_manager',
				'title' => 'Activate Login Manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'mtk_plugin', //The slug of the page
				'section' => 'mtk_admin_index', // The id of the seciton
				'args' => array(
					'label_for' => 'login_manager', /* The label should always match the id, that is the way we are sending the information to the callback function */
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'membership_manager',
				'title' => 'Activate Membership Manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'mtk_plugin', //The slug of the page
				'section' => 'mtk_admin_index', // The id of the seciton
				'args' => array(
					'label_for' => 'membership_manager', /* The label should always match the id, that is the way we are sending the information to the callback function */
					'class' => 'ui-toggle'
				)
			),
			array(
				'id' => 'chat_manager',
				'title' => 'Activate Chat Manager',
				'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
				'page' => 'mtk_plugin', //The slug of the page
				'section' => 'mtk_admin_index', // The id of the seciton
				'args' => array(
					'label_for' => 'chat_manager', /* The label should always match the id, that is the way we are sending the information to the callback function */
					'class' => 'ui-toggle'
				)
			)
		);
		$this->settings->setFields( $args );
	}
}
