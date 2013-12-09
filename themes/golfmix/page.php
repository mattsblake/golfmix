<?php
/**
 * Template Name: page template
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

<!--content-->

<?php 
global $detect;
$detect = new Mobile_Detect();
if ($detect->isMobile() && !$detect->isIpad()) { 

	include('mobile-page.php');

} else { ?>

		<div id="content">
      <div class="content-data">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<h1><?php the_title(); ?></h1>
<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
<?php the_content(); ?> 
<?php endwhile; // end of the loop. ?>
</div>

		<?php get_sidebar(); ?>

      <br class="clear" />
    </div>
    <!--/content-->

<?php } ?>

<?php get_footer(); ?>
