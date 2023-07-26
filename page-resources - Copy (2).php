<?php
   /*
      Template Name: Resources
      Template Post Type: page
      Template Description: Page Template for Resources Section
   */
	get_header('resources');
	remove_filter( 'the_content', 'wpautop' );

	if ( have_posts() ) while ( have_posts() ) : the_post();
		$bannerbgimage = get_post_meta( get_the_ID(), 'bannerbgimage', true );
		$pagebigline = get_post_meta( get_the_ID(), 'pagebigline', true );

   // Retrieve the terms for 'rescat' taxonomy
   $resindusty_terms = get_terms(array(
      'taxonomy' => 'industry',
      'hide_empty' => false,
   ));
   // Retrieve the terms for 'rescat' taxonomy
   $rescat_terms = get_terms(array(
      'taxonomy' => 'type',
      'hide_empty' => false,
   ));
   // Retrieve the terms for 'ressector' taxonomy
   $ressector_terms = get_terms(array(
      'taxonomy' => 'sector',
      'hide_empty' => false,
   ));

?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- ===== Banner ===== -->
<div class="clearfix resource-banner">
   <div class="clearfix wrapper">
      <h1><?php the_title(); ?></h1>
      <p class="pagebigline"><?php echo $pagebigline; ?></p>
   </div>
   
   <!-- ===== Single Featured Post ===== -->
   <div class="clearfix single-resources-fetured">
      <div class="clearfix wrapper">
      <?php
         if( !is_paged() ){
            $homesinglePosts = array(
               'post_type' => array('resources', 'post'),
               'posts_per_page' => 1,
               'tax_query' => array(
                  'relation' => 'OR',
                  array(
                     'taxonomy' => 'rtag', // For 'resources' post type
                     'field' => 'slug',
                     'terms' => 'featured'
                  ),
                  array(
                     'taxonomy' => 'post_tag', // For 'post' post type
                     'field' => 'slug',
                     'terms' => 'featured'
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
                  <a href="<?php echo get_permalink(); ?>" class="learnmoretext">Learn more &raquo;</span></a>
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






<!-- ===== Category Filter ===== -->
<div class="clearfix filter-wrap">
   <div class="clearfix hero-cat-container wrapper">
      <div class="fl">Filter by</div>
      <div class="fl">
         <select id="industry-dropdown" class="filter-dropdown">
            <option value="">Industries</option>
            <?php foreach ($resindusty_terms as $term) : ?>
               <option value="<?php echo $term->slug; ?>" <?php if (isset($_GET['industry']) && $_GET['industry'] === $term->slug) echo 'selected'; ?>><?php echo $term->name; ?></option>
            <?php endforeach; ?>
         </select>
      </div>
      <div class="fl">
         <select id="sector-dropdown" class="filter-dropdown">
            <option value="">Services</option>
            <?php foreach ($ressector_terms as $term) : ?>
               <option value="<?php echo $term->slug; ?>" <?php if (isset($_GET['sector']) && $_GET['sector'] === $term->slug) echo 'selected'; ?>><?php echo $term->name; ?></option>
            <?php endforeach; ?>
         </select>                     
      </div>
      <div class="fl">
         <select id="type-dropdown" class="filter-dropdown">
            <option value="">Types</option>
            <?php foreach ($rescat_terms as $term) : ?>
               <option value="<?php echo $term->slug; ?>" <?php if (isset($_GET['type']) && $_GET['type'] === $term->slug) echo 'selected'; ?>><?php echo $term->name; ?></option>
            <?php endforeach; ?>
         </select>
      </div>
   </div>
</div>
<!-- ===== //Category Filter ===== -->

<!-- ===== Three Featured Post ===== -->
<div class="clearfix resources-fetured">
   <div class="wrapper clearfix text-center">
      <h2 class="smallh2">Featured Resources</h2>
   </div>   
   <div class="clearfix wrapper">
      <?php
      if( !is_paged() ){
         $homepagePosts = array(
            'post_type' => 'resources',
            'posts_per_page' => 3,
            'tax_query' => array(
               array(
                  'taxonomy' => 'rtag',
                  'field' => 'slug',
                  'terms' => 'resourced-featured'
               )
            )
         );
         $query = new WP_Query($homepagePosts);
         if ($query->have_posts()) {
            while ($query->have_posts()) {
               $query->the_post();
               ?>
               <div class="width33 fl">
                  <div class="resources-fetured-post clearfix">
                     <div class="featured-post-thumb">
                        <?php if (has_post_thumbnail( $post->ID ) ): ?>
                        <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'singplepost' ); ?>
                           <a href="<?php echo get_permalink(); ?>">
                              <img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" width="594" height="296" />
                           </a>
                        <?php endif; ?>
                     </div>
                     <div class="featured-post-content">
                        <div class="clearfix tag-wrap">
                        <?php
                           // Display the post type and sector
                           $type_terms = get_the_terms($post->ID, 'type');
                           $sector_terms = get_the_terms($post->ID, 'sector');
                           //$industry_terms = get_the_terms($post->ID, 'industry');
                           if (!empty($type_terms)) {
                              $type = $type_terms[0]->name;
                              echo '<span class="resource_tag">' . $type . '</span>';
                           }
                           if (!empty($sector_terms)) {
                              $sector = $sector_terms[0]->name;
                              echo '<span class="resource_tag">' . $sector . '</span>';
                           }
                           //if (!empty($industry_terms)) {
                           //   $industry = $industry_terms[0]->name;
                           //   echo '<span class="resource_tag">' . $industry . '</span>';
                           //}
                           ?>
                        </div>
                        <h2><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <p><?php echo wp_trim_words(get_the_excerpt(), 18); ?></p>
                        <a href="<?php echo get_permalink(); ?>" class="learnmorebtn">&raquo; <span>Learn more</span></a>
                     </div>
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
<!-- ===== // Three Featured Post ===== -->

<!-- ===== Filter Result ===== -->
<div class="clearfix width100 position-relative">
   <div id="notification-bar" class="alert-success fadeInUp"></div>
   <div class="clearfix wrapper">
      <div class="clearfix cat-filter-container" id="filtered-posts">
      </div>
   </div>
</div>
<!-- ===== //Filter Result ===== -->

<div class="clearfix wrapper text-center position-relative mt-1 mb-4 pb-4">
   <div id="pagination-container" class="resource-pagination clearfix"></div>
</div>

<?php the_content(); ?>
   
<?php endwhile; ?>


<script>
// Initialize the notification bar state
var notificationBar = document.getElementById('notification-bar');
notificationBar.style.display = 'none';
   
// Add this code to set #filtered-posts to display none when the page loads
window.addEventListener('load', function() {
   document.getElementById('filtered-posts').style.display = 'none';
});

// Listen for changes in the dropdowns
document.getElementById('type-dropdown').addEventListener('change', filterPosts);
document.getElementById('sector-dropdown').addEventListener('change', filterPosts);
document.getElementById('industry-dropdown').addEventListener('change', filterPosts);

function filterPosts() {
   document.getElementById('filtered-posts').style.display = 'flex';
   
   // Get the selected values from the dropdowns
   var type = document.getElementById('type-dropdown').value;
   var sector = document.getElementById('sector-dropdown').value;
   var industry = document.getElementById('industry-dropdown').value;

   // Make an AJAX request to retrieve the filtered posts
   var xhr = new XMLHttpRequest();
   xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
         if (xhr.status === 200) {
            // Update the content of the 'filtered-posts' div with the retrieved posts
            document.getElementById('filtered-posts').innerHTML = xhr.responseText;
            // Update the notification bar with the selected filters and post count
            var postCount = xhr.getResponseHeader('X-WP-Total');
            if (postCount > 0) {
               updateNotificationBar(type, sector, industry, postCount);
               document.getElementsByClassName('resources-fetured')[0].style.display = 'none';
            } else {
               notificationBar.style.display = 'none';
               document.getElementsByClassName('resources-fetured')[0].style.display = 'none';
            }
         } else {
            console.log('Error: ' + xhr.status);
         }
      }
   };   

   xhr.open('GET', '<?php echo admin_url('admin-ajax.php'); ?>?action=filter_posts&type=' + type + '&sector=' + sector + '&industry=' + industry, true);
   xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
   xhr.send();
}


function updateNotificationBar(type, sector, industry, postCount) {
   var notificationBar = document.getElementById('notification-bar');
   if (type || sector || industry) {
      var notificationText = 'Displaying results of';
      if (industry) {
         var industryDropdown = document.getElementById('industry-dropdown');
         var selectedIndustryOption = industryDropdown.options[industryDropdown.selectedIndex];
         var industryName = selectedIndustryOption.textContent.trim().replace(/\([\d]+\)/, '');
         notificationText += ' <strong>' + industryName + '</strong>';
      }
      if (sector) {
         var sectorDropdown = document.getElementById('sector-dropdown');
         var selectedSectorOption = sectorDropdown.options[sectorDropdown.selectedIndex];
         var sectorName = selectedSectorOption.textContent.trim().replace(/\([\d]+\)/, '');
         notificationText += ' <strong>' + sectorName + '</strong>';
      }
      if (type) {
         var typeDropdown = document.getElementById('type-dropdown');
         var selectedTypeOption = typeDropdown.options[typeDropdown.selectedIndex];
         var typeName = selectedTypeOption.textContent.trim().replace(/\([\d]+\)/, '');
         notificationText += ' <strong>' + typeName + '</strong>';
      }
      notificationText += ' - ' + postCount + ' posts found';
      notificationBar.innerHTML = notificationText;
      notificationBar.style.display = 'block';
   } else {
      notificationBar.style.display = 'none';
   }
}
</script>



<?php get_footer('resources'); ?>