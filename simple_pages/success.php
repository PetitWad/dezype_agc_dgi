<?php
require '../vendor/autoload.php';

\Stripe\Stripe::setApiKey('sk_test_51KHugMBPcrw5s6v3oAXZpQ2dfg7YiyTkNB06MBChlSyYWND0SLICs8D59LlJvLK2ADDgtplIhMfOnLD65UrxgSEf00JcxUt03z');

$session = \Stripe\Checkout\Session::retrieve(
    $_GET['session_id']
);

var_dump($session);