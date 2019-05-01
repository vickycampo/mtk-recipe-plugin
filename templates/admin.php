<?php
/**
* @package mkt-recipe-plugin
*/
/*
     ===================================
          ADMIN PAGE - DASHBOARD PAGE
     ===================================
*
*
*/
?>
<div class="wrap">
	<h1 class="adminPage_title" >MTK Recipe Plugin</h1>
	<?php settings_errors(); ?>

	<ul class="nav nav-tabs">
		<li class="active"><a href="#tab-1">Manage Settings</a></li>
		<li><a href="#tab-2">Updates</a></li>
		<li><a href="#tab-3">About</a></li>
	</ul>
	<div class="tab-content">
		<div id="tab-1" class="tab-pane active">
			<form method="post" action="options.php">
				<?php
					settings_fields( 'mtk_options_group' );
					do_settings_sections( 'mtk_plugin' );
					submit_button();
				?>
			</form>
		</div>
		<div id="tab-2" class="tab-pane">
			<h3>
				Updates
			</h3>
		</div>
		<div id="tab-3" class="tab-pane">
			<h3>
				About
			</h3>
			<p>
				I started develping this plugin for two reasons. First, create the Custom Post Type for the recipes of my blog. I know there are a lot of plugins out there that would probably work much better, and probably have a lot of integrated features like SEO. But I do want to have full control of how I want to manage and display the recipes of my blog.
			</p>
			<p>
			The second reason is learing how to make plugins. I found Alecad tutorias a while back and they are a good way to get things started. I have done a couple of his Youtube courses.
			</p>
			<p>
				If you have decided to install this plugin, I hope you find it useful. If you have any feedbacks you can contact me at  or <a href="mailto:info@virginiacampo.com?Subject='MTK Recipe Plugin'" target="_new">info@virginiacampo.com</a> .
			</p>
		</div>
	</div>


</div>
