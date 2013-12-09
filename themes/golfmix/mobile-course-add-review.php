<?php
/**
 * Template Name: Mobile Course Add Review
 *
**/

if(!isset($_REQUEST['app'])) {

	global $post;
	include('./wp-admin/admin-functions.php');	
	
	if ( !is_user_logged_in() && (isset($_REQUEST['id']) && $_REQUEST['id'] !== '') ) { header('Location: http://golfmix.com/login/?redirect_to=http%3A%2F%2Fgolfmix.com%2Fm%2Fa%2F%3Fid%3D'.$_REQUEST['id']); }
?>
<head>	
	<meta name="viewport" content="initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" />	
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/style-mobile.css?v=1" type="text/css" media="screen" />
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	
	<?php wp_head(); ?>
	
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
<?php } else { get_header(); } 

if(isset($_REQUEST['id']) && $_REQUEST['id'] !== '') {

	$post = get_post($_REQUEST['id']); 
	setup_postdata($post);
	?>

	<div class="recent-reviews">Write a review on <?php the_title(); ?></div> 
	
	<div class="reviews">

		<?php golfmix_comment_form(); ?>


	</div>

	<script>
		$(document).ready( function() {
			//$(".must-log-in").html('<a href="http://golfmix.com/login" class="login-button">Login</a>');
			$("table.ratings").after('<div style="clear:both;width:100%;height:40px;float:left;"></div><div class="clear"></div>');		
		});

		
		$('#commentform').submit(function() {
		 	 if ($("input#1_rating").val() !== "0" && $("input#2_rating").val() !== "0" && $("input#3_rating").val() !== "0" && $("input#4_rating").val() !== "0" && $("input#5_rating").val() !== "0" && $("input#6_rating").val() !== "0" && $("textarea#comment").val() !== "" && $("input#_iti_ccf_post_plays").val() !== ""  && $("input#_iti_ccf_post_average_score").val() !== "") {
		 	 	$('#loader').show();
		 	 	$('#left-col .new-reviwes-bot table.ratings').hide();
		 	 	$('input#submit').hide();
		 	 	$('#review_form').hide();
		 	 	//$('input#submit').attr('disabled', 'disabled');
		 	 	_gaq.push(['_trackEvent', 'Add Review', 'Mobile Review', '<?php $current_user = wp_get_current_user(); echo $current_user->user_login; ?>']);
		        return true;
		      } else {
		      	alert("Please fill in all ratings categories and fields.");
		     	return false;
		      }
		      return false;
		});
	</script>


<?php } else { ?>	

	<div class="recent-reviews">What course would you like to review?</div> 
	
	<div class="reviews">

		<form method="get" id="write-review-search" class="mobile-search" action="<?php bloginfo('url'); ?>/search/" autocomplete="off">
			<input name="q" id="q-small" value="">
			<?php if(isset($_REQUEST['app'])) { ?><input type="hidden" name="app" id="app" value="no"><?php } ?>
			<input type="submit" name="search" value="Search">
		</form>
		<script>
			$("#q-small").focus( function() {
				$(this).val('');	
			});
		</script>

	</div>	
	
	
<?php }

if(!isset($_REQUEST['app'])) { } else { get_footer(); }

wp_footer();

?>
</body>