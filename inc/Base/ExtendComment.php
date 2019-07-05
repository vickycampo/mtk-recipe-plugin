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

          //Saves the average in the post meta data
          add_action('transition_comment_status', array ( $this , 'save_average_ratings' ), 10, 3);

          /* Add the jQuery parameters */
          /* Listen to the action that was specified in the hidden field in the form */
          add_action( 'wp_ajax_submit_comments_form', array( $this, 'submit_comments_form' ) );
		add_action( 'wp_ajax_nopriv_submit_comments_form', array( $this, 'submit_comments_form' ) );
          // Send all comment submissions through my "ajaxComment" method
          add_action('comment_post', array ( $this , 'ajaxComment'), 20, 2);
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
          if ( ( isset ( $cpt_options[$post_type] ) )  && ( isset ( $cpt_options[$post_type]['has_rating'] ) )  && ( $cpt_options[$post_type]['has_rating'] == 1 ) )
          {
               echo ('<p class="comment-form-rating">');
               echo ('<label for="rating">'. __('Rating'));
               echo ('<span class="required">*</span>');
               echo ('</label>');
               echo ('<span class="commentratingbox">');
               echo (__FILE__ . ' - '. __LINE__ .  '<br>Add the stars and create the js file with the event handler.<br>');
               for( $i=1; $i <= 5; $i++ )
               {
                    echo '<span id="input_rating_'.$i.'" class="rating-star input_rating inactive-star">&#9733;</span>';
               }
               echo'</span></p>';
               /* Sending hidden values */
               echo ('<input type="hidden" id="rating" name="rating" value="0">');
               echo ('<input type="hidden" id="post_type" name="post_type" value="'.$post_type.'">');
               echo ('<input type="hidden" id="data-url" name="data-url" value="'.admin_url('admin-ajax.php').'">');
               echo ('<input type="hidden" name="action" value="submit_comments_form">');
               echo ('<input type="hidden" name="nonce" value="'.wp_create_nonce("comment_form-nonce").'">');

               /* Dipslying messages for ajax form */
               echo ('<small class="field-msg js-form-submission">Submission in process, please wait&hellip;</small>');
               echo ('<small class="field-msg success js-form-success">Comment Successfully submitted, thank you!</small>');
               echo ('<small class="field-msg error js-form-error">There was a problem with the comment, please try again!</small>');

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
               add_comment_meta( $comment_id, 'post_type', $post_type );
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

          if( $rating = get_comment_meta( get_comment_ID(), 'rating', true ) )
          {
               $text = '<p class="comment-rating">';
               for ($star = 1; $star < 6; $star ++)
               {
                    if ($star <= $rating)
                    {
                         $text .= ('<span class="rating-star active-star">&#9733;</span>');
                    }
                    else
                    {
                         $text .= ('<span class="rating-star inactive-star">&#9734;</span>');
                    }
               }
               $text .= '<br/>Rating: <strong>'. $rating .' / 5</strong></p>';
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

          if ( $post_type != '')
          {
               wp_nonce_field( 'extend_comment_update', 'extend_comment_update', false );
               echo (__FILE__ . ' - '. __LINE__ .  '<br>Add the stars and create the js file with the event handler.<br>');
               ?>
               <p>
                    <label for="rating"><?php _e( 'Rating: ' ); ?></label>
                    <span class="commentratingbox">
                         <?php
                         for( $i=1; $i <= 5; $i++ )
                         {
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
     public function save_average_ratings($new_status, $old_status, $comment)
     {
          if($old_status != $new_status)
          {
               if($new_status == 'approved')
               {
                    $post_id = $comment->comment_post_ID;
                    $post_type = get_post_type ($post_id);
                    $cpt_options = get_option ( 'mtk_plugin_cpt');

                    if ( isset ($cpt_options[$post_type]) && $cpt_options[$post_type]['has_rating'] == 1 && isset ( $cpt_options[$post_type]['customFields'] ) && isset ( $cpt_options[$post_type]['customFields']['rating'] ) )
                    {


                         $parent = $cpt_options[$post_type]['customFields']['rating']['Parent'];
                         $meta_key = '_mtk_default_recipe_'.$parent.'_0';
                         if ($cpt_options[$post_type]['customFields'][$parent]['Parent'] != $parent)
                         {
                              $grandParent = $cpt_options[$post_type]['customFields'][$parent]['Parent'];
                              $meta_key = '_mtk_default_recipe_'.$grandParent.'_0';
                              if ($cpt_options[$post_type]['customFields'][$grandParent]['Parent'] != $grandParent)
                              {
                                   $GreatGrandParent = $cpt_options[$post_type]['customFields'][$grandParent]['Parent'];
                                   $meta_key = '_mtk_default_recipe_'.$grandParent.'_0';
                                   if ($cpt_options[$post_type]['customFields'][$GreatGrandParent]['Parent'] != $GreatGrandParent)
                                   {
                                        $TataGreatGrandParent = $cpt_options[$post_type]['customFields'][$GreatGrandParent]['Parent'];
                                        $meta_key = '_mtk_default_recipe_'.$TataGreatGrandParent.'_0';
                                   }
                              }
                         }
                         $prev_value = get_post_meta($post_id, $meta_key);
                         $meta_value = $prev_value;
                         $average_ratings = $this->get_average_ratings( $post_id );
                         $meta_value[0]['rating_0'] = $average_ratings;

                         update_post_meta( $post_id, $meta_key, $meta_value[0] );
                         error_log (print_r ($post_id , true));
                         error_log (print_r ($post_type , true));
                         error_log (print_r ($meta_key , true));
                         error_log (print_r ($prev_value , true));
                         error_log (print_r ($meta_value , true));

                    }


               }
          }
     }
     public function ajaxComment($comment_ID, $comment_status)
     {
     	// If it's an AJAX-submitted comment
     	if( isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
          {
     		// Get the comment data
     		$comment = get_comment($comment_ID);
     		// Allow the email to the author to be sent
     		wp_notify_postauthor($comment_ID, $comment->comment_type);
     		// Get the comment HTML from my custom comment HTML function
     		$commentContent = getCommentHTML($comment);
     		// Kill the script, returning the comment HTML
     		die($commentContent);
     	}
     }
     public function submit_comments_form ()
     {


          /* double check if this is an actual ajax call */
          if ( ! ( DOING_AJAX  ||  check_ajax_referer ( 'comment_form-nonce' , 'nonce' )  ) )
          {
               return ( $this->return_json('error') );
          }


          /* Store the data into testimonial CPT */
          /** Sets up the WordPress Environment. */
          $path = preg_replace('/wp-content.*$/','',__DIR__);
          require( $path.'wp-load.php' );
          nocache_headers();
          $comment = wp_handle_comment_submission( wp_unslash( $_POST ) );

          if ( is_wp_error( $comment ) )
          {
          	$data = intval( $comment->get_error_data() );
          	if ( ! empty( $data ) )
               {

                    $message['status'] = 'error';
                    $message['message'] = $comment->get_error_message();
                    return ( $this->return_json($message) );
          		wp_die();

          	}
               else
               {
          		exit;
          	}
          }

          $user            = wp_get_current_user();
          $cookies_consent = ( isset( $_POST['wp-comment-cookies-consent'] ) );
          do_action( 'set_comment_cookies', $comment, $user, $cookies_consent );

          $message['status'] = 'success';
          $message['message'] = 'Your comment has been saved';
          return ( $this->return_json($message) );
          exit;
     }
     public function return_json ( $message )
     {
          error_log (__FUNCTION__ . ' - ' . __LINE__);
          error_log( print_r ( $message , true ) );
          error_log ('----------------------------');
          $return = array (
               'status' => $message['status'],
               'message' => $message['message'],
          );
          wp_send_json( $return );
          wp_die ();
     }
}
