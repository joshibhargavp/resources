<?php

remove_filter ('the_exceprt', 'wpautop');

if ( ! isset( $content_width ) )
	$content_width = 604;


/** * Twenty Thirteen only works in WordPress 3.6 or later.  */
if ( version_compare( $GLOBALS['wp_version'], '3.6-alpha', '<' ) )
	require get_template_directory() . '/inc/back-compat.php';	

// Injecting Stylesheets and Scripts Dynamically
function my_theme_setup() {
    register_nav_menu('primary', 'Navigation Menu');
}
add_action('after_setup_theme', 'my_theme_setup');

function hitechbpotheme_files() {
	if ( is_front_page() ):
		wp_enqueue_style( 'home', get_template_directory_uri() . '/home.css',false);
		wp_enqueue_style('hitechbpotheme_main_styles', get_stylesheet_uri());
	else :
		wp_enqueue_style('hitechbpotheme_main_styles', get_stylesheet_uri());
	endif;
}
add_action('wp_enqueue_scripts', 'hitechbpotheme_files');

function twentythirteen_setup() {
   load_theme_textdomain( 'twentythirteen', get_template_directory() . '/languages' );
   add_theme_support( 'html5', array(
      'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
   ) );
   add_theme_support( 'post-formats', array(
      'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
   ) );

   // This theme uses wp_nav_menu() in one location.
   // register_nav_menu( 'primary', __( 'Navigation Menu', 'twentythirteen' ) );
   // register_nav_menu('primary','Navigation Menu'); // Registering / Adding Menu
   //	register_nav_menu( 'primarynofollow', __( 'Navigation No Follow', 'twentythirteen' ) );
   //	register_nav_menu( 'architecture', __( 'Architecture Services', 'twentythirteen' ) );
   //	register_nav_menu( 'structure', __( 'Structural Services', 'twentythirteen' ) );
   //	register_nav_menu( 'bim', __( 'BIM Services', 'twentythirteen' ) );
   //	register_nav_menu( 'bimsupport', __( 'BIM Support Services', 'twentythirteen' ) );
   //	register_nav_menu( 'engineering', __( 'Engineering Services', 'twentythirteen' ) );
   //	register_nav_menu( 'otherservices', __( 'MEP Services', 'twentythirteen' ) );
   //	register_nav_menu( 'cfd', __( 'CFD Services', 'twentythirteen' ) );
   //	register_nav_menu( 'fea', __( 'FEA Services', 'twentythirteen' ) );
   //	register_nav_menu( 'company', __( 'Company Pages', 'twentythirteen' ) );
   //	register_nav_menu( 'bem', __( 'Energy Modeling Services', 'twentythirteen' ) );
   //	register_nav_menu( 'industriesmech', __( 'Industries', 'twentythirteen' ) );	
   //	register_nav_menu( 'millwork', __( 'Millwork', 'twentythirteen' ) );		
   //	register_nav_menu( 'designautomation', __( 'Design Automation', 'twentythirteen' ) );	

   add_theme_support('post-thumbnails');
   set_post_thumbnail_size( 604, 270, true );
   add_image_size( 'home-thumb', 585, 9999); // Hard Crop Mode
   add_image_size( 'newpost', 391, 150, true ); 
   add_image_size( 'sidethumb', 104, 72, true ); 
   add_image_size( 'homealtimgbig', 841, 410, true ); 
   add_image_size( 'homealtimgsmall', 414, 182, true ); 
   add_image_size( 'singplepost', 606, 302, true ); 	

   // This theme uses its own gallery styles.
   add_filter( 'use_default_gallery_style', '__return_false' );
}

add_action( 'after_setup_theme', 'twentythirteen_setup' );

// Custom Function for adding Total Reading time of Post
function reading_time() {
    $content = get_post_field( 'post_content', get_the_ID() );
    $word_count = str_word_count( strip_tags( $content ) );
    $readingtime = ceil($word_count / 250);
    if ($readingtime == 1) {
      $timer = " min read";
    } else {
      $timer = " min read";
    }
    $totalreadingtime = $readingtime . $timer;
    return $totalreadingtime;
}


function twentythirteen_scripts_styles() {
	/*
	 * Adds JavaScript to pages with the comment form to support
	 * sites with threaded comments (when in use).
	 */
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	// Adds Masonry to handle vertical alignment of footer widgets.
	if ( is_active_sidebar( 'sidebar-1' ) )
		wp_enqueue_script( 'jquery-masonry' );

	// Loads JavaScript file with functionality specific to Twenty Thirteen.
	// Add Genericons font, used in the main stylesheet.
	// Loads the Internet Explorer specific stylesheet.
}

add_action( 'wp_enqueue_scripts', 'twentythirteen_scripts_styles' );

//Perfmatters Buffer Excluded Extensions

add_filter('perfmatters_buffer_excluded_extensions', function($extensions) {
	if(($key = array_search('.php', $extensions)) !== false) {
		unset($extensions[$key]);
	}
	return $extensions;
});


add_filter( 'aioseo_schema_disable', 'aioseo_disable_schema' );
function aioseo_disable_schema( $disabled ) {
   if ( is_singular() ) {
      return true;
   }
   return $disabled;
}

/**
 * Filter the page title.
 *
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Twenty Thirteen 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep   Optional separator.
 * @return string The filtered title.
 */
function twentythirteen_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name', 'display' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'twentythirteen' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'twentythirteen_wp_title', 10, 2 );


function redirect_attachment_page() {
    global $post;
  
    if (is_attachment()) {
        if ($post && $post->post_parent) {
            wp_redirect(get_permalink($post->post_parent), 301);
            exit;
        } else {
            wp_redirect(home_url(), 301);
            exit;
        }
    }
}
add_action('template_redirect', 'redirect_attachment_page');


/**
 * Register two widget areas.
 *
 * @since Twenty Thirteen 1.0
 */
function twentythirteen_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Widget Area', 'twentythirteen' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the footer section of the site.', 'twentythirteen' ),
		'before_widget' => '<li class="aside widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Secondary Widget Area', 'twentythirteen' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'twentythirteen' ),
		'before_widget' => '<li class="aside widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'twentythirteen_widgets_init' );


function t5_force_404()
{
    if ( have_posts() )
    {
        return FALSE;
    }

    header( 'HTTP/1.0 404 Not Found' );
    locate_template( '404.php', TRUE, TRUE );
    $GLOBALS['wp_query']->is_404 = TRUE;
    return TRUE;
}

remove_action( 'wp_head',             'wp_shortlink_wp_head',          10, 0 );
remove_action( 'template_redirect',   'wp_shortlink_header',           11, 0 );
remove_action( 'wp_head',             'wlwmanifest_link'                     );
add_filter( 'wpseo_canonical', '__return_false' );
remove_action( 'wp_head',      'rest_output_link_wp_head'              );
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
remove_action( 'wp_head',      'wp_oembed_add_discovery_links'         );
remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link' ); // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version

add_filter('wp_sitemaps_enabled', '__return_false');

// Main Inspiration Code

//https://martinlea.com/how-to-catch-the-referer-page-with-contact-form-7/
//https://contactform7.com/special-mail-tags/

//function getRefererPage( $form_tag )
//{
//   if (isset($_SERVER['HTTP_REFERER']) && $form_tag['name'] == 'referer-page' ) {
//      $form_tag['values'][] = htmlspecialchars($_SERVER['HTTP_REFERER']);
//   }
//   return $form_tag;
//}
//if ( !is_admin() ) {
//   add_filter( 'wpcf7_form_tag', 'getRefererPage' );
//}

// This Worked Fine Version - 1
//function getRefererPage( $form_tag )
//{
//   if ( isset( $_SERVER['HTTP_REFERER'] ) && $form_tag['name'] == 'referer-page' ) {
//      $referer_url = htmlspecialchars( $_SERVER['HTTP_REFERER'] );
//      $home_url = home_url();
//      if ( strpos( $referer_url, $home_url ) === 0 ) {
//         $path = parse_url( $referer_url, PHP_URL_PATH );
//         $path = trim( $path, '/' );
//         $path_parts = explode( '/', $path );
//         $post_slug = end( $path_parts );
//         $form_tag['values'][] = $post_slug;
//      }
//   }
//   return $form_tag;
//}
//
//if ( !is_admin() ) {
//   add_filter( 'wpcf7_form_tag', 'getRefererPage' );
//}


//function getRefererPage( $form_tag )
//{
//   if ( isset( $_SERVER['HTTP_REFERER'] ) && $form_tag['name'] == 'referer-page' ) {
//      $referer_url = htmlspecialchars( $_SERVER['HTTP_REFERER'] );
//      $home_url = home_url();
//      if ( strpos( $referer_url, $home_url ) === 0 ) {
//         $path = str_replace( 'https://www.hitechbpo.com/pdf/', '', $referer_url );
//         $path = parse_url( $path, PHP_URL_PATH );
//         $path = trim( $path, '/' );
//         $path_parts = explode( '/', $path );
//         $post_slug = end( $path_parts );
//         $form_tag['values'][] = $post_slug;
//      }
//   }
//   return $form_tag;
//}
//
//if ( !is_admin() ) {
//   add_filter( 'wpcf7_form_tag', 'getRefererPage' );
//}


// Code that also remove page extension like .php
function getRefererPage( $form_tag )
{
   if ( isset( $_SERVER['HTTP_REFERER'] ) && $form_tag['name'] == 'referer-page' ) {
      $referer_url = htmlspecialchars( $_SERVER['HTTP_REFERER'] );
      $home_url = home_url();
      if ( strpos( $referer_url, $home_url ) === 0 ) {
         $path = str_replace( 'https://www.hitechbpo.com/pdf/', '', $referer_url );
         $path = parse_url( $path, PHP_URL_PATH );
         $path = trim( $path, '/' );
         $path = preg_replace( '/\.php$/', '', $path ); // remove .php extension
         $path_parts = explode( '/', $path );
         $path = preg_replace( '/\/$/', '', $path ); // remove trailing slash
         $path = str_replace( '/', '', $path ); // remove any remaining slashes         
         $path = 'pdfile-' . $path;
         $post_slug = end( $path_parts );
         $form_tag['values'][] = $post_slug;
      }
   }
   return $form_tag;
}

if ( !is_admin() ) {
   add_filter( 'wpcf7_form_tag', 'getRefererPage' );
}


//function custom_cf7_redirect() {
//>
//    <script type="text/javascript">
//    document.addEventListener( 'wpcf7mailsent', function( event ) {
//        if ( '8277' == event.detail.contactFormId ) { // Replace 123 with the ID of your form
//            location = 'https://www.hitechbpo.com/thankyou-download.php'; // Replace with the URL of your thank you page
//        }
//        else { // Replace 123 with the ID of your form
//        }       
//    }, false );
//    </script>
//<?php
//}
//add_action( 'wp_footer', 'custom_cf7_redirect' );


include('resources/cpt-resources.php');  // Registration of Resource Section

function load_custom_single_templates($template) {
   $post_type = get_post_type();
   $template_files = array(
      'resources' => 'single-resources.php',       
      'white-paper' => 'single-whitepaper.php',
      'video' => 'single-video.php',
   );

   if (is_singular($post_type)) {
      foreach ($template_files as $type => $file) {
         if (has_term($type, 'type')) {
            $template_path = get_stylesheet_directory() . '/resources/templates-parts/' . $file;
            if (file_exists($template_path)) {
               return $template_path;
            }
         }
      }

      // If no specific template found, load the default template for 'resources'.
      $default_template_path = get_stylesheet_directory() . '/resources/templates-parts/single-resources.php';

      if (file_exists($default_template_path)) {
         return $default_template_path;
      }
   }

   return $template;
}
add_filter('single_template', 'load_custom_single_templates');




function get_previous_page() {
    if (isset($_GET['prev_page'])) {
        $previous_page = esc_url($_GET['prev_page']);
        return $previous_page;
    }
    return false;
}




add_action('wp_ajax_filter_posts', 'filter_posts_callback');
add_action('wp_ajax_nopriv_filter_posts', 'filter_posts_callback');


function filter_posts_callback() {
   // Retrieve the selected taxonomy terms from the AJAX request
   $type = $_GET['type'];
   $sector = $_GET['sector'];
   $industry = $_GET['industry'];

   // Create an array to store the query arguments
   $args = array(
      'post_type' => 'resources',
      'tax_query' => array(
         'relation' => 'AND',
      ),
   );

   // Add the selected taxonomy terms to the query arguments dynamically
   if (!empty($type)) {
      $args['tax_query'][] = array(
         'taxonomy' => 'type',
         'field' => 'slug',
         'terms' => $type,
      );
   }

   if (!empty($sector)) {
      $args['tax_query'][] = array(
         'taxonomy' => 'sector',
         'field' => 'slug',
         'terms' => $sector,
      );
   }

   if (!empty($industry)) {
      $args['tax_query'][] = array(
         'taxonomy' => 'industry',
         'field' => 'slug',
         'terms' => $industry,
      );
   }

   $query = new WP_Query($args);// Perform the query using WP_Query

   ob_start();// Prepare the response content

   // The Loop
   if ($query->have_posts()) {
      while ($query->have_posts()) {
         $query->the_post();
         // Generate the HTML content for each post
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
                     $type_terms = get_the_terms($post->ID, 'type');
                     $sector_terms = get_the_terms($post->ID, 'sector');
                     $industry_terms = get_the_terms($post->ID, 'industry');
                     if (!empty($type_terms)) {
                        $type = $type_terms[0]->name;
                        echo '<span class="resource_tag">' . $type . '</span>';
                     }
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
      echo '<div class="alert alert-warning border mb-4 width100">No posts found.</div>';
   }

   wp_reset_postdata();// Restore original post data

   $response = ob_get_clean();// Get the buffered content and clean the buffer

   header('X-WP-Total: ' . $query->found_posts);// Set the response header with the total number of posts

   echo $response;// Send the response

   wp_die();// Always exit after handling the AJAX request
}



/* ========== Filter for Type Taxonomy ========== */
add_action('wp_ajax_type_filter_posts', 'filter_type_posts_callback');
add_action('wp_ajax_nopriv_type_filter_posts', 'filter_type_posts_callback');


function filter_type_posts_callback() {
   $sector = $_GET['sector'];
   $industry = $_GET['industry'];

   // Retrieve the term ID and term slug from the AJAX request
   $term_id = $_GET['term_id'];
   $term_slug = $_GET['term_slug'];

   // Create an array to store the query arguments
   $args = array(
      'post_type' => 'resources',
      'tax_query' => array(
         'relation' => 'AND',
      ),
   );

   // Add the selected taxonomy terms to the query arguments dynamically
   if (!empty($term_id)) {
      $args['tax_query'][] = array(
         'taxonomy' => 'type',
         'field' => 'term_id',
         'terms' => $term_id,
      );
   } elseif (!empty($term_slug)) {
      $args['tax_query'][] = array(
         'taxonomy' => 'type',
         'field' => 'slug',
         'terms' => $term_slug,
      );
   }

   if (!empty($sector)) {
      $args['tax_query'][] = array(
         'taxonomy' => 'sector',
         'field' => 'slug',
         'terms' => $sector,
      );
   }

   if (!empty($industry)) {
      $args['tax_query'][] = array(
         'taxonomy' => 'industry',
         'field' => 'slug',
         'terms' => $industry,
      );
   }

   $query = new WP_Query($args);// Perform the query using WP_Query

   ob_start();// Prepare the response content

   // The Loop
   if ($query->have_posts()) {
      while ($query->have_posts()) {
         $query->the_post();
         // Generate the HTML content for each post
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
                     $type_terms = get_the_terms($post->ID, 'type');
                     $sector_terms = get_the_terms($post->ID, 'sector');
                     $industry_terms = get_the_terms($post->ID, 'industry');
                     if (!empty($type_terms)) {
                        $type = $type_terms[0]->name;
                        echo '<span class="resource_tag">' . $type . '</span>';
                     }
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
      echo '<div class="alert alert-warning border mb-4 width100">No posts found.</div>';
   }

   wp_reset_postdata();// Restore original post data

   $response = ob_get_clean();// Get the buffered content and clean the buffer

   header('X-WP-Total: ' . $query->found_posts);// Set the response header with the total number of posts

   echo $response;// Send the response

   wp_die();// Always exit after handling the AJAX request
}
?>