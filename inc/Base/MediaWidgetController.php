<?php
/*

@package mkt-recipe-plugin

     ===================================
          MEDIAWIDGET.PHP
     ===================================
*
*
*/
namespace Inc\Base;
use Inc\Base\BaseController;
/**
 * Enqueue - Enqueue the scripts and style files
 */
class MediaWidgetController extends BaseController
{
     public $callbacks;
     public $subpages = array();
     public function register ()
     {
          /* Check if it is active */
          if ( ! ( $this->activated( 'media_widget' ) ) ) return;
          /* We don't need to add a subpage becasue we are going to use the page of the widgets */

     }

     public function activate ()
     {

     }
}
