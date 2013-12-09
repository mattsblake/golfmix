<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
get_header(); ?>

		<div id="content">
      <div class="content-data" style="padding-left:0px;">

		<h1><?php _e( 'You\'ve found the rough...', 'twentyten' ); ?></h1>

		<h2>The page you are looking for does not exist. Please check out some of our top cities, or <a href="<?php bloginfo('url'); ?>/contact">provide us feedback</a> if you have reached this page in error. </h2>
		<br /><br />
		
		<h2>Are we not in your area? Please <a href="http://eepurl.com/gWW61">sign up to be notified</a> when we launch near you!</h2>
		
		<br /><br />

		<?php include('cities-list.php'); ?>	


		</div>

		<?php get_sidebar(); ?>

      <br class="clear" />
    </div>
    <!--/content-->
    
	<script type="text/javascript">
		// focus on search field after it has loaded
		document.getElementById('s') && document.getElementById('s').focus();
	</script>

<?php get_footer(); ?>