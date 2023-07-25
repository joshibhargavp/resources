<?php
   get_header('resources');
   remove_filter( 'the_content', 'wpautop' );
   global $wp_query;
   if ( have_posts() ) while ( have_posts() ) : the_post();
      $theCat = wp_get_object_terms($post->ID, 'type');
      $theSector = wp_get_object_terms($post->ID, 'sector');
      $theTag = wp_get_object_terms($post->ID, 'resourcetag');
      $thumbimage = get_post_meta( get_the_ID(), 'thumbimage', true );
      $pageline = get_post_meta( get_the_ID(), 'pageline', true );
      $downloadlink = get_post_meta( get_the_ID(), 'downloadlink', true );
?>


<!-- Banner -->
<div class="clearfix resource_post_banner">
   <div class="clearfix wrapper">
      <div class="width33 fl">
         <div class="clearfix resource_thumb">
            <div class="resource-thumb-figure">
               <?php echo the_post_thumbnail('full');?>
            </div>
         </div>
      </div>      
      <div class="width66 fl">
         <div class="clearfix mb-1">
            <span class="resource-type-tag"><?php echo $theCat[0]->name ?></span>
            <span class="resource-type-tag"><?php echo $theSector[0]->name ?></span>
         </div>         
         <h1><?php echo get_the_title($post->ID) ?></h1>
         <p><?php echo $pageline; ?></p>
         <a href="<?php echo $downloadlink; ?>">Download Now&nbsp;&raquo;</a>
      </div>
   </div>
   <!--div class="resource_post_bottom">
      <svg viewBox="0 0 250 50" preserveAspectRatio="xMinYMin meet"><path d="M0,50 L0,4 C95,-23 285,115 250,2 L250,50 L0,50 Z" style="stroke: none; fill: #fff;"></path></svg>
   </div-->
   <div class="resource_post_right-color">
      <svg width="863px" height="962px" viewBox="0 0 863 962" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><defs><linearGradient x1="2.45199586%" y1="102.378378%" x2="102.450722%" y2="2.37837838%" id="linearGradient1"><stop class="gradient_color-stop1" offset="0%"></stop><stop class="gradient_color-stop2" offset="100%"></stop></linearGradient></defs><g id="backgroundBlob" stroke="none" stroke-width="1" fill-rule="evenodd"><g id="blobOverlay" transform="translate(-1.000000, 0.000000)"><path class="blob__linearGradient1" d="M70,258.19 C283.67,154.82 317.24,0 537.08,0 C756.92,0 864,298.26 864,544.54 C864,790.82 743.9,962 462.68,962 C181.46,962 -143.61,361.57 70,258.19 Z" id="blob"></path></g></g></svg>     
   </div>
</div>
<!-- /Banner -->

<div class="clearfix breadcrumb">
   <div class="wrapper clearfix">
      <div id="breadcrumb">
         <?php if(function_exists('bcn_display')) { bcn_display(); }?>
      </div>
   </div>
</div>



<!-- Content Information -->
<div class="clearfix resource_content">
   <div class="wrapper clearfix">
      <div class="width66 fl resource_content_info">
         <?php
            echo the_content();
            endwhile;
         ?>
         
         <!-- Display previous and next links -->
         <div class="clearfix previous-next-wrap">
            <?php
               $current_post = get_post(); // Get the current post object
               $infographic_posts = new WP_Query(array(
                  'post_type' => 'resources',
                  'posts_per_page' => -1,
                  'tax_query' => array(
                     array(
                        'taxonomy' => 'type',
                        'field' => 'slug',
                        'terms' => $theCat[0]->slug,
                     ),
                  ),
               ));
               $infographic_post_ids = wp_list_pluck($infographic_posts->posts, 'ID'); // Get an array of infographic post IDs
               $current_index = array_search($current_post->ID, $infographic_post_ids); // Get the index of the current infographic post
               $previous_post = null;
               $next_post = null;

               if ($current_index !== false) {
                  $previous_post_id = $infographic_post_ids[$current_index - 1] ?? null; // Get the ID of the previous infographic post
                  $next_post_id = $infographic_post_ids[$current_index + 1] ?? null; // Get the ID of the next infographic post
                  if ($previous_post_id) {
                     $previous_post = get_post($previous_post_id);
                  }      
                  if ($next_post_id) {
                     $next_post = get_post($next_post_id);
                  }
               }
            ?>            
            <?php if ($previous_post) : ?>
               <div class="fl width50">
                  <a href="<?php echo get_permalink($previous_post); ?>" class="previous-resource">&larr; Previous <?php echo $theCat[0]->name ?></a>
               </div>
            <?php endif; ?>
            <?php if ($next_post) : ?>
               <div class="fl width50 text-right">
                  <a href="<?php echo get_permalink($next_post); ?>" class="next-resource">Next <?php echo $theCat[0]->name ?> &rarr;</a>
               </div>
            <?php endif; ?>
         </div>
         <!-- Display previous and next links -->
      </div>
      <div class="width33 fl type_content_form">
         
         <p class="type_content_form_head">Get Resource now!</p>
         <p>Please click to view and download free content</p>
         
         <script charset="utf-8" type="text/javascript" src="//js.hsforms.net/forms/embed/v2.js"></script>
         <script>
           hbspt.forms.create({
             region: "na1",
             portalId: "9033818",
             formId: "aac9855b-d71f-4aca-ad3c-6371f3413307"
           });
         </script>
        
      </div>
   </div>
</div>
<!-- /Content Information -->





<!-- Related Infographics -->
<div class="clearfix related-resources">
   <div class="clearfix wrapper">
      <div class="clearfix related-resource-header">
         <h2>Related <?php echo $theCat[0]->name ?></h2>
      </div>
      <div class="clearfix related-resource-wrapper">
      <?php
   //      query_posts(
   //         array(
   //            'post_type'=>'cpt_resource',
   //            'posts_per_page' => 3,
   //            'rescat' => 'infographic'
   //         )
   //      );
         query_posts (
            array(
               'post_type'=>'resources',
               'posts_per_page'  => 3,
               'type' => $theCat[0]->name,
               'sector' => $theSector[0]->name,
               'orderby' => 'rand'
            )
         );
         ?>   
         <?php while (have_posts()) : the_post(); ?>

            <div class="one-third fl">
               <div class="clearfix related-resource-card">
                  <div class="related-resource-thumb clearfix">               
                     <?php if (has_post_thumbnail( $post->ID ) ): ?>
                        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'csimg' ); ?>
                        <a href="<?php echo get_permalink(); ?>" title="<?php the_title(); ?>" class="d-block">
                           <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" width="390" height="195" />
                        </a>
                     <?php endif; ?>
                  </div>
                  <div class="related-resource-info clearfix">
                     <span class="resource_tag"><?php echo $theCat[0]->name ?></span>
                     <span class="resource_tag"><?php echo $theSector[0]->name ?></span>
                     <h3><a href="<?php echo get_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h3>
                     <p class="resource_excerpt"><?php echo wp_trim_words(get_the_excerpt(),10); ?></p>
                     <a href="<?php echo get_permalink(); ?>" class="bluelink">Learn more&nbsp;&rarr;</a>
                  </div>
               </div>
            </div>
         <?php endwhile; ?>
      </div>
   </div>
</div>
<!-- /Related Infographics -->





<?php get_footer('kb'); ?>


<!--
<div style="position:fixed;width:100%;height:5px;left:0;right:0;bottom:0;top:auto;display:block;z-index:99999;"><progress id="scrollProgress" value="0" max="100"></progress></div>   
<script>
window.addEventListener('scroll', function() {
// Get the scroll position of the page
var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
// Get the total height of the page
var totalHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
// Calculate the scroll progress as a percentage
var scrollProgress = (scrollTop / totalHeight) * 100;
// Update the value of the progress element
var progressElement = document.getElementById('scrollProgress');
progressElement.value = scrollProgress;
});
</script>
-->