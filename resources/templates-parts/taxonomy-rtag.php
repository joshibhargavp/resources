<?php
	get_header('resources');
	remove_filter( 'the_content', 'wpautop' );
   $term = $wp_query->queried_object;

   // Retrieve the terms for 'rescat' taxonomy
   $industrys = get_terms(array(
      'taxonomy' => 'industry',
      'hide_empty' => false,
   ));
   // Retrieve the terms for 'rescat' taxonomy
   $types = get_terms(array(
      'taxonomy' => 'type',
      'hide_empty' => false,
   ));
   // Retrieve the terms for 'ressector' taxonomy
   $sectors = get_terms(array(
      'taxonomy' => 'sector',
      'hide_empty' => false,
   ));
?>


<!-- ===== Banner ===== -->
<div class="clearfix resource-banner">
   <div class="clearfix wrapper">
      <h1><?php echo $term->name; ?></h1>
   </div>   
   <!-- ===== Single Featured Post ===== -->
   <div class="clearfix single-resources-fetured">
      <div class="clearfix wrapper">
      <?php
         if( !is_paged() ){
            $homesinglePosts = array(
               'post_type' => 'resources',
               'posts_per_page' => 1,
               'tax_query' => array(
                  'relation' => 'OR',
                  array(
                     'taxonomy' => 'rtag', // For 'resources' post type
                     'field' => 'slug',
                     'terms' => 'featured-resource'
                  )
               )
            );

            $query = new WP_Query($homesinglePosts);
            if ($query->have_posts()) {
               while ($query->have_posts()) {
                  $query->the_post();
            ?>
            <div class="resources-single-fetured-post clearfix width100">
               <div class="single-featured-post-thumb width50 fl">
                  <?php if (has_post_thumbnail( $post->ID ) ): ?>
                  <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'singplepost' ); ?>
                     <a href="<?php echo get_permalink(); ?>">
                        <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" width="594" height="296" />
                     </a>
                  <?php endif; ?>
               </div>
               <div class="single-featured-post-content width50 fl">
                  <div class="clearfix tag-wrap"><span class="resource_tag">Featured Resource</span></div>
                  <h2><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
                  <p><?php echo wp_trim_words(get_the_excerpt(), 24); ?></p>
                  <a href="<?php echo get_permalink(); ?>" class="learnmoretext">Learn more &rang;</span></a>
               </div>
            </div>    
         <?php
               }
            } else {
               echo 'No featured resource found.';
            }
            wp_reset_postdata();
         }
         ?>
      </div>
   </div>
   <!-- ===== // Single Featured Post ===== -->
   <!-- ===== Resource Category ===== -->
   <div class="clearfix width100 resource-category-container mt-3">
      <div class="wrapper clearfix">
         <div class="clearfix res-cat-wrap">
            <div class="width25 fl">
               <div class="res-cat-box">
                  <a href="<?php echo home_url('/blog'); ?>">
                     <div class="res-cat-box-thumb fl">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/resources/icon-blog.png" alt="Icon Blogs" height="64" width="64" />
                     </div>
                     <span>Blog</span>
                  </a>
               </div>
            </div>
            <div class="width25 fl">
               <div class="res-cat-box">
                  <a href="<?php echo home_url('/case-studies.php'); ?>">
                     <div class="res-cat-box-thumb fl">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/resources/icon-case-study.png" alt="Icon Case Study" height="64" width="64" />
                     </div>
                     <span>Case Study</span>
                  </a>
               </div>
            </div>
            <div class="width25 fl">
               <div class="res-cat-box">
                  <a href="<?php echo home_url('/resource/type/infographic/'); ?>">
                     <div class="res-cat-box-thumb fl">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/resources/icon-infographics.png" alt="Icon Infographics" height="64" width="64" />
                     </div>
                     <span>Infographics</span>
                  </a>
               </div>
            </div>
            <div class="width25 fl">
               <div class="res-cat-box">
                  <a href="<?php echo home_url('/resource/type/brochure/'); ?>">
                     <div class="res-cat-box-thumb fl">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/resources/icon-brochure.png" alt="Icon Brochure" height="64" width="64" />
                     </div>
                     <span>Brochure</span>
                  </a>
               </div>
            </div>         
         </div>
      </div>
   </div>
   <!-- ===== // Resource Category ===== -->   
</div>
<!-- ===== // Banner ===== -->



<!-- ===== Filter Result ===== -->
<div class="clearfix wrapper">
   <div class="clearfix taxonomy-container" id="filtered-posts">
      <?php
      $args = array(
         'post_type' => 'resources',
         'posts_per_page' => 9,
         'rtag' => $term->name,
         'paged' => get_query_var( 'paged' ),
         'tax_query' => array(),
      );

      // Run the post query
      $query = new WP_Query( $args );

      // Output the post loop
      if ( $query->have_posts() ) {
         while ( $query->have_posts() ) {
            $query->the_post();
      ?>
      <div class="one-third fl mb-3">
         <div class="clearfix filter-post-wrap">
            <div class="clearfix filter-post-thumb">
               <?php if (has_post_thumbnail($post->ID)) :
               $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'csimg');
               ?>
               <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>" class="d-block">
                  <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" width="390" height="195" />
               </a>
               <?php endif; ?>
            </div>
            <div class="clearfix filter-post-info">
               <div class="clearfix tag-wrap">
                  <?php
                  // Display the post type and sector
                  // $type_terms = get_the_terms($post->ID, 'type');
                  $sector_terms = get_the_terms($post->ID, 'sector');
                  $industry_terms = get_the_terms($post->ID, 'industry');
                  // if (!empty($type_terms)) {
                  // $type = $type_terms[0]->name;
                  // echo '<span class="resource_tag">' . $type . '</span>';
                  // }
                  if (!empty($sector_terms)) {
                     $sector = $sector_terms[0]->name;
                     echo '<span class="resource_tag">' . $sector . '</span>';
                  }
                  if (!empty($industry_terms)) {
                     $industry = $industry_terms[0]->name;
                     echo '<span class="resource_tag">' . $industry . '</span>';
                  }
                  ?>
               </div>
               <h3><a href="<?php echo get_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
               <p><?php echo wp_trim_words(get_the_excerpt(), 10); ?></p>
            </div>
            <a href="<?php echo get_permalink(); ?>" class="bluelink">Learn more&nbsp;&rarr;</a>
         </div>
      </div>
      <?php
         }
      } else {
         echo 'No posts found for the specific term.';
      }
      wp_reset_postdata();
      ?>
   </div>
</div>
<!-- ===== //Filter Result ===== -->



<div class="clearfix wrapper text-center position-relative mt-1 mb-4 pb-4">
   <div class="clearfix resource-pagination">   
   <?php global $query;
      $big = 999999999; // need an unlikely integer
      echo paginate_links( array(
         'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
         'format' => '?paged=%#%',
         'current' => max( 1, get_query_var('paged') ),
         'total' => $query->max_num_pages
      ) );
      ?>
   </div>
</div>

<?php get_footer('resources'); ?>