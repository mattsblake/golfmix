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
				.city-list-container h2 {
				margin-bottom:20px;
				}
				.city-list-container ul {
				display:inline;
				list-style-type:none;
				margin-bottom:20px;
				}
				.city-list-container ul li {
				float:left;
				margin-left:10px;
				font-size:16px;
				}
				.city-list-container ul li span {
				padding:10px;
				font-size:16px;
				color:#fff;
				background: #E07401;
				-moz-border-radius: 25px; 
				-webkit-border-radius: 25px;
				border-radius: 25px;
				margin-right:15px;
				}
				</style>

				<div class="courses-box-by-city">

					<div class="city-list-container">
					<h2>Write a review in 3 easy steps</h2>
						<ul>
						<li><span>1</span>Search for the golf course</li>
						<li><span>2</span>Select the course</li>
						<li><span>3</span>Write your review!</li>
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
