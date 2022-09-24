<?php

require_once('/path/to/stripe-php/init.php'); // Ne pas oublier cette ligne +modifier lien vers la bonne librairie

\Stripe\Stripe::setApiKey("sk_test_51LlY2LHxPTQ0uXfNywLaGb6uEKwJ5gedb2PQI73yYlbQwLIWxiCPQYr2OyvLGiSV9KL6Aw5g4K0DEnUQYMMGCMw900M6XhUxNz");

  $token = $_POST['stripeToken'];
  $email = $_POST['stripeEmail'];
  $pay   = $_GET['pay'];

  $customer = \Stripe\Customer::create(array(
    'email' => $email,
    'source'  => $token
));

  $charge = \Stripe\Charge::create(array(
    'customer' => $customer,
      'amount'   => $pay,
      'currency' => 'USD',
      'description' => 'impot',
      'receipt_email' => $email  
  ));

  if($charge){
    header("Location: retenuSource?error=Prelevement effectuer avec success ✔ | 💲");
  }

  
?>