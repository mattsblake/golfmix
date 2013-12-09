<?php
/**
 * Template Name: Mobile Course Reviews
 *
**/
if(isset($_REQUEST['id']) || isset($_REQUEST['review_id'])) {

if(!isset($_REQUEST['app'])) {

	global $post;
	include('./wp-admin/admin-functions.php');	
?>
<head>	
	<meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />	
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style-mobile.css?v=1" type="text/css" media="screen" />
	
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
	<?php if(!isset($_REQUEST['review_id'])) { ?>
		<div class="recent-reviews"><?php echo get_the_title($_REQUEST['id']); ?> Reviews</div>
	<?php } else { ?>
		<div class="recent-reviews"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">&#171; Back</a></div>
	<?php } ?>
	
	<div class="reviews">

		<?php
				
		if(isset($_REQUEST['offset'])) { $offset = ($_REQUEST['offset']*10)-10; } else { $offset = 0; }

		if(isset($_REQUEST['review_id'])) {
				
			$comment = & get_comment($_REQUEST['review_id']);
			
			include('review_mobile.php');				
			
		} else {

			$comment_args = array(
			    'post_id' => $_REQUEST['id'],
			    'number' => 10,
			    'offset' => $offset,
			    'order' => 'DESC',
			    'status' => 'approve'
			);
			
			$comments = get_comments($comment_args);
			
			foreach($comments as $comment) :
				
				include('review_mobile.php');				
				
			endforeach;
			
		}
		
		?>

	</div>

	<?php

} else { 
	exit; 
}
?>
</body>