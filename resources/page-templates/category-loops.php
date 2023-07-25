<div class="clearfix cat-loop">
   <!-- START: Blog Articles -->
   <div class="clearfix wrapper res_cat_card">
      <div class="clearfix res_cat_card_header">
         <h2>Latest Articles</h2>
         <a href="<?php echo home_url('/blog'); ?>">View all Articles&nbsp;&raquo;</a>
      </div>
      <div class="clearfix res_cat_card_wrap">
         <?php
            $query = new WP_Query(
               array(
                  'post_type'      => 'post',
                  'posts_per_page' => 3
               )
            );
         ?>   
         <?php while ($query->have_posts()) : $query->the_post(); ?>
            <?php $theTerms = wp_get_object_terms($post->ID, 'division'); ?> 
            <div class="one-third fl">
               <div class="clearfix res_cat_card_box">
                  <div class="res_cat_card_thumb clearfix">               
                     <?php if (has_post_thumbnail($post->ID)) : ?>
                        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'csimg'); ?>
                        <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>" class="d-block">
                           <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" width="390" height="195" />
                        </a>
                     <?php endif; ?>
                  </div>
                  <div class="res_cat_card_info clearfix">
                     <h3 class="mt-0"><a href="<?php echo get_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                     <div class="card_hidden">
                        <h3><a href="<?php echo get_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                        <p class="res_cat_card_excerpt"><?php echo wp_trim_words(get_the_excerpt(), 10); ?></p>
                     </div>
                     <a href="<?php echo get_permalink(); ?>" class="bluelink">Learn more&nbsp;&rarr;</a>
                  </div>
               </div>
            </div>
         <?php endwhile; ?>
         <?php wp_reset_postdata(); ?>
      </div>
   </div>
   <!-- END: Blog Articles -->



   <!-- START: Case Studies -->
   <div class="clearfix wrapper res_cat_card">
      <div class="clearfix res_cat_card_header">
         <h2>Case Studies</h2>
         <a href="<?php echo home_url('/case-studies'); ?>">View all Case Studies&nbsp;&raquo;</a>
      </div>
      <div class="clearfix res_cat_card_wrap">
         <?php
            $query = new WP_Query(
               array(
                  'post_type'      => 'case_studies',
                  'posts_per_page' => 3
               )
            );
         ?>   
         <?php while ($query->have_posts()) : $query->the_post(); ?>
            <?php $theTerms = wp_get_object_terms($post->ID, 'division'); ?> 
            <div class="one-third fl">
               <div class="clearfix res_cat_card_box">
                  <div class="res_cat_card_thumb clearfix">               
                     <?php if (has_post_thumbnail($post->ID)) : ?>
                        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'csimg'); ?>
                        <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>" class="d-block">
                           <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" width="390" height="195" />
                        </a>
                     <?php endif; ?>
                  </div>
                  <div class="res_cat_card_info clearfix">
                     <span class="resource_tag"><?php echo $theTerms[0]->name ?></span>
                     <h3><a href="<?php echo get_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                     <div class="card_hidden">
                        <h3><a href="<?php echo get_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                        <p class="res_cat_card_excerpt"><?php echo wp_trim_words(get_the_excerpt(), 10); ?></p>
                     </div>
                     <a href="<?php echo get_permalink(); ?>" class="bluelink">Learn more&nbsp;&rarr;</a>
                  </div>
               </div>
            </div>
         <?php endwhile; ?>
         <?php wp_reset_postdata(); ?>
      </div>
   </div>
   <!-- END: Case Studies -->



   <!-- START: White Papers Categories -->
   <div class="clearfix wrapper res_cat_card">
      <div class="clearfix res_cat_card_header">
         <h2>White Papers</h2>
         <?php $term_link = get_term_link('white-paper', 'type'); if (!is_wp_error($term_link)) { echo '<a href="' . esc_url($term_link) . '">View all White Papers&nbsp;&raquo;</a>'; } ?>
      </div>
      <div class="clearfix res_cat_card_wrap">
         <?php
            $query = new WP_Query(
               array(
                  'post_type'      => 'resources',
                  'posts_per_page' => 3,
                  'tax_query'      => array(
                     array(
                        'taxonomy' => 'type',
                        'field'    => 'slug',
                        'terms'    => 'white-paper'
                     )
                  )
               )
            );
         ?>   
         <?php while ($query->have_posts()) : $query->the_post(); ?>
            <?php $theSectors = wp_get_object_terms($post->ID, 'sector'); ?>         
            <div class="one-third fl">
               <div class="clearfix res_cat_card_box">
                  <div class="res_cat_card_thumb clearfix">               
                     <?php if (has_post_thumbnail($post->ID)) : ?>
                        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'csimg'); ?>
                        <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>" class="d-block">
                           <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" width="390" height="195" />
                        </a>
                     <?php endif; ?>
                  </div>
                  <div class="res_cat_card_info clearfix">
                     <span class="resource_tag"><?php echo $theSectors[0]->name ?></span>
                     <h3><a href="<?php echo get_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                     <div class="card_hidden">
                        <h3><a href="<?php echo get_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                        <p class="res_cat_card_excerpt"><?php echo wp_trim_words(get_the_excerpt(), 10); ?></p>
                     </div>
                     <a href="<?php echo get_permalink(); ?>" class="bluelink">Learn more&nbsp;&rarr;</a>
                  </div>
               </div>
            </div>
         <?php endwhile; ?>
         <?php wp_reset_postdata(); ?>
      </div>
   </div>
   <!-- END: White Papers Categories -->



   <!-- START: Video Categories -->
   <div class="clearfix wrapper res_cat_card">
      <div class="clearfix res_cat_card_header">
         <h2>Video</h2>
         <?php $term_link = get_term_link('video', 'type'); if (!is_wp_error($term_link)) { echo '<a href="' . esc_url($term_link) . '">View all Videos&nbsp;&raquo;</a>'; } ?>
      </div>
      <div class="clearfix res_cat_card_wrap">
      <?php
         $video_posts = new WP_Query(
            array(
               'post_type'      => 'resources',
               'posts_per_page' => 3,
               'tax_query'      => array(
                  array(
                     'taxonomy' => 'type',
                     'field'    => 'slug',
                     'terms'    => 'video'
                  )
               )
            )
         );
         if ($video_posts->have_posts()) :
      ?>
         <?php while ($video_posts->have_posts()) : $video_posts->the_post(); ?>
            <?php $theSectors = wp_get_object_terms($post->ID, 'sector'); ?>
            <div class="one-third fl">
               <div class="clearfix res_cat_card_box">
                  <div class="res_cat_card_thumb clearfix">
                     <?php if (has_post_thumbnail($post->ID)) : ?>
                        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'csimg'); ?>
                        <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>" class="d-block">
                           <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" width="390" height="195" />
                        </a>
                     <?php endif; ?>
                  </div>
                  <div class="res_cat_card_info clearfix">
                     <span class="resource_tag"><?php echo $theSectors[0]->name ?></span>
                     <h3><a href="<?php echo get_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                     <div class="card_hidden">
                        <h3><a href="<?php echo get_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                        <p class="res_cat_card_excerpt"><?php echo wp_trim_words(get_the_excerpt(), 10); ?></p>
                     </div>
                     <a href="<?php echo get_permalink(); ?>" class="bluelink">Learn more&nbsp;&rarr;</a>
                  </div>
               </div>
            </div>
         <?php endwhile; ?>
      <?php else : ?>
         <p>Sorry, no videos are available.</p>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
      </div>
   </div>
   <!-- END: Video Categories -->


   <!-- START: Infographic Categories -->
   <div class="clearfix wrapper res_cat_card">
      <div class="clearfix res_cat_card_header">
         <h2>Infographic</h2>
         <?php $term_link = get_term_link('infographic', 'type'); if (!is_wp_error($term_link)) { echo '<a href="' . esc_url($term_link) . '">View all Infographic&nbsp;&raquo;</a>'; } ?>
      </div>
      <div class="clearfix res_cat_card_wrap">
      <?php
         $infographic_posts = new WP_Query(
            array(
               'post_type'      => 'resources',
               'posts_per_page' => 3,
               'tax_query'      => array(
                  array(
                     'taxonomy' => 'type',
                     'field'    => 'slug',
                     'terms'    => 'infographic'
                  )
               )
            )
         );
         if ($infographic_posts->have_posts()) :
      ?>
         <?php while ($infographic_posts->have_posts()) : $infographic_posts->the_post(); ?>
            <?php $theSectors = wp_get_object_terms($post->ID, 'sector'); ?>
            <div class="one-third fl">
               <div class="clearfix res_cat_card_box">
                  <div class="res_cat_card_thumb clearfix">
                     <?php if (has_post_thumbnail($post->ID)) : ?>
                        <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'csimg'); ?>
                        <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>" class="d-block">
                           <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" width="390" height="195" />
                        </a>
                     <?php endif; ?>
                  </div>
                  <div class="res_cat_card_info clearfix">
                     <span class="resource_tag"><?php echo $theSectors[0]->name ?></span>
                     <h3><a href="<?php echo get_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                     <div class="card_hidden">
                        <h3><a href="<?php echo get_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                        <p class="res_cat_card_excerpt"><?php echo wp_trim_words(get_the_excerpt(), 10); ?></p>
                     </div>
                     <a href="<?php echo get_permalink(); ?>" class="bluelink">Learn more&nbsp;&rarr;</a>
                  </div>
               </div>
            </div>
         <?php endwhile; ?>
      <?php else : ?>
         <p>Sorry, no infographics are available.</p>
      <?php endif; ?>
      <?php wp_reset_postdata(); ?>
      </div>
   </div>
   <!-- END: Infographic Categories -->
   
</div>