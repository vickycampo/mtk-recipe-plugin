<?php
/*

@package mkt-recipe-plugin

     ======================================================================
          Extra funtcions to make the RecipeCPTController more readable
     ======================================================================
*
*
*/
namespace Inc\Base;

/**
 * Enqueue - Enqueue the scripts and style files
*/
class ExtendComment extends BaseController
{
     public function register ()
     {
          // Add custom meta (ratings) fields to the default comment form
          // Default comment form includes name, email address and website URL
          // Default comment form elements are hidden when user is logged in
          add_filter( 'comment_form_default_fields', array ( $this , 'custom_fields' ) );

          // Add fields after default fields above the comment box, always visible
          add_action( 'comment_form_logged_in_after', array ( $this , 'additional_fields' ) );
          add_action( 'comment_form_after_fields', array ( $this , 'additional_fields' ) );

          // Save the comment meta data along with comment
          add_action( 'comment_post', array ( $this , 'save_comment_meta_data' ) );

          // Add the filter to check whether the comment meta data has been filled
          add_filter( 'preprocess_comment', array ( $this , 'verify_comment_meta_data' ) );

          // Add the comment meta (saved earlier) to the comment text
          // You can also output the comment meta values directly to the comments template
          add_filter( 'comment_text', array ( $this , 'modify_comment' ) );

          // Add an edit option to comment editing screen
          add_action( 'add_meta_boxes_comment', array ( $this , 'extend_comment_add_meta_box' ) );

          // Update comment meta data from comment editing screen 
          add_action( 'edit_comment', array ( $this , 'extend_comment_edit_metafields' ));
     }

     public function custom_fields( $fields )
     {
          // Add custom meta (ratings) fields to the default comment form
          // Default comment form includes name, email address and website URL
          // Default comment form elements are hidden when user is logged in


          $commenter = wp_get_current_commenter();
          $req = get_option( 'require_name_email' );
          $aria_req = ( $req ? " aria-required='true'" : ’ );

          $fields[ 'author' ] = '<p class="comment-form-author">'.
          '<label for="author">' . __( 'Name' ) . '</label>'.
           ( $req ? '<span class="required">*</span>' : ’ ).
           '<input id="author" name="author" type="text" value="'. esc_attr( $commenter['comment_author'] ) .
           '" size="30" tabindex="1"' . $aria_req . ' /></p>';

         $fields[ 'email' ] = '<p class="comment-form-email">'.
           '<label for="email">' . __( 'Email' ) . '</label>'.
           ( $req ? '<span class="required">*</span>' : ’ ).
           '<input id="email" name="email" type="text" value="'. esc_attr( $commenter['comment_author_email'] ) .
           '" size="30"  tabindex="2"' . $aria_req . ' /></p>';

         $fields[ 'url' ] = '<p class="comment-form-url">'.
           '<label for="url">' . __( 'Website' ) . '</label>'.
           '<input id="url" name="url" type="text" value="'. esc_attr( $commenter['comment_author_url'] ) .
           '" size="30"  tabindex="3" /></p>';

         $fields[ 'phone' ] = '<p class="comment-form-phone">'.
           '<label for="phone">' . __( 'Phone' ) . '</label>'.
           '<input id="phone" name="phone" type="text" size="30"  tabindex="4" /></p>';

       return $fields;
     }
     public function additional_fields ()
     {
          // Add fields after default fields above the comment box, always visible
          echo ('<p class="comment-form-rating">');
          echo ('<label for="rating">'. __('Rating'));
          echo ('<span class="required">*</span>');
          echo ('</label>');
          echo ('<span class="commentratingbox">');
          for( $i=1; $i <= 5; $i++ )
          {
               echo '<span class="commentrating"><input type="radio" name="rating" id="rating" value="'. $i .'"/>'. $i .'</span>';
          }
          echo'</span></p>';
     }
     function save_comment_meta_data( $comment_id )
     {
          // Save the comment meta data along with comment
          if ( ( isset( $_POST['phone'] ) ) && ( $_POST['phone'] != ’) )
          $phone = wp_filter_nohtml_kses($_POST['phone']);
          add_comment_meta( $comment_id, 'phone', $phone );

          if ( ( isset( $_POST['title'] ) ) && ( $_POST['title'] != ’) )
          $title = wp_filter_nohtml_kses($_POST['title']);
          add_comment_meta( $comment_id, 'title', $title );

          if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != ’) )
          $rating = wp_filter_nohtml_kses($_POST['rating']);
          add_comment_meta( $comment_id, 'rating', $rating );
     }
     public function verify_comment_meta_data( $commentdata )
     {

          if ( ! isset( $_POST['rating'] ) )
          {
               wp_die( __( 'Error: You did not add a rating. Hit the Back button on your Web browser and resubmit your comment with a rating.' ) );
          }
           return $commentdata;
     }
     public function modify_comment( $text )
     {
          // Add the comment meta (saved earlier) to the comment text
          // You can also output the comment meta values directly to the comments template
          $plugin_url_path = WP_PLUGIN_URL;

          if( $commentrating = get_comment_meta( get_comment_ID(), 'rating', true ) )
          {
               $commentrating = '<p class="comment-rating"><img src="'. $plugin_url_path .
          '/ExtendComment/images/'. $commentrating . 'star.gif"/><br/>Rating: <strong>'. $commentrating .' / 5</strong></p>';
               $text = $text . $commentrating;
               return $text;
          }
          else
          {
               return $text;
          }
     }
     function extend_comment_add_meta_box()
     {
          // Add an edit option to comment editing screen
          add_meta_box( 'title', __( 'Comment Metadata - Extend Comment' ), array ( $this , 'extend_comment_meta_box'), 'comment', 'normal', 'high' );
     }

     function extend_comment_meta_box ( $comment )
     {
          $phone = get_comment_meta( $comment->comment_ID, 'phone', true );
          $title = get_comment_meta( $comment->comment_ID, 'title', true );
          $rating = get_comment_meta( $comment->comment_ID, 'rating', true );
          wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
          ?>
          <p>
             <label for="phone"><?php _e( 'Phone' ); ?></label>
             <input type="text" name="phone" value="<?php echo esc_attr( $phone ); ?>" class="widefat" />
          </p>
          <p>
             <label for="title"><?php _e( 'Comment Title' ); ?></label>
             <input type="text" name="title" value="<?php echo esc_attr( $title ); ?>" class="widefat" />
          </p>
          <p>
             <label for="rating"><?php _e( 'Rating: ' ); ?></label>
           <span class="commentratingbox">
           <?php for( $i=1; $i <= 5; $i++ ) {
             echo '<span class="commentrating"><input type="radio" name="rating" id="rating" value="'. $i .'"';
             if ( $rating == $i ) echo ' checked="checked"';
             echo ' />'. $i .' </span>';
             }
           ?>
           </span>
          </p>
          <?php
     }
     function extend_comment_edit_metafields( $comment_id )
     {
          // Update comment meta data from comment editing screen
          if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) return;

          if ( ( isset( $_POST['phone'] ) ) && ( $_POST['phone'] != ’) ) :
               $phone = wp_filter_nohtml_kses($_POST['phone']);
               update_comment_meta( $comment_id, 'phone', $phone );
          else :
               delete_comment_meta( $comment_id, 'phone');
          endif;

          if ( ( isset( $_POST['title'] ) ) && ( $_POST['title'] != ’) ):
               $title = wp_filter_nohtml_kses($_POST['title']);
               update_comment_meta( $comment_id, 'title', $title );
          else :
          delete_comment_meta( $comment_id, 'title');
          endif;

          if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != ’) ):
               $rating = wp_filter_nohtml_kses($_POST['rating']);
               update_comment_meta( $comment_id, 'rating', $rating );
          else :
               delete_comment_meta( $comment_id, 'rating');
          endif;

     }
}
