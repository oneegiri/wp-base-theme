<?php
function add_pingback_header()
{
	if (is_singular() && pings_open()) {
		printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
	}
}
add_action('wp_head', 'add_pingback_header');

function get_attribute_terms()
{
	$attribute = $_POST['attribute_name'];
	$terms = get_terms(array(
		'taxonomy' => $attribute,
		'hide_empty' => false,
	));
	wp_send_json_success($terms);
}
add_action('wp_ajax_get_attribute_terms', 'get_attribute_terms');

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Theme settings',
		'menu_title'	=> 'Theme Settings',
		'menu_slug' 	=> 'theme-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));
}