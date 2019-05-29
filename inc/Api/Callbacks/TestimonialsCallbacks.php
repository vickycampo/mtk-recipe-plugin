<?php
/*

@package mkt-recipe-plugin

     ===================================
          TESTIMONIALSCALLBACKS.PHP
     ===================================
*
*
*/
namespace Inc\Api\Callbacks;
use Inc\Base\BaseController;

class TestimonialsCallbacks extends BaseController
{

     function shortcodePage ()
     {
          return ( require_once ( "$this->plugin_path/templates/testimonial.php" ) );
     }
}
