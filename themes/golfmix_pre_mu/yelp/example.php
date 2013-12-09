<?php

// Enter the path that the oauth library is in relation to the php file
include_once(dirname(__FILE__) .'/OAuth.php');

// Yelp Search URL
$unsigned_url = "http://api.yelp.com/v2/search?term=tpc+of+scottsdale&location=scottsdale&limit=1&sort=0";


// Set your keys here
$consumer_key = "oYDhXN_x1FNLNrmaiMZZaA";
$consumer_secret = "NNEQPE4uwc4vF9AhX1SGk_tjSnI";
$token = "s4es9bMtaCYAWCMD-ciWuytQ0d4VZRqu";
$token_secret = "dnnYSBt0D6hCB5bjkd98eIX6Jts";

// Token object built using the OAuth library
$token = new OAuthToken($token, $token_secret);

// Consumer object built using the OAuth library
$consumer = new OAuthConsumer($consumer_key, $consumer_secret);

// Yelp uses HMAC SHA1 encoding
$signature_method = new OAuthSignatureMethod_HMAC_SHA1();

// Build OAuth Request using the OAuth PHP library. Uses the consumer and token object created above.
$oauthrequest = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $unsigned_url);

// Sign the request
$oauthrequest->sign_request($signature_method, $consumer, $token);

// Get the signed URL
$signed_url = $oauthrequest->to_url();

// Send Yelp API Call
$ch = curl_init($signed_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch); // Yelp response
curl_close($ch);

// Handle Yelp response data
$response = json_decode($data);

// Print it for debugging
print_r($response);

$business = $response->businesses[0]->id;

echo $business;

$response = null;


//********************* New Yelp Request

// For Business API Call
$unsigned_url2 = "http://api.yelp.com/v2/business/".$business;

$oauthrequest = OAuthRequest::from_consumer_and_token($consumer, $token, 'GET', $unsigned_url2);
$oauthrequest->sign_request($signature_method, $consumer, $token);
$signed_url = $oauthrequest->to_url();
$ch = curl_init($signed_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HEADER, 0);
$data = curl_exec($ch); // Yelp response
curl_close($ch);

// Handle Yelp response data
$response = json_decode($data);


$yelp_rcount = $response->review_count;
$yelp_image = $response->image_url;
$yelp_url = $response->url;
$yelp_reviews = $response->reviews;

//print_r($yelp_reviews);


if($yelp_image) { echo '<img src="'.$yelp_image.'" /><br />'; }

foreach($yelp_reviews as $review) {
	echo '<img src="'.$review->user->image_url.'" />';
	echo '<p><img src="'.$review->rating_image_url.'" />'.$review->excerpt.'</p>';
	echo '<p>From: '.$review->user->name.'</p>';
}


?>
