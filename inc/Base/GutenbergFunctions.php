<?php
/*

@package mkt-recipe-plugin

     ===================================
          GutenbergFunctions.PHP
     ===================================
*
*
*/
namespace Inc\Base;
class GutenbergFunctions
{
     public function register ()
     {
          add_action ( 'init' , array ( $this , 'addThemeSupport' ) );
     }
     public function addThemeSupport ()
     {
          $this -> addDefaultColors ();
          $this -> addFontSizes ();
     }
     public function addDefaultColors ()
     {
          add_theme_support (
               'editor-color-palette' ,
               array
               (
                    array (
                         'name' => 'White',
                         'slug' => 'slug',
                         'color' => '#ffffff'
                    ),
                    array (
                         'name' => 'Black',
                         'slug' => 'slug',
                         'color' => '#000000'
                    ),
                    array (
                         'name' => 'Orange',
                         'slug' => 'slug',
                         'color' => '#ffa500'
                    ),
                    array (
                         'name' => 'Light Gray',
                         'slug' => 'slug',
                         'color' => '#dcdcdc'
                    ),
                    array (
                         'name' => 'Middle Gray',
                         'slug' => 'slug',
                         'color' => '#BEBEBE'
                    ),
                    array (
                         'name' => 'Dark Gray',
                         'slug' => 'slug',
                         'color' => '#282828'
                    )
               )
          );
     }
     public function addFontSizes ()
     {
          add_theme_support(
               'edit-font-sizes',
               array
               (
                    array
                    (
                         'name' => 'Normal',
                         'slug' => 'normal',
                         'size' => 16
                    ),
                    array
                    (
                         'name' => 'Large',
                         'slug' => 'large',
                         'size' => 24
                    )
               )
          );
     }


}
