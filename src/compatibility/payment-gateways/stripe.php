<?php

use Stripe\Stripe;
use Stripe\Checkout\Session;

class StripeController{

  public function __construct()
  {
  }

  public function stripe_checkout(float $price, int $order_number)
  {
    $values = $this->get_env_values('test', [
      '_KEY'
    ]);

    Stripe::setApiKey($values);

    header('Content-Type: application/json');

    $url = get_home_url();

    $checkout_session = Session::create([
				'payment_method_types' => ['card'],
				'line_items' => [[
					'price_data' => [
						'currency' => 'gbp',
						'unit_amount' => $price,
						'product_data' => [
							'name' => $order_number,
						],
					],
					'quantity' => 1,
				]],
				'mode' => 'payment',
				'success_url' => $url . '/my-account?payment=success',
				'cancel_url' => $url . '/my-account?payment=cancel',
			]);

			wp_send_json_success(array(
				'id' => $checkout_session->id
			));
  }
}
