<?php 
global $market_distance;

global $detect;
$detect = new Mobile_Detect();
if ($detect->isMobile() && !$detect->isIpad()) { 

	include('mobile-index.php');

} else { ?>

<div id="content">

	<div id="featured-top">
		<div id="featured-bestof">
			<?php //include('best-of.php'); ?>
			<h3>videomix <span>powered by golfmix</span></h3>
			
			<?php $feedURL = 'http://gdata.youtube.com/feeds/api/playlists/PL28DH8HKgcj6O_cZSEuvVD4xuNyapDQWY?alt=json-in-script&callback=showMyVideos2&max-results=4';
			?>
			 
			 <style>
			.titlec {
				font-size: 11px;
				height: 26px;
				color: #333;
				padding: 4px;
				width: 98%;
				font-weight: bold;
				clear: both;
				padding-top: 14px;
				line-height: 14px;
			}
			ul.videos {
			  margin: 0;
			  padding: 0;
			  list-style-type:none;
			  clear:both;
			}
			ul.videos li {
				position: relative;
				float: left;
				width: 150px;
				list-style-type: none;
				height: 160px;
				overflow: hidden;
				margin-bottom: 20px;
				padding-left: 0;
				margin-left: 0;
				margin-right: 7px;
				border: 0;
				padding-bottom: 0;
			}
			ul.videos li:last-child {
				margin-right:0;
			}
			ul.videos li:hover {
				cursor:pointer;
			}
			ul.videos li:hover .titlec {
				color: #666;
				text-decoration: underline;
			}
			ul.videos li img {
				float: left;
				margin: 0;
				border: 0;
				box-shadow: 0.6px 2px 5px #111;
				-moz-box-shadow:0.6px 2px 5px #111;
				-webkit-box-shadow: 0.6px 2px 5px #111;
				padding: 0;
				border: 0 !important;
			}

			
			</style>
			<script type="text/javascript" src="http://swfobject.googlecode.com/svn/trunk/swfobject/swfobject.js"></script>
			<script type="text/javascript">
			function loadVideo(playerUrl, autoplay) {
			  swfobject.embedSWF(
			      playerUrl + '&rel=1&border=0&fs=1&hd=1&autoplay=' + 
			      (autoplay?1:0), 'player', '630', '405', '9.0.0', false, 
			      false, {allowfullscreen: 'true'});
			}
			
			function showMyVideos2(data) {
			  var feed = data.feed;
			  var entries = feed.entry || [];
			  var html = ['<ul class="videos">'];
			  for (var i = 0; i < entries.length; i++) {
			    var entry = entries[i];
			    var title = entry.title.$t.substr(0, 55);
			    var thumbnailUrl = entries[i].media$group.media$thumbnail[0].url;
			    var playerUrl = entries[i].media$group.media$content[0].url;
			    html.push('<li onclick="loadVideo(\'', playerUrl, '\', true)">',
			              '<img src="', 
			              thumbnailUrl, '" width="150" height="97"/>', '<div class="titlec">', title, '&#8230;</div></li>');
			  }
			  html.push('</ul><br style="clear: left;"/>');
			  document.getElementById('videos2').innerHTML = html.join('');
			  if (entries.length > 0) {
			    loadVideo(entries[0].media$group.media$content[0].url, false);
			  }
			}
			</script>
			
			<div id="playerContainer" style="width:100%; float: left;margin-bottom:10px;">
			    <object id="player"></object>
			</div>
			<div style="clear:both;margin-bottom:10px;width:100%;"></div>
			<div id="videos2" style="display:none;"></div>
			<script 
			    type="text/javascript" 
			    src="<?php echo $feedURL; ?>"
			    id="youtube"
			    >
			</script>
		</div>
		
		<div id="featured-right">
			<?php include('promos.php'); ?>
			<div id="featured-events">
				<div class="box-holder box-home">
					<div class="daily-box-top"><h3>Upcoming Local Events<a href="<?php bloginfo('url'); ?>/events-calendar">Calendar</a></h3></div>
					<div class="daily-box-bottom-2">
						<?php echo do_shortcode('[eventlist limit=5 noresults="No Events Available"]'); ?>
					</div>
				</div>
			</div>		
		</div>

	</div>
	<div id="featured-mid">
		<div class="box-holder box-home">
			<div class="daily-box-top"><h3>Latest Video & Blogs<a href="<?php bloginfo('url'); ?>/blog">More</a></h3></div>
			<div class="daily-box-bottom-2">
				<?php include('recent-blogs.php'); ?>
			</div>
		</div>
		<div id="mid-box">
			<div class="box-holder box-home" id="review-of-the-day">
				<?php include('review-of-day.php'); ?>
			</div>

			<div class="box-holder box-home" id="email-subscribe">
				<?php include('subscribe.php'); ?>
			</div>
		</div><!--End Midbox-->
				
		<div class="box-home" id="featured-deal">
			<?php include('deal-of-week.php'); ?>
			<br class="clear" />
		</div>	
	</div>
	
	<div id="featured-courses">
        <?php query_posts('cat=6&tag=featured&posts_per_page=5&orderby=rand');
        	if ( have_posts() ) while ( have_posts() ) : the_post();
				$image_img_tag = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),  'large');
				$featured_title = str_replace('(Formerly Raven Golf Club At Verrado)','',get_the_title());?>
				<div class="featured-course">
					<a href="<?php the_permalink(); ?>"><img src="<?php echo $image_img_tag[0]; ?>" class="course-photo"></a>
					<a href="<?php the_permalink(); ?>" class="course-name"><?php echo $featured_title; ?></a>
					<span><?php echo num_to_stars(get_average_rating($post->ID)); ?></span>
				</div>			
        <?php endwhile; ?>
	</div>
	
	<div id="featured-bottom">
		<div id="featured-reviews">
				<div class="box-holder box-home">
					<div class="daily-box-top"><h3>Recent Reviews</h3></div>
					<div class="daily-box-bottom-2">
						<?php include('recent-reviews.php'); ?>
					</div>
				</div>
		</div>
		<div id="featured-ads">
			<script type='text/javascript'>
			GA_googleFillSlot("Sidebar_300x250");
			</script>
			<div class="clear" style="height:15px;width:100%;"></div>
			<script type='text/javascript'>
			GA_googleFillSlot("Homepage_300x250");
			</script>
		</div>
	
	</div>

	<div class="clear"></div>
</div><!--/content--> 

<?php } ?>