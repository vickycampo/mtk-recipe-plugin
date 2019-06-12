<?php
/*

@package mkt-recipe-plugin

     ===================================
          CUSTOMPOSTTYPECONTROLLER.PHP
     ===================================
*
*
*/
namespace Inc\Base;
use Inc\Base\BaseController;

/**
 * Enqueue - Enqueue the scripts and style files
 */
class TemplateController extends BaseController
{
     public $callbacks;
     public $subpages = array();
     public function register ()
     {

          /* Check if it is active */
          if ( ! ( $this->activated( 'template_manager' ) ) ) return;

     }
}
