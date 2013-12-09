<?php
	/*
	Plugin Name: WP Review Site
	Plugin URI: http://www.wpreviewsite.com
	Description: Allows you to build a review site with WordPress with Amazon-style user reviews.
	Author: Dan Grossman
	Author URI: http://www.dangrossman.info
	Version: 3.0
	*/ 
	
	/* 
	THIS IS COMMERCIAL SOFTWARE. You must own a license to use this plugin. You should not call 
	any functions in this file. User-callable functions are in review-site-api.php
	*/
		
	/** Set Up Constants **/
	global $wpdb;
	$wpdb->ratings = $wpdb->prefix . 'rs_ratings';
	$wpdb->visitlinks = $wpdb->prefix . 'rs_visit_links';
	
	if (!defined('WP_CONTENT_DIR')) {
		define( 'WP_CONTENT_DIR', ABSPATH.'wp-content');
	}
	if (!defined('WP_CONTENT_URL')) {
		define('WP_CONTENT_URL', get_option('siteurl').'/wp-content');
	}
	if (!defined('WP_PLUGIN_DIR')) {
		define('WP_PLUGIN_DIR', WP_CONTENT_DIR.'/plugins');
	}
	if (!defined('WP_PLUGIN_URL')) {
		define('WP_PLUGIN_URL', WP_CONTENT_URL.'/plugins');
	}
	
	//Handles the settings pages
	include('review-site-config.php');
	
	//Contains all user-callable functions
	include('review-site-api.php');
	
	//Sidebar widgets
	include('review-site-widgets.php');
	
	add_action('init', 'rs_init');
		
	function rs_init() {
	
		wp_register_script('rs_js', get_bloginfo('wpurl') . '/wp-content/plugins/review-site/review-site.js');
		wp_enqueue_script('rs_js');
		
		if (get_option('rs_map_embed')) {
			$key = get_option('rs_map_key');
			wp_register_script('rs_gmap_js', 'http://maps.google.com/maps?file=api&v=1&key=' . $key);
			wp_enqueue_script('rs_gmap_js');
		}
		
		add_action('wp_head', 'rs_css');

		//Settings stuff
		if (is_admin()) {
			add_action('admin_menu', 'rs_add_boxes');
			add_action('save_post', 'wprs_box_hook', 5, 2);
			add_filter('get_comment_text', 'rs_comment_text');
		}
		
		//Auto-embeds
		$rs_comment_form_embed = get_option('rs_comment_form_embed');
		if (!empty($rs_comment_form_embed))
			add_action('comment_form', 'ratings_input_table');
		
		$rs_post_embed = get_option('rs_post_embed');
		if (!empty($rs_post_embed))
			add_filter('the_content', 'embed_ratings_table', 100);
					
		$rs_comment_embed = get_option('rs_comment_embed');
		if (!empty($rs_comment_embed))
			add_filter('get_comment_text', 'embed_comment_ratings_table');
		
		$rs_comparison_embed_home = get_option('rs_comparison_embed_home');
		$rs_comparison_embed_category = get_option('rs_comparison_embed_category');
		if (!empty($rs_comparison_embed_home) || !empty($rs_comparison_embed_category))
			add_action('loop_start', 'rs_comparison_embed');
			
		$rs_map_embed = get_option('rs_map_embed');
		if ($rs_map_embed)
			add_filter('the_content', 'embed_rs_gmap', 101);
		
		//Post image/icon
		add_filter('the_content', 'embed_rs_icon', 102);
			
		//When comment is posted
		add_action('comment_post', 'rs_comment_posted');
		
		//Post sorting
		$sort = get_option('rs_sort');
		if ($sort == 'rating') {
			add_filter('posts_fields', 'rs_weighted_fields');
			add_filter('posts_join', 'rs_weighted_join');
			add_filter('posts_groupby', 'rs_weighted_groupby');
			add_filter('posts_orderby', 'rs_weighted_orderby');
		} else if ($sort == 'comments') {
			add_filter('posts_orderby', 'rs_comments_orderby');
		}
		
	}
		
	function rs_comment_text($content) {
		ob_start();
		comment_ratings_table();
		$table = ob_get_contents();
		ob_end_clean();
		
		return $content . "<br />" . $table;
	}
	
	/* Fires when a comment is posted */
	function rs_comment_posted($comment_ID, $status = null) {
		global $wpdb;		
		$categories = get_option('rs_categories');
		
		foreach ($categories as $id => $cat) {
			if (isset($_POST[$id . '_rating']) && $_POST[$id . '_rating'] > 0 && $_POST[$id . '_rating'] <= 5) {
				$query = "INSERT INTO " . $wpdb->ratings . " (comment_id, rating_id, rating_value) VALUES (" . $comment_ID . ", " . $id . ", " . $_POST[$id . '_rating'] . ")";
				$wpdb->query($query);
			}
		}
		
	}
	
	function rs_css() {
		echo "<!-- WP Review Site CSS -->\n";
		echo "<link rel='stylesheet' href='" . WP_PLUGIN_URL . "/review-site/review-site.css' type='text/css' media='all' />\n";
		echo '<style type="text/css">' . "\n";
		
		$plugin_url = WP_PLUGIN_URL;
		
		$css = <<<EOD
		.rating_value a {
			background: url($plugin_url/review-site/images/star-empty.gif) no-repeat;
			width: 12px;
			height: 12px;
			display: block;
			float: left;
		}
		
		.rating_value .on {
			background: url($plugin_url/review-site/images/star.gif) no-repeat;
		}
EOD;

		echo $css;
		echo "\n</style>\n";
	}
		
	/* Adds boxes to the post/page write/edit screens */
	function rs_add_boxes() {
	
		add_meta_box('rs_rating_categories', 'Rating Categories', 'rs_rating_categories_box', 'post', 'normal', 'high');
		add_meta_box('rs_post_image', 'Post Image', 'rs_post_image_box', 'post', 'normal', 'high');
		add_meta_box('rs_visit_site', '"Visit Site" Link', 'rs_visit_site_box', 'post', 'normal', 'high');
		add_meta_box('rs_rating_categories', 'Rating Categories', 'rs_rating_categories_box', 'page', 'normal', 'high');
		add_meta_box('rs_post_image', 'Post Image', 'rs_post_image_box', 'page', 'normal', 'high');
		add_meta_box('rs_visit_site', '"Visit Site" Link', 'rs_visit_site_box', 'page', 'normal', 'high');
		
	}
	
	function rs_visit_site_box() {
		global $post;
		echo '<b>Set the URL you want the "Visit Site" link to point to:</b><br /><br />';
		$url = get_post_meta($post->ID, '_rs_link', true);
		if (empty($url)) $url = 'http://';
		echo "<input type='text' name='visitlink' value='" . $url . "' style='width: 350px' />";     
	}
	
	function rs_rating_categories_box() {
		global $post;
		$categories = get_option('rs_categories');
		$mine = get_post_meta($post->ID, '_rs_categories', true);
		echo '<ul class="categorychecklist form-no-clear" >';
		foreach ($categories as $id => $category) {
			echo '<li><input type="checkbox" name="rs_categories[]" value="' . $id . '" ';
			if (!empty($mine) && in_array($id, $mine)) echo 'checked="checked" ';
			echo '/> <label>' . $category . '</label></li>';
		}
		echo '</ul>';
	}
	
	function rs_post_image_box() {
		global $post;
		echo '<b>Set the URL for an image/icon for this post:</b><br /><br />';
		$url = get_post_meta($post->ID, '_rs_icon', true);
		if (empty($url)) $url = 'http://';
		echo "<input type='text' name='posticon' value='" . $url . "' style='width: 350px' />";
	}
	
	function wprs_box_hook($post_id, $post) {
		if ($post->post_type != 'revision' && isset($_POST['visitlink'])) {
			$categories = !empty($_POST['rs_categories']) ? $_POST['rs_categories'] : array();
			update_post_meta($post_id, '_rs_link', $_POST['visitlink']);
			update_post_meta($post_id, '_rs_icon', $_POST['posticon']);
			update_post_meta($post_id, '_rs_categories', $categories);
		}
	}
	
	function embed_ratings_table($content) {
		if (get_option('rs_embed_format') == 'table') {
			if (get_option('rs_post_embed') == 'top')
				return ratings_table(null, true) . $content;
			return $content . ratings_table(null, true);
		}	
		if (get_option('rs_post_embed') == 'top')
			return ratings_list(null, true) . $content;
		return $content . ratings_list(null, true);
	}
	
	function embed_comment_ratings_table($content) {
		if (get_option('rs_embed_format') == 'table') {
			if (get_option('rs_comment_embed') == 'top')
				return comment_ratings_table(null, true) . $content;
			return $content . comment_ratings_table(null, true);
		}
		if (get_option('rs_comment_embed') == 'top')
			return comment_ratings_list(null, true) . $content;
		return $content . comment_ratings_list(null, true);
	}
		
	function rs_comparison_embed() {
		$count = get_option('rs_comparison_embed_count');
		$homecats = get_option('rs_comparison_embed_home_categories');
		$cats = get_option('rs_comparison_embed_categories');
		if ($homecats == -1) $homecats = '';
		if ($cats == -1) $cats = '';
				
		$text = get_option('rs_comparison_embed_text');
		if (get_option('rs_comparison_embed_home')) {
			if (is_home()) {
				rs_comparison_table($count, $text, $homecats);
			}
		}
		if (get_option('rs_comparison_embed_category')) {
			$categories = split(",",$cats);
			if (is_category()) {
				$current = get_query_var('cat');
				if (in_array($current, $categories) || $cats == '') {
					rs_comparison_table($count, $text, $current);
				}
			}	
		}
	}
	
	function embed_rs_gmap($content) {
		
		global $post;
		$map = rs_gmap($post->ID, true);
			
		if (get_option('rs_map_loc') == 'top')
			return $map . $content;
		return $content . $map;

	}

	function embed_rs_icon($content) {
	
		if (get_option('rs_embed_icon')) {
	
			ob_start();
			rs_post_icon();
			$html = ob_get_contents();
			ob_end_clean();
			
			return $html . $content;
			
		}
		
		return $content;
	
	}
	
	function rs_weighted_fields($content) {
		global $wpdb;
		$content .= ", (SUM(" . $wpdb->ratings . ".rating_value) / COUNT(" . $wpdb->ratings . ".rating_id)) AS `rs_rating`, ";
		$content .= "(COUNT(" . $wpdb->comments . ".comment_ID) / (COUNT(" . $wpdb->comments . ".comment_ID) + 10)) * ";
		$content .= "(SUM(" . $wpdb->ratings . ".rating_value) / COUNT(" . $wpdb->ratings . ".rating_id)) ";
		$content .= "+ (5 / (COUNT(" . $wpdb->comments . ".comment_ID) + 10)) * 3 AS `rs_weighted`";
		return $content;
	}
	
	function rs_weighted_join($content) {
		global $wpdb;
		$content .= " LEFT OUTER JOIN " . $wpdb->comments . " ON " . $wpdb->posts . ".ID = " . $wpdb->comments . ".comment_post_ID "
					. "AND " . $wpdb->comments . ".comment_approved = 1 "
					. "LEFT OUTER JOIN " . $wpdb->ratings . " ON " . $wpdb->comments . ".comment_ID = " . $wpdb->ratings . ".comment_id AND " . $wpdb->ratings . ".rating_value > 0 ";
		return $content;
	}
		
	function rs_weighted_groupby($content) {
		global $wpdb;
		if (!empty($content))
			return $content . ", " . $wpdb->posts . ".ID";
		return $wpdb->posts . ".ID";
	}
	
	function rs_weighted_orderby($content) {
		global $wpdb;
		return "`rs_weighted` DESC, " . $wpdb->posts . ".post_date DESC";
	}
	
	function rs_comments_orderby($content) {
		global $wpdb;
		return $wpdb->posts . ".comment_count DESC, " . $wpdb->posts . ".post_date DESC";
	}
	
	/* Installation */
	
	//Creates database table and sets default option values
	register_activation_hook(__FILE__, 'rs_install');
	function rs_install() {
	
		global $wpdb;
		
		if(@is_file(ABSPATH.'/wp-admin/upgrade-functions.php')) {
			include_once(ABSPATH.'/wp-admin/upgrade-functions.php');
		} elseif(@is_file(ABSPATH.'/wp-admin/includes/upgrade.php')) {
			include_once(ABSPATH.'/wp-admin/includes/upgrade.php');
		} else {
			die('Problem finding \'/wp-admin/upgrade-functions.php\' and \'/wp-admin/includes/upgrade.php\'');
		}
		
		update_option('rs_sort', 'default');
		
		update_option('rs_comparison_embed_home_categories', -1);
		update_option('rs_comparison_embed_categories', -1);
		update_option('rs_comparison_embed_count', 5);
		update_option('rs_comparison_embed_text', 'Visit Site');
		
		update_option('rs_map_loc', 'bottom');
		update_option('rs_map_width', '400px');
		update_option('rs_map_height', '300px');
		update_option('rs_map_zoom', 3);
		
		$categories = get_option('rs_categories');
		if (empty($categories))
			update_option('rs_categories', array(0 => 'Overall Rating'));
				
		$create_table_sql = "CREATE TABLE " . $wpdb->ratings . " (".
				"comment_id INT, ".
				"rating_id INT, ".
				"rating_value DOUBLE, ".
				"PRIMARY KEY (comment_id, rating_id))";
		maybe_create_table($wpdb->ratings, $create_table_sql);
				
		//Upgrade WPRS 2.0 to 3.0
    	if ($wpdb->get_var("SHOW TABLES LIKE '" . $wpdb->visitlinks . "'") == $wpdb->visitlinks) {
       		$query = "SELECT * FROM " . $wpdb->visitlinks;
    		$result = $wpdb->get_results($query);
			foreach ($result as $row) {
				$post = $row->post_id;
				$url = $row->url;
				update_post_meta($post, '_rs_link', $url);				
			}
		}  		
    	
	
	}


		
?>
