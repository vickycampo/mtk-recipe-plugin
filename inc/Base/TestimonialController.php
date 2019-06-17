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
use Inc\Api\Callbacks\TestimonialsCallbacks;

/**
 * Enqueue - Enqueue the scripts and style files
 */
class TestimonialController extends BaseController
{
     public $settings;
     public $callbacks;

     public function register ()
     {
          /* Check if it is active */
          if ( ! ( $this->activated( 'recipe_slider_manager' ) ) ) return;
          /* Initialize */
          $this->settings = new SettingsApi();
          $this->callbacks = new TestimonialsCallbacks();

          /* Trigger the generation of a custom post type */
          add_action( 'init', array( $this, 'testimonial_cpt' ) );

          /* Add metabox */
          add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
          /* Save new fields of the meta boxes */
          add_action ( 'save_post' , array ( $this , 'save_meta_box') );

          /* Edit the custom columns of the custom post type */
          add_action ( 'manage_testimonial_posts_columns' , array ( $this , 'set_custom_column' ) );
          /* We are going to hook the custom columns with the information */
          add_action ( 'manage_testimonial_posts_custom_column' , array ( $this , 'set_custom_columns_data' ) , 10 , 2 );
          /* add a filter to make the columns sortable */
          add_filter ( 'manage_edit-testimonial_sortable_columns' , array ( $this , 'set_custom_columns_sortable' ) );

          /* Setup and activate the shortcodes */
          $this->setShortcodePage();

          /* Generate the Shorcode subpage */
          add_shortcode ( 'testimonial-form' , array ( $this , 'testimonial_form' ) );
          add_shortcode ( 'testimonial-slideshow'  , array ( $this , 'testimonial_slideshow' ));

          /* Add the jQuery parameters */
          /* Listen to the action that was specified in the hidden field in the form */
          add_action( 'wp_ajax_submit_testimonial', array( $this, 'submit_testimonial' ) );
		add_action( 'wp_ajax_nopriv_submit_testimonial', array( $this, 'submit_testimonial' ) );
     }
     public function submit_testimonial ()
     {
          // error_log (__FUNCTION__ . ' - ' . __LINE__);
          // error_log('Functino - ' . debug_backtrace()[1]['function'] );
          // error_log ('----------------------------');

          /* double check if this is an actual ajax call */
          if ( ! ( DOING_AJAX  ||  check_ajax_referer ( 'testimonial-nonce' , 'nonce' )  ) )
          {
               return ( $this->return_json('error') );
          }

          /* Sanitize the data */
		$name = sanitize_text_field($_POST['name']);
		$email = sanitize_email($_POST['email']);
		$message = sanitize_textarea_field($_POST['message']);

          /* Store the data into testimonial CPT */
          $data = array(
			'name' => $name,
			'email' => $email,
			'approved' => 0,
			'featured' => 0,
		);
          /* Array with data to create the new post */
          $args = array(
			'post_title' => 'Testimonial from ' . $name,
			'post_content' => $message,
			'post_author' => 1,
			'post_status' => 'publish',
			'post_type' => 'testimonial',
			'meta_input' => array(
				'_mtk_testimonial_key' => $data
			)
		);

          /* We insert the post */
          $postID = wp_insert_post($args);

          /* if the return of the insert is anything different from cero we send a success message */
          if ( $postID )
          {
               return ( $this->return_json('success') );
          }
          return ( $this->return_json('error') );
     }
     public function return_json ( $status )
     {
          $return = array (
               'status' => $status
          );
          wp_send_json( $return );
          wp_die ();
     }
     /* Function that Generate the testimonial form */
     public function testimonial_form()
     {
          /* require one simple php file that contains the form */
          /* Read but don't execute */
          ob_start ();
          /* Load the styles*/
          echo ( "<link rel=\"stylesheet\" href=\"$this->plugin_url/assets/form.css\" type=\"text/css\" media=\"all\" /> " );
          /* Load the contact form */
          require_once ( "$this->plugin_path/templates/contact-form.php");
          /* only enqueues the javascript file if I am using the form */
          echo ( "<script src=\"$this->plugin_url/assets/form.js\"></script> " );
          return ( ob_get_clean () );
     }
     /* Function that Generate the testimonial slideshow */
     public function testimonial_slideshow()
     {
          /* require one simple php file that contains the form */
          /* Read but don't execute */
          ob_start ();
          /* Load the styles*/
          echo ( "<link rel=\"stylesheet\" href=\"$this->plugin_url/assets/slider.css\" type=\"text/css\" media=\"all\" /> " );
          /* Load the contact form */
          require_once ( "$this->plugin_path/templates/slider.php");
          /* only enqueues the javascript file if I am using the form */
          echo ( "<script src=\"$this->plugin_url/assets/slider.js\"></script> " );
          return ( ob_get_clean () );
     }
     /* Activates the Shurtcodes */
     public function setShortcodePage()
     {
          /* We are going to add a subpage */
          $subpage = array (
               array (
                    'parent_slug' => 'edit.php?post_type=testimonial', //We use the url of the Testimonial posts
                    'page_title' => 'Shortcodes',
                    'menu_title' => 'Shortcodes',
                    'capability' => 'manage_options',
                    'menu_slug' => 'mtk_testimonial_shortcode',
                    'callback' => array ( $this->callbacks , 'shortcodePage' )
          ));
          $this->settings->addSubPages( $subpage )->register();
     }
     /* Crates the Custome Post Type for the Testimonials */
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
			'supports' => array( 'title', 'editor' ),
               'show_in_rest' => true
		);
		register_post_type ( 'testimonial', $args );
	}
     /* Adds the meta boxes */
     public function add_meta_boxes()
     {
          /* Author Name */
          add_meta_box(
               'testimonial_options',
               'Testimonial Options',
               array ( $this , 'render_features_box'),
               'testimonial',
               'side',
               'default'
          );
          /* Author email */
          /* approved [checkbox] */
          /* featured [checkbox] */
     }
     /* Creates the actual meta box that is previously added */
     public function render_features_box ( $post )
     {
          /*  validate that the contents of the form request */
          wp_nonce_field( 'mtk_testimonial_author' , 'mtk_testimonial_author_nonce' );
          /* Get the data */
          $data  = get_post_meta ( $post->ID , '_mtk_testimonial_key' , true );

          /* Create the variables where we are going to sort the information */
          /* Author Name */
          $name = isset($data['name']) ? $data['name'] : '';
          /* Email */
          $email = isset($data['email']) ? $data['email'] : '';
          /* approved */
          $approved = isset($data['approved']) ? $data['approved'] : false;
          /* featured */
          $featured = isset($data['featured']) ? $data['featured'] : false;
          ?>
          <label class="meta-label" for="mtk_testimonial_author">Author Name</label>
          <input type="text" id="mtk_testimonial_author" name="mtk_testimonial_author" value="<?php echo ( esc_attr( $name ) ); ?>"
          <label class="meta-label" for="mtk_testimonial_author">Author Email</label>
          <input type="text" id="mtk_testimonial_author" name="mtk_testimonial_email" value="<?php echo ( esc_attr( $email ) ); ?>"
          <div class="meta-container">
			<label class="meta-label w-50 text-left" for="mtk_testimonial_approved">Approved</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline"><input type="checkbox" id="mtk_testimonial_approved" name="mtk_testimonial_approved" value="1" <?php echo $approved ? 'checked' : ''; ?>>
					<label for="mtk_testimonial_approved"><div></div></label>
				</div>
			</div>
               <label class="meta-label w-50 text-left" for="mtk_testimonial_featured">Featured</label>
			<div class="text-right w-50 inline">
				<div class="ui-toggle inline"><input type="checkbox" id="mtk_testimonial_featured" name="mtk_testimonial_featured" value="1" <?php echo $featured ? 'checked' : ''; ?>>
					<label for="mtk_testimonial_featured"><div></div></label>
				</div>
			</div>
		</div>
          <?php
     }
     /* Saves the data we have added to the Meta box */
     public function save_meta_box( $post_id )
     {
          /* Happens every time the user saves the post */
          if ( ! ( isset ( $_POST['mtk_testimonial_author'] ) ) )
          {
               /* If the another post is saved, not the testimonial type then we just return the post id*/
               return ( $post_id );
          }
          /* then wer stoe our extra variables */
          /* We store our custom nonce */
          $nonce = $_POST['mtk_testimonial_author_nonce'];
          /* Verify the that the none is valid */
          if ( ! ( wp_verify_nonce ( $nonce , 'mtk_testimonial_author' ) ) )
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
               return ( $post_id );
          }
          /* Store this metabox */
          $data = array(
			'name' => sanitize_text_field( $_POST['mtk_testimonial_author'] ),
			'email' => sanitize_email( $_POST['mtk_testimonial_email'] ),
			'approved' => isset($_POST['mtk_testimonial_approved']) ? 1 : 0,
			'featured' => isset($_POST['mtk_testimonial_featured']) ? 1 : 0,
		);
          update_post_meta( $post_id, '_mtk_testimonial_key', $data );
     }
     /*  Customizes the fields of the list we see in the Testimonial list */
     public function set_custom_column( $columns )
     {
          /* We are going to rearrange the information */
          $title = $columns['title'];
          $date = $columns['date'];
          unset ( $columns['title'] , $columns['date'] );

          $columns['name'] = 'Author Name';
          $columns['title'] = $title;
          $columns['approved'] = 'Approved';
          $columns['featured'] = 'Featured';
          $columns['date'] = $date;
          return ( $columns );
     }
     /* Sets the data that will be display in the list of Testimonials */
     public function set_custom_columns_data( $column , $post_id )
     {
          $data  = get_post_meta ( $post_id , '_mtk_testimonial_key' , true );
          /* Create the variables where we are going to sort the information */
          /* Author Name */
          $name = isset($data['name']) ? $data['name'] : '';
          /* Email */
          $email = isset($data['email']) ? $data['email'] : '';
          /* approved */
          $approved = ( isset($data['approved']) && ( $data['approved'] === 1 ) ) ? '<strong>YES</strong>' : 'NO';
          /* featured */
          $featured = ( isset($data['featured']) && ( $data['featured'] === 1 ) ) ? '<strong>YES</strong>' : 'NO';

          switch ( $column )
          {
               case 'name':
                    echo '<strong>' . $name . '</strong><br /><a href="mailto:'. $email .'">'. $email .'</a>';
                    break;
                    case 'approved':
                         echo ($approved);
                         break;
               case 'featured':
                    echo ($featured);
                    break;
          }
     }
     /* Sets Which fields are sortable */
     public function set_custom_columns_sortable ( $columns )
     {
          $columns['name'] = 'name';
          $columns['approved'] = 'approved';
          $columns['featured'] = 'featured';
          return ( $columns );
     }
}
