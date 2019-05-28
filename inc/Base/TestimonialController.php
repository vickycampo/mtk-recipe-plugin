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
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

/**
 * Enqueue - Enqueue the scripts and style files
 */
class TestimonialController extends BaseController
{

     public function register ()
     {
          /* Check if it is active */
          if ( ! ( $this->activated( 'testimonial_manager' ) ) ) return;
          /* Trigger the generation of a custom post type */
          add_action( 'init', array( $this, 'testimonial_cpt' ) );
          /* Add metabox */
          add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
          /* Save new fields of the meta boxes */
          add_action ( 'save_post' , array ( $this , 'save_meta_box') );

     }
     public function testimonial_cpt ()
	{
		$labels = array(
			'name' => 'Testimonials',
			'singular_name' => 'Testimonial'
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'has_archive' => false,
			'menu_icon' => 'dashicons-testimonial',
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'supports' => array( 'title', 'editor' )
		);
		register_post_type ( 'testimonial', $args );
	}
     public function add_meta_boxes()
     {
          add_meta_box(
               'testimonial_author',
               'Author',
               array ( $this , 'render_author_box'),
               'testimonial',
               'side',
               'default'
          );


     }

     public function render_author_box ( $post )
     {

          /*  validate that the contents of the form request */
          wp_nonce_field( 'mtk_testimonial_author' , 'mtk_testimonial_author_nonce' );
          $value = get_post_meta ( $post->ID , '_mtk_testimonial_author_key' , true );
          ?>
          <label for="mtk_testimonial_author">
               Testimonial Author
          </label>
          <input type="text" id="mtk_testimonial_author" name="mtk_testimonial_author" value="<?php echo ( esc_attr( $value ) ); ?>"
          <?php
     }
     public function save_meta_box( $post_id )
     {
          /* Happens every time the user saves the post */

          if ( ! ( isset ( $_POST['mtk_testimonial_author_nonce'] ) ) )
          {
               /* If the another post is saved, not the testimonial type then we just return the post id*/
               return ( $post_id );
          }
          /* then wer stoe our extra variables */
          /* We store our custom nonce */
          $nonce = $_POST['mtk_testimonial_author_nonce'];
          /* Verify the that the none is valid */
          if ( ! ( wp_verify ( $nonce , 'mtk_testimonial_author' ) ) )
          {
               /* if is not valid we stop the execution of the script */
               return ( $post_id );
          }
          /* We check if Wordpress is doing an autosave we interrupt the script */
          if ( defined ('DOING_AUTOSAVE') && DOING_AUTOSAVE)
          {
               return ( $post_id );
          }
          /* Check it the user has the ability to edit the post */
          if ( ! ( current_user_can ( 'edit_post' , $post_id ) ) )
          {
               
          }
     }

}
