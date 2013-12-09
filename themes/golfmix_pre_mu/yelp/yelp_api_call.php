<?php

// Enter the path that the oauth library is in relation to the php file
include_once(dirname(__FILE__) .'/OAuth.php');


// Yelp Search URL
$c_name_trim = strtolower($c_name);
$c_name_trim = str_replace(" ", "+", $c_name_trim);
$c_name_trim = str_replace("of+", "", $c_name_trim);
$c_city_trim = strtolower($c_city);
$c_city_trim = str_replace(" ","+",$c_city_trim);
$unsigned_url = "http://api.yelp.com/v2/search?term=".$c_name_trim."&location=".$c_city_trim."&limit=1&category_filter=golf";
if(isset($_REQUEST['show'])) { echo $unsigned_url; }

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
if(isset($_REQUEST['show'])) { print_r($response); }

$business = $response->businesses[0]->id;

if(isset($_REQUEST['show'])) { echo '<br />'.$business; }

$response = null;


//********************* New Yelp Request

// For Business API Call
$unsigned_url2 = "http://api.yelp.com/v2/business/".$business;
if(isset($_REQUEST['show'])) { echo '<br />'.$unsigned_url2; }

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
$yelp_name = $response->name;
$yelp_image = $response->image_url;
$yelp_url = $response->url;
$yelp_reviews = $response->reviews;

//if(isset($_REQUEST['show'])) { echo '<br />'; print_r($yelp_reviews); }

if(isset($_REQUEST['show'])) { 
	echo '<br />'.$yelp_name; 
	echo '<br />'.$yelp_rcount; 
}

if($yelp_rcount > '0') {

?>
<div class="inner-page-all-reviews-container">
					<div class="inner-reviwes-left">
						<h3>All Reviews <span>(<?php echo $yelp_rcount; ?>)</span></h3>
					</div>
					<div class="inner-reviews-right">
						<ul>
							<li>Sort by</li>
							<li>[<a class="active" href="#">Date</a>]</li>
							<li>[<a href="#">Rating</a>]</li>
						</ul>
					</div>
					<br class="clear" />
				</div>
				
				<div class="reviews-container">
					<div class="reviews-top">
					</div>					
					<div class="reviews-center">
<?php 
foreach($yelp_reviews as $review) {
?>		
					<div class="reviews-container">
							<div class="recent-reviews-heading inner-recent-reviews-heading">
								<h4><?php echo $review->user->name; ?> <span>Wrote :</span></h4>
								<div class="right-area"> <a href="#"><img src="http://98.131.223.164/xhtml1/golf-mix/18-jan-11/images/like-img.gif" alt="" /></a> </div>
							</div>
							<div class="reviews-center">
								<div class="recent-post-box inner-recent-post-box">
									<div class="post-box-col-1 inner-span-1"> <span class="inner-span-1"> <a href="#"><img src="<?php echo $review->user->image_url; ?>" alt="" border="0" /></a> <a href="#"><em>Average Score : 81<em>Plays : Weekly</em></em></a> </span> </div>
									<div class="post-box-col-2 inner-span-2"> <span class="clock-box inner-clock"><a href="#">3 hours ago</a></span>
								<p> "<?php echo $review->excerpt; ?>"</p>

										<!--<a href="#" class="comments">8 comments</a>--> 
									</div>
									<div class="post-box-col-3 inner-third-star-colum">
										<ul>
											<li>Value :<span><img src="http://98.131.223.164/xhtml1/golf-mix/18-jan-11/images/small-ratting-stars.gif" alt="" border="0" /></span></li>
											<li>Course conditions  :<span><img src="http://98.131.223.164/xhtml1/golf-mix/18-jan-11/images/small-ratting-stars.gif" alt="" border="0" /></span></li>
											<li>Design :<span><img src="http://98.131.223.164/xhtml1/golf-mix/18-jan-11/images/small-ratting-stars.gif" alt="" border="0" /></span></li>
											<li>Amenities :<span><img src="http://98.131.223.164/xhtml1/golf-mix/18-jan-11/images/small-ratting-stars.gif" alt="" border="0" /></span></li>
											<li>Pace of play :<span><img src="http://98.131.223.164/xhtml1/golf-mix/18-jan-11/images/small-ratting-stars.gif" alt="" border="0" /></span></li>
										</ul>
									</div>
									<div class="over-all-rating-box inner-third-star-box">
										<ul>
											<li>Overall Rating :</li>
											<li><a href="#"><img src="<?php echo $review->rating_image_url; ?>" alt="" border="" /></a></li>
										</ul>
									</div>
									<br class="clear" />
									<div class="hands-area">
										<div class="left-hands"> <span>Would you recommend this course to a friend? <a href="#">Yes</a></span> </div>
										<div class="right-hands">
											<ul>
												<!--<li><a class="main-nav-1" href="#">&nbsp;</a></li>
											<li><a class="main-nav-2" href="#">&nbsp;</a></li>-->
												<li><a class="main-nav-3"href="#">&nbsp;</a></li>
												<li><a class="main-nav-4"href="#">&nbsp;</a></li>
												<li><a class="main-nav-5"href="#">&nbsp;</a></li>
												<li><a class="main-nav-6"href="#">&nbsp;</a></li>
											</ul>
										</div>
										<br class="clear" />
									</div>
								</div>
							</div>
						</div>

<?php } 
}
?>