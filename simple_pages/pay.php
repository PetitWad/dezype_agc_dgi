<?php

require '../vendor/autoload.php';
// This is your test secret API key.
//\Stripe\Stripe::setApiVersion("2022-08-01");
\Stripe\Stripe::setApiKey('sk_test_51KHugMBPcrw5s6v3oAXZpQ2dfg7YiyTkNB06MBChlSyYWND0SLICs8D59LlJvLK2ADDgtplIhMfOnLD65UrxgSEf00JcxUt03z');

header('Content-Type: application/json');

$YOUR_DOMAIN = 'http://localhost:4000/';

$checkout_session = \Stripe\Checkout\Session::create([
//    'payment_method_types' => ['cards'],
    'line_items' => [[
        'price_data' => [
            'product_data' => [
                'name' => 'Name',
            ],
            'unit_amount' => $_GET['pay'] * 100,
            'currency' => 'HTG',
        ],
        'quantity' => 1,
        'description' => 'Name',
    ]],
    'mode' => 'payment',
    'success_url' => $YOUR_DOMAIN . 'simple_pages/success.php?session_id={CHECKOUT_SESSION_ID}',
    'cancel_url' => $YOUR_DOMAIN . 'simple_pages/?session_id={CHECKOUT_SESSION_ID}',
]);

header("HTTP/1.1 303 See Other");
header("Location: " . $checkout_session->url);

