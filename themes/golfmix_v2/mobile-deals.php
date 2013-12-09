<?php
/**
 * Template Name: Mobile Deal of the Week
 *
**/
if(!isset($_REQUEST['app'])) {

global $post;
include('./wp-admin/admin-functions.php');	
	
?>
<head>	
	<meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />	
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style-mobile.css?v=1" type="text/css" media="screen" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<title>Deal of the Week - golfmix.com</title>
	
	<?php //wp_head(); ?>
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-21045136-1']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>
</head>
<body>
<?php } else { get_header(); } ?>

	<div class="recent-reviews">Deal of the Week</div> 
	
	<div class="reviews">
	
		<div class="deal">
		<?php 
		$count = 0;
		$args = array( 'numberposts' => 1, 'offset'=> 0, 'post_type' => 'deals' );
		$deals = get_posts( $args );
		foreach( $deals as $post ) :	setup_postdata($post);
			$deal_company = get_post_meta($post->ID, 'deal_company', true);
			$deal_logo = get_post_meta($post->ID, 'deal_logo', true);
			$deal_image = get_post_meta($post->ID, 'deal_image', true);
			$deal_link = get_post_meta($post->ID, 'deal_link', true);
			$deal_video = get_post_meta($post->ID, 'deal_video', true);
			$deal_promo_code = get_post_meta($post->ID, 'deal_promo_code', true);
			$deal_retail = get_post_meta($post->ID, 'deal_retail', true);
			$deal_price = get_post_meta($post->ID, 'deal_price', true);
			if($deal_retail !== '' && $deal_price !== '') { 
				$deal_discount = $deal_price/$deal_retail; 
				$deal_discount = number_format($deal_discount, 2, '.', '');
				$deal_discount = str_replace('0.','',$deal_discount); 
				$deal_discount.='%';
			}
		
		?>
			<?php if($deal_logo !== '') { ?><img src="<?php echo $deal_logo; ?>" class="deal-logo"/><?php } ?>
			<div class="deal-title"><?php the_title(); ?></div>
			<?php if($deal_discount !== '' && $turnoff == 'true') { ?><div class="deal-percent"><?php echo $deal_discount; ?> off!</div><?php } ?>
			<?php if($deal_video !== '') { ?><div class="deal-video"><iframe width="300" height="182" src="<?php echo $deal_video; ?>" frameborder="0" allowfullscreen></iframe></div>
			<?php } elseif($deal_image !== '') { ?><div class="deal-image"><img src="<?php echo $deal_image; ?>" /></div><?php } ?>
			
			<?php if($deal_promo_code !== '') { ?><div class="deal-promo"><em><strong><?php echo 'Promo code: '.$deal_promo_code;?></strong></em></div><?php } ?>
			<a class="deal-more" id="more">Learn More</a>
			
			<div id="deal-content">
				<?php the_content(); ?>
				<?php if($deal_promo_code !== '') { ?><em><strong><?php echo 'Promo code: '.$deal_promo_code;?></strong></em><?php } ?>
				<a href="<?php echo $deal_link; ?>" class="deal-more">Buy Now</a>
			</div>
		
		<?php endforeach; ?>
		</div>	
		
		<script>
		$(document).ready( function() {
			$("a#more").click( function() {
				$(this).hide();
				$("#deal-content").show();
			});		
		});
		</script>


	</div>

</body>