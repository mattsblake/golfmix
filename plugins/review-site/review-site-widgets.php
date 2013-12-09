<?php

	/*
	* Widgets
	*/
	
	function rs_top_rated_widget($args) {
	
		extract($args, EXTR_SKIP);

		$options = get_option('widget_rs_top_rated');
		$title = empty($options['title']) ? __('Top Rated') : apply_filters('widget_title', $options['title']);
		
		echo $before_widget . $before_title . $title . $after_title;
		
		echo '<ul id="toprated">';
		
		$sort = get_option('rs_sort');
		if ($sort == 'default') {
			add_filter('posts_fields', 'rs_weighted_fields');
			add_filter('posts_join', 'rs_weighted_join');
			add_filter('posts_groupby', 'rs_weighted_groupby');
			add_filter('posts_orderby', 'rs_weighted_orderby');
		} else if ($sort == 'comments') {
			remove_filter('posts_orderby', 'rs_comments_orderby');
			add_filter('posts_fields', 'rs_weighted_fields');
			add_filter('posts_join', 'rs_weighted_join');
			add_filter('posts_groupby', 'rs_weighted_groupby');
			add_filter('posts_orderby', 'rs_weighted_orderby');
		}
		
		if ( !$number = (int) $options['number'] )
			$number = 10;
		else if ( $number < 1 )
			$number = 1;
		
		if ( !$cat = (int) $options['cat'] )
			$cat = 1;
		
		$args = array();
		$args['suppress_filters'] = false;
		$args['numberposts'] = $number;
		
		if ($cat > 0)
			$args['category'] = $cat; 
		
		$posts = get_posts($args);
		
		if ($sort == 'default') {
			remove_filter('posts_fields', 'rs_weighted_fields');
			remove_filter('posts_join', 'rs_weighted_join');
			remove_filter('posts_groupby', 'rs_weighted_groupby');
			remove_filter('posts_orderby', 'rs_weighted_orderby');
		} else if ($sort == 'comments') {
			add_filter('posts_orderby', 'rs_comments_orderby');
		}

		foreach ($posts as $post) {
			echo "<li>";
									
			echo "<a href=\"" . get_permalink($post->ID) . "\">" . $post->post_title . "</a> ";
			
			if ($options['show_counts'])
				echo "(" . (int)get_comments_number($post->ID) . ") ";
			
			if ($options['show_stars'])
				echo num_to_stars(get_average_rating($post->ID));
			
			echo "</li>";
		}
		echo "</ul>";
		
		echo $after_widget;

	}
	
	function rs_top_rated_widget_control() {
	
		$options = $newoptions = get_option('widget_rs_top_rated');
		
		if ( $_POST["rs-top-rated-submit"] ) {
			$newoptions['title'] = strip_tags(stripslashes($_POST["rs-top-rated-title"]));
			$newoptions['number'] = (int) $_POST["rs-top-rated-number"];
			$newoptions['cat'] = (int) $_POST["rs-top-rated-cat"];
			$newoptions['show_stars'] = (isset($_POST['rs-top-rated-stars'])) ? true : false;
			$newoptions['show_counts'] = (isset($_POST['rs-top-rated-counts'])) ? true : false;
		}
		
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_rs_top_rated', $options);
		}
		
		$title = attribute_escape($options['title']);
		
		if (!$cat = (int)$options['cat'])
			$cat = -1;
					
		if (!$number = (int) $options['number'])
			$number = 10;
			
		$stars = $options['show_stars'];
		$count = $options['show_counts'];
			
	?>
		<p>
			<label for="rs-top-rated-title"><?php _e('Title:'); ?> <input class="widefat" id="rs-top-rated-title" name="rs-top-rated-title" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<p>
			<label for="rs-top-rated-number"><?php _e('Number of posts to show:'); ?> <input style="width: 25px; text-align: center;" id="rs-top-rated-number" name="rs-top-rated-number" type="text" value="<?php echo $number; ?>" /></label>
		</p>
		<p>
			<label for="rs-top-rated-counts"><?php _e('Show comment count? '); ?> <input type="checkbox" id="rs-top-rated-counts" name="rs-top-rated-counts" value="1" <?php if ($count) echo 'checked="checked"'; ?>/></label>
		</p>
		<p>
			<label for="rs-top-rated-stars"><?php _e('Show rating average? '); ?> <input type="checkbox" id="rs-top-rated-stars" name="rs-top-rated-stars" value="1" <?php if ($stars) echo 'checked="checked"'; ?>/></label>
		</p>
		<p>
			<label for="rs-top-rated-cat"><?php _e('Restrict to category:'); ?>
			<br />
			<?php wp_dropdown_categories('selected=' . $cat . '&name=rs-top-rated-cat&show_option_none=All Categories'); ?>
			</label>
		</p>
		<input type="hidden" id="rs-top-rated-submit" name="rs-top-rated-submit" value="1" />
	<?php
	}

	
	function rs_recent_reviews_widget($args) {
		global $wpdb, $comments, $comment;
		extract($args, EXTR_SKIP);
		
		$options = get_option('widget_rs_recent_reviews');
		$title = empty($options['title']) ? __('Recent Reviews') : apply_filters('widget_title', $options['title']);
		
		if ( !$number = (int) $options['number'] )
			$number = 10;
		else if ( $number < 1 )
			$number = 1;
	
		$comments = $wpdb->get_results("SELECT comment_author, comment_author_url, comment_ID, comment_post_ID FROM $wpdb->comments WHERE comment_approved = '1' AND comment_type = '' ORDER BY comment_date_gmt DESC LIMIT $number");
		
		echo $before_widget;
		echo $before_title . $title . $after_title;
		echo '<ul id="recentreviews">';
		
		if ($comments) {
			foreach ($comments as $comment) {
			
				echo '<li>';
				
				if ($options['show_author'])
					echo get_comment_author_link($comment->comment_ID) . " on ";
				
				echo '<a href="' . get_permalink($comment->comment_post_ID) . '#comment-' . $comment->comment_ID . '">' . get_the_title($comment->comment_post_ID) . '</a> ';

				if ($options['show_stars'])
					echo num_to_stars(get_average_comment_rating($comment->comment_ID));
								
				echo '</li>';
	
			}
		}
		
		echo '</ul>';
		echo $after_widget;
			
	}
	
	function rs_recent_reviews_widget_control() {
	
		$options = $newoptions = get_option('widget_rs_recent_reviews');
		
		if ( $_POST["rs-recent-reviews-submit"] ) {
			$newoptions['title'] = strip_tags(stripslashes($_POST["rs-recent-reviews-title"]));
			$newoptions['number'] = (int) $_POST["rs-recent-reviews-number"];
			$newoptions['cat'] = (int) $_POST["rs-recent-reviews-cat"];
			$newoptions['show_author'] = (isset($_POST['rs-recent-reviews-author'])) ? true : false;
			$newoptions['show_stars'] = (isset($_POST['rs-recent-reviews-stars'])) ? true : false;
		}
		
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_rs_recent_reviews', $options);
		}
		
		$title = attribute_escape($options['title']);
		
		if (!$cat = (int)$options['cat'])
			$cat = -1;
					
		if (!$number = (int) $options['number'])
			$number = 10;
			
		$stars = $options['show_stars'];
		$author = $options['show_author'];
		
			
	?>
		<p>
			<label for="rs-recent-reviews-title"><?php _e('Title:'); ?> <input id="rs-recent-reviews-title" name="rs-recent-reviews-title" type="text" value="<?php echo $title; ?>" /></label>
		</p>
		<p>
			<label for="rs-recent-reviews-number"><?php _e('Number of comments to show:'); ?> <input style="width: 25px" id="rs-recent-reviews-number" name="rs-recent-reviews-number" type="text" value="<?php echo $number; ?>" /></label>
		</p>
		<p>
			<label for="rs-recent-reviews-author"><?php _e('Show author name? '); ?> <input type="checkbox" id="rs-recent-reviews-author" name="rs-recent-reviews-author" value="1" <?php if ($author) echo 'checked="checked"'; ?>/></label>
		</p>	
		<p>
			<label for="rs-recent-reviews-stars"><?php _e('Show rating average? '); ?> <input type="checkbox" id="rs-recent-reviews-stars" name="rs-recent-reviews-stars" value="1" <?php if ($stars) echo 'checked="checked"'; ?>/></label>
		</p>
		<p>
			<label for="rs-recent-reviews-cat"><?php _e('Restrict to category:'); ?>
			<br />
			<?php wp_dropdown_categories('selected=' . $cat . '&name=rs-recent-reviews-cat&show_option_none=All Categories'); ?>
			</label>
		</p>
		<input type="hidden" id="rs-recent-reviews-submit" name="rs-recent-reviews-submit" value="1" />
	<?php
	}

	function rs_widgets_init() {
		
		register_sidebar_widget('Top Rated Posts', 'rs_top_rated_widget');
		register_widget_control('Top Rated Posts', 'rs_top_rated_widget_control');

		register_sidebar_widget('Recent Reviews', 'rs_recent_reviews_widget');
		register_widget_control('Recent Reviews', 'rs_recent_reviews_widget_control');
		
	}
	
	add_action('widgets_init', 'rs_widgets_init');

?>