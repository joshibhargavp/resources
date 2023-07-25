<div class="filter-resource-container clearfix">
   <div class="clearfix wrapper pb-4 mb-2">
      <div class="clearfix res_cat_card_container">
      <?php
         $args = array(
            'post_type' => 'resources',
            'posts_per_page' => -1, // Set to -1 to display all posts
         );

         // Check if there are any filter parameters in the URL
         $selectedIndustry = isset($_GET['industry']) ? $_GET['industry'] : '';
         $selectedType = isset($_GET['type']) ? $_GET['type'] : '';
         $selectedSector = isset($_GET['sector']) ? $_GET['sector'] : '';

         if ($selectedIndustry !== '') {
            $args['tax_query'][] = array(
               'taxonomy' => 'industry',
               'field' => 'slug',
               'terms' => $selectedIndustry,
            );
         }      

         if ($selectedType !== '') {
            $args['tax_query'][] = array(
               'taxonomy' => 'type',
               'field' => 'slug',
               'terms' => $selectedType,
            );
         }

         if ($selectedSector !== '') {
            $args['tax_query'][] = array(
               'taxonomy' => 'sector',
               'field' => 'slug',
               'terms' => $selectedSector,
            );
         }

         $query = new WP_Query($args);

         if ($query->have_posts()) {
            while ($query->have_posts()) {
               $query->the_post();
               $theTerms = wp_get_object_terms($post->ID, 'type');
               $theSectors = wp_get_object_terms($post->ID, 'sector');
               $theIndustry = wp_get_object_terms($post->ID, 'industry');
         ?>

         <!-- Rest of the code for displaying the resource cards fadeInUp -->
         <div class="one-third fl mb-3">
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
                  <span class="resource_tag"><?php echo $theIndustry[0]->name ?></span>
                  <span class="resource_tag"><?php echo $theTerms[0]->name ?></span>
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
         <?php
            }
         } else {
            echo "Sorry, No Posts to display";
         }
         wp_reset_postdata();
         ?>
      </div>
   </div>
</div>   