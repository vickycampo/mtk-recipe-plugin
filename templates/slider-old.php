<?php
$args = array (
     'post_type' => 'testimonial',
     'post_status' => 'publish',
     'posts_per_page' => 5,
     'meta_query' => array (
          array (
               'key' => '_mtk_testimonial_key',
               'value' => 's:8:"approved";i:1;s:8:"featured";i:1;',
               'compare' => 'LIKE'
          )
     )
);
$query = new WP_Query( $args );
if ($query->have_posts()) :
     $i = 1;
     echo '<div class="mtk-slider--wrapper">';
     echo '<div class="mtk-slider--container">';
     echo '<div class="mtk-slider--view">';
     echo ('<ul>');
     /* We loop through all the testimonials */
     while ($query->have_posts()) : $query->the_post();
          echo '<li class="mtk-slider--view__slides'. ( $i ===1 ? ' is-active' : '') .'">';
          /* add the quote - content */
          echo '<p class="testimonial-quote">' . get_the_content() . '</p>';
          /* add the author (which is in the metadata) */
          $name = get_post_meta( get_the_ID() , '_mtk_testimonial_key' , true )['name'] ?: '';

          echo '<p class="testimonial-author">~ ' . $name .' ~</p>';
          echo '</li>';
          $i ++;
     endwhile;
     echo '</ul>';
     echo '</div><!-- mtk-slider--view -->';
     /* We write a container that contains all our arrows */
     echo ('<div class="mtk-slider--arrows">');
     /* Left arrow */
     echo ('<span class="arro mtk-slider--arrows__left" >');
     echo('<');
     echo ('</span <!-- mtk-slider--arrows__left-->');
     /* Right Arrow */
     echo ('<span class="arro mtk-slider--arrows__right" >');
     echo('>');
     echo ('</span <!-- mtk-slider--arrows__right -->');

     echo ('</div> <!-- mtk-slider--arrows -->');
     /* Close all the previous divs*/
     echo '</div><!-- mtk-slider--container -->';
     echo '</div><!-- mtk-slider--wrapper -->';
endif;

wp_reset_postdata();
