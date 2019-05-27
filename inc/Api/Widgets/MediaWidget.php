<?php
/*

@package mkt-recipe-plugin

     ===================================
          MEDIAWIDGET.PHP
     ===================================
*
*
*/
namespace Inc\Api\Widgets;
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
          $this->control_options = array (
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
          parent :: __construct ( $this->widget_ID , $this->widget_name ,  $this->widget_options , $this->control_options );
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
     public function widget($args, $instance)
     {
          //Before the Widget
          echo ( $args['before_widget'] );
          /* The Widget */
          /* Title */
          if ( ! ( empty ( $instance['title'] ) ) )
          {
               //Before Title
               echo ( $args['before_title'] );
               //Title
               echo ( apply_filters ( 'widget_title' , $instance['title'] ) );
               //After Title
               echo ( $args['after_title'] );
          }
          /* Image */
          if ( ! ( empty ( $instance['image'] ) ) )
          {
               /* Prints the image */
               echo ( '<img src="' . esc_url( $instance['image'] ) . '" alt="">');
          }
          //after the Widget
          echo ( $args['after_widget'] );
     }
     public function form ( $instance )
     {
          $title = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Custom Text', 'mtk_recipe_plugin' );
          $image = ! empty( $instance['image'] ) ? $instance['image'] : '';
          ?>
          <p>
               <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title:', 'mtk_recipe_plugin' ); ?></label>
               <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
          </p>
          <p>
               <label for="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>"><?php esc_attr_e( 'Image:', 'mtk_recipe_plugin' ); ?></label>
               <input class="widefat image-upload" id="<?php echo esc_attr( $this->get_field_id( 'image' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image' ) ); ?>" type="text" value="<?php echo esc_url( $image ); ?>">

               <button type="button" class="button button-primary js-image-upload">Select Image</button>
          </p>
          <?php
     }
     public function update( $new_instance , $old_instance)
     {
          /* We get the old information from the old instance because we know it works */
          $instance = $old_instance;
          /* We modify only the parameter we want */
          /* We prevent the user to inject new parameters that are not in our old instance */
          $instance['title'] = sanitize_text_field ( $new_instance['title'] ); //This is a function of word press
          $instance['image'] = ! empty( $new_instance['image'] ) ? $new_instance['image'] : ''; //This is a function of word press
          return ( $instance );
     }

}
