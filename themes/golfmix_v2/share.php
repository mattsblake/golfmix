	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
	<script type="text/javascript" src="<?php bloginfo('template_url'); ?>/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

	<script type="text/javascript">
		jQuery(document).ready(function() {
		
       		jQuery("#share").fancybox( {
       			'titleShow'			: false,
       			'overlayColor'		: '#efefef',
				'overlayOpacity'	: 0.7
       		}).trigger('click');
   		
		});
	</script>

	<style>
	.share {
		color: #999;
		font-size: 14px;
		clear:both;
		margin:20px 20px 0;
	}
	.share h3 {
		font-size: 20px;
		color: #F26F03;
		line-height: normal;
		text-transform: capitalize;
	}
	.share h4 {
		font-size: 18px;
		color: #555;
		font-family: Helvetica, Arial, serif;
		margin-top: 3px;
		line-height: 1.3em;
	}
	.share input {
		width:200px;
	}
	</style>


	<div style="display: none;">
			<a id="share" href="#sharebox" title="Share"></a>
			<div id="sharebox" style="width:600px;height:auto;overflow:auto;">
			
				<div class="share">
					<h3>You just scored $10 off at Vans Golf Shops!</h3> 
					<h4>Click on the image to print:</h4>
					<a href="http://golfmix.com/vans-promo.pdf"><img src="<?php bloginfo('template_url'); ?>/images/vans.jpg" /></a>
				</div>
							
				<div class="share">
					<h3>Nice Review!</h3>
					<h4>Share with friends to be entered to win free rounds of golf, apparel and much more:</h4>
				</div>
			
				<div class="share">
					<?php $share_url = get_permalink()."?referred_by=".$_REQUEST['referred_by']."#review-".$_REQUEST['r']; ?>
				
					<a href="https://twitter.com/share" class="twitter-share-button" data-count="none" data-via="golfmix" data-url="<?php echo $share_url;?>" data-text="Check out my review of <?php the_title(); ?>:">Tweet</a><script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>
								
					<script src="http://platform.linkedin.com/in.js" type="text/javascript"></script>
					<script type="IN/Share" data-url="<?php echo $share_url;?>"></script>
				
					<div class="fb-like" data-send="true" data-href="<?php echo $share_url;?>" data-width="100" data-show-faces="false" data-font="arial" style="width: 112px; height:24px;"></div>	
					<div class="clear"></div>	
				</div>
					
				<div class="share">Your Share Link: &nbsp;<input type="text" value="<?php echo $share_url;?>"></div>

			</div>
	</div>