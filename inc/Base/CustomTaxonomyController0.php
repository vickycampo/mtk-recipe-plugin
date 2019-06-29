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
          /* Create a default set of Taxonomies */
          $this->register_default_taxnomies ();
          // add_action ( 'init' , array ( $this , 'activate') );
          /* Register the taxonomy */
          if ( ! ( empty ( $this->taxonomies ) ) )
          {
               add_action ( 'init' , array( $this , 'registerCustomTaxonomy') );
          }
          /* Update taxonomies based on posible post changes */
          $this->updateChanges ();
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
               // hierarchical
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
               ),
               /* Associated Post Tyhpes */
               array(
                    'id' => 'objects',
                    'title' => 'Post Types',
                    /* We want a list of all the available post types */
                    'callback' => array ($this->tax_callbacks , 'checkboxPostTypesField'),
                    'page' => 'mtk_taxonomy', //The slug of the page
                    'section' => 'mtk_tax_index', // The id of the seciton
                    'args' => array(
                         'option_name' => 'mtk_plugin_tax',
                         'label_for' => 'objects', /* The label should always match the id, that is the way we are sending the information to the callback function */
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
			$this->taxonomies[$option['taxonomy']] = array(
				'hierarchical'      => isset($option['hierarchical']) ? true : false,
				'labels'            => $labels,
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
                    'show_in_rest'      => true,
				'rewrite'           => array( 'slug' => $option['taxonomy'] ),
                    'objects'           => isset ( $option['objects'] ) ? $option['objects'] : null
			);
          }
     }
     public function register_default_taxnomies ()
     {
          $i = 0;
          $DefaultTax[$i]['taxonomy'] = 'by-meal';
          $DefaultTax[$i]['singular_name'] = 'By meal';
          $DefaultTax[$i]['hierarchical'] = 1;
          $DefaultTax[$i]['objects']['default_recipe'] = 1;

          $j = 0;
          $TaxTerms[$i][$j]['term'] = 'Breakfast';
          $TaxTerms[$i][$j]['taxonomy'] = $DefaultTax[$i]['taxonomy'];
          $TaxTerms[$i][$j]['args'] = array (
               'description'=> 'A yummy apple.',
               'slug' => 'apple',
               'parent'=> $parent_term['term_id']  // get numeric term id
          );

          $i++;
          $DefaultTax[$i]['taxonomy'] = 'by-meal-course-or-type-of-dish';
          $DefaultTax[$i]['singular_name'] = 'By meal course or type of dish';
          $DefaultTax[$i]['hierarchical'] = 1;
          $DefaultTax[$i]['objects']['default_recipe'] = 1;

          $i++;
          $DefaultTax[$i]['taxonomy'] = 'by-main-ingredient';
          $DefaultTax[$i]['singular_name'] = 'By main ingredient';
          $DefaultTax[$i]['hierarchical'] = 1;
          $DefaultTax[$i]['objects']['default_recipe'] = 1;

          $i++;
          $DefaultTax[$i]['taxonomy'] = 'by-dietary-restrictions';
          $DefaultTax[$i]['singular_name'] = 'By dietary restrictions';
          $DefaultTax[$i]['hierarchical'] = 1;
          $DefaultTax[$i]['objects']['default_recipe'] = 1;

          $i++;
          $DefaultTax[$i]['taxonomy'] = 'by-holiday';
          $DefaultTax[$i]['singular_name'] = 'By holiday';
          $DefaultTax[$i]['hierarchical'] = 1;
          $DefaultTax[$i]['objects']['default_recipe'] = 1;

          $i++;
          $DefaultTax[$i]['taxonomy'] = 'by-preparation-time';
          $DefaultTax[$i]['singular_name'] = 'By preparation time';
          $DefaultTax[$i]['hierarchical'] = 1;
          $DefaultTax[$i]['objects']['default_recipe'] = 1;

          $i++;
          $DefaultTax[$i]['taxonomy'] = 'by-status';
          $DefaultTax[$i]['singular_name'] = 'By status';
          $DefaultTax[$i]['hierarchical'] = 1;
          $DefaultTax[$i]['objects']['default_recipe'] = 1;

          $i++;
          $DefaultTax[$i]['taxonomy'] = 'by-cooking-method';
          $DefaultTax[$i]['singular_name'] = 'By cooking method';
          $DefaultTax[$i]['hierarchical'] = 1;
          $DefaultTax[$i]['objects']['default_recipe'] = 1;

          $i++;
          $DefaultTax[$i]['taxonomy'] = 'by-source';
          $DefaultTax[$i]['singular_name'] = 'By source';
          $DefaultTax[$i]['hierarchical'] = 1;
          $DefaultTax[$i]['objects']['default_recipe'] = 1;

          $i++;
          $DefaultTax[$i]['taxonomy'] = 'by-part-of-the-world';
          $DefaultTax[$i]['singular_name'] = 'By part of the world';
          $DefaultTax[$i]['hierarchical'] = 1;
          $DefaultTax[$i]['objects']['default_recipe'] = 1;

          error_log (__FILE__ . ' - ' . __LINE__ . ' - ' . __FUNCTION__);
          error_log(print_r($DefaultTax, true));
          error_log('--------------------------------------------');

          // $input['taxonomy'] = '';
          foreach ($DefaultTax as $i => $input )
          {
               if ( ! ( isset ( $this->taxonomies[$input['taxonomy']] ) ) )
               {
                    $output = $this->tax_callbacks->taxSanitize ( $input );
                    /* update option */
                    $option = 'mtk_plugin_tax';
                    update_option( $option, $output);
                    /* Update the array */
                    $this->storeCustomTaxonomies();
               }
          }


     }
     public function registerCustomTaxonomy ()
     {
          foreach ( $this->taxonomies as $taxonomy )
          {
               $objects = isset ( $taxonomy['objects'] ) ? array_keys ($taxonomy['objects']) : null ;
               register_taxonomy ( $taxonomy['rewrite']['slug'] , $objects , $taxonomy );
          }
     }
     /* Update taxonomies based on posible post changes */
     public function updateChanges ()
     {
          /* Get the */
     }
}
