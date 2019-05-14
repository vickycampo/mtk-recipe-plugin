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
		<li class="active"><a href="#tab-1">Your custom post types</a></li>
		<li><a href="#tab-2">Add Custom Post Type</a></li>
		<li><a href="#tab-3">Export</a></li>
	</ul>
	<div class="tab-content">
		<div id="tab-1" class="tab-pane active">
               <h3>
                    Your Custom Post types
               </h3>
               <?php
                    $options = get_option ('mtk_plugin_cpt');
                    echo ('<table class="wp-list-table widefat fixed striped posts">');
                    echo ('<tr class="title_row">');
                         echo ('<th><span>ID</span>');
                         echo ('</th>');
                         echo ('<th>');
                         echo ('<span>Singular Name</span>');
                         echo ('</th>');
                         echo ('<th>');
                         echo ('<span>Plural Name</span>');
                         echo ('</th>');
                         echo ('<th>');
                         echo ('<span>Public</span>');
                         echo ('</th>');
                         echo ('<th>');
                         echo ('<span>Has Archive</span>');
                         echo ('</th>');
                    echo ('</tr>');
                    foreach ($options as $option)
                    {

                         echo ("<tr>");
                              echo ("<td>");
                              echo ("<span>{$option['post_type']}</span>");
                              echo ("</td>");
                              echo ("<td>");
                              echo ("<span>{$option['singular_name']}</span>");
                              echo ("</td>");
                              echo ("<td>");
                              echo ("<span>{$option['plural_name']}</span>");
                              echo ("</td>");
                              echo ("<td>");
                              echo ("<span>{$option['public']}</span>");
                              echo ("</td>");
                              echo ("<td>");
                              echo ("<span>{$option['has_archive']}</span>");
                              echo ("</td>");
                         echo ("</tr>");
                    }
                    echo ('</table>');
               ?>
		</div>
		<div id="tab-2" class="tab-pane">
			<h3>
				Create a new Custom Post Type
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

		</div>
	</div>


</div>
