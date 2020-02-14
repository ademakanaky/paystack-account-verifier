<?php
// only a post with paystack signature header gets our attention
if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) 
	|| !array_key_exists('HTTP_X_PAYSTACK_SIGNATURE', $_SERVER) ) 
    exit();

// Retrieve the request's body
$input = @file_get_contents("php://input");
define('PAYSTACK_SECRET_KEY','sk_test_70da1cd7cdbfadd3ca9efdd9c2866e1261bac113');//change this to your live secret key

// validate event do all at once to avoid timing attack
if($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $input, PAYSTACK_SECRET_KEY))
  exit();

http_response_code(200);

// parse event (which is json string) as object
// Do something - that will not take long - with $event
$event = json_decode($input);

exit();