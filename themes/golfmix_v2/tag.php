<?php
/**
 * The template for displaying Tag Archive pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>

		<div id="container">
			<div id="content" role="main">

				<h1 class="page-title"><?php
					printf( __( 'Tag Archives: %s', 'twentyten' ), '<span>' . single_tag_title( '', false ) . '</span>' );
				?></h1>

	<?php while ( have_posts() ) : the_post();	
		
		include('entry-content.php');
		
	  endwhile; 
	 ?> 
	  			</div><!-- #content -->
		</div><!-- #container -->

		<?php get_sidebar(); ?>

      <br class="clear" />
    <!--/content-->
			
		</div>
<?php get_footer(); ?>
