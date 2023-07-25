<!-- START : BANNER -->
<div class="clearfix kc_banner">
   <div class="wrapper clearfix">
      
      <div class="kc_banner_head clearfix">
         <span>Resource Overview</span>
         <h1>All the information you need.</h1>
      </div>
      
      <div class="clearfix featured_post">
         <div class="featured_post_head">
            Featured Resources
         </div>
         <?php
         if( !is_paged() ){
            $homepagePosts = new WP_Query(
                              array(
                                 'posts_per_page' => 1,
                                 'restag' => 'featured-res'
                              )
                           );
            while ($homepagePosts->have_posts()) {
               $homepagePosts->the_post(); ?>
               <?php $theTerms = wp_get_object_terms($post->ID, 'rescat'); ?> 
               <div class="clearfix featured_post_wrap">
                  <div class="width50 fl">
                     <div class="featured_thumb clearfix">
                        <?php if (has_post_thumbnail( $post->ID ) ): ?>
                        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'singplepost' ); ?>
                           <a href="<?php the_permalink() ?>"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" width="594" height="296" /></a>
                        <?php endif; ?>
                     </div>
                  </div>
                  <div class="width50 fl">
                     <div class="featured_info clearfix">
                        <span class="resource_tag"><?php echo $theTerms[0]->name ?></span>
                        <h2><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
                        <p><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
                        <a href="#" class="bluelink">Learn more&nbsp;&rarr;</a>
                     </div>
                  </div>
               </div>
            <?php } wp_reset_postdata(); ?> 
         <?php } ?>         
      </div>
      
      
      <!-- Start : Featured Resources Categories -->
      <div class="clearfix res_cat">
         <div class="clearfix res_cat_wrap row-cols-7-gutter">
            <div class="fl res_cat_box">
               <a href="<?php echo home_url('/blog'); ?>">
                  <div class="clearfix res_cat_thumb">
                     <img src="<?php echo get_template_directory_uri(); ?>/images/kc/icon-blog.png" alt="Icon Blogs" height="65" width="65" />
                  </div>
                  <p>Blogs</p>
               </a>
            </div>
            <div class="fl res_cat_box">
               <a href="<?php echo home_url('/case-studies'); ?>">
                  <div class="clearfix res_cat_thumb">
                     <img src="<?php echo get_template_directory_uri(); ?>/images/kc/icon-case-studies.png" alt="Case Studies" height="65" width="65" />
                  </div>
                  <p>Case Studies</p>
               </a>
            </div>
            <div class="fl res_cat_box">
               <a href="<?php echo home_url('/resource/white-paper'); ?>">
                  <div class="clearfix res_cat_thumb">
                     <img src="<?php echo get_template_directory_uri(); ?>/images/kc/icon-white-paper.png" alt="Icon White Papers" height="65" width="65" />
                  </div>
                  <p>White Papers</p>
               </a>
            </div>
            <div class="fl res_cat_box">
               <a href="<?php echo home_url('/resource/infographic'); ?>">
                  <div class="clearfix res_cat_thumb">
                     <img src="<?php echo get_template_directory_uri(); ?>/images/kc/icon-infographics.png" alt="Icon Infographics" height="65" width="65" />
                  </div>
                  <p>Infographics</p>
               </a>
            </div>
            <div class="fl res_cat_box">
               <a href="<?php echo home_url('/resource/research-paper'); ?>">
                  <div class="clearfix res_cat_thumb">
                     <img src="<?php echo get_template_directory_uri(); ?>/images/kc/icon-research-paper.png" alt="Icon Research Papers" height="65" width="65" />
                  </div>
                  <p>Ebook / Papers</p>
               </a>
            </div>            
            <div class="fl res_cat_box">
               <a href="<?php echo home_url('/resource/brochure'); ?>">
                  <div class="clearfix res_cat_thumb">
                     <img src="<?php echo get_template_directory_uri(); ?>/images/kc/icon-brochure.png" alt="Icon Brochure" height="65" width="65" />
                  </div>
                  <p>Brochure</p>
               </a>
            </div>
            <div class="fl res_cat_box">
               <a href="<?php echo home_url('/resource/video'); ?>">
                  <div class="clearfix res_cat_thumb">
                     <img src="<?php echo get_template_directory_uri(); ?>/images/kc/icon-video.png" alt="Icon Videos" height="65" width="65" />
                  </div>
                  <p>Videos</p>
               </a>
            </div>            
         </div>
      </div>         
      <!-- End : Featured Resources Categories -->      
   </div>
</div>
<!-- END : BANNER -->