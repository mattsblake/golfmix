<?php
/**
 * Template Name: Video
 *
 */

get_header(); ?>

		<div id="content">
    	  <div class="content-data">
			
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
			<h1 class="best-of-header" style="width:auto;float:left;"><?php the_title(); ?></h1>
			<div class="tab-main" style="width: auto; float: right;">
				<ul>
					<li><a href="http://gdata.youtube.com/feeds/users/mygolfmix/uploads?alt=json-in-script&callback=showMyVideos2&max-results=32" class="<?php if($_REQUEST['playlist']=='' || $_REQUEST['playlist']=='all') { echo 'active'; } ?>"><span>All Videos</span></a></li>
					<li><a href="http://gdata.youtube.com/feeds/api/playlists/PLkx_YwdxOhppBTsHn2ucMBp2mdyG9pS6c?alt=json-in-script&callback=showMyVideos2&max-results=32" class="<?php if($_REQUEST['playlist']=='wmpo') { echo 'active'; } ?>"><span>WMPO</span></a></li>
					<li><a href="http://gdata.youtube.com/feeds/api/playlists/6E7A59AA5DA90449?alt=json-in-script&callback=showMyVideos2&max-results=32" class="<?php if($_REQUEST['playlist']=='pgashow') { echo 'active'; } ?>"><span>PGA Show</span></a></li>
					<li><a href="http://gdata.youtube.com/feeds/api/playlists/82DAE3BFBDFB1113?alt=json-in-script&callback=showMyVideos2&max-results=32" class="<?php if($_REQUEST['playlist']=='celebrity') { echo 'active'; } ?>"><span>Celebrity Reviews</span></a></li>
				</ul>
			</div>
			
			<script>
				$('.tab-main ul li a').click( function() {
					var url = $(this).attr('href');
					$('.active').removeClass('active');
					$(this).addClass('active');
					$.ajax({
				      type: "GET",
					  url: url,
					  dataType: "script"
					});
					return false;
				});
			
			</script>

			<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link" style="float:right;">', '</span>' ); ?>
			
			<?php //the_content(); ?>
			<?php endwhile; // end of the loop. ?>
							
			<?php if ( $paged < 2 ) { 
			    $feedURL = 'http://gdata.youtube.com/feeds/users/mygolfmix/uploads?alt=json-in-script&callback=showMyVideos2&max-results=32';
			} else {
			    $start = ($paged * 32) - 32;
			    $feedURL = 'http://gdata.youtube.com/feeds/users/mygolfmix/uploads?alt=json-in-script&callback=showMyVideos2&max-results=32&start-index='.$start;
			} 
			
			
			if($_REQUEST['playlist'] == 'all') { 
				$feedURL = 'http://gdata.youtube.com/feeds/users/mygolfmix/uploads?alt=json-in-script&callback=showMyVideos2&max-results=32';
			} elseif($_REQUEST['playlist'] == 'pgashow')	 {
				$feedURL = 'http://gdata.youtube.com/feeds/api/playlists/6E7A59AA5DA90449?alt=json-in-script&callback=showMyVideos2&max-results=32';
			} elseif($_REQUEST['playlist'] == 'wmpo')	 {
				$feedURL = 'http://gdata.youtube.com/feeds/users/WMPhoenixOpen/uploads?alt=json-in-script&callback=showMyVideos2&max-results=32';
			} elseif($_REQUEST['playlist'] == 'celebrity')	 {
				$feedURL = 'http://gdata.youtube.com/feeds/api/playlists/82DAE3BFBDFB1113?alt=json-in-script&callback=showMyVideos2&max-results=32';			
			} else {
				$feedURL = 'http://gdata.youtube.com/feeds/users/mygolfmix/uploads?alt=json-in-script&callback=showMyVideos2&max-results=32';
			}
		
			
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
				width: 130px;
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
			      (autoplay?1:0), 'player', '680', '405', '9.0.0', false, 
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
			              thumbnailUrl, '" width="130" height="97"/>', '<div class="titlec">', title, '&#8230;</div></li>');
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
			<div id="videos2"></div>
			<script 
			    type="text/javascript" 
			    src="<?php echo $feedURL; ?>"
			    id="youtube"
			    >
			</script>
			
			<div class="post_nav" style="display:none;"><a class="more-videos">More Videos &raquo;</a></div>
					
			<br class="clear" />
		
			</div>
		
		</div>

      
</div>

		<?php get_sidebar(); ?>

      <br class="clear" />
    </div>
    <!--/content-->

<?php get_footer(); ?>
