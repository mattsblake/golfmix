	<div class="bestof-course" id="best-of-<?php echo $count; ?>">
		<div class="best-image-wrapper">
			<div class="best-image"><img src="<?php echo $image; ?>"></div>
			<div class="best-of-number"><?php echo $count; ?></div>
			<div class="clear"></div>
		</div>
		
		<div class="best-info">
			<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
			<div class="best-share">
				<a href="<?php the_permalink(); ?>#reviews"><?php comments_number('','1 Review','% Reviews'); ?><?php echo '&nbsp;|&nbsp;'; ?></a><span><?php echo num_to_stars($value);  ?></span>
			</div>
			<ul class="info">
				<li><?php echo $c_city; ?>, <?php echo $c_state; ?> <?php echo $c_zip; ?></li>
			</ul>
		</div>
	</div>
