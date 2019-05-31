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
use Inc\Api\Callbacks\CptCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;

/**
 * Enqueue - Enqueue the scripts and style files
 */
class CustomPostTypeController extends BaseController
{
     public $settings;
     public $callbacks;
     public $cpt_callbacks;
     public $subpages = array();
     public $custom_post_types = array();
     public function register ()
     {
          /* Check if it is active */
          if ( ! ( $this->activated( 'cpt_manager' ) ) ) return;


          /* Initialize the class that will actually generate the menu pages and subpages */
		$this->settings = new SettingsApi();
          /* Initialize the class that manages the */
		$this->callbacks = new AdminCallbacks();
          /* Initialize the class that manages the */
		$this->cpt_callbacks = new CptCallbacks();
          /* Call the subpages method */
          $this->setSubpages();

          /*  Create Settings / Sections / Fields */
          $this->setSettings ();
          $this->setSections ();
          $this->setFields ();
          /* Register all the subpages / settings / sections / Fields */
          $this->settings->addSubPages( $this->subpages )->register();
          /* Store a custom post type in our array */
          $this->storeCustomPostTypes();
          /* If the user has defined post types then we register the type */
          if ( ! empty ( $this->custom_post_types ))
          {
               add_action ( 'init' , array ( $this , 'registerCustomPostTypes') );
          }

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
				'callback' => array( $this->callbacks, 'adminCPT' )
			)
		);
	}
     /* Create the settings */
     public function setSettings()
	{

		$args = array(
			array(
				'option_group' => 'mtk_plugin_cpt_settings',
				'option_name' => 'mtk_plugin_cpt', //same name as the page slug
				'callback' => array( $this->cpt_callbacks, 'cptSanitize' ),
			)
		);

		$this->settings->setSettings( $args );
	}
     /* Create the Section */
	public function setSections()
	{
		$args = array(
			array(
				'id' => 'mtk_cpt_index',
				//'title' => 'Custom Post Type Manager',
                    'title' => '',
				'callback' => array( $this->cpt_callbacks, 'cptSectionManager' ),
				'page' => 'mtk_cpt' //The slug of the page where
			)
		);
		$this->settings->setSections( $args );
	}
	/* Create the fields */
     public function setFields()
	{
          /* Fields that we need */
          // Post type ide
          $args = array (
               array(
                    'id' => 'post_type',
                    'title' => 'Custom Post Type Id',
                    'callback' => array ($this->cpt_callbacks , 'textField'),
                    'page' => 'mtk_cpt', //The slug of the page
                    'section' => 'mtk_cpt_index', // The id of the seciton
                    'args' => array(
                         'option_name' => 'mtk_plugin_cpt',
                         'label_for' => 'post_type',
                         'placeholder' => 'eg. product',
					'array' => 'post_type'

                    )
               ),
               // Singular name
               array(
                    'id' => 'singular_name',
                    'title' => 'Singular Name',
                    'callback' => array ($this->cpt_callbacks , 'textField'),
                    'page' => 'mtk_cpt', //The slug of the page
                    'section' => 'mtk_cpt_index', // The id of the seciton
                    'args' => array(
                         'option_name' => 'mtk_plugin_cpt',
                         'label_for' => 'singular_name',
                         'placeholder' => 'eg. Product',
					'array' => 'post_type'

                    )
               ),
               // Plural name
               array(
                    'id' => 'plural_name',
                    'title' => 'Plural Name',
                    'callback' => array ($this->cpt_callbacks , 'textField'),
                    'page' => 'mtk_cpt', //The slug of the page
                    'section' => 'mtk_cpt_index', // The id of the seciton
                    'args' => array(
                         'option_name' => 'mtk_plugin_cpt',
                         'label_for' => 'plural_name',
                         'placeholder' => 'eg. Products',
					'array' => 'post_type'

                    )
               ),
               // /* Associated Taxonomies */
               // array(
               //      'id' => 'taxonomies', /* an unique Id*/
               //      'title' => 'Taxonomies', /* Text to display in the field */
               //      /* We want a list of all the available post types */
               //      'callback' => array ($this->cpt_callbacks , 'checkboxTaxonomiesField'), /* Call Back function that generates the field */
               //      'page' => 'mtk_cpt', //The slug of the page
               //      'section' => 'mtk_cpt_index', // The id of the seciton
               //      'args' => array(
               //           'option_name' => 'mtk_plugin_cpt',
               //           'label_for' => 'taxonomies', /* The label should always match the id, that is the way we are sending the information to the callback function */
               //           'class' => 'ui-toggle',
			// 		'array' => 'mtk_plugin_cpt'
               //      )
               // ),
               // Add an icon
               array(
                    'id' => 'menu_icon',
                    'title' => 'Menu Icon',
                    'callback' => array ($this->cpt_callbacks , 'iconPicker'),
                    'page' => 'mtk_cpt', //The slug of the page
                    'section' => 'mtk_cpt_index', // The id of the seciton
                    'args' => array(
                         'option_name' => 'mtk_plugin_cpt',
                         'label_for' => 'menu_icon',
                         'placeholder' => 'eg. dashicons-admin-tools',
					'array' => 'post_type'

                    )
               ),
               // public
               array(
                    'id' => 'public',
                    'title' => 'Public',
                    'callback' => array ($this->cpt_callbacks , 'checkboxField'),
                    'page' => 'mtk_cpt', //The slug of the page
                    'section' => 'mtk_cpt_index', // The id of the seciton
                    'args' => array(
                         'option_name' => 'mtk_plugin_cpt',
                         'label_for' => 'public', /* The label should always match the id, that is the way we are sending the information to the callback function */
                         'class' => 'ui-toggle',
					'array' => 'post_type'
                    )
               ),
               // has_archive
               array(
                    'id' => 'has_archive',
                    'title' => 'Archive',
                    'callback' => array ($this->cpt_callbacks , 'checkboxField'),
                    'page' => 'mtk_cpt', //The slug of the page
                    'section' => 'mtk_cpt_index', // The id of the seciton
                    'args' => array(
                         'option_name' => 'mtk_plugin_cpt',
                         'label_for' => 'has_archive', /* The label should always match the id, that is the way we are sending the information to the callback function */
                         'class' => 'ui-toggle',
					'array' => 'post_type'
                    )
               )
          );

		$this->settings->setFields( $args );
	}
     public function registerCustomPostTypes()
	{

		foreach ($this->custom_post_types as $post_type) {
			register_post_type( $post_type['post_type'],
				array(
					'labels' => array(
						'name'                  => $post_type['name'],
						'singular_name'         => $post_type['singular_name'],
						'menu_name'             => $post_type['menu_name'],
						'name_admin_bar'        => $post_type['name_admin_bar'],
						'archives'              => $post_type['archives'],
						'attributes'            => $post_type['attributes'],
						'parent_item_colon'     => $post_type['parent_item_colon'],
						'all_items'             => $post_type['all_items'],
						'add_new_item'          => $post_type['add_new_item'],
						'add_new'               => $post_type['add_new'],
						'new_item'              => $post_type['new_item'],
						'edit_item'             => $post_type['edit_item'],
						'update_item'           => $post_type['update_item'],
						'view_item'             => $post_type['view_item'],
						'view_items'            => $post_type['view_items'],
						'search_items'          => $post_type['search_items'],
						'not_found'             => $post_type['not_found'],
						'not_found_in_trash'    => $post_type['not_found_in_trash'],
						'featured_image'        => $post_type['featured_image'],
						'set_featured_image'    => $post_type['set_featured_image'],
						'remove_featured_image' => $post_type['remove_featured_image'],
						'use_featured_image'    => $post_type['use_featured_image'],
						'insert_into_item'      => $post_type['insert_into_item'],
						'uploaded_to_this_item' => $post_type['uploaded_to_this_item'],
						'items_list'            => $post_type['items_list'],
						'items_list_navigation' => $post_type['items_list_navigation'],
						'filter_items_list'     => $post_type['filter_items_list']
					),
					'label'                     => $post_type['label'],
					'description'               => $post_type['description'],
					'supports'                  => $post_type['supports'],
					'taxonomies'                => $post_type['taxonomies'],
					'hierarchical'              => $post_type['hierarchical'],
					'public'                    => $post_type['public'],
					'show_ui'                   => $post_type['show_ui'],
					'show_in_menu'              => $post_type['show_in_menu'],
					'menu_position'             => $post_type['menu_position'],
                         'menu_icon'                 => $post_type['menu_icon'],
					'show_in_admin_bar'         => $post_type['show_in_admin_bar'],
					'show_in_nav_menus'         => $post_type['show_in_nav_menus'],
					'can_export'                => $post_type['can_export'],
					'has_archive'               => $post_type['has_archive'],
					'exclude_from_search'       => $post_type['exclude_from_search'],
					'publicly_queryable'        => $post_type['publicly_queryable'],
					'capability_type'           => $post_type['capability_type']
				)
			);
		}
	}
     public function storeCustomPostTypes()
	{

          if ( ! ( get_option ( 'mtk_plugin_cpt' ) ) )
		{
               update_option ( 'mtk_plugin_cpt' , array () );
			return;
		}
          $options = get_option ('mtk_plugin_cpt');


          foreach ( $options as $option)
          {
               /* we fix the taxonomies array */
               if ( isset ($option['taxonomies']) )
               {
                    $taxonomies_array = $option['taxonomies'];
                    unset ( $option['taxonomies'] );
                    foreach ( $taxonomies_array as $key => $value )
                    {
                          $option['taxonomies'][] = $key;
                    }

               }
               else {
                    $option['taxonomies'] = array( 'category' , 'post_tag' );
               }
               /* Fix icon */
               if ( ! ( isset ( $option['menu_icon'] ) ) )
               {
                    $option['menu_icon'] = '';
               }

               $this->custom_post_types[] = array(
     			'post_type'             => $option['post_type'],
     			'name'                  => $option['plural_name'],
     			'singular_name'         => $option['singular_name'],
     			'menu_name'             => $option['plural_name'],
     			'name_admin_bar'        => $option['singular_name'],
     			'archives'              => $option['singular_name'] . ' Archives',
     			'attributes'            => $option['singular_name'] . ' Attributes',
     			'parent_item_colon'     => 'Parent ' . $option['singular_name'],
     			'all_items'             => 'All ' . $option['plural_name'],
     			'add_new_item'          => 'Add New ' . $option['singular_name'],
     			'add_new'               => 'Add New',
     			'new_item'              => 'New' . $option['singular_name'],
     			'edit_item'             => 'Edit ' . $option['singular_name'],
     			'update_item'           => 'Update ' . $option['singular_name'],
     			'view_item'             => 'View ' . $option['singular_name'],
     			'view_items'            => 'View ' . $option['plural_name'],
     			'search_items'          => 'View ' . $option['plural_name'],
     			'not_found'             => 'No ' . $option['singular_name'] . ' Found',
     			'not_found_in_trash'    => 'No ' . $option['singular_name'] . ' Found in Trash',
     			'featured_image'        => 'Featured Image',
     			'set_featured_image'    => 'Set Featured Image',
     			'remove_featured_image' => 'Remove Featured Image',
     			'use_featured_image'    => 'Use Featured Image',
     			'insert_into_item'      => 'Insert into ' . $option['singular_name'],
     			'uploaded_to_this_item' => 'Upload to this ' . $option['singular_name'],
     			'items_list'            => $option['plural_name'] . ' List',
     			'items_list_navigation' => $option['plural_name'] . ' List Navigation',
     			'filter_items_list'     => 'Filter ' . $option['plural_name'] . ' list',
     			'label'                 => $option['singular_name'],
     			'description'           => $option['plural_name'] . ' Custom Post Type',
     			'supports'              => array ( 'title' , 'editor' , 'thumbnail' ),
     			'taxonomies'            => $option['taxonomies'],
     			'hierarchical'          => false,
     			'public'                => isset ( $option['public'] ) ?: false,
     			'show_ui'               => true,
     			'show_in_menu'          => true,
     			'menu_position'         => 5,
                    'menu_icon'             => $option['menu_icon'],
     			'show_in_admin_bar'     => true,
     			'show_in_nav_menus'     => true,
     			'can_export'            => true,
     			'has_archive'           => isset ( $option['has_archive'] ) ?: false,
     			'exclude_from_search'   => false,
     			'publicly_queryable'    => true,
     			'capability_type'       => 'post'
     		);
          }

	}
}
