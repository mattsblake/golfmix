<?php
/**
 * Template Name: Facebook Test
 *
**/

wp_head();
?>

<div id="comment-user-details" style="margin:10px 0;">
	<?php
	jfb_output_facebook_btn();
	jfb_output_facebook_init();
	jfb_output_facebook_callback();
	?>
</div>

<?php
wp_footer();
?>