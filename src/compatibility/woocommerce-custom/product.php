<?php

/**
 * Rearrange woocommerce elements
 */
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20);
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);

remove_action('woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);

add_action('woocommerce_before_single_product_summary', 'woocommerce_template_single_meta', 5);
add_action('woocommerce_before_single_product_summary', 'woocommerce_template_single_title', 10);
add_action('woocommerce_before_single_product_summary', 'show_product_image', 15);
//add_action( 'woocommerce_before_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
//add_action('woocommerce_before_single_product_summary', 'woocommerce_template_single_add_to_cart', 30);



if (!function_exists('build_product_gallery')) {
	function build_product_gallery()
	{
		global $product;
		$attachment_ids = $product->get_gallery_image_ids();

		if (!empty($attachment_ids)) {
?>
			<div class="slider__wrap">
				<ul class="slider">
					<?php foreach ($attachment_ids as $attachment_id) : ?>
						<li class="slider__item">
							<?php echo wc_get_gallery_image_html($attachment_id); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
<?php
		}
	}
}
add_action('woocommerce_product_thumbnails', 'build_product_gallery');

if (!function_exists('show_product_image')) {
	function show_product_image()
	{
		global $product;

		$post_thumbnail_id = $product->get_image_id();
		$attachment_ids = $product->get_gallery_image_ids();


		if (!empty($attachment_ids)) {
			do_action('woocommerce_product_thumbnails');
		} else {
			if ($post_thumbnail_id) {
				$html = wc_get_gallery_image_html($post_thumbnail_id, true);
			} else {
				$html  = '<div class="woocommerce-product-gallery__image--placeholder">';
				$html .= sprintf('<img src="%s" alt="%s" class="wp-post-image" />', esc_url(wc_placeholder_img_src('woocommerce_single')), esc_html__('Awaiting product image', 'woocommerce'));
				$html .= '</div>';
			}
			echo apply_filters('woocommerce_single_product_image_thumbnail_html', $html, $post_thumbnail_id);
		}
	}
}

function remove_short_description() {
	remove_meta_box( 'postexcerpt', 'product', 'normal');
}
add_action('add_meta_boxes', 'remove_short_description', 999);