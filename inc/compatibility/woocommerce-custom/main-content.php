<?php
/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

/**
 * Removes flash sale
 */
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);

if (!function_exists('add_before_wrapper')) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function add_before_wrapper()
	{
?>
		<div class="container">
		<?php
	}
}
add_action('woocommerce_before_main_content', 'add_before_wrapper');

if (!function_exists('add_after_wrapper')) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function add_after_wrapper()
	{
		?>
		</div>
	<?php
	}
}
add_action('woocommerce_after_main_content', 'add_after_wrapper');