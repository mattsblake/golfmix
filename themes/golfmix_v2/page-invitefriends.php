<?php
/**
 * Template Name: Invite Friends
 */

get_header(); ?>

		<div id="content">
      <div class="content-data">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<h1><?php the_title(); ?></h1>
<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>

 <script src="http://connect.facebook.net/en_US/all.js"></script>
    <div id="fb-root"></div>
    <script>
      // assume we are already logged in
      FB.init({appId: '149725578415723', xfbml: true, cookie: true});

      FB.ui({
          method: 'apprequests',
          name: 'Invite Friends',
          message: 'I just signed up for golfmix. You should too!',
          redirect_uri: 'http://golfmix.com/invite-friends',
          display: 'page'
          });
     </script>

<?php endwhile; // end of the loop. ?>
</div>

		<?php get_sidebar(); ?>

      <br class="clear" />
    </div>
    <!--/content-->

<?php get_footer(); ?>
