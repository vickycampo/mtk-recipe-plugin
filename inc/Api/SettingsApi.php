<?php
/*

@package mkt-recipe-plugin

     ===================================
          SETTINGSAPI.PHP
     ===================================
*
*
*/
namespace Inc\Api;
use \Inc\Base\Controller;
use \Inc\Api\SettingsApi;
/**
*  SettingsApi - Generates the menu pages and subpages
*/
class SettingsApi
{
     public $admin_pages = array();
     public $admin_subpages = array();

     public $settings = array ();
     public $sections = array ();
     public $field = array ();
     public function register()
     {
          if ( ! empty ( $this->admin_pages ) || ! empty ( $this->admin_subpages ) )
          {
               add_action( 'admin_menu', array( $this, 'addAdminMenu' ) );
          }
          if ( ! empty ( $this->settings ))
          {
               add_action( 'admin_init' , array ($this, 'registerCustomFields') );
          }
     }
     public function addPages( array $pages )
     {
          $this->admin_pages = $pages;
          return $this;
     }
     public function addSubPages ( array $pages )
     {
          $this->admin_subpages = array_merge ( $this->admin_subpages , $pages);
          return $this;
     }
     public function setSettings( array $settings )
     {
          $this->settings = $settings;
          return $this;
     }
     public function setSections( array $sections )
     {
          $this->sections = $sections;
          return $this;
     }
     public function setFields( array $fields )
     {
          $this->fields = $fields;
          return $this;
     }
     /* With this function we are going to add a first page to the settings section, that will be the same as the section page. */
     public function withSubpage ( string $title = null )
     {

          if ( empty($this->admin_pages) )
          {
               return $this;
          }
          //We grab the page we want to replicate
          $admin_page = $this->admin_pages[0];
          $subpage = array (
               array (
                    'parent_slug' => $admin_page['menu_slug'],
                    'page_title' => $admin_page['page_title'],
				'menu_title' => ($title) ? $title : $admin_page['menu_title'],
				'capability' => $admin_page['capability'],
				'menu_slug' => $admin_page['menu_slug'],
				'callback' => $admin_page['callback']
               )
          );
          $this->admin_subpages = $subpage;
          return $this;
     }

     public function addAdminMenu()
     {
          foreach ( $this->admin_pages as $page )
          {
               add_menu_page( $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'], $page['icon_url'], $page['position'] );
          }
          foreach ( $this->admin_subpages as $page ) {
			add_submenu_page( $page['parent_slug'], $page['page_title'], $page['menu_title'], $page['capability'], $page['menu_slug'], $page['callback'] );
		}
     }
     public function registerCustomFields ()
     {
          /* Register Custom Fields */
          /* To do this we require 3 diferent actions
               1. Register Settings
               2. Add Settings Section
               3. Add Settings Field
          */
          foreach ( $this->settings as $setting )
          {
               /* Register Settings */
               register_setting (  $setting['option_group'] , $setting['option_name'] , ( isset ( $setting['callback'] )  ? $setting['callback'] : '') ) ;
          }
          foreach ( $this->sections as $section )
          {
               /* Add Settings Section */
               add_settings_section ( $section['id'] , $section['title'] , ( isset ( $section['callback'] )  ? $section['callback'] : '') , $section['page'] );
          }
          foreach ( $this->fields as $field )
          {
               /* Add settings field */
               add_settings_field ( $field['id'] , $field['title'] , ( isset ( $field['callback'] )  ? $field['callback'] : '' ) , $field['page'] , $field['section'] ,  ( isset ( $field['args'] )  ? $field['args'] : '' ) );
          }
          // echo ('all has been registered');
          // echo ('<pre>');
          // print_r ($this->settings);
          // print_r ($this->sections);
          // print_r ($this->fields);
          // echo ('</pre>');

     }
}
