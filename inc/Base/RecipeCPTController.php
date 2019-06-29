<?php
/*

@package mkt-recipe-plugin

===================================
RecipeCPTController.PHP
===================================
*
*
*/
namespace Inc\Base;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Base\RecipeCPTFunctions;
use Inc\Api\Widgets\MediaWidget;
use Inc\Api\Callbacks\CptCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;


/**
* Enqueue - Enqueue the scripts and style files
*/
class RecipeCPTController extends BaseController
{
     public $settings;
     public $callbacks;
     public $cpt_callbacks;
     public $subpages = array();
     public $custom_post_types = array();
     public $customFields = array ();
     public $ordered;
     public $current_post_type;
     public $r_cptFuntions;
     public $scriptsAdded = false;


     public function register ()
     {
          /* Check if it is active */
          if ( ! ( $this->activated( 'recipe_cpt_manager' ) ) ) return;


          /* Initialize the class that will actually generate the menu pages and subpages */
          $this->settings = new SettingsApi();
          /* Initialize the class that manages the */
          $this->callbacks = new AdminCallbacks();
          /* Initialize the class that manages the */
          $this->cpt_callbacks = new CptCallbacks();
          /* Initialize the class that manages the */
          $this->r_cptFuntions = new RecipeCPTFunctions();
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
          /* Register a default Recipe post type*/
          $this->register_default_cpt ();
          /* If the user has defined post types then we register the type */
          if ( ! empty ( $this->custom_post_types ))
          {
               add_action ( 'init' , array ( $this , 'registerCustomPostTypes') );
          }
          /* Manage CPT columns */
          if ( isset ( $this->customFields ) )
          {
               /* if wer are using Custom Fields we also need to activate the mediawidget */
               $media_widget = new MediaWidget ();
               $media_widget -> register ();
               $this->manage_cpt_columns (  );
          }
          /* If we have meta boxes it means that we need to insert the short-code */
          add_shortcode('cpt_shortcode', array ( $this , 'cpt_shortcode' ) );

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
               ),
               /* customFields */
               array(
                    'id' => 'customFields',
                    'title' => 'Customize Fields',
                    'callback' => array ($this->cpt_callbacks , 'customFields'),
                    'page' => 'mtk_cpt', //The slug of the page
                    'section' => 'mtk_cpt_index', // The id of the seciton
                    'args' => array(
                         'option_name' => 'mtk_plugin_cpt',
                         'label_for' => 'customFields',
                         'placeholder' => array(
                              'ID' => 'author_name',
                              'Name' => 'Author Name',
                              'Type' => 'text',
                              'Parent' =>'parent_field',
                              'Show_in_columns' => false,
                              'add_remove_buttons' => false
                         ),
                         'array' => 'post_type'
                    )
               ),
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
                    'show_in_rest'              => $post_type['show_in_rest'],
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
          /* After adding the post type we should add the filter to fix the title */



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

          $this->custom_post_types[$option['post_type']] = array(
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
               'show_in_rest'          => true,
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
          /* Add the information to the local variable */

          if ( isset ( $option['customFields'] ) )
          {
               /* Add the custom Fields to a variable that we are going to use in the rest of the functions */
               $this->getColumns ( $option['post_type'] , $option['customFields'] );
          }
     }



}
public function register_default_cpt ()
{
     if ( ! ( isset ( $this->custom_post_types['default_recipe'] ) ) )
     {
          /* We don't have a default post type yet so we need to register it */
          $input['post_type'] = 'default_recipe';
          $input['singular_name'] = 'Recipe';
          $input['plural_name'] = 'Recipes';
          $input['menu_icon'] = 'dashicons-carrot';
          $input['public'] = 1;
          $input['has_archive'] = 1;

          /* General Section */
          $i = 0;
          $input['customFields'][$i]['ID'] = 'general';
          $input['customFields'][$i]['Name'] = 'Recipe';
          $input['customFields'][$i]['Type'] = 'Section';
          $input['customFields'][$i]['Parent'] = 'general';
          $input['customFields'][$i]['Show_in_columns'] = false;
          $input['customFields'][$i]['add_remove_buttons'] = false;


               $i++;
               $input['customFields'][$i]['ID'] = 'recipe_name';
               $input['customFields'][$i]['Name'] = 'Name';
               $input['customFields'][$i]['Type'] = 'Item';
               $input['customFields'][$i]['Parent'] = 'general';
               $input['customFields'][$i]['Show_in_columns'] = true;
               $input['customFields'][$i]['add_remove_buttons'] = false;

               $i++;
               $input['customFields'][$i]['ID'] = 'recipe_author';
               $input['customFields'][$i]['Name'] = 'Author';
               $input['customFields'][$i]['Type'] = 'Item';
               $input['customFields'][$i]['Parent'] = 'general';
               $input['customFields'][$i]['Show_in_columns'] = true;
               $input['customFields'][$i]['add_remove_buttons'] = false;

               $i++;
               $input['customFields'][$i]['ID'] = 'recipe_image_file';
               $input['customFields'][$i]['Name'] = 'Image';
               $input['customFields'][$i]['Type'] = 'Item';
               $input['customFields'][$i]['Parent'] = 'general';
               $input['customFields'][$i]['Show_in_columns'] = false;
               $input['customFields'][$i]['add_remove_buttons'] = false;

               $i++;
               $input['customFields'][$i]['ID'] = 'recipe_description';
               $input['customFields'][$i]['Name'] = 'Description';
               $input['customFields'][$i]['Type'] = 'Item';
               $input['customFields'][$i]['Parent'] = 'general';
               $input['customFields'][$i]['Show_in_columns'] = true;
               $input['customFields'][$i]['add_remove_buttons'] = false;

               $i++;
               $input['customFields'][$i]['ID'] = 'recipe_servings';
               $input['customFields'][$i]['Name'] = 'Servings';
               $input['customFields'][$i]['Type'] = 'Item';
               $input['customFields'][$i]['Parent'] = 'general';
               $input['customFields'][$i]['Show_in_columns'] = false;
               $input['customFields'][$i]['add_remove_buttons'] = false;

               /* Cooking Time */
               $i++;
               $input['customFields'][$i]['ID'] = 'recipe_times';
               $input['customFields'][$i]['Name'] = 'Times';
               $input['customFields'][$i]['Type'] = 'Item';
               $input['customFields'][$i]['Parent'] = 'general';
               $input['customFields'][$i]['Show_in_columns'] = true;
               $input['customFields'][$i]['add_remove_buttons'] = false;

                    $i++;
                    $input['customFields'][$i]['ID'] = 'recipe_prep_time';
                    $input['customFields'][$i]['Name'] = 'Prep Time';
                    $input['customFields'][$i]['Type'] = 'SubItem';
                    $input['customFields'][$i]['Parent'] = 'recipe_times';
                    $input['customFields'][$i]['Show_in_columns'] = true;
                    $input['customFields'][$i]['add_remove_buttons'] = false;

                    $i++;
                    $input['customFields'][$i]['ID'] = 'recipe_cook_time';
                    $input['customFields'][$i]['Name'] = 'Cook Time';
                    $input['customFields'][$i]['Type'] = 'SubItem';
                    $input['customFields'][$i]['Parent'] = 'recipe_times';
                    $input['customFields'][$i]['Show_in_columns'] = true;
                    $input['customFields'][$i]['add_remove_buttons'] = false;

                    $i++;
                    $input['customFields'][$i]['ID'] = 'recipe_passive_time';
                    $input['customFields'][$i]['Name'] = 'Passive Time';
                    $input['customFields'][$i]['Type'] = 'SubItem';
                    $input['customFields'][$i]['Parent'] = 'recipe_times';
                    $input['customFields'][$i]['Show_in_columns'] = true;
                    $input['customFields'][$i]['add_remove_buttons'] = false;

          /* Group Section */
          $i++;
          $input['customFields'][$i]['ID'] = 'group';
          $input['customFields'][$i]['Name'] = 'Group';
          $input['customFields'][$i]['Type'] = 'Section';
          $input['customFields'][$i]['Parent'] = 'group';
          $input['customFields'][$i]['Show_in_columns'] = false;
          $input['customFields'][$i]['add_remove_buttons'] = true;

               /* Ingredients Section */
               $i++;
               $input['customFields'][$i]['ID'] = 'recipe_group_general';
               $input['customFields'][$i]['Name'] = 'Group General';
               $input['customFields'][$i]['Type'] = 'SubSection';
               $input['customFields'][$i]['Parent'] = 'group';
               $input['customFields'][$i]['Show_in_columns'] = false;
               $input['customFields'][$i]['add_remove_buttons'] = false;

                    /* Gropup detials */
                    $i++;
                    $input['customFields'][$i]['ID'] = 'recipe_group_general_name';
                    $input['customFields'][$i]['Name'] = 'Procedure Name';
                    $input['customFields'][$i]['Type'] = 'Item';
                    $input['customFields'][$i]['Parent'] = 'recipe_group_general';
                    $input['customFields'][$i]['Show_in_columns'] = false;
                    $input['customFields'][$i]['add_remove_buttons'] = false;

                    $i++;
                    $input['customFields'][$i]['ID'] = 'recipe_group_general_notes';
                    $input['customFields'][$i]['Name'] = 'Procedure Notes';
                    $input['customFields'][$i]['Type'] = 'Item';
                    $input['customFields'][$i]['Parent'] = 'recipe_group_general';
                    $input['customFields'][$i]['Show_in_columns'] = false;
                    $input['customFields'][$i]['add_remove_buttons'] = false;

                    $i++;
                    $input['customFields'][$i]['ID'] = 'recipe_group_general_image_file';
                    $input['customFields'][$i]['Name'] = 'Procedure Image';
                    $input['customFields'][$i]['Type'] = 'Item';
                    $input['customFields'][$i]['Parent'] = 'recipe_group_general';
                    $input['customFields'][$i]['Show_in_columns'] = false;
                    $input['customFields'][$i]['add_remove_buttons'] = false;

               /* Ingredients Section */
               $i++;
               $input['customFields'][$i]['ID'] = 'recipe_ingredients';
               $input['customFields'][$i]['Name'] = 'Ingredients';
               $input['customFields'][$i]['Type'] = 'SubSection';
               $input['customFields'][$i]['Parent'] = 'group';
               $input['customFields'][$i]['Show_in_columns'] = false;
               $input['customFields'][$i]['add_remove_buttons'] = false;

                    /* Single Ingredient Section */
                    $i++;
                    $input['customFields'][$i]['ID'] = 'recipe_ingredient_item';
                    $input['customFields'][$i]['Name'] = 'Ingredient';
                    $input['customFields'][$i]['Type'] = 'Item';
                    $input['customFields'][$i]['Parent'] = 'recipe_ingredients';
                    $input['customFields'][$i]['Show_in_columns'] = false;
                    $input['customFields'][$i]['add_remove_buttons'] = true;

                    $i++;
                    $input['customFields'][$i]['ID'] = 'recipe_ingredient_quantity';
                    $input['customFields'][$i]['Name'] = 'Quantity';
                    $input['customFields'][$i]['Type'] = 'SubItem';
                    $input['customFields'][$i]['Parent'] = 'recipe_ingredient_item';
                    $input['customFields'][$i]['Show_in_columns'] = false;
                    $input['customFields'][$i]['add_remove_buttons'] = false;

                    $i++;
                    $input['customFields'][$i]['ID'] = 'recipe_ingredient_unit';
                    $input['customFields'][$i]['Name'] = 'Unit';
                    $input['customFields'][$i]['Type'] = 'SubItem';
                    $input['customFields'][$i]['Parent'] = 'recipe_ingredient_item';
                    $input['customFields'][$i]['Show_in_columns'] = false;
                    $input['customFields'][$i]['add_remove_buttons'] = false;

                    $i++;
                    $input['customFields'][$i]['ID'] = 'recipe_ingredient_name';
                    $input['customFields'][$i]['Name'] = 'Ingredient Name';
                    $input['customFields'][$i]['Type'] = 'SubItem';
                    $input['customFields'][$i]['Parent'] = 'recipe_ingredient_item';
                    $input['customFields'][$i]['Show_in_columns'] = false;
                    $input['customFields'][$i]['add_remove_buttons'] = false;

                    $i++;
                    $input['customFields'][$i]['ID'] = 'recipe_ingredient_notes';
                    $input['customFields'][$i]['Name'] = 'Notes';
                    $input['customFields'][$i]['Type'] = 'SubItem';
                    $input['customFields'][$i]['Parent'] = 'recipe_ingredient_item';
                    $input['customFields'][$i]['Show_in_columns'] = false;
                    $input['customFields'][$i]['add_remove_buttons'] = false;

               /* Instructions Section */
               $i++;
               $input['customFields'][$i]['ID'] = 'recipe_instructions';
               $input['customFields'][$i]['Name'] = 'Instructions';
               $input['customFields'][$i]['Type'] = 'SubSection';
               $input['customFields'][$i]['Parent'] = 'group';
               $input['customFields'][$i]['Show_in_columns'] = false;
               $input['customFields'][$i]['add_remove_buttons'] = false;

                    /* Step Section */
                    $i++;
                    $input['customFields'][$i]['ID'] = 'recipe_instructions_step';
                    $input['customFields'][$i]['Name'] = 'Step';
                    $input['customFields'][$i]['Type'] = 'Item';
                    $input['customFields'][$i]['Parent'] = 'recipe_instructions';
                    $input['customFields'][$i]['Show_in_columns'] = false;
                    $input['customFields'][$i]['add_remove_buttons'] = true;

                    $i++;
                    $input['customFields'][$i]['ID'] = 'recipe_step_number';
                    $input['customFields'][$i]['Name'] = 'Step Number';
                    $input['customFields'][$i]['Type'] = 'SubItem';
                    $input['customFields'][$i]['Parent'] = 'recipe_instructions_step';
                    $input['customFields'][$i]['Show_in_columns'] = false;
                    $input['customFields'][$i]['add_remove_buttons'] = false;

                    $i++;
                    $input['customFields'][$i]['ID'] = 'recipe_step_instruction';
                    $input['customFields'][$i]['Name'] = 'Instruction';
                    $input['customFields'][$i]['Type'] = 'SubItem';
                    $input['customFields'][$i]['Parent'] = 'recipe_instructions_step';
                    $input['customFields'][$i]['Show_in_columns'] = false;
                    $input['customFields'][$i]['add_remove_buttons'] = false;

                    $i++;
                    $input['customFields'][$i]['ID'] = 'recipe_step_image_file';
                    $input['customFields'][$i]['Name'] = 'Instructions Image';
                    $input['customFields'][$i]['Type'] = 'SubItem';
                    $input['customFields'][$i]['Parent'] = 'recipe_instructions_step';
                    $input['customFields'][$i]['Show_in_columns'] = false;
                    $input['customFields'][$i]['add_remove_buttons'] = false;

          /* Extras Section */
          $i++;
          $input['customFields'][$i]['ID'] = 'recipe_extras';
          $input['customFields'][$i]['Name'] = 'Extra Information';
          $input['customFields'][$i]['Type'] = 'Section';
          $input['customFields'][$i]['Parent'] = 'recipe_extras';
          $input['customFields'][$i]['Show_in_columns'] = false;
          $input['customFields'][$i]['add_remove_buttons'] = false;

          $i++;
          $input['customFields'][$i]['ID'] = 'recipe_notes';
          $input['customFields'][$i]['Name'] = 'Recipe notes';
          $input['customFields'][$i]['Type'] = 'Item';
          $input['customFields'][$i]['Parent'] = 'recipe_extras';
          $input['customFields'][$i]['Show_in_columns'] = false;
          $input['customFields'][$i]['add_remove_buttons'] = true;

          $i++;
          $input['customFields'][$i]['ID'] = 'recipe_video';
          $input['customFields'][$i]['Name'] = 'Recipe Video';
          $input['customFields'][$i]['Type'] = 'Item';
          $input['customFields'][$i]['Parent'] = 'recipe_extras';
          $input['customFields'][$i]['Show_in_columns'] = false;
          $input['customFields'][$i]['add_remove_buttons'] = true;

               $i++;
               $input['customFields'][$i]['ID'] = 'recipe_video_file';
               $input['customFields'][$i]['Name'] = 'Recipe Video';
               $input['customFields'][$i]['Type'] = 'SubItem';
               $input['customFields'][$i]['Parent'] = 'recipe_video';
               $input['customFields'][$i]['Show_in_columns'] = false;
               $input['customFields'][$i]['add_remove_buttons'] = false;
               $i++;
               $input['customFields'][$i]['ID'] = 'recipe_video_title';
               $input['customFields'][$i]['Name'] = 'Video Title';
               $input['customFields'][$i]['Type'] = 'SubItem';
               $input['customFields'][$i]['Parent'] = 'recipe_video';
               $input['customFields'][$i]['Show_in_columns'] = false;
               $input['customFields'][$i]['add_remove_buttons'] = false;
               $i++;
               $input['customFields'][$i]['ID'] = 'recipe_video_notes';
               $input['customFields'][$i]['Name'] = 'Video Notes';
               $input['customFields'][$i]['Type'] = 'SubItem';
               $input['customFields'][$i]['Parent'] = 'recipe_video';
               $input['customFields'][$i]['Show_in_columns'] = false;
               $input['customFields'][$i]['add_remove_buttons'] = false;






          $output = $this->cpt_callbacks->cptSanitize ( $input );
          /* update option */
          $option = 'mtk_plugin_cpt';
          update_option( $option, $output);
          /* Update the array */
          $this->storeCustomPostTypes();

     }
}

/* We are going to manage the custom columns of the cpt */
/* Set columns */
public function getColumns ( $post_type , $customFields)
{
     $this->customFields[$post_type] = $customFields;

}
public function manage_cpt_columns (  )
{

     /* Add metabox */
     add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
     // /* Save new fields of the meta boxes */
     add_action ( 'save_post' , array ( $this , 'save_meta_box') );

     foreach ( $this->customFields as $post_type => $customFields )
     {
          $this->ordered[$post_type] = $this->orderCustomcolumns ( $customFields );
          if ( count ( $this->ordered[$post_type] ) == 0 )
          {
               unset ( $this->ordered[$post_type] );
               unset ( $this->customFields[$post_type] );
          }
          else
          {
               $this->current_post_type = $post_type;

               /* Edit the custom columns of the custom post type */
               add_action ( 'manage_' . $post_type . '_posts_columns' , array ( $this , 'set_custom_column' ) );
               /* We are going to hook the custom columns with the information */
               add_action ( 'manage_' . $post_type . '_custom_column' , array ( $this , 'set_custom_columns_data' ) , 10 , 2 );
               /* add a filter to make the columns sortable */
               add_filter ( 'manage_edit-' . $post_type . '_sortable_columns' , array ( $this , 'set_custom_columns_sortable' ) );
          }

     }


}
/* order custom columns array */
public function orderCustomcolumns ( $customFields )
{
     $ordered = [];
     while ( count ( $customFields  ) > 0)
     {
          foreach ($customFields as $i => $fields)
          {
               if ( isset ( $fields['Parent'] ) )
               {
                    /* Section */
                    if ($fields['Parent'] == $fields['ID'])
                    {
                         $ordered[$fields['ID']]['field-info'] = $fields;

                         unset ($customFields[$i]);
                    }
                    /* We check if we have the parent in the parent array */
                    else if ( isset ( $ordered[ $fields['Parent'] ] ) )
                    {

                         $ordered[ $fields['Parent'] ] [$fields['ID'] ] ['field-info'] =  $fields;
                         /* array to find the parent afterwards */
                         $firstIndex[$fields['ID']] = $fields['Parent'];
                         unset ($customFields[$i]);
                    }
                    /* We didn't find the parent so we find the grandparent  */
                    else if ( isset ( $firstIndex[$fields['Parent'] ] ) )
                    {
                         $second = $fields['Parent'];
                         $first = $firstIndex [ $fields['Parent'] ] ;
                         $id = $fields['ID'];

                         $ordered[ $first ] [ $second ] [ $id ] ['field-info'] =  $fields;
                         $secondIndex[$id] = $second;

                         unset ($customFields[$i]);
                    }
                    /* We didn't find the grandparent so we look for the greatgrandad */
                    else if ( isset ( $secondIndex[ $fields['Parent'] ] ) )
                    {
                         $id = $fields['ID'];
                         $third = $fields['Parent'];
                         $second = $secondIndex[ $fields['Parent'] ];
                         $first = $firstIndex [ $second ] ;
                         $ordered[ $first ] [ $second ] [ $third ] [ $id ] ['field-info'] =  $fields;
                         $thirdIndex[$id] = $third;
                         unset ($customFields[$i]);
                    }
                    else if ( isset ( $thirdIndex[ $fields['Parent'] ] ) )
                    {
                         $id = $fields['ID'];
                         $fourth = $fields['Parent'];
                         $third = $thirdIndex[ $fields['Parent'] ];
                         $second = $secondIndex[ $third ];
                         $first = $firstIndex[$second];
                         $ordered[ $first ] [ $second ] [ $third ] [ $fourth ] [ $id ] ['field-info'] =  $fields;
                         unset ($customFields[$i]);
                    }
               }
               else
               {
                    unset ($customFields[$i]);
               }
          }
     }



     return ($ordered);


}
/* Enqueue styles and scripts */
public function enqueue ()
{
     /* Enqueue the styles and scripts*/
     // error_log (__FUNCTION__ . ' - ' . __LINE__) . '<pre>';
     // error_log ($this->plugin_url . 'assets/cpt_customFields.css');
     // error_log ($this->plugin_url . 'assets/cpt_customFields.js');
     // error_log ('<br>----------------------------</pre>');
     wp_enqueue_style ( 'authStyle' , $this->plugin_url . 'assets/cpt_customFields.css');
     wp_enqueue_script ( 'authScript' , $this->plugin_url . 'assets/cpt_customFields.js');

}
/* Functions for the shortCodes */

public function cpt_shortcode()
{
     /* require one simple php file that contains the form */
     /* Read but don't execute */
     ob_start ();
     /* Load the contact form */
     require_once ( "$this->plugin_path/templates/shortcode/cpt_shortcode.php");

     return ( ob_get_clean () );
}
/* Adds the meta boxes */
public function add_meta_boxes( $post_type )
{
     /* Check if we have columns */
     if ( ! isset ( $this->ordered[$post_type] ) )
     {
          /* empty array, nothing to add */
          return ;
     }


     /* We create the meta boxes based on the section name */
     foreach ( $this->ordered[$post_type] as $id => $fields )
     {



          unset ($id_value);
          $id_value[0] = $id . '_0';

          if ( isset ( $fields['field-info']['add_remove_buttons'] ) && ( $fields['field-info']['add_remove_buttons'] ) )
          {
               $id_value = $this->r_cptFuntions->addIdExtension ( $post_type , $id );
          }

          foreach ($id_value as $i => $FixedId)
          {
               // error_log (__FUNCTION__ . ' - ' . __LINE__);
               // error_log ( print_r ( $FixedId , true ) );
               // error_log ( print_r ( $fields , true ) );
               // error_log ('----------------------------');

               $title = $fields['field-info']['Name'];
               $callback = array ( $this , 'render_features_box');
               $screen = $post_type;
               $context = 'normal';
               $priority = 'default';
               $callback_args = '';

               add_meta_box ( $FixedId, $title, $callback, $screen, $context, $priority, $callback_args );
          }



     }


}
/* Creates the actual meta box that is previously added */
public function render_features_box ( $post , $args )
{
     /* add scripts and css */
     if ( ! $this->scriptsAdded )
     {
          echo ( "<script src=\"$this->plugin_url/assets/cpt_customFields.js\"></script> " );
          echo ( "<link rel=\"stylesheet\" href=\"$this->plugin_url/assets/cpt_customFields.css\"> " );
          $this->scriptsAdded = true;
     }

     /*get the post type based on the post */
     /* Get the post type */
     $post_type = $post->post_type;
     $post_id = $post->ID;
     $id = $args['id'];

     /*  validate that the contents of the form request */
     echo '<p style="display: none;">';
     wp_nonce_field( 'mtk_'.$post_type.'_nonce_' . $post_id, 'mtk_'.$post_type.'_nonce', FALSE );
     echo '</p>';

     /* Get the data */
     unset ($data);
     $data  = get_post_meta ( $post->ID , '_mtk_' . $post_type . '_'. $id , true );


     /* Multiple sections? */
     $add_remove_buttons = false;
     $fieldName = $this->r_cptFuntions->createFieldName ( $post_type , '', $id );
     /* We got a fixed id, we need to fix it to make it valid for our array */
     if ( ! ( isset ($this->ordered[$post_type][$id]) ) )
     {
          $simpleId = $this->r_cptFuntions->removeIdExtension( $id );
     }
     $textForId = $fieldName;
     $textForId = str_replace( "[" , "-" , $textForId );
     $textForId = str_replace( "]" , "-" , $textForId );
     echo ('<div class="'.$this->ordered[$post_type][$simpleId]['field-info']['Type'].'_div " id="'.$textForId.'">');

     if (isset ($this->ordered[$post_type][$simpleId]['field-info']['add_remove_buttons']) && ( $this->ordered[$post_type][$simpleId]['field-info']['add_remove_buttons'] ))
     {
          $add_remove_buttons = true;
          $this->r_cptFuntions->add_remove_buttons( $fieldName );
     }

     foreach ( $this->ordered[$post_type][$simpleId] as $fieldId => $fieldInfo )
     {

          /* We don't use the field-info */
          if ( $fieldId != 'field-info' )
          {
               $values = $this->r_cptFuntions->filterMetadata( $fieldId , $data );

               /* What type?*/
               if ($fieldInfo['field-info']['Type'] == 'Section')
               {

               }
               else if ($fieldInfo['field-info']['Type'] == 'SubSection')
               {

                    $this->r_cptFuntions->SetSubSectionFields ( $post_type , $fieldInfo , $id , $values);
               }
               else if ($fieldInfo['field-info']['Type'] == 'Item')
               {
                    $this->r_cptFuntions->SetItemFields ( $post_type , $fieldInfo , $id , $values);
               }
               else if ($fieldInfo['field-info']['Type'] == 'SubItem')
               {

               }
          }
     }
     echo ('</div><!-- ' . $fieldName . ' -->');

}

/* Saves the data we have added to the Meta box */
public function save_meta_box( $post_id)
{
     /*---------------- Prevous checks and information ----------------*/
     /* Get the post type */
     $post_type = $this->r_cptFuntions->getThisPostId ( $post_id );
     /* Check if is one of this our custom post types */
     if ( ! ( isset ( $this->custom_post_types[$post_type] ) ) )
     {
          return ( $post_id );
     }
     if ( ! ( isset ( $this->customFields[$post_type] ) ) )
     {
          return ( $post_id );
     }
     /* Check if we should save the meta */
     if ( ! ( $this->r_cptFuntions->save_meta_box_authorization ( $post_type, $post_id ) ) )
     {
          return ( $post_id );
     }

     /*  order the post into an data array */
     $index = 'mtk_' . $post_type;
     // error_log (__FILE__ . ' - ' . __LINE__ . ' - ' . __FUNCTION__);
     // error_log(print_r($_POST, true));
     // error_log('--------------------------------------------');
     $data = $this->r_cptFuntions->orderForSaveMeta ( $index );
     /*---------------- Store this metabox ----------------*/
     /* We get the values saved in the post mtk_default_recipe*/
     if ( is_array ( $data ) )
     {
          foreach ( $data as $sectionId => $section )
          {
               $index = '_mtk_' . $post_type . '_' . $sectionId;

               /* if the section has not content no need to add it */

               if ( ( count ( $section ) == 1 ) && ( isset ( $section[0] ) ) && ( $section[0] == '' )  )
               {
                    /* First we delete old inforamtion */
                    delete_post_meta( $post_id, $index );
               }
               else {
                    if ( ! add_post_meta( $post_id, $index, $section, true ) )
                    {
                         update_post_meta( $post_id, $index, $section );

                    }
                    // error_log (__FILE__ . ' - ' . __LINE__ . ' - ' . __FUNCTION__);
                    // error_log($index);
                    // error_log(print_r($section, true));
                    // error_log('--------------------------------------------');
               }



          }
     }

}
/*  Customizes the fields of the list we see in the  list */
public function set_custom_column( $columns )
{
     $post_type = $this->current_post_type;
     $cb = $columns['cb'];
     $title = $columns['title'];
     $date = $columns['date'];
     unset ( $columns );
     /* We are going to rearrange the information */
     $columns['cb'] = $cb;
     $columns['title'] = 'Post Title';
     $columns['date'] = $date;

     foreach ($this->customFields[$post_type] as $i => $fieldInfo)
     {
          if ($fieldInfo['Show_in_columns'])
          {
               $columns[$fieldInfo['ID']] = $fieldInfo['Name'];
          }

     }
     return ( $columns );
}
/* Sets the data that will be display in the list */
public function set_custom_columns_data( $column , $post_id )
{

     $data  = get_post_meta ( $post_id , '_mtk_'.$post_type.'_key' , true );
     switch ( $column )
     {
          case 'name':
          echo '<strong>' . $name . '</strong><br /><a href="mailto:'. $email .'">'. $email .'</a>';
          break;
          case 'approved':
          echo ($approved);
          break;
          case 'featured':
          echo ($featured);
          break;
     }
}
/* Sets Which fields are sortable */
public function set_custom_columns_sortable ( $columns )
{
     $columns['name'] = 'name';
     $columns['approved'] = 'approved';
     $columns['featured'] = 'featured';
     return ( $columns );
}

}
