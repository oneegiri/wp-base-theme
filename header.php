<?php
$pageID = get_the_ID();
if (!is_404()) {
	global $post;
	$page_slug = $post->post_name;
}
$body_class = isset($page_slug) ? 'current-page-' . $page_slug : '';
$site_desc = get_bloginfo('description', 'display');
$site_name = get_bloginfo('name', 'display');
?>
<!doctype html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<?php wp_head(); ?>
</head>

<body <?php body_class($body_class); ?>>
	<?php wp_body_open(); ?>
	<h1 class="sr-only"><?php echo esc_html($site_name . ' | ' . $site_desc); ?></h1>
	<a class="skip-link sr-only" href="#main-content"><?php esc_html_e('Skip to content', TEXT_DOMAIN); ?></a>
	<header>
		<?php 
			get_template_part('template-parts/shared/navbar');
		?>
		<?php 
			if(is_post_type_archive('product')){
				//do_action('render_woocommerce_archive_header');
			}
		?>
	</header>
	<div class="container-fluid p-0">
		<main id="main-content">