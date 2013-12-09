<?php

	add_action('admin_menu', 'rs_menus');
	
	function rs_menus() {
	
		/* Set up WP-Admin menus */
	    add_menu_page('Settings', 'Review Site', 8, __FILE__, 'rs_config');
	    add_submenu_page(__FILE__, 'General Settings', 'General Settings', 8, __FILE__, 'rs_config');
	    add_submenu_page(__FILE__, 'Rating Categories', 'Rating Categories', 8, 'rs_config_categories', 'rs_config_categories');
	    add_submenu_page(__FILE__, 'Comparison Tables', 'Comparison Tables', 8, 'rs_config_comparison', 'rs_config_comparison');
	    add_submenu_page(__FILE__, 'Google Maps', 'Google Maps', 8, 'rs_config_gmaps', 'rs_config_gmaps');
	    		    	
	}

	function rs_config() {
		
		if (!empty($_POST)) {
			if (isset($_POST['rs_sort']))
				update_option('rs_sort', $_POST['rs_sort']);
			
			if (isset($_POST['rs_comment_form_embed']))
				update_option('rs_comment_form_embed', $_POST['rs_comment_form_embed']);
			else
				delete_option('rs_comment_form_embed');
				
			if (isset($_POST['rs_post_embed']))
				update_option('rs_post_embed', $_POST['rs_post_embed_loc']);
			else
				delete_option('rs_post_embed');
						
			if (isset($_POST['rs_comment_embed']))
				update_option('rs_comment_embed', $_POST['rs_comment_embed_loc']);
			else
				delete_option('rs_comment_embed');
				
			if (isset($_POST['rs_embed_format']))
				update_option('rs_embed_format', $_POST['rs_embed_format']);
				
			if (isset($_POST['rs_embed_icon']))
				update_option('rs_embed_icon', $_POST['rs_embed_icon']);
			else
				delete_option('rs_embed_icon');
		}
		
		$rs_comment_form_embed = get_option('rs_comment_form_embed');
		$rs_post_embed = get_option('rs_post_embed');
		$rs_comment_embed = get_option('rs_comment_embed');
		$rs_embed_format = get_option('rs_embed_format');
		$rs_sort = get_option('rs_sort');
		$rs_embed_icon = get_option('rs_embed_icon');
				
		?>
			
		<div class="wrap"> 
			<div id="icon-options-general" class="icon32"><br /></div> 
			
			<h2>WP Review Site: General Settings</h2> 
			
			<?php if (isset($_POST['rs_sort'])): ?>
			<p style="font-weight: bold">Your changes have been saved.</p>
			<?php endif; ?>
			
			<p>Note: The themes that come with WP Review Site already have code in them to display ratings. You should not check off the boxes 
			to display ratings on this form when using those themes. Use these options to add the ratings to other themes without having 
			to edit the code. You can still manually add the rating features to a theme for full control of location and appearance; see the 
			<a href="http://www.wpreviewsite.com/documentation">documentation</a> for a list of functions WP Review Site makes available to 
			your theme.</p>
		 
			<form method="post" action="">
			
				<table class="form-table"> 
					<tr valign="top"> 
						<th scope="row"><label for="rs_sort">Sort Posts By:</label></th> 
						<td>
							<select name="rs_sort">
								<option value="default"<?php if ($rs_sort == 'default') echo ' selected="selected"'; ?>>WordPress Default</option>
								<option value="rating"<?php if ($rs_sort == 'rating') echo ' selected="selected"'; ?>>Average User Rating (Weighted)</option>
								<option value="comments"<?php if ($rs_sort == 'comments') echo ' selected="selected"'; ?>>Number of Reviews/Comments</option>
							</select>				
						</td> 
					</tr>
					<tr valign="top">
						<th scope="row" style="width: 350px"><label for="rs_embed_icon">Display Post Image/Icon Before Post Content</label></th>
						<td>
							<input type="checkbox" name="rs_embed_icon" value="checked" <?php if ($rs_embed_icon) echo 'checked="checked"'; ?> />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row" style="width: 350px"><label for="rs_post_embed">Display Average Ratings on Posts &amp; Pages</label></th>
						<td>
							<input type="checkbox" name="rs_post_embed" value="checked" <?php if ($rs_post_embed) echo 'checked="checked"'; ?> />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="rs_post_embed_loc">Ratings Location in Post/Page Text</label></th>
						<td>
							<input type="radio" name="rs_post_embed_loc" value="top" <?php if (empty($rs_post_embed) || $rs_post_embed == 'top') echo 'checked="checked"'; ?> /> Top<br />
							<input type="radio" name="rs_post_embed_loc" value="bottom" <?php if ($rs_post_embed == 'bottom') echo 'checked="checked"'; ?> /> Bottom
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="rs_comment_embed">Display Ratings in Comment Lists</label></th>
						<td>
							<input type="checkbox" name="rs_comment_embed" value="checked" <?php if ($rs_comment_embed) echo 'checked="checked"'; ?> />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="rs_comment_embed_loc">Ratings Location in Comment Text</label></th>
						<td>
							<input type="radio" name="rs_comment_embed_loc" value="top" <?php if (empty($rs_comment_embed) || $rs_comment_embed == 'top') echo 'checked="checked"'; ?> /> Top<br />
							<input type="radio" name="rs_comment_embed_loc" value="bottom" <?php if ($rs_comment_embed == 'bottom') echo 'checked="checked"'; ?> /> Bottom
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="rs_comment_form_embed">Automatically Add Clickable Rating Stars to Comment Form</label></th>
						<td>
							<input type="checkbox" name="rs_comment_form_embed" value="checked" <?php if ($rs_comment_form_embed) echo 'checked="checked"'; ?> />
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="rs_embed_format">Use Tables or Lists for Ratings Display</label></th>
						<td>
							<input type="radio" name="rs_embed_format" value="table" <?php if (empty($rs_embed_format) || $rs_embed_format == 'table') echo 'checked="checked"'; ?> /> Table<br />
							<input type="radio" name="rs_embed_format" value="list" <?php if ($rs_embed_format == 'list') echo 'checked="checked"'; ?> /> List
						</td>
					</tr>
				</table>
				
				<br />
				<input type="submit" value="Save Settings" class="button" />
			
			</form>
		</div>		
	
		<?php
	
	}
	
	function rs_config_categories() {
	
		if (isset($_POST['submittype']) && $_POST['submittype'] == "categories") {
		
			foreach ($_POST['rs_categories'] as $id => $category)
				if (empty($category))
					unset($_POST['rs_categories'][$id]);
				else
					$_POST['rs_categories'][$id] = str_replace('"', '', stripslashes($category));
					
			update_option('rs_categories', $_POST['rs_categories']);
			
		} else if (isset($_POST['submittype']) && $_POST['submittype'] == "bulkapply") {
					
			$apply_to = $_POST['post_category'];
			$add = $_POST['rs_categories'];
						
			if (empty($add)) $add = array();
			
						$args = 'numberposts=9999';
			
			if (!empty($apply_to)) $args .= '&category=' . $apply_to;
			
			$posts = get_posts($args);
			
			foreach ($posts as $post) {
				update_post_meta($post->ID, '_rs_categories', $add);
			}

		}

		$categories = get_option('rs_categories');
	
		?>
		
		<script type="text/javascript">
		
			function removeElement(id) {
				var pd = document.getElementById('categories_td');
				var old = document.getElementById('rs_categories_' + id);
				pd.removeChild(old);
				var old = document.getElementById('rs_remove_' + id);
				pd.removeChild(old);
				var old = document.getElementById('rs_br_' + id);
				pd.removeChild(old);
			}
		
		</script>
		
		<div class="wrap"> 
			
			<div id="icon-options-general" class="icon32"><br /></div> 
			
			<h2>Rating Categories</h2>
			
			<?php if (isset($_POST['submittype']) && $_POST['submittype'] == "categories"): ?>
			<p style="font-weight: bold">Your changes have been saved.</p>
			<?php endif; ?>
					 
			<form method="post" action="">
			<input type="hidden" name="submittype" value="categories" />

			<table class="form-table"> 
				<tr valign="top">
					<th scope="row" style="width: 350px"><label for="categories">Edit Rating Categories</label></th>
					<td id="categories_td">
						<?php
							if (!empty($categories)) {
								foreach ($categories as $id => $category) {
									echo '<input type="text" id="rs_categories_' . $id . '" name="rs_categories[' . $id . ']" value="' . $category . '" /> ';
									?>
									<a href="" id="rs_remove_<?php echo $id; ?>" onclick="removeElement('<?php echo $id; ?>'); return false;" style="color: #c00">remove</a>
									<br id="rs_br_<?php echo $id; ?>" />
									<?php
								}
							}
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="blogdescription">Add a Category</label></th>
					<td><input type="text" name="rs_categories[]" value="" /></td>
				</tr>
			</table>
			
			<p>Caution: You probably shouldn't delete existing rating categories once you've allowed users to rate items on your site, 
			unless you plan to delete all comments as well. You can always add new categories. If you do delete categories, you should 
			use the bulk apply form below to make sure only the remaining categories you want to use are set to be shown on your posts.</p>
			
			<br />
			<input type="submit" value="Save Settings" class="button" />

			</form>
			
			<h2>Bulk Apply Rating Categories</h2>
			
			<?php if (isset($_POST['submittype']) && $_POST['submittype'] == "bulkapply"): ?>
			<p style="font-weight: bold">Your changes have been saved.</p>
			<?php endif; ?>
			
			<p>Use the form below to add a set of rating categories to all posts or to all posts in a post category. You can also use this form 
			to remove rating categories from all posts in a category by checking no boxes.</p>
			
			<form method="post" action="">
			<input type="hidden" name="submittype" value="bulkapply" />
			
			<table class="form-table"> 
				<tr valign="top">
					<th scope="row" style="width: 350px"><label for="categories">Edit Rating Categories</label></th>
					<td id="categories_td">
						<?php
							if (!empty($categories)) {
								foreach ($categories as $id => $category) {
									echo '<input type="checkbox" name="rs_categories[]" value="' . $id . '" /> ' . $category . '<br />';
								}
							}
						?>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="category">Apply to Posts in Category:</label></th>
					<td>
					
						<select name="post_category"> 
						 <option value="">All Categories</option> 
						 <?php 
						  $categories = get_categories(); 
						  foreach ($categories as $cat) {
						  	$option = '<option value="'.$cat->cat_ID.'">';
							$option .= $cat->cat_name;
							$option .= ' ('.$cat->category_count.')';
							$option .= '</option>';
							echo $option;
						  }
						 ?>
						</select>
					
					</td>
				</tr>
			</table>
			
			<br />
			<input type="submit" value="Save Settings" class="button" />

			</form>
						
		</div>		
		
		<?php
	
	}
	
	function rs_config_comparison() {
	
		if (!empty($_POST)) {
		
			if (isset($_POST['rs_comparison_embed_home']))
				update_option('rs_comparison_embed_home', $_POST['rs_comparison_embed_home']);
			else
				delete_option('rs_comparison_embed_home');
			
			if (isset($_POST['rs_comparison_embed_category']))
				update_option('rs_comparison_embed_category', $_POST['rs_comparison_embed_category']);
			else
				delete_option('rs_comparison_embed_category');
				
			if (isset($_POST['rs_comparison_embed_home_categories']))
				update_option('rs_comparison_embed_home_categories', $_POST['rs_comparison_embed_home_categories']);
				
			if (isset($_POST['rs_comparison_embed_categories']))
				update_option('rs_comparison_embed_categories', $_POST['rs_comparison_embed_categories']);
			
			if (isset($_POST['rs_comparison_embed_count']))
				update_option('rs_comparison_embed_count', $_POST['rs_comparison_embed_count']);
			
			if (isset($_POST['rs_comparison_embed_text']))
				update_option('rs_comparison_embed_text', $_POST['rs_comparison_embed_text']);
							
			if (isset($_POST['rs_comparison_embed_fields']))
				update_option('rs_comparison_embed_fields', $_POST['rs_comparison_embed_fields']);
				
		}
		
		$rs_comparison_embed_home = get_option('rs_comparison_embed_home');
		$rs_comparison_embed_home_categories = get_option('rs_comparison_embed_home_categories');
		$rs_comparison_embed_category = get_option('rs_comparison_embed_category');
		$rs_comparison_embed_categories = get_option('rs_comparison_embed_categories');
		$rs_comparison_embed_count = get_option('rs_comparison_embed_count');
		$rs_comparison_embed_text = get_option('rs_comparison_embed_text');
		$rs_comparison_embed_fields = get_option('rs_comparison_embed_fields');

		?>

		<div class="wrap"> 
			
			<div id="icon-options-general" class="icon32"><br /></div> 
			
			<h2>Comparison Tables</h2>			
			
			<?php if (isset($_POST['rs_comparison_embed_home_categories'])): ?>
			<p style="font-weight: bold">Your changes have been saved.</p>
			<?php endif; ?>
			
			<p>Note: The position the plugin can embed the table automatically might not look great in every theme. You can position it manually 
			by not checking off the boxes on this page, and instead adding a snippet of code to your theme file where you want the table 
			to appear. You can find examples in the <a href="http://www.wpreviewsite.com/documentation">documentation</a>.</p>
					 
			<form method="post" action="">

			<table class="form-table">
				<tr valign="top">
					<th scope="row" style="width: 350px"><label>Display a Comparison Table on Home Page</label></th>
					<td>
						<input type="checkbox" name="rs_comparison_embed_home" value="checked" <?php if ($rs_comparison_embed_home) echo 'checked="checked"'; ?> />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label>Categories To Display On Home Page</label></th>
					<td><input type="text" name="rs_comparison_embed_home_categories" value="<?php echo $rs_comparison_embed_home_categories; ?>" /><br />(Separate category IDs with commas, -1 for all)</td>
				</tr>
				<tr valign="top">
					<th scope="row" style="width: 350px"><label>Display a Comparison Table on Category Page(s)</label></th>
					<td>
						<input type="checkbox" name="rs_comparison_embed_category" value="checked" <?php if ($rs_comparison_embed_category) echo 'checked="checked"'; ?> />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label>Categories To Display Comparison Table On</label></th>
					<td><input type="text" name="rs_comparison_embed_categories" value="<?php echo $rs_comparison_embed_categories; ?>" /><br />(Separate category IDs with commas, -1 for all)</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label>Number of Posts in the Table</label></th>
					<td><input type="text" name="rs_comparison_embed_count" value="<?php echo $rs_comparison_embed_count; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label>Custom Fields to Display</label></th>
					<td><input type="text" name="rs_comparison_embed_fields" value="<?php echo $rs_comparison_embed_fields; ?>" /><br />(Separate fields with commas, ex: Price,Features,Guarantee)</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label>Text for the Visit Site link in the Table</label></th>
					<td><input type="text" name="rs_comparison_embed_text" value="<?php echo $rs_comparison_embed_text; ?>" /></td>
				</tr>
			</table>
			
			<br />
			<input type="submit" value="Save Settings" class="button" />

			</form>
						
		</div>		

		<?php	
	
	}
	
	function rs_config_gmaps() {
	
		if (!empty($_POST)) {
			if (isset($_POST['rs_map_embed']))
				update_option('rs_map_embed', true);
			else
				delete_option('rs_map_embed');
				
			update_option('rs_map_loc', $_POST['rs_map_loc']);
			update_option('rs_map_key', trim($_POST['rs_map_key']));
			update_option('rs_map_width', $_POST['rs_map_width']);
			update_option('rs_map_height', $_POST['rs_map_height']);
			update_option('rs_map_zoom', $_POST['rs_map_zoom']);
		}
		
		$rs_map_embed = get_option('rs_map_embed');
		$rs_map_loc = get_option('rs_map_loc');
		$rs_map_key = get_option('rs_map_key');
		$rs_map_width = get_option('rs_map_width');
		$rs_map_height = get_option('rs_map_height');
		$rs_map_zoom = get_option('rs_map_zoom');
		
		?>
		
		<div class="wrap"> 
			
			<div id="icon-options-general" class="icon32"><br /></div> 
			
			<h2>Google Maps</h2>			
			
			<?php if (!empty($_POST)): ?>
			<p style="font-weight: bold">Your changes have been saved.</p>
			<?php endif; ?>
			
			<p>If you are reviewing businesses or running a local directory, this feature will allow you to add a Google map 
			to your posts. To use it, fill in the settings below and add a <a href="http://codex.wordpress.org/Custom_Fields">custom field</a>
			to each post you want a map on called <b>mapaddress</b>.</p>
			
			<p>You need a Google Maps API Key for each domain you want to display maps on. You can get one 
			<a href="http://code.google.com/apis/maps/signup.html">here</a>.</p>
								 
			<form method="post" action="">

			<table class="form-table">
				<tr valign="top">
					<th scope="row" style="width: 350px"><label>Display a Google Map on Posts/Pages with <b>mapaddress</b> Custom Field</label></th>
					<td>
						<input type="checkbox" name="rs_map_embed" value="checked" <?php if ($rs_map_embed) echo 'checked="checked"'; ?> />
					</td>
				</tr>
					<tr valign="top">
						<th scope="row"><label for="rs_comment_embed_loc">Map Position</label></th>
						<td>
							<input type="radio" name="rs_map_loc" value="top" <?php if (empty($rs_map_loc) || $rs_map_loc == 'top') echo 'checked="checked"'; ?> /> Top of Post<br />
							<input type="radio" name="rs_map_loc" value="bottom" <?php if ($rs_map_loc == 'bottom') echo 'checked="checked"'; ?> /> Bottom of Post
						</td>
					</tr>
				<tr valign="top">
					<th scope="row"><label>Your Google Maps API Key</label></th>
					<td><input type="text" name="rs_map_key" value="<?php echo $rs_map_key; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label>Map Width</label></th>
					<td><input type="text" name="rs_map_width" value="<?php echo $rs_map_width; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label>Map Height</label></th>
					<td><input type="text" name="rs_map_height" value="<?php echo $rs_map_height; ?>" /></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label>Map Zoom Level (1-5)</label></th>
					<td><input type="text" name="rs_map_zoom" value="<?php echo $rs_map_zoom; ?>" /></td>
				</tr>
			</table>
			
			<br />
			<input type="submit" value="Save Settings" class="button" />

			</form>
						
		</div>	

		<?php
	
	}