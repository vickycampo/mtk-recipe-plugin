<?php
/**
* @package mkt-recipe-plugin
*/
/*
     ===================================
          ADMIN PAGE - CUSTOM POST TYPE
     ===================================
*
*
*/
?>
<div class="wrap">
</div>
<div class="wrap">
     <h1>
          CPT Manager
     </h1>
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class=" <?php echo ( ! isset ( $_POST["edit_post"] ) ? 'active' : '' ); ?>"><a href="#tab-1">Your custom post types</a></li>
		<li class=" <?php echo ( isset ( $_POST["edit_post"] ) ? 'active' : '' ); ?>">
               <a href="#tab-2">
                    <?php echo ( isset ( $_POST["edit_post"] ) ? 'Edit' : 'Add' ); ?> Custom Post Type
               </a>
          </li>
		<li><a href="#tab-3">Export</a></li>
	</ul>
	<div class="tab-content">
		<div id="tab-1" class="tab-pane <?php echo ( isset ( $_POST["edit_post"] ) ? '' : 'active' ); ?>">
               <h3>
                    Manage Your Custom Post types
               </h3>
               <?php
                    /* We check if we have set post types, if not we return an empty array to avoid any problem with the page.  */
                    $options =  get_option ( 'mtk_plugin_cpt' )?: array();
                    echo ('<table class="wp-list-table widefat fixed striped posts cpt-table">');
                    echo ('<tr class="cpt_title_row">');
                         echo ('<th><span>ID</span></th>');
                         echo ('<th><span>Singular Name</span></th>');
                         echo ('<th><span>Plural Name</span></th>');
                         echo ('<th><span>Public</span></th>');
                         echo ('<th><span>Has Archive</span></th>');
                         echo ('<th><span></span></th>');
                    echo ('</tr>');
                    foreach ($options as $option)
                    {
                         $public = isset ( $option['public'] ) ? "TRUE" : "FALSE";
                         $has_archive = isset ( $option['has_archive'] ) ? "TRUE" : "FALSE";
                         echo ("<tr>");
                              echo ("<td><span>{$option['post_type']}</span></td>");
                              echo ("<td><span>{$option['singular_name']}</span></td>");
                              echo ("<td><span>{$option['plural_name']}</span></td>");
                              echo ("<td><span>$public</span></td>");
                              echo ("<td><span>$has_archive</span></td>");
                              echo ('<td>');
                              /* add the edit form */
                              ?>
                              <form method="post" action="" class="inline-block">
                              <?php
                                   echo ('<input type="hidden" name="edit_post" value="'. $option['post_type'] .'">');
                                   submit_button( 'Edit' , 'primary small' , 'submit' , false );
                              ?>
                              </form>
                              <?php
                              /* add a delete form to process the information */
                              ?>
                              <form method="post" action="options.php" class="inline-block">
                              <?php
                                   /* All the options we have set will apear in the options tab */
                                   settings_fields( 'mtk_plugin_cpt_settings' );
                                   /* We add a hidden field sending information of the cpt that we want to erase */
                                   echo ('<input type="hidden" name="remove" value="'. $option['post_type'] .'">');
                                   submit_button( 'Delete' , 'delete small' , 'submit' , false , array (
                                        'onclick' => 'return confirm ("Are you sure you want to delete this Custom Post Type? The data associated with it will not be deleted.")'
                                    ) );
                              ?>
                              </form>
                              <?php
                              echo ('</td>');
                         echo ("</tr>");
                    }
                    echo ('</table>');
               ?>
		</div>
		<div id="tab-2" class="tab-pane  <?php echo ( isset ( $_POST["edit_post"] ) ? 'active' : '' ); ?>">
			<h3>
				<?php echo ( isset ( $_POST["edit_post"] ) ? 'Edit your' : 'Add a ' ); ?> Custom Post Type
			</h3>
               <form method="post" action="options.php">
                    <?php
                         /* All the options we have set will apear in the options tab */
                         settings_fields( 'mtk_plugin_cpt_settings' );
                         do_settings_sections( 'mtk_cpt' );
                         submit_button();
                    ?>
               </form>
		</div>
		<div id="tab-3" class="tab-pane">
			<h3>
				Export your Custom Post Types
			</h3>
               <?php
               foreach ($options as $option)
               {
               ?>
               <h4>
                    <?php echo ( $option['singular_name'] ); ?>
               </h4>
               <pre class="prettyprint">
// Register Custom Post Type
function <?php echo ( $option['post_type'] ); ?>_post_type() {

	$labels = array(
		'name'                  => _x( 'Post Types', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( '<?php echo ( $option['singular_name'] ); ?>', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( '<?php echo ( $option['plural_name'] ); ?>', 'text_domain' ),
		'plural_name'           => __( '<?php echo ( $option['plural_name'] ); ?>', 'text_domain' ),
		'name_admin_bar'        => __( '<?php echo ( $option['singular_name'] ); ?>', 'text_domain' ),
		'archives'              => __( '<?php echo ( $option['singular_name'] ); ?> Archives', 'text_domain' ),
		'attributes'            => __( '<?php echo ( $option['singular_name'] ); ?> Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent <?php echo ( $option['singular_name'] ); ?>:', 'text_domain' ),
		'all_items'             => __( 'All <?php echo ( $option['plural_name'] ); ?>', 'text_domain' ),
		'add_new_item'          => __( 'Add New <?php echo ( $option['singular_name'] ); ?>', 'text_domain' ),
		'add_new'               => __( 'Add New', 'text_domain' ),
		'new_item'              => __( 'New <?php echo ( $option['singular_name'] ); ?>', 'text_domain' ),
		'edit_item'             => __( 'Edit <?php echo ( $option['singular_name'] ); ?>', 'text_domain' ),
		'update_item'           => __( 'Update <?php echo ( $option['singular_name'] ); ?>', 'text_domain' ),
		'view_item'             => __( 'View <?php echo ( $option['singular_name'] ); ?>', 'text_domain' ),
		'view_items'            => __( 'View Items', 'text_domain' ),
		'search_items'          => __( 'Search <?php echo ( $option['singular_name'] ); ?>', 'text_domain' ),
		'not_found'             => __( '<?php echo ( $option['singular_name'] ); ?> Not found', 'text_domain' ),
		'not_found_in_trash'    => __( '<?php echo ( $option['singular_name'] ); ?> Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into <?php echo ( $option['singular_name'] ); ?>', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this <?php echo ( $option['singular_name'] ); ?>', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( '<?php echo ( $option['post_type'] ); ?>', 'text_domain' ),
		'description'           => __( '<?php echo ( $option['singular_name'] ); ?> Description', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => false,
		'taxonomies'            => array( 'category', 'post_tag' ),
		'hierarchical'          => false,
		'public'                => <?php echo ( isset ( $option['public'] ) ? "true" : "false" ); ?>,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => <?php echo ( isset ( $option['has_archive'] ) ? "true" : "false" ); ?>,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( '<?php echo ( $option['post_type'] ); ?>', $args );

}
add_action( 'init', '<?php echo ( $option['post_type'] ); ?>_post_type', 0 );
               </pre>
               <?php
               }
               ?>
		</div>
	</div>


</div>
