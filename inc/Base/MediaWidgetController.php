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
use Inc\Api\Widgets\MediaWidget;
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
          /* Crate a new instance of the MediaWidget class */
          $media_widget = new MediaWidget ();
          $media_widget -> register ();


     }

     public function activate ()
     {

     }
}
