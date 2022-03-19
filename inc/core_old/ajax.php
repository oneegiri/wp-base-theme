<?php
//add_action('wp_ajax_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');
//add_action('wp_ajax_nopriv_woocommerce_ajax_add_to_cart', 'woocommerce_ajax_add_to_cart');

function woocommerce_ajax_add_to_cart()
{
  $product_id = $_POST['product_id'];
  $quantity = $_POST['product_qty'];

  WC()->cart->add_to_cart( intval($product_id), intval($quantity) );
}
