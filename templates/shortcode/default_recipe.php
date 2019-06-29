
<br>
<div  class="default_recipe_container mtk_default_recipe_shortcode">
<h1>default_recipe</h1>

<?php
global $post;

echo ('<pre><h2>');
echo $post->post_title;
echo ('</h2></pre>');

/* Gest post type fields */
$options = get_option ('mtk_plugin_cpt');
$meta = get_post_meta( get_the_ID() );
if (isset ( $meta ))
{

     foreach ($meta as $meta_key => $meta_value)
     {
          if ( strpos ( $meta_key , "mtk_default_recipe" ) > -1 )
          {

               foreach ($meta_value as $key => $value)
               {
                    $meta_values[$meta_key] = unserialize ( $value );

               }
          }

     }
     echo ('<pre><h3>');
     var_dump ( $meta_values );
     echo ('</h3></pre>');
}

?>
</div>
