<?php
/**
* @package mkt-recipe-plugin
*/
/*
     ===================================
          ADMIN PAGE - CUSTOM TAXONOMIES
     ===================================
*
*
*/
?>

<div class="wrap">
</div>
<div class="wrap">
     <h1>
          Taxonomy Manager
     </h1>
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class=" <?php echo ( ! isset ( $_POST["edit_taxonomy"] ) ? 'active' : '' ); ?>"><a href="#tab-1">Your Taxonomies</a></li>
		<li class=" <?php echo ( isset ( $_POST["edit_taxonomy"] ) ? 'active' : '' ); ?>">
               <a href="#tab-2">
                    <?php echo ( isset ( $_POST["edit_taxonomy"] ) ? 'Edit' : 'Add' ); ?> Taxonomy
               </a>
          </li>
		<li><a href="#tab-3">Export</a></li>
	</ul>
	<div class="tab-content">
		<div id="tab-1" class="tab-pane <?php echo ( isset ( $_POST["edit_taxonomy"] ) ? '' : 'active' ); ?>">
               <h3>
                    Manage Your Custom Taxonomies
               </h3>
               <?php
                    /* We check if we have set taxonomy, if not we return an empty array to avoid any problem with the page.  */
                    // $options =  get_option ( 'mtk_plugin_cpt' )?: array();
                    // echo ('<table class="wp-list-table widefat fixed striped posts">');
                    // echo ('<tr class="cpt_title_row">');
                    //      echo ('<th><span>ID</span></th>');
                    //      echo ('<th><span>Singular Name</span></th>');
                    //      echo ('<th><span>Plural Name</span></th>');
                    //      echo ('<th><span>Public</span></th>');
                    //      echo ('<th><span>Has Archive</span></th>');
                    //      echo ('<th><span></span></th>');
                    // echo ('</tr>');
                    // foreach ($options as $option)
                    // {
                    //      $public = isset ( $option['public'] ) ? "TRUE" : "FALSE";
                    //      $has_archive = isset ( $option['has_archive'] ) ? "TRUE" : "FALSE";
                    //      echo ("<tr>");
                    //           echo ("<td><span>{$option['post_type']}</span></td>");
                    //           echo ("<td><span>{$option['singular_name']}</span></td>");
                    //           echo ("<td><span>{$option['plural_name']}</span></td>");
                    //           echo ("<td><span>$public</span></td>");
                    //           echo ("<td><span>$has_archive</span></td>");
                    //           echo ('<td>');
                    //           /* add the edit form */
                    //           ?>
                    //           <form method="post" action="" class="inline-block">
                    //           <?php
                    //                echo ('<input type="hidden" name="edit_taxonomy" value="'. $option['post_type'] .'">');
                    //                submit_button( 'Edit' , 'primary small' , 'submit' , false );
                    //           ?>
                    //           </form>
                    //           <?php
                    //           /* add a delete form to process the information */
                    //           ?>
                    //           <form method="post" action="options.php" class="inline-block">
                    //           <?php
                    //                /* All the options we have set will apear in the options tab */
                    //                settings_fields( 'mtk_plugin_cpt_settings' );
                    //                /* We add a hidden field sending information of the cpt that we want to erase */
                    //                echo ('<input type="hidden" name="remove" value="'. $option['post_type'] .'">');
                    //                submit_button( 'Delete' , 'delete small' , 'submit' , false , array (
                    //                     'onclick' => 'return confirm ("Are you sure you want to delete this Custom Taxonomy The data associated with it will not be deleted.")'
                    //                 ) );
                    //           ?>
                    //           </form>
                    //           <?php
                    //           echo ('</td>');
                    //      echo ("</tr>");
                    // }
                    // echo ('</table>');
               ?>
		</div>
		<div id="tab-2" class="tab-pane  <?php echo ( isset ( $_POST["edit_taxonomy"] ) ? 'active' : '' ); ?>">
			<h3>
				<?php echo ( isset ( $_POST["edit_taxonomy"] ) ? 'Edit your' : 'Add a ' ); ?> Custom Taxonomy
			</h3>
               <form method="post" action="options.php">
                    <?php
                         /* All the options we have set will apear in the options tab */
                         settings_fields( 'mtk_plugin_tax_settings' );
                         do_settings_sections( 'mtk_taxonomy' );
                         submit_button();
                    ?>
               </form>
		</div>
		<div id="tab-3" class="tab-pane">
			<h3>
				Export your Taxonomies
			</h3>

		</div>
	</div>


</div>
