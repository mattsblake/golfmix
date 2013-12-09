<?php
$promo_title 	= 'Have an iOS device?';
$promo_subtitle = 'Want to use golfmix on the go? golfmix just launched a free app just for you!';
$promo_link 	= 'http://itunes.apple.com/us/app/golfmix/id497402587?ls=1&mt=8';
$promo_call_to_action = 'Get it for FREE today!';
$promo_css_image = 'app-promo';
//$promo_title 	= 'Trilogy golfmixer';
//$promo_subtitle = 'An 18-hole Tournament Benefiting the American Cancer Society';
//$promo_link 	= 'http://golfmix.com/events';
//$promo_call_to_action = 'Sign up today!';
//$promo_css_image = 'golfmixer-promo';
?>
			<div id="featured-promo">
				<a class="<?php echo $promo_css_image; ?>" href="<?php echo $promo_link; ?>"></a>
				<div class="text-promo">
					<h4><?php echo $promo_title; ?></h4>
					<h5><?php echo $promo_subtitle; ?></h5>
					<a href="<?php echo $promo_link; ?>"><?php echo $promo_call_to_action; ?></a>
				</div>
			</div>