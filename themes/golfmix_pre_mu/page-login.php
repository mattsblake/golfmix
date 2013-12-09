<?php
/**
 * Template Name: Login
 *
 */

get_header(); ?>

		<div id="content">
      <div class="content-data">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>


<?php 
global $detect;
$detect = new Mobile_Detect();
if ($detect->isMobile() && !$detect->isIpad()) { ?>
	<div class="recent-reviews"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" style="display:none;">&#171; Back</a><h1><?php the_title(); ?></h1></div>
<?php } else { ?>

<h1><?php the_title(); ?></h1>

<?php } ?>


<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>

<?php if(($_REQUEST['action'] == 'lostpassword' || $_REQUEST['action'] == 'login' || !isset($_REQUEST['action'])) && $turn_off == true) { ?>
<p class="error">Please note: If you are entering your e-mail address and the system is not able to find your account, we apologize.  In order to create a better experience for you on golfmix, we have transitioned to a new system and we are asking anybody with an account on our old system to set up a new user account (although you can use the same e-mail address that you used previously). We apologize for any inconvenience this has caused. If you continue to have problems logging in after setting up a new account,  please <a href="<?php bloginfo('url'); ?>/contact?issue=login">click here to report your problem</a> and we will respond to your issue promptly.
</p>

<?php } ?>

<?php echo do_shortcode("[theme-my-login]"); ?>

	<div id="social-login" style="display:none;">
	<?php
	//jfb_output_facebook_btn();
	jfb_output_facebook_init();
	jfb_output_facebook_callback();
	?>
	</div>
	
	<?php if ( is_user_logged_in() && !$detect->isMobile() && !$detect->isIpad()) { ?>
		<div id="share-link" class="profile" style="display:none;">
			<h3>Share and win:</h3>
			<div class="form-table">
				<?php //<p>Every day we give away a unique assortment of prizes from Dixon golf balls, to DNA drivers, to amazing <strong>playing lessons with PGA Tour Winner Arron Oberholser</strong>.</p>?>
				<p>Current prize: A trip to Las Vegas!</p>
				<p>Share this link with friends and <em>for every person that you refer to golfmix, you will receive an entry into our giveaways</em>:</p>
				<?php
				$current_user = wp_get_current_user();
				$referral = md5($current_user->user_email.$current_user->ID);
				$share_url = 'http://golfmix.com/?referred_by='.$referral;
				?>
				<div class="share" style="font-weight:bold;">Your Share Link: &nbsp;<br /><input type="text" value="<?php echo $share_url;?>" style="width:500px;float:right;"><div class="clear"></div></div>
			</div>
		</div>
	<?php } ?>	
		



<script type="text/javascript">/* <![CDATA[ */
var hideFields = [ "url", "description" ];
jQuery.each( jQuery( "form#your-profile tr" ), function() {
	var field = jQuery( this ).find( "input,textarea,select" ).attr( "id" );
	if ( hideFields.indexOf( field ) != -1 ) {
		jQuery( this ).remove();
	}
});

jQuery('p.error:contains("Wordpress")').each(function() {
    jQuery(this).text(jQuery(this).text().replace('Wordpress','golfmix'));
});

jQuery("h3:eq(0)").remove();
jQuery("table.form-table:eq(0)").remove();

jQuery("h3:eq(2)").text("Reset Password");
     
<?php if($detect->isMobile() && !$detect->isIpad()) { ?>
jQuery("h3:eq(3)").remove();
jQuery("table.form-table:eq(3)").remove();
<?php } else { ?>
jQuery("h3:eq(3)").text("Profile Picture");
     
jQuery("table.form-table:eq(3) th").text("Current Profile Picture");
<?php } ?>

jQuery(document).ready(function() {

	jQuery("h1").after($('#share-link'));
	jQuery("#share-link").show();

});
     

jQuery(document).ready(function() {
var action = getParameterByName('action');
//alert(action);
if(action == 'lostpassword') {
   //jQuery('.message').append('<p class="error">Bla bla</p>');
}
});

function getParameterByName( name )
{
  name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
  var regexS = "[\\?&]"+name+"=([^&#]*)";
  var regex = new RegExp( regexS );
  var results = regex.exec( window.location.href );
  if( results == null )
    return "";
  else
    return decodeURIComponent(results[1].replace(/\+/g, " "));
}

/* ]]> */</script>



<?php endwhile; // end of the loop. ?>

</div>

		<?php if ($detect->isMobile() && !$detect->isIpad()) { } else { get_sidebar(); } ?>

      <br class="clear" />
    </div>
    <!--/content-->

<?php  //if ($detect->isMobile() && !$detect->isIpad()) { } else { get_footer(); } ?>
<?php  get_footer(); ?>
