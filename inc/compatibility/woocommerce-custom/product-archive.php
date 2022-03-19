<?php
//Reposition WooCommerce breadcrumb 
remove_action(
  'woocommerce_before_main_content',
  'woocommerce_breadcrumb',
  20
);

function woocommerce_custom_breadcrumb()
{
  get_template_part('/template-parts/shared/woocommerce-archive-header');
}

add_action('render_woocommerce_archive_header', 'woocommerce_custom_breadcrumb');


/**
 * Before product
 */
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);

/**
 * After product
 */
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10);
remove_action('woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);

function custom_loop_product_title(){
  global $product;
  $html = '';
  $html .= '<h2 class="woocommerce-loop-product__title">' . get_the_title() . '</h2>';
  $html .= "<small class='woocommerce-loop-product__sku'>" . esc_html(_('E-nr: ', TEXT_DOMAIN)) . $product->get_sku() . '</small>';
  echo $html;
}
add_action('woocommerce_shop_loop_item_title', 'custom_loop_product_title', 10);