<?php
/*
 * Plugin Name: HitechDigital Resources
 * Plugin URI: https://www.hitechdigital.com/
 * Description: A powerful plugin easily create & manage Resoures Section CPT, effortlessly register and organize Resources Section. Take control of your content structure and enhance your site's functionality with this flexible and intuitive plugin.
 * Version: 1.2.9
 * Author: Bhargav Joshi
 * Text Domain: hitechdigital-resources
 * Author URI: https://www.hitechdigital.com/
 * Tags: custom post type, resources
 * @package WordPress 
 */

/*====================================================================================================================*/
/*===================================      Resources Section Custom Post Type       ==================================*/
/*====================================================================================================================*/


add_action( 'init', 'cpt_resources' );
function cpt_resources() {
   $labels = array(
      'name'                  => 'Resources',
      'singular_name'         => 'Resource',
      'menu_name'             => 'Resources',
      'name_admin_bar'        => 'Resources',
      'all_items'             => 'All', /* All items menu item */
      'add_new'               => 'Add New', /* New menu item */
      'add_new_item'          => 'Add New', /* New Display Title */
      'edit'                  => 'Edit', /* Edit Dialog */
      'edit_item'             => 'Edit', /* Edit Display Title */
      'new_item'              => 'New', /* New Display Title */
      'view_item'             => 'View', /* View Display Title */
      'search_items'          => 'Search', /* Search Custom Type Title */ 
      'not_found'             => 'Nothing found', /* No entries yet */ 
      'not_found_in_trash'    => 'Nothing found in Trash', /* Nothing in trash */
      'featured_image'        => 'Featured Image',
      'set_featured_image'    => 'Set Featured image',
      'parent_item_colon'     => 'Parent:',
      'remove_featured_image' => 'Remove cover image',
      'use_featured_image'    => 'Use as cover image',
      'archives'              => 'Archives',
      'attributes'            => 'Attributes',
      'insert_into_item'      => 'Insert into',
      'uploaded_to_this_item' => 'Uploaded to this',
      'filter_items_list'     => 'Filter list',
      'items_list_navigation' => 'White navigation',
      'items_list'            => 'White'      
      
   );

   $args = array(
      'label'                 => 'Resources',
      'labels'                => $labels,
      'description'           => 'Add new Resource here',
      'public'                => true,
      'show_ui'               => true,
      'show_in_rest'          => true,
      'has_archive'           => false,
      'show_in_menu'          => true,
      'exclude_from_search'   => false,
      'capability_type'       => 'post',
      'map_meta_cap'          => true,
      'hierarchical'          => true,
      'rewrite'               => false,
      'query_var'             => true,
      'menu_position'         => 4,
      'menu_icon'             => 'dashicons-clipboard',
      'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'revisions'),
      'taxonomies'            => array( 'type', 'sector', 'industry', 'rtag' ),
      'publicly_queryable'    => true,
      'can_export'            => true,
      'show_in_admin_bar'     => true,
      'show_in_nav_menus'     => true 
   );
   
   register_post_type( 'resources', $args );
}

/* Taxonomy : Type (Infographic, Research papaer, white paper, etc) */
add_action( 'init', 'cpt_resources_tax_type' );
function cpt_resources_tax_type() {
   $labels = array(
      'name'                  => 'Type',
      'label'                 => 'Type',
      'singular_name'         => 'Type',
      'search_items'          => 'Search Types',
      'all_items'             => 'All Types',
      'parent_item'           => 'Parent Type',
      'parent_item_colon'     => 'Parent Type:',
      'edit_item'             => 'Edit Type',
      'update_item'           => 'Update Type',
      'add_new_item'          => 'Add New Type',
      'new_item_name'         => 'New Type Name',
      'menu_name'             => 'Types',      
   );
   $args = array(
      'labels'                => $labels,
      'hierarchical'          => true,
      'label'                 => 'Type',
      'show_ui'               => true,
      'query_var'             => true,
      'rewrite'               => array( 'slug' => 'resource/type', 'with_front' => true ),
      'show_admin_column'     => false,      
      'public'                => true,
      'publicly_queryable'    => true,
   );
   register_taxonomy( 'type', array( 'resources' ), $args );
}


/* Taxonomy : Sector (Service Type like BIM, BPM, Engineering, etc.) */
add_action( 'init', 'cpt_resources_tax_sector' );

function cpt_resources_tax_sector() {
   $labels = array(
      'name'                  => 'Sector',
      'label'                 => 'Sector',
      'singular_name'         => 'Sector',
      'search_items'          => 'Search Sector',
      'all_items'             => 'All Sector',
      'parent_item'           => 'Parent Sector',
      'parent_item_colon'     => 'Parent Sector:',
      'edit_item'             => 'Edit Sector',
      'update_item'           => 'Update Sector',
      'add_new_item'          => 'Add New Sector',
      'new_item_name'         => 'New Sector Name',
      'menu_name'             => 'Categories',      
   );
   $args = array(
      'labels'                => $labels,
      'hierarchical'          => true,
      'label'                 => 'Sector',
      'show_ui'               => true,
      'query_var'             => true,
      'rewrite'               => array( 'slug' => 'resource/sector', 'with_front' => true ),
      'show_admin_column'     => false,
      'public'                => true,
      'publicly_queryable'    => true,
   );
   register_taxonomy( 'sector', array( 'resources' ), $args );
}

/* Taxonomy : Industy (Service Industry like Construction, Automotive etc.) */
add_action( 'init', 'cpt_resources_ind_sector' );

function cpt_resources_ind_sector() {
   $labels = array(
      'name'                  => 'Industry',
      'label'                 => 'Industry',
      'singular_name'         => 'Industry',
      'search_items'          => 'Search Industry',
      'all_items'             => 'All Industry',
      'parent_item'           => 'Parent Industry',
      'parent_item_colon'     => 'Parent Industry:',
      'edit_item'             => 'Edit Industry',
      'update_item'           => 'Update Industry',
      'add_new_item'          => 'Add New Industry',
      'new_item_name'         => 'New Industry Name',
      'menu_name'             => 'Industry',      
   );
   $args = array(
      'labels'                => $labels,
      'hierarchical'          => true,
      'label'                 => 'Industry',
      'show_ui'               => true,
      'query_var'             => true,
      'rewrite'               => array( 'slug' => 'resource/industry', 'with_front' => true ),
      'show_admin_column'     => false,
      'public'                => true,
      'publicly_queryable'    => true,
   );
   register_taxonomy( 'industry', array( 'resources' ), $args );
}


/* Taxonomy : Tag (Tag to handle or show post as featured post) */
add_action( 'init', 'cpt_resources_tax_rtag' );

function cpt_resources_tax_rtag() {
   $labels = array(
      'name'                  => 'Tag',
      'label'                 => 'Tag',
      'singular_name'         => 'Tag',
      'search_items'          => 'Search Tag',
      'all_items'             => 'All Tag',
      'parent_item'           => 'Parent Tag',
      'parent_item_colon'     => 'Parent Tag:',
      'edit_item'             => 'Edit Tag',
      'update_item'           => 'Update Tag',
      'add_new_item'          => 'Add New Tag',
      'new_item_name'         => 'New Tag Name',
      'menu_name'             => 'Tag',      
   );
   $args = array(
      'labels'                => $labels,
      'hierarchical'          => false,
      'label'                 => 'Tag',
      'show_ui'               => true,
      'query_var'             => true,
      'rewrite'               => array( 'slug' => 'resource/tag', 'with_front' => false ),
      'show_admin_column'     => false,
      'public'                => true,
      'publicly_queryable'    => true,
   );
   register_taxonomy( 'rtag', array( 'resources' ), $args );
}

// Flush rewrite rules to apply changes
flush_rewrite_rules();

/*
// Enqueue assets
function resources_cpt_assets() {
    wp_enqueue_style( 'hitechdigital-resources-style', plugins_url( 'assets/style-kc.css', __FILE__ ) );
    //wp_enqueue_script( 'hitechdigital-resources-script', plugins_url( 'assets/script.js', __FILE__ ), array( 'jquery' ), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'resources_cpt_assets' );
*/

/*
function resources_cpt_activate() {
   // Get the active theme directory path.
   $theme_path = get_stylesheet_directory();

   // Copy the template files to the active theme directory.
   $template_files = array(
      'single-whitepaper.php',
      'single-resources.php',
      'single-video.php',
   );

   foreach ( $template_files as $template_file ) {
      $template_path = plugin_dir_path( __FILE__ ) . 'templates-parts/' . $template_file;
      $destination = trailingslashit( $theme_path ) . $template_file;

      // Copy the template file to the active theme directory.
      if ( ! file_exists( $destination ) ) {
         copy( $template_path, $destination );
      }
   }
}
register_activation_hook( __FILE__, 'resources_cpt_activate' );
*/







function resources_cpt_taxonomy_template( $template ) {
    if ( is_tax( 'rtag' ) ) {
        $template_path = plugin_dir_path( __FILE__ ) . 'templates-parts/taxonomy-rtag.php';
        if ( file_exists( $template_path ) ) {
            return $template_path;
        }
    } elseif ( is_tax( 'sector' ) ) {
        $template_path = plugin_dir_path( __FILE__ ) . 'templates-parts/taxonomy-sector.php';
        if ( file_exists( $template_path ) ) {
            return $template_path;
        }
    } elseif ( is_tax( 'type' ) ) {
        $template_path = plugin_dir_path( __FILE__ ) . 'templates-parts/taxonomy-type.php';
        if ( file_exists( $template_path ) ) {
            return $template_path;
        }
    }

    return $template;
}
add_filter( 'template_include', 'resources_cpt_taxonomy_template' );


/*
// Add main menu to the WordPress admin menu
add_action('admin_menu', 'resources_cpt_main_menu');
function resources_cpt_main_menu() {
   add_menu_page(
      'HitechDigital Resources', // Menu page title
      'Resources', // Menu link text
      'manage_options', // Required capability to access the menu
      'hitechdigital-resources', // Menu slug
      'resources_cpt_main_page', // Callback function to display the menu page
      'dashicons-clipboard', // Menu icon
      4 // Menu position
   );

   add_submenu_page(
      'hitechdigital-resources', // Parent menu slug
      'Background Image', // Submenu page title
      'Background Image', // Submenu link text
      'manage_options', // Required capability to access the submenu
      'resources_cpt_background', // Submenu page slug
      'resources_cpt_background_page' // Callback function to display the submenu page
   );   
}
*/


// Security: Prevent direct access to plugin files
if ( ! defined( 'ABSPATH' ) ) {
    die;
}
?>