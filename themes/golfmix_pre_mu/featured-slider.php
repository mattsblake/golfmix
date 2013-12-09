 <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/nivo-slider.css" type="text/css" media="screen" /> 
      
		<div id="slider-wrapper">
        
            <div id="slider" class="nivoSlider">
               	
				<?php query_posts('orderby=date&order=DESC&post_type=blog&tag=featured&posts_per_page=2'); ?>
			   	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<?php  $image_img_tag = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),  'large'); ?>	
					<a href="<?php the_permalink(); ?>"><img src="<?php echo $image_img_tag[0]; ?>" title="#<?php echo get_the_id(); ?>" alt="<?php the_title(); ?>" /></a>
               	<?php endwhile; ?>
                <?php query_posts('post_type=page&p=851'); ?>
			   	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<?php  $image_img_tag = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),  'large'); ?>	
					<a href="<?php the_permalink(); ?>"><img src="<?php echo $image_img_tag[0]; ?>" title="#<?php echo get_the_id(); ?>" alt="<?php the_title(); ?>" /></a>
               	<?php endwhile; ?>
				<?php query_posts('orderby=date&order=DESC&post_type=blog&tag=featured&posts_per_page=2&offset=2'); ?>
			   	<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<?php  $image_img_tag = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),  'large'); ?>	
					<a href="<?php the_permalink(); ?>"><img src="<?php echo $image_img_tag[0]; ?>" title="#<?php echo get_the_id(); ?>" alt="<?php the_title(); ?>" /></a>
               	<?php endwhile; ?>
            	<?php query_posts('cat=6&tag=featured'); ?>
			    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
					<?php  $image_img_tag = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ),  'large'); ?>	
					<a href="<?php the_permalink(); ?>"><img src="<?php echo $image_img_tag[0]; ?>" title="#<?php echo get_the_id(); ?>" alt="<?php the_title(); ?>" /></a>
                <?php endwhile; ?>


            </div>


			<?php query_posts('orderby=date&order=DESC&post_type=blog&tag=featured&posts_per_page=2'); ?>
			    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	            <div id="<?php echo get_the_id(); ?>" class="nivo-html-caption">
	                <a href="<?php the_permalink(); ?>"><strong><?php the_title(); ?></strong></a>
	            </div>
            <?php endwhile; ?>
			<?php query_posts('post_type=page&p=851'); ?>
			    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	            <div id="<?php echo get_the_id(); ?>" class="nivo-html-caption">
	                <a href="<?php the_permalink(); ?>"><strong>video: golfmix brings you the latest and greatest from Orlando</strong></a>
	            </div>
            <?php endwhile; ?>  
			<?php query_posts('orderby=date&order=DESC&post_type=blog&tag=featured&posts_per_page=2&offset=2'); ?>
			    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	            <div id="<?php echo get_the_id(); ?>" class="nivo-html-caption">
	                <a href="<?php the_permalink(); ?>"><strong><?php the_title(); ?></strong></a>
	            </div>
            <?php endwhile; ?>            <?php query_posts('cat=6&tag=featured'); ?>
			    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
	            <div id="<?php echo get_the_id(); ?>" class="nivo-html-caption">
	                <a href="<?php the_permalink(); ?>">Featured Course: <strong><?php the_title(); ?></strong></a>
	                <div class="featured-rating"><?php echo num_to_stars(get_average_rating($post->ID)) ?></div>
	            </div>
            <?php endwhile; ?>
        
        </div>
        
    <!--script type="text/javascript" src="<?php bloginfo('template_url'); ?>/js/jquery-1.4.3.min.js"></script-->
    <script type="text/javascript" src="<?php bloginfo('template_url'); ?>/jquery.nivo.slider.pack.js"></script>

	<script type="text/javascript">
	jQuery(window).load(function() {
		jQuery('#slider').nivoSlider({
			startSlide:0,
			pauseTime:4000,
            pauseOnHover:true,
    		controlNavThumbs:true
		});
	});
	</script>
