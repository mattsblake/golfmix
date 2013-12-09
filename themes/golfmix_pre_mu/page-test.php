<?php
/**
 * Template Name: Test Page
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

		<div id="content">
      <div class="content-data">
            
      <?php include('featured-slider.php');?>
      
</div>

		<?php get_sidebar(); ?>

      <br class="clear" />
    </div>
    <!--/content-->

<?php get_footer(); ?>
