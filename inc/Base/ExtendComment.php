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

          //Display the average rating above the content.
          add_filter( 'the_content', array ( $this , 'display_average_rating') );
     }

     public function custom_fields( $fields )
     {
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
          // Add fields after default fields above the comment box, always visible+
          /* only if is a custom post type */
          $post_type = get_post_type ();
          $cpt_options = get_option ( 'mtk_plugin_cpt');
          if ( ( isset ( $cpt_options[$post_type] ) )  && ( $cpt_options[$post_type]['has_rating'] == 1 ) )
          {
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
               echo ('<input type="hidden" id="post_type" name="post_type" value="$post_type">');
          }

     }
     function save_comment_meta_data( $comment_id )
     {

          if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != '') )
          {
               $rating = wp_filter_nohtml_kses($_POST['rating']);
               add_comment_meta( $comment_id, 'rating', $rating );
          }
          if ( ( isset( $_POST['post_type'] ) ) && ( $_POST['post_type'] != '') )
          {
               $post_type = wp_filter_nohtml_kses($_POST['post_type']);
               add_comment_meta( $comment_id, 'post_type', $rating );
          }
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
          $post_type = get_post_type ();
          error_log (__FILE__ . ' - ' . __LINE__ . 'post_type - ' . $post_type);

          if ( ( isset ( $cpt_options[$post_type] ) )  && ( $cpt_options[$post_type]['has_rating'] == 1 ) )
          {
          }
          // Add an edit option to comment editing screen
          add_meta_box( 'title', __( 'Comment Metadata - Extend Comment' ), array ( $this , 'extend_comment_meta_box'), 'comment', 'normal', 'high' );
     }

     function extend_comment_meta_box ( $comment )
     {
          $post_type = get_comment_meta( $comment->comment_ID, 'post_type', true );
          $rating = get_comment_meta( $comment->comment_ID, 'rating', true );
          if ( $post_type = '')
          {
               wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
               ?>
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

     }
     function extend_comment_edit_metafields( $comment_id )
     {
          // Update comment meta data from comment editing screen
          if( ! isset( $_POST['extend_comment_update'] ) || ! wp_verify_nonce( $_POST['extend_comment_update'], 'extend_comment_update' ) ) return;

          if ( ( isset( $_POST['rating'] ) ) && ( $_POST['rating'] != ’) ):
               $rating = wp_filter_nohtml_kses($_POST['rating']);
               update_comment_meta( $comment_id, 'rating', $rating );
          else :
               delete_comment_meta( $comment_id, 'rating');
          endif;

     }

     public function get_average_ratings( $id )
     {
          //Get the average rating of a post.
          $comments = get_approved_comments( $id );
          if ( $comments )
          {
               $i = 0;
               $total = 0;
               foreach( $comments as $comment )
               {
                    $rate = get_comment_meta( $comment->comment_ID, 'rating', true );
                    if( isset( $rate ) && '' !== $rate )
                    {
                         $i++;
                         $total += $rate;
                    }
               }
               if ( 0 === $i )
               {
                    return false;
               }
               else
               {
                    return round( $total / $i, 1 );
               }
          }
          else
          {
               return false;
          }
     }

     public function display_average_rating( $content )
     {
          //Display the average rating above the content.
          global $post;

          $stars   = '';
          $average = $this->get_average_ratings( $post->ID );

          if ( false === $average )
          {
               return $content;
          }
          for ( $i = 1; $i <= $average + 1; $i++ )
          {
               $width = intval( $i - $average > 0 ? 20 - ( ( $i - $average ) * 20 ) : 20 );

               if ( 0 === $width )
               {
                    continue;
               }

               $stars .= '<span style="overflow:hidden; width:' . $width . 'px" class="dashicons dashicons-star-filled"></span>';

               if ( $i - $average > 0 )
               {
                    $stars .= '<span style="overflow:hidden; position:relative; left:-' . $width .'px;" class="dashicons dashicons-star-empty"></span>';
               }
          }

          $custom_content  = '<p class="average-rating">This post\'s average rating is: ' . $average .' ' . $stars .'</p>';
          $custom_content .= $content;
          return $custom_content;
     }
}
