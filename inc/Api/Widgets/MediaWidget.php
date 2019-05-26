<?php
/*

@package mkt-recipe-plugin

     ===================================
          MEDIAWIDGET.PHP
     ===================================
*
*
*/
namespace Inc\Api;
use WP_Widget;

/**
 * Enqueue - Enqueue the scripts and style files
 */
class MediaWidget extends WP_Widget
{
     public $widget_ID;
     Public $widget_name;
     public $widget_options = array ();
     public $control_options = array ();
     public function __construct ()
     {
          $this->widget_ID = 'mtk_media_widget';
          $this->widget_name = 'My Tiny Kitchen Widget';
          $this->$widget_options = array (
               'classname' => $this->widget_ID,
               'description' => $this->widget_name,
               'customize_selective_refresh' => true
          );
          $this->control_options = array (
               'width' => 400,
               'height' => 350
          );
     }
     public function register ()
     {
          /* We call the construct */
          parent :: __construct ( $this->widget_ID , $this->widget_name ,  $this->$widget_options , $this->control_options );
          /* Initialize the widget and extend the parent class */
          add_action ( 'widgets_init' , array ( $this , 'widgetInit') );

     }
     public function widgetInit ()
     {
          /* We generate the wiget with an instance of thic class */
          register_widget ( $this );
          /* we need 3 methods contained in the instance of this class */
          /*
          1.- widget () - generate the output in the front endº
          2.- form () - Generate the widget in the administration area
          3.- update () - Updates the information of a widget
          */
     }
     public function widget ()
     {

     }
     public function form ( $instance )
     {
          /* Super simple widget */
          $title = ! empty ( $instance['title'] ) ? $instance['title']  : esc_html_( 'Custom Text' , 'mtk-recipe-plugin' );
          $titleID = esc_attr( $this->get_field_id ('title') );
          ?>
          <p>
               <label for="<?php echo ( $titleID ); ?>">Title </label>
               <input type="text" class="widefat" id="<?php echo ( $titleID ) ); ?>" name="">
          </p>
          <?php
     }
     public function update()
     {

     }

}
