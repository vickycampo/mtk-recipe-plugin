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
use Inc\Api\Callbacks\TaxonomyCallbacks;

/**
 * Enqueue - Enqueue the scripts and style files
 */
class CustomTaxonomyController extends BaseController
{
     public $settings;
     public $callbacks;
     public $tax_callbacks;
     public $subpages = array ();
     public $taxonomies = array ();
     public function register ()
     {
          /* Check if it is active */
          if ( ! ( $this->activated( 'taxonomy_manager' ) ) ) return;
          /* Initialize the class that will actually generate the menu pages and subpages */
		$this->settings = new SettingsApi();
          /* Initialize the class that manages the */
		$this->callbacks = new AdminCallbacks();
          /* New instance of TaxonomyCallbacks */
          $this->tax_callbacks = new TaxonomyCallbacks();
          /* Call the subpages method */
          $this->setSubpages();
          /* Set the settings  */
		$this->setSettings();
          /* Set the Sections */
		$this->setSections();
          /* Set the Fields */
		$this->setFields();
          /* Add the subpages */
          $this->settings->addSubPages( $this->subpages )->register();
          /* Store the custom taxonomy */
          $this->storeCustomTaxonomies();
          // add_action ( 'init' , array ( $this , 'activate') );
          /* Register the taxonomy */
          if ( ! ( empty ( $this->taxonomies ) ) )
          {
               add_action ( 'init' , array( $this , 'registerCustomTaxonomy') );
          }

     }
     public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'mtk_plugin',
				'page_title' => 'Taxonomy Manager',
				'menu_title' => 'Taxonomy Manager',
				'capability' => 'manage_options',
				'menu_slug' => 'mtk_taxonomy',
				'callback' => array( $this->callbacks, 'adminTaxonomy' )
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
     public function setSettings()
     {
          $args = array (
               array (
                    'option_group' => 'mtk_plugin_tax_settings',
                    'option_name' => 'mtk_plugin_tax',
                    'callback' => array ($this->tax_callbacks, 'taxSanitize')
               )
          );
          $this->settings->setSettings($args);
     }
     public function setSections()
     {
          $args = array (
               array (
                    'id' => 'mtk_tax_index',
                    'title' => 'Custom Taxonomy Manager',
                    'callback' => array ( $this->tax_callbacks , 'taxSectionManager' ),
                    'page' => 'mtk_taxonomy'
               )
          );
          $this->settings->setSections($args);
     }
     public function setFields()
     {
          $args = array (
               array (
                    'id' => 'taxonomy',
                    'title' => 'Custom Taxonomy ID',
                    'callback' => array ( $this->tax_callbacks , 'textField' ),
                    'page' => 'mtk_taxonomy',
                    'section' => 'mtk_tax_index',
                    'args' => array (
                         'option_name' => 'mtk_plugin_tax',
                         'label_for' => 'taxonomy',
                         'placeholder' => 'eg. genre',
					'array' => 'taxonomy'
                    )
               ),
               // Singular name
               array(
                    'id' => 'singular_name',
                    'title' => 'Singular Name',
                    'callback' => array ($this->tax_callbacks , 'textField'),
                    'page' => 'mtk_taxonomy', //The slug of the page
                    'section' => 'mtk_tax_index', // The id of the seciton
                    'args' => array(
                         'option_name' => 'mtk_plugin_tax',
                         'label_for' => 'singular_name',
                         'placeholder' => 'eg. Genre',
					'array' => 'taxonomy'

                    )
               ),
               // public
               array(
                    'id' => 'hierarchical',
                    'title' => 'Hierarchical',
                    'callback' => array ($this->tax_callbacks , 'checkboxField'),
                    'page' => 'mtk_taxonomy', //The slug of the page
                    'section' => 'mtk_tax_index', // The id of the seciton
                    'args' => array(
                         'option_name' => 'mtk_plugin_tax',
                         'label_for' => 'hierarchical', /* The label should always match the id, that is the way we are sending the information to the callback function */
                         'class' => 'ui-toggle',
					'array' => 'taxonomy'
                    )
               )
          );
          $this->settings->setFields($args);
     }
     public function storeCustomTaxonomies()
     {
          /* Get the taxonomies array */
          if ( ! ( get_option ( 'mtk_plugin_tax' ) ) )
		{
               update_option ( 'mtk_plugin_tax' , array () );
			return;
		}
          $options = get_option ('mtk_plugin_tax');
          /* Store into an array */
          foreach ( $options as $option )
          {
               $labels = array(
				'name'              => $option['singular_name'],
				'singular_name'     => $option['singular_name'],
				'search_items'      => 'Search ' . $option['singular_name'],
				'all_items'         => 'All ' . $option['singular_name'],
				'parent_item'       => 'Parent ' . $option['singular_name'],
				'parent_item_colon' => 'Parent ' . $option['singular_name'] . ':',
				'edit_item'         => 'Edit ' . $option['singular_name'],
				'update_item'       => 'Update ' . $option['singular_name'],
				'add_new_item'      => 'Add New ' . $option['singular_name'],
				'new_item_name'     => 'New ' . $option['singular_name'] . ' Name',
				'menu_name'         => $option['singular_name'],
			);
			$this->taxonomies[] = array(
				'hierarchical'      => isset($option['hierarchical']) ? true : false,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => $option['taxonomy'] ),
			);
          }
     }
     public function registerCustomTaxonomy ()
     {
          foreach ( $this->taxonomies as $taxonomy )
          {
               register_taxonomy ( $taxonomy['rewrite']['slug'] , array( 'post' ) , $taxonomy );
          }
     }
}
