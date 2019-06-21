<?php
/* we choose the template we are going to use depending on the custom post type */
if ( get_post_type () != '' )
{
     $fileName = get_post_type();

     /* Load the styles*/
     if (file_exists ( "$this->plugin_url/assets/$fileName.css" ))
     {
          echo ( "<link rel=\"stylesheet\" href=\"$this->plugin_url/assets/$fileName.css\" type=\"text/css\" media=\"all\" /> " );
     }
     /* only enqueues the javascript file if I am using the form */
     if (file_exists ( "$this->plugin_url/assets/$fileName.js" ))
     {

          echo ( "<script src=\"$this->plugin_url/assets/$fileName.js\"></script> " );
     }
     if (file_exists ( "$this->plugin_path/templates/shortcode/$fileName.php" ))
     {
          require_once ( "$this->plugin_path/templates/shortcode/$fileName.php");
     }

}
?>
