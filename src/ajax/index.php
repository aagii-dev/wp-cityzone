<?php
// function enqueue_review_scripts()
// {
// 	// jQuery-г WordPress-ээс ачаалах
// 	wp_enqueue_script('jquery');

// 	wp_enqueue_script('review-ajax', get_template_directory_uri() . '/assets/js/ajax/review.js', array('jquery'), null, true);

// 	wp_localize_script('review-ajax', 'reviewAjax', array(
// 		'ajax_url' => admin_url('admin-ajax.php'), // AJAX URL
// 		'nonce' => wp_create_nonce('submit_review_nonce') // Хамгаалалтын nonce
// 	));
// }
// add_action('wp_enqueue_scripts', 'enqueue_review_scripts');


// function handle_submit_review()
// {
// 	// Nonce шалгах
// 	if (!isset($_POST['nonce']) || !wp_verify_nonce($_POST['nonce'], 'submit_review_nonce')) {
// 		wp_send_json_error('Nonce verification failed.');
// 	}

// 	// Талбаруудыг шалгах
// 	if (empty($_POST['review_title']) || empty($_POST['review_content']) || empty($_POST['review_rating']) || empty($_POST['review_page'])) {
// 		wp_send_json_error('All fields are required.');
// 	}

// 	// Review post үүсгэх
// 	$review_data = array(
// 		'post_title' => sanitize_text_field($_POST['review_title']),
// 		'post_type' => 'review',
// 		'post_status' => 'pending', // Админ батлахыг шаардлагатай бол pending гэж тавьж болно
// 	);

// 	$post_id = wp_insert_post($review_data);

// 	if (is_wp_error($post_id)) {
// 		wp_send_json_error('Failed to insert review.');
// 	}

// 	$rating = intval($_POST['review_rating']);
// 	// Post meta-г хадгалах
// 	add_post_meta($post_id, 'review_rating', $rating);
// 	add_post_meta($post_id, 'review_comment', $_POST['review_content']);

	
//     $category  = intval($_POST['review_page']); // taxonomy ID эсвэл slug
	
// 	// Taxonomy оноох
//     wp_set_post_terms($post_id, array($category), 'review_category');

// 	// Амжилттай болсон хариуг буцаах
// 	wp_send_json_success('Review submitted successfully.');
// }
// add_action('wp_ajax_submit_review', 'handle_submit_review');
// add_action('wp_ajax_nopriv_submit_review', 'handle_submit_review');
// ?>



// <?php
// // 1) Хайлтын AJAX endpoint (нийтэд нээлттэй)
// add_action('wp_ajax_hc_global_search', 'hc_global_search');
// add_action('wp_ajax_nopriv_hc_global_search', 'hc_global_search');

// function hc_global_search(){
//     // Security
//     $nonce = isset($_GET['nonce']) ? sanitize_text_field($_GET['nonce']) : '';
//     if ( ! wp_verify_nonce($nonce, 'hc_search_nonce') ) {
//         wp_send_json_error(['message' => 'Invalid nonce'], 403);
//     }

//     $q = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
//     if ( $q === '' ) {
//         wp_send_json_success(['items' => []]);
//     }

//     // CPT: help_center, нийтэд ил (publish)
//     $args = [
//         'post_type'      => 'help_center',
//         'post_status'    => 'publish',
//         'posts_per_page' => 10,
//         's'              => $q,
//         'orderby'        => 'relevance', // WP core relevance
//     ];

//     $query = new WP_Query($args);

//     $items = [];
//     if ( $query->have_posts() ) {
//         while ($query->have_posts()) {
//             $query->the_post();

//             // (сонголтоор) ангиллын нэр авах — эхний term
//             $term_name = '';
//             $terms = get_the_terms(get_the_ID(), 'help_center_category');
//             if ( ! is_wp_error($terms) && ! empty($terms) ) {
//                 $term_name = $terms[0]->name;
//             }

//             $items[] = [
//                 'title' => html_entity_decode( wp_strip_all_tags( get_the_title() ), ENT_QUOTES, 'UTF-8' ),
//                 'link'  => get_permalink(),
//                 'term'  => $term_name,
//             ];
//         }
//         wp_reset_postdata();
//     }

//     wp_send_json_success(['items' => $items]);
// }

// // 2) Inline script-д ашиглах nonce-ийг өгөх helper (хэрэв shortcode-д ашиглах бол)
// function hc_search_get_nonce(){
//     return wp_create_nonce('hc_search_nonce');
// }

?>