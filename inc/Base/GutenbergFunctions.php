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
use Inc\Base\BaseController;

class GutenbergFunctions extends BaseController
{
     public $blocksList = [];
     public function register ()
     {
          /* We keep a list of all the block we want to create in an array */

          add_action( 'enqueue_block_editor_assets', array ( $this , 'mtk_enqueueBlockEditorFiles' ) );
          add_action( 'enqueue_block_assets ', array ( $this , 'mtk_enqueueBlockFiles' ) );
          $this->registerBlock();
     }
     public function mtk_enqueueBlockEditorFiles()
     {
          /* Register the block-building Script */
          $handle = 'mtk_myfirstblock_editor';
          $src = $this->plugin_url . 'assets/gut_myfirstblock.js';
          $deps = array( 'wp-blocks' , 'wp-element') ;
          wp_register_script( $handle ,  $src , $deps );

          /* Register global block css - backend only */
          $handle = 'mtk_myfirstblock_editor';
          $src = $this->plugin_url . 'assets/gut_myfirstblock_editor.css';
          $deps = array( 'wp-edit-blocks') ;
          $ver = filemtime( $this->plugin_path . 'assets/gut_myfirstblock_editor.css' );
          wp_register_style( $handle, $src, $deps, $ver );
     }
     public function mtk_enqueueBlockFiles()
     {
          /* Register global block css - Front and backend */
          $handle = 'mtk_myfirstblock';
          $src = $this->plugin_url . 'assets/gut_myfirstblock.css';
          $deps = array( 'wp-edit-blocks') ;
          $ver = filemtime( $this->plugin_path . 'assets/gut_myfirstblock.css' );
          wp_register_style( $handle, $src, $deps, $ver );
     }
     public function registerBlock()
     {
          /* Register the block type */
          register_block_type( 'mtk-plugin/myfirstblock' , array (
               'editor_script' => 'mtk_myfirstblock_editor',
               'editor_style' => 'mtk_myfirstblock_editor',
               'style' => 'mtk_myfirstblock',
          ) );

     }



}
/* Documentation */
//https://developer.wordpress.org/block-editor/tutorials/block-tutorial/creating-dynamic-blocks/
