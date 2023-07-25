<div class="clearfix wrapper">
   <div class="clearfix res_cat_card_header pb-2">
      <div class="fl width50">
      <?php

      // Get the rescat terms for the cpt_resource post type
      $rescats = get_terms( array(
          'taxonomy' => 'rescat',
          'hide_empty' => true,
      ) );
         
      $term_id = get_queried_object_id(); // current term ID
      $taxonomy = get_queried_object()->taxonomy; // current taxonomy
      $per_page = get_query_var('posts_per_page', 10); // Set the number of posts per page
      $paged = max(1, get_query_var('paged')); // current page number or set it to 1

      $args = array(
         'post_type' => 'cpt_resource', // post type
         'posts_per_page' => $per_page, // posts per page
         'paged' => $paged, // current page number
         'tax_query' => array(
                           array(
                              'taxonomy' => $taxonomy,
                              'field' => 'term_id',
                              'terms' => $term_id,
                           ),
                        ),
                     );
         
         // Check if rescat filter is set and not empty
         if (isset($_GET['rescat-filter']) && !empty($_GET['rescat-filter'])) {
            $rescat_filter = sanitize_text_field($_GET['rescat-filter']);
            if ($rescat_filter !== '') {
               $args['tax_query'][] = array(
                  'taxonomy' => 'rescat',
                  'field' => 'slug',
                  'terms' => $rescat_filter,
               );
            }
         }
         
         $query = new WP_Query($args); // Create a new query object and run the query

         if ($query->have_posts()) {
            $total = $query->found_posts; // Get the total number of posts
            $first = ($per_page * ($paged - 1)) + 1; // Calculate the first post number on the current page
            $last = min($total, $per_page * $paged); // Calculate the last post number on the current page
            //echo '<p class="bigtext">Displaying Results ' . $first . ' - ' . $last . ' of ' . $total . ' for <i><strong>' . $term->name . '</strong></i></p>';
            
            // echo '<p class="bigtext">Displaying Results ' . $first . ' - ' . $last . ' of ' . $total . ' for <i><strong>' . $term->name . '</strong></i>';
            //
            // // Check if ressector is selected
            // if (isset($_GET['rescat-filter']) && !empty($_GET['rescat-filter'])) {
            // $rescat_filter = sanitize_text_field($_GET['rescat-filter']);
            // echo ' for <i><strong> ' . $rescat_filter . '</strong></i>';
            // }
            //
            // echo '</p>';


            echo '<p class="bigtext">Displaying Results ' . $first . ' - ' . $last . ' of ' . $total . ' for <i><strong>' . $term->name . '</strong></i>';

            // Check if ressector is selected
            if (isset($_GET['rescat-filter']) && !empty($_GET['rescat-filter'])) {
               $rescat_filter = sanitize_text_field($_GET['rescat-filter']);
               $rescat_term = get_term_by('slug', $rescat_filter, 'rescat'); // Get the term object
               if ($rescat_term) {
                  echo ' for <i><strong> ' . $rescat_term->name . '</strong></i>'; // Display the term name
               }
            }

            echo '</p>';            
            
            
            if (is_wp_error($paginate_links)) {
               echo 'Error: ' . $paginate_links->get_error_message();
            } else {
               echo $paginate_links;
            }

            wp_reset_postdata(); // Reset the post data
         } else {
            echo 'No posts found for ' . $taxonomy . '.';
      }
      ?>
      </div>
      
      
      <div class="fl width50 text-right">
         <form action="<?php echo esc_url(get_term_link($term)); ?>" method="get" id="resource-filter-form">
             <label for="rescat-filter"><?php esc_html_e( 'Filter by:', 'hitechdigital' ); ?></label>
             <select name="rescat-filter" id="rescat-filter">
                <option value="" <?php selected(!isset($_GET['rescat-filter']) || $_GET['rescat-filter'] === ''); ?>><?php esc_html_e('All', 'hitechdigital'); ?></option>
                 <?php foreach ( $rescats as $rescat ) : ?>
                     <option value="<?php echo esc_attr( $rescat->slug ); ?>" <?php selected( isset( $_GET['rescat-filter'] ) && $_GET['rescat-filter'] === $rescat->slug ); ?>><?php echo esc_html( $rescat->name ); ?></option>
                 <?php endforeach; ?>
             </select>
             <button type="submit"><?php esc_html_e( 'Filter', 'hitechdigital' ); ?></button>
         </form>         
      </div>
   </div>
</div>

<div class="clearfix width100 p-4">
   <div class="wrapper clearfix">
      <?php
      $term = $wp_query->queried_object;

      // Get the rescat terms for the cpt_resource post type
      $rescats = get_terms( array(
          'taxonomy' => 'rescat',
          'hide_empty' => true,
      ) );

      // Output the filter form
      ?>      
   </div>
</div>      

<script>
jQuery(document).ready(function($) {
   // Handle form submission using AJAX
   $('#rescat-filter').on('change', function() {
      
      // Get the selected option text
      var selectedText = $(this).find('option:selected').text();

      // Get the selected option value
      var selectedValue = $(this).val();

      // Update the URL parameter
      var currentURL = new URL(window.location.href);
      currentURL.searchParams.set('rescat-filter', selectedValue);

      // Load the content from the updated URL into the wrapper element
      $('.res_cat_card_wrap').load(currentURL.toString() + ' .res_cat_card_wrap', function() {
         
         // Retrieve the updated values from the PHP code
         var totalPosts = $('.res_cat_card_wrap .res_cat_card_box').length;
         var message;

         if (totalPosts === 1) {
            message = 'Displaying Result 1 of 1 for <i><strong><?php echo $term->name; ?></strong></i> from <i><strong>' + selectedText + '</strong></i>';
         } else {
            var first = Math.min(totalPosts, 1);
            var last = Math.min(totalPosts, 9);
            message = 'Displaying Results ' + first + ' - ' + last + ' of ' + totalPosts + ' for <i><strong><?php echo $term->name; ?></strong></i> from <i><strong>' + selectedText + '</strong></i>';
         }

         // Update the message with the selected option text, rescat, and term name
         $('.bigtext').html(message);

         // Show or hide the pagination based on the total number of posts
         if (totalPosts < 9) {
            $('.cs-pagination').css('display', 'none');
         } else {
            $('.cs-pagination').css('display', 'block');
         }           
      });

      // Prevent the default form submission
      return false;
   });
});   
/*jQuery(function($) {
   // When the rescat dropdown is changed, submit the form
//   $('#rescat-filter').on('change', function(e) {
//      $('#resource-filter-form').submit();
//      e.preventDefault();
//   });
});*/

   
//jQuery(document).ready(function($) {
//   // Handle form submission using AJAX
//   $('#rescat-filter').on('change', function() {
//      // Get the selected option text
//      var selectedText = $(this).find('option:selected').text();
//      
//      // Get the selected option value
//      var selectedValue = $(this).val();
//      
//      // Update the URL parameter
//      var currentURL = new URL(window.location.href);
//      currentURL.searchParams.set('rescat-filter', selectedValue);
//
//      // Load the content from the updated URL into the wrapper element
//      $('.res_cat_card_wrap').load(currentURL.toString() + ' .res_cat_card_wrap', function() {
//         
//         // Retrieve the updated values from the PHP code
//         var $first = <php echo $first; ?>;
//         var $last = <php echo $last; ?>;
//         var $total = <php echo $total; ?>;
//         var termName = '<php echo $term->name; ?>';
//
//         // Update the message with the selected option text, rescat, and term name
//         var message = 'Displaying Results ' + $first + ' - ' + $last + ' of ' + $total + ' for <i><strong>' + termName + '</strong></i> ' + ' from <i><strong>' + selectedText + '</strong></i>';
//         $('.bigtext').html(message);
//
//         // Load the content from the updated URL into the wrapper element
//         $('.res_cat_card_wrap').load(currentURL.toString() + ' .res_cat_card_wrap');
//         
//         // Get the total number of posts after the content is loaded
//         var totalPosts = $('.res_cat_card_wrap .res_cat_card_box').length;
//         // Show or hide the pagination based on the total number of posts
//         if (totalPosts < 9) {
//            $('.cs-pagination').css('display', 'none');
//         } else {
//            $('.cs-pagination').css('display', 'block');
//         }           
//      });
//
//      // Prevent the default form submission
//      return false;
//   });
//}); 
   
//jQuery(document).ready(function($) {
//   // Handle form submission using AJAX
//   $('#rescat-filter').on('change', function() {
//      var selectedValue = $(this).val(); // Get the selected option value
//      var currentURL = new URL(window.location.href);
//      currentURL.searchParams.set('rescat-filter', selectedValue); // Update the URL parameter
//
//      // Load the content from the updated URL into the wrapper element
//      $('.res_cat_card_wrap').load(currentURL.toString() + ' .res_cat_card_wrap');
//         // Get the total number of posts after the content is loaded
//         var totalPosts = $('.res_cat_card_wrap .res_cat_card_box').length;
//         // Show or hide the pagination based on the total number of posts
//         if (totalPosts < 9) {
//            $('.cs-pagination').css('display', 'none');
//         } else {
//            $('.cs-pagination').css('display', 'block');
//         }      
//      
//      // Prevent the default form submission
//      return false;
//   });
//});   
</script>

<style>
select{box-shadow:0 4px 10px rgba(0,0,0,.15); height:auto; padding:0.6rem 2.8rem 0.6rem 1.2rem; appearance:none!important; background:#f9f7fa url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 4 5'%3E%3Cpath fill='%23343a40' d='M2 0L0 2h4zm0 5L0 3h4z'/%3E%3C/svg%3E")  no-repeat right .75rem center; background-size:8px 10px; border-radius:4px; -webkit-appearance:none!important; -moz-appearance:none!important; vertical-align:middle; width:auto; background-color:#fff; min-width:250px; margin:0 10px; }
button[type=submit]{ background:#005ce6; border:1px solid #005ce6; color:#fff; padding:10px 45px; border-radius:5px; transition:background 0.4s ease; }
button[type=submit]:hover{ background:#262626; border:1px solid #262626; }         
</style>

<!--
// Original Working Code without State Change of Dropdown list
<form action="<php echo esc_url( get_term_link( $term ) ); ?>" method="get">
    <label for="rescat-filter"><php esc_html_e( 'Filter by rescat:', 'text-domain' ); ?></label>
    <select name="rescat-filter" id="rescat-filter">
        <option value=""><php esc_html_e( 'All', 'text-domain' ); ?></option>
        <php foreach ( $rescats as $rescat ) : ?>
            <option value="<php echo esc_attr( $rescat->slug ); ?>" <php selected( isset( $_GET['rescat-filter'] ) && $_GET['rescat-filter'] === $rescat->slug ); ?>><php echo esc_html( $rescat->name ); ?></option>
        <php endforeach; ?>
    </select>
    <button type="submit"><php esc_html_e( 'Filter', 'text-domain' ); ?></button>
</form>
-->
 <!--form method="get">
    <label for="rescat-filter"><php _e( 'Filter by rescat:', 'text-domain' ); ?></label>
    <select name="rescat-filter" id="rescat-filter">
        <option value=""><php _e( 'All rescats', 'text-domain' ); ?></option>
        <php
        $terms = get_terms( array(
            'taxonomy' => 'rescat',
            'hide_empty' => false,
        ) );
        foreach ( $terms as $term ) {
            $option = '<option value="' . esc_attr( $term->slug ) . '"';
            if ( isset( $_GET['rescat-filter'] ) && $_GET['rescat-filter'] == $term->slug ) {
                $option .= ' selected';
            }
            $option .= '>' . esc_html( $term->name ) . '</option>';
            echo $option;
        }
        ?>
    </select>
    <button type="submit"><php _e( 'Filter', 'text-domain' ); ?></button>
</form>

<form method="get">
    <label for="rescat-filter"><php _e( 'Filter by rescat:', 'text-domain' ); ?></label>
    <select name="rescat-filter" id="rescat-filter">
        <option value=""><php _e( 'All rescats', 'text-domain' ); ?></option>
        <php
        $terms = get_terms( array(
            'taxonomy' => 'rescat',
            'hide_empty' => false,
        ) );
        foreach ( $terms as $term ) {
            $option = '<option value="' . esc_attr( $term->slug ) . '"';
            if ( isset( $_GET['rescat-filter'] ) && $_GET['rescat-filter'] == $term->slug ) {
                $option .= ' selected';
            }
            $option .= '>' . esc_html( $term->name ) . '</option>';
            echo $option;
        }
        ?>
    </select>
    <button type="submit"><php _e( 'Filter', 'text-domain' ); ?></button>
</form>
<php
// Set up the query arguments
$args = array(
    'post_type' => 'cpt_resource',
    'tax_query' => array(),
);

// Check for the rescat filter parameter and add it to the query arguments if present
if ( isset( $_GET['rescat-filter'] ) && ! empty( $_GET['rescat-filter'] ) ) {
    $args['tax_query'][] = array(
        'taxonomy' => 'rescat',
        'field' => 'slug',
        'terms' => sanitize_text_field( $_GET['rescat-filter'] ),
    );
}

// Check for the rescat filter parameter and add it to the query arguments if present
if ( isset( $_GET['rescat-filter'] ) && ! empty( $_GET['rescat-filter'] ) ) {
    $args['tax_query'][] = array(
        'taxonomy' => 'rescat',
        'field' => 'slug',
        'terms' => sanitize_text_field( $_GET['rescat-filter'] ),
    );
}

// Set up the query
$query = new WP_Query( $args );

// Check if there are any posts
if ( $query->have_posts() ) {
    // Start the loop
    while ( $query->have_posts() ) {
        $query->the_post();
        // Display the post content
        the_title();
        the_content();
    }
    // Reset post data
    wp_reset_postdata();
} else {
    // If no posts are found, display a message
    echo 'No posts found.';
}
?-->


      
