<?php
/* we choose the template we are going to use depending on the custom post type */
if ( get_post_type () != '' )
{
     $fileName = get_post_type();

     /* Load the styles*/
     echo ( "<link rel=\"stylesheet\" href=\"$this->plugin_url/assets/$fileName.css\" type=\"text/css\" media=\"all\" /> " );
     /* Load the scripts */
     echo ( "<script src=\"$this->plugin_url/assets/$fileName.js\"></script> " );
     /* only enqueues the javascript file if I am using the form */
     require_once ( "$this->plugin_path/templates/shortcode/$fileName.php");
}
?>
