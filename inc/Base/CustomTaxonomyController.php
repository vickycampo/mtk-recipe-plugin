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
     public $TermsToInsert = array ();
     public function register ()
     {
          /* Check if it is active */
          if ( ! ( $this->activated( 'taxonomy_manager' ) ) ) return;
          /* Initialize the class that will actually generate the menu pages and subpages */
		$this->settings = new SettingsApi();
          /* Initialize the class that manages the CallBacks*/
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
          if ( ! ( empty ( $this->TermsToInsert ) ) )
          {
               add_action ( 'init' , array( $this , 'registerTerms') );
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
          $DefaultTax[$i]['taxonomy'] = 'recipe_tax';
          $DefaultTax[$i]['singular_name'] = 'Recipe Taxonomies';
          $DefaultTax[$i]['hierarchical'] = 1;
          $DefaultTax[$i]['objects']['default_recipe'] = 1;

               $j = 0;
               $k = 0;
               $TaxTerms[$i][$j][$k] = 'By meal';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Breakfast';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Brunch';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Lunch';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Dinner';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Snack';

               $j++;
               $k = 0;
               $TaxTerms[$i][$j][$k] = 'By meal course or type of dish';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Appetizer';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Main course';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Soup';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Salad';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Bread';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Pizza and Focaccia';

                    $k ++;
                    $l= 0;
                    $TaxTerms[$i][$j][$k][$l] = 'Dessert';
                         $l ++;
                         $TaxTerms[$i][$j][$k][$l] = 'Cakes';
                         $l ++;
                         $TaxTerms[$i][$j][$k][$l] = 'Confectionery and candies';
                         $l ++;
                         $TaxTerms[$i][$j][$k][$l] = 'Cookies';
                         $l ++;
                         $TaxTerms[$i][$j][$k][$l] = 'Custards';
                         $l ++;
                         $TaxTerms[$i][$j][$k][$l] = 'Dessert sauces';
                         $l ++;
                         $TaxTerms[$i][$j][$k][$l] = 'Doughnuts';
                         $l ++;
                         $TaxTerms[$i][$j][$k][$l] = 'Frozen desserts';
                         $l ++;
                         $TaxTerms[$i][$j][$k][$l] = 'Pastries';
                         $l ++;
                         $TaxTerms[$i][$j][$k][$l] = 'Pies';
                         $l ++;
                         $TaxTerms[$i][$j][$k][$l] = 'Puddings';


               $j++;
               $k = 0;
               $TaxTerms[$i][$j][$k] = 'By main ingredient';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Chicken';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Fish';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Eggs';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Meat';

               $j++;
               $k = 0;
               $TaxTerms[$i][$j][$k] = 'By dietary restrictions';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Gluten-free';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Vegetarian';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Vegan';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Nut-free';

               $j++;
               $k = 0;
               $TaxTerms[$i][$j][$k] = 'By holiday';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Christmas';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Lunar New Year';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Passover';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Thanksgiving';
               $j++;
               $k = 0;
               $TaxTerms[$i][$j][$k] = 'By preparation time';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Quick Recipes';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Time-consuming';
               $j++;
               $k = 0;
               $TaxTerms[$i][$j][$k] = 'By status';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Untested';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'old favorites';

               $j++;
               $k = 0;
               $TaxTerms[$i][$j][$k] = 'By cooking method';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'outdoor grill';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'slow cooker';

               $j++;
               $k = 0;
               $TaxTerms[$i][$j][$k] = 'By source';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Family Recipes';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Bon Appétit magazine';
               $j++;
               $k = 0;
               $TaxTerms[$i][$j][$k] = 'By part of the world';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Indian';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Italian';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Korean';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Thai';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Spanish';
                    $k ++;
                    $TaxTerms[$i][$j][$k] = 'Guatemalan';


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

                    $x = 0;


                    foreach ( $TaxTerms[$i] as $j => $termInfo )
                    {
                         $parentTerm = $termInfo[0];
                         $term = term_exists( $parentTerm, $input['taxonomy'] );
                         if ( 0 == $term && null == $term )
                         {
                              /* Generate the slug */
                              $slug = str_replace ( " " , "-" , $parentTerm );
                              $slug = strtolower ( $slug );

                              $this->TermsToInsert[$x]['term'] = $parentTerm;
                              $this->TermsToInsert[$x]['taxonomy'] = $input['taxonomy'];
                              $this->TermsToInsert[$x]['args'] = array(
                                   'description'=> $parentTerm,
                                   'slug' => $slug
                              );
                              $x++;
                         }
                         /* has another level */
                         if ( count ($termInfo) > 1 )
                         {

                              foreach ($termInfo as $k => $childTerm)
                              {
                                   /* last one */

                                   if (( ! is_array ($childTerm) )&& ( $k !=0 ))
                                   {
                                        $term = term_exists( $childTerm, $input['taxonomy'] );
                                        if ( 0 == $term && null == $term )
                                        {
                                             $slug = str_replace ( " " , "-" , $childTerm );
                                             $slug = strtolower ( $slug );


                                             $this->TermsToInsert[$x]['term'] = $childTerm;
                                             $this->TermsToInsert[$x]['taxonomy'] = $input['taxonomy'];
                                             $this->TermsToInsert[$x]['args'] = array(
                                                  'description'=> $childTerm,
                                                  'slug' => $slug,
                                                  'parent'=> $termInfo[0]
                                             );
                                             $x++;
                                        }

                                   }
                                   else if ( is_array ($childTerm) )
                                   {
                                        $term = term_exists( $childTerm[0], $input['taxonomy'] );
                                        if ( 0 == $term && null == $term )
                                        {

                                             $slug = str_replace ( " " , "-" , $childTerm[0] );
                                             $slug = strtolower ( $slug );

                                             $this->TermsToInsert[$x]['term'] = $childTerm[0];
                                             $this->TermsToInsert[$x]['taxonomy'] = $input['taxonomy'];
                                             $this->TermsToInsert[$x]['args'] = array(
                                                  'description'=> $childTerm[0],
                                                  'slug' => $slug,
                                                  'parent'=> $parentTerm
                                             );
                                             $x++;
                                        }
                                        foreach ($childTerm as $l => $GrandTerm)
                                        {
                                             if ( $l != 0 )
                                             {
                                                  $term = term_exists( $GrandTerm, $input['taxonomy'] );
                                                  if ( 0 == $term && null == $term )
                                                  {
                                                       $slug = str_replace ( " " , "-" , $GrandTerm );
                                                       $slug = strtolower ( $slug );
                                                       $this->TermsToInsert[$x]['term'] = $GrandTerm;
                                                       $this->TermsToInsert[$x]['taxonomy'] = $input['taxonomy'];
                                                       $this->TermsToInsert[$x]['args'] = array(
                                                            'description'=> $GrandTerm,
                                                            'slug' => $slug,
                                                            'parent'=> $childTerm[0]
                                                       );
                                                       $x++;
                                                  }
                                             }
                                        }
                                   }

                              }
                         }
                    }

               }
          }


     }
     public function registerTerms ()
     {

          if ( isset ($this->TermsToInsert) )
          {
               foreach ($this->TermsToInsert as $key => $value)
               {
                    /* Get the parent Id */
                    if ( isset ($value['args']['parent']) )
                    {
                         $parent_term = term_exists( $value['args']['parent'], $value['taxonomy'] );
                         $value['args']['parent'] = $parent_term['term_id'];
                    }
                    //error_log (print_r ( $value , true ));
                    /* Register the new term */
                    wp_insert_term(
                         $value['term'], // the term
                         $value['taxonomy'], // the taxonomy
                         $value['args']
                    );
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
