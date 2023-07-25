<div class="clearfix wrapper">
   <div class="clearfix res_cat_card_header pb-2">
      <div class="fl width50">
      <?php

      // Get the type terms for the cpt_resource post type
      $types = get_terms( array(
          'taxonomy' => 'type',
          'hide_empty' => true,
      ) );
         
      $term_id = get_queried_object_id(); // current term ID
      $taxonomy = get_queried_object()->taxonomy; // current taxonomy
      $per_page = get_query_var('posts_per_page', 10); // Set the number of posts per page
      $paged = max(1, get_query_var('paged')); // current page number or set it to 1

      $args = array(
         'post_type' => 'resources', // post type
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
         
         // Check if type filter is set and not empty
         if (isset($_GET['type-filter']) && !empty($_GET['type-filter'])) {
            $type_filter = sanitize_text_field($_GET['type-filter']);
            if ($type_filter !== '') {
               $args['tax_query'][] = array(
                  'taxonomy' => 'type',
                  'field' => 'slug',
                  'terms' => $type_filter,
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
            // // Check if type is selected
            // if (isset($_GET['type-filter']) && !empty($_GET['type-filter'])) {
            // $type_filter = sanitize_text_field($_GET['type-filter']);
            // echo ' for <i><strong> ' . $type_filter . '</strong></i>';
            // }
            //
            // echo '</p>'; 


            echo '<p class="bigtext">Displaying Results ' . $first . ' - ' . $last . ' of ' . $total . ' for <i><strong>' . $term->name . '</strong></i>';
            // Check if type is selected
            if (isset($_GET['type-filter']) && !empty($_GET['type-filter'])) {
               $type_filter = sanitize_text_field($_GET['type-filter']);
               $type_term = get_term_by('slug', $type_filter, 'type'); // Get the term object
               if ($type_term) {
                  echo ' for <i><strong> ' . $type_term->name . '</strong></i>'; // Display the term name
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
         <form action="<?php echo esc_url( get_term_link( $term ) ); ?>" method="get" id="resource-filter-form">
             <label for="type-filter"><?php esc_html_e( 'Filter by:', 'hitechdigital' ); ?></label>
             <select name="type-filter" id="type-filter">
               <!--option value=""><php esc_html_e( 'All', 'hitechdigital' ); ?></option-->
               <option value="" <?php selected(!isset($_GET['$type-filter']) || $_GET['$type-filter'] === ''); ?>><?php esc_html_e('All', 'hitechdigital'); ?></option>
                 <?php foreach ( $types as $type ) : ?>
                     <option value="<?php echo esc_attr( $type->slug ); ?>" <?php selected( isset( $_GET['type-filter'] ) && $_GET['type-filter'] === $type->slug ); ?>><?php echo esc_html( $type->name ); ?></option>
                 <?php endforeach; ?>
             </select>
             <button type="submit"><?php esc_html_e( 'Filter', 'hitechdigital' ); ?></button>
         </form>         
      </div>
   </div>
</div>


<!--div class="clearfix width100 p-4">
   <div class="wrapper clearfix">
      <php
      $term = $wp_query->queried_object;

      // Get the type terms for the cpt_resource post type
      $types = get_terms( array(
          'taxonomy' => 'type',
          'hide_empty' => true,
      ) );

      // Output the filter form
      ?>      
   </div>
</div-->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
jQuery(document).ready(function($) {
   // Handle form submission using AJAX
   $('#type-filter').on('change', function() {
      
      // Get the selected option text
      var selectedText = $(this).find('option:selected').text();

      // Get the selected option value
      var selectedValue = $(this).val();

      // Update the URL parameter
      var currentURL = new URL(window.location.href);
      currentURL.searchParams.set('type-filter', selectedValue);

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

         // Update the message with the selected option text, type, and term name
         $('.bigtext').html(message);

         // Show or hide the pagination based on the total number of posts
         if (totalPosts < 9) {
            $('.resource-pagination').css('display', 'none');
         } else {
            $('.resource-pagination').css('display', 'block');
         }           
      });

      // Prevent the default form submission
      return false;
   });
   
});


   
//jQuery(function($) {
//   // When the rescat dropdown is changed, submit the form
////   $('#rescat-filter').on('change', function(e) {
////      $('#resource-filter-form').submit();
////      e.preventDefault();
////   });
//});
//jQuery(document).ready(function($) {
//   // Handle form submission using AJAX
//   $('#type-filter').on('change', function() {
//      var selectedValue = $(this).val(); // Get the selected option value
//      var currentURL = new URL(window.location.href);
//      currentURL.searchParams.set('type-filter', selectedValue); // Update the URL parameter
//
//      // Load the content from the updated URL into the wrapper element
//      $('.res_cat_card_wrap').load(currentURL.toString() + ' .res_cat_card_wrap');
//      
//      // Prevent the default form submission
//      return false;
//   });
//});
   
//jQuery(document).ready(function($) {
//   // Handle form submission using AJAX
//   $('#type-filter').on('change', function() {
//      var selectedValue = $(this).val(); // Get the selected option value
//      var currentURL = new URL(window.location.href);
//      currentURL.searchParams.set('type-filter', selectedValue); // Update the URL parameter
//
//      // Load the content from the updated URL into the wrapper element
//      $('.res_cat_card_wrap').load(currentURL.toString() + ' .res_cat_card_wrap', function() {
//         // Get the total number of posts after the content is loaded
//         var totalPosts = $('.res_cat_card_wrap .res_cat_card_box').length;
//
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
//   $('#type-filter').on('change', function() {
//      var selectedText = $(this).find('option:selected').text(); // Get the selected option text
//      var selectedValue = $(this).val(); // Get the selected option value
//      var currentURL = new URL(window.location.href);
//      currentURL.searchParams.set('type-filter', selectedValue); // Update the URL parameter
//
//      // Load the content from the updated URL into the wrapper element
//      $('.res_cat_card_wrap').load(currentURL.toString() + ' .res_cat_card_wrap', function() {
//         // Update the message with the selected option text
//         var message = 'Displaying Results ' + $first + ' - ' + $last + ' of ' + $total + ' for ' + selectedText;
//         $('.bigtext').text(message);
//      });
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

<?php
// AJAX callback to update the type posts
//add_action('wp_ajax_update_type_posts', 'update_type_posts_callback');
//add_action('wp_ajax_nopriv_update_type_posts', 'update_type_posts_callback');
//function update_type_posts_callback()
//{
//   $termID = intval($_POST['termID']);
//   $taxonomy = sanitize_text_field($_POST['taxonomy']);
//   $typeFilter = sanitize_text_field($_POST['typeFilter']);
//
//   // Create a new query to fetch the updated posts
//   $args = array(
//      'post_type' => 'cpt_resource',
//      'posts_per_page' => get_query_var('posts_per_page', 10),
//      'paged' => max(1, get_query_var('paged')),
//      'tax_query' => array(
//         array(
//            'taxonomy' => $taxonomy,
//            'field' => 'term_id',
//            'terms' => $termID,
//         ),
//      ),
//   );
//
//   // Check if type filter is set and not empty
//   if ($typeFilter !== '') {
//      $args['tax_query'][] = array(
//         'taxonomy' => 'type',
//         'field' => 'slug',
//         'terms' => $typeFilter,
//      );
//   }
//
//   $query = new WP_Query($args); // Create a new query object and run the query
//
//   ob_start();
//
//   if ($query->have_posts()) {
//      while ($query->have_posts()) {
//         $query->the_post();
//         // Output the post content here
//      }
//
//      // Output the pagination
//      if ($query->max_num_pages > 1) {
//         echo '<div class="pagination">';
//         echo paginate_links(array(
//            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
//            'format' => '?paged=%#%',
//            'current' => max(1, get_query_var('paged')),
//            'total' => $query->max_num_pages,
//            'prev_text' => '&laquo; Previous',
//            'next_text' => 'Next &raquo;',
//         ));
//         echo '</div>';
//      }
//   } else {
//      echo 'No posts found.';
//   }
//
//   wp_reset_postdata(); // Reset the post data
//
//   $output = ob_get_clean();
//
//   echo $output;
//
//   wp_die();
//}
?>

<!--
// Original Working Code without State Change of Dropdown list
<form action="<php echo esc_url( get_term_link( $term ) ); ?>" method="get">
    <label for="type-filter"><php esc_html_e( 'Filter by type:', 'text-domain' ); ?></label>
    <select name="type-filter" id="type-filter">
        <option value=""><php esc_html_e( 'All', 'text-domain' ); ?></option>
        <php foreach ( $types as $type ) : ?>
            <option value="<php echo esc_attr( $type->slug ); ?>" <php selected( isset( $_GET['type-filter'] ) && $_GET['type-filter'] === $type->slug ); ?>><php echo esc_html( $type->name ); ?></option>
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
    <label for="type-filter"><php _e( 'Filter by type:', 'text-domain' ); ?></label>
    <select name="type-filter" id="type-filter">
        <option value=""><php _e( 'All types', 'text-domain' ); ?></option>
        <php
        $terms = get_terms( array(
            'taxonomy' => 'type',
            'hide_empty' => false,
        ) );
        foreach ( $terms as $term ) {
            $option = '<option value="' . esc_attr( $term->slug ) . '"';
            if ( isset( $_GET['type-filter'] ) && $_GET['type-filter'] == $term->slug ) {
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

// Check for the type filter parameter and add it to the query arguments if present
if ( isset( $_GET['type-filter'] ) && ! empty( $_GET['type-filter'] ) ) {
    $args['tax_query'][] = array(
        'taxonomy' => 'type',
        'field' => 'slug',
        'terms' => sanitize_text_field( $_GET['type-filter'] ),
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


      
