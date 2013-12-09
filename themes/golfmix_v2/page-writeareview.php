<?php
/**
 * Template Name: Write a Review
 *
 */

get_header(); ?>

		<div id="content">
      <div class="content-data">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>

	<div class="blog">


		<h1><?php the_title(); ?></h1>
	
				<style>
				.city-list-container {
				padding: 5px 0 24px 0px;
				}
				.city-list-container h2 {
				margin-bottom:20px;
				}
				.city-list-container ul {
				display:inline;
				list-style-type:none;
				margin-bottom:20px;
				padding: 0;
				margin-left: 0;
				}
				.city-list-container ul li {
				float: left;
				font-size: 16px;
				margin-left: 5px;
				}
				.city-list-container ul li span {
				padding:10px;
				font-size:16px;
				color:#fff;
				background: #E07401;
				-moz-border-radius: 25px; 
				-webkit-border-radius: 25px;
				border-radius: 25px;
				margin-right:5px;
				}
				</style>

				<div class="courses-box-by-city">

					<div class="city-list-container">
					<h2>In 4 easy steps</h2>
						<ul>
						<li><span>1</span><a href="<?php echo bloginfo('url'); ?>/login">Register/Login</a></li>
						<li><span>2</span>Search for the golf course</li>
						<li><span>3</span>Select the course</li>
						<li><span>4</span>Write your review!</li>
						</ul>
				

					</div>

					<div class="city-search-box">

						<ul>

						<?php get_search_form(); ?>
						</ul>

					</div>

				</div>
				
			<br class="clear" />	
	 </div>



<?php endwhile; // end of the loop. ?>
</div>

		<?php get_sidebar(); ?>

      <br class="clear" />
    </div>
    <!--/content-->

<?php get_footer(); ?>
