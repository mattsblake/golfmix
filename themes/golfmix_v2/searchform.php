<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
 ?>
 <?php global $market_name; ?>
			<form method="get" id="writeareview" class="custom_search widget custom_search_custom_fields__search" action="<?php bloginfo('url');?>/golf-courses/" autocomplete="off">
				<div class="searchform-params">
				<div class="TextField"><div class="searchform-param"><label class="searchform-label">Find a Golf Course in <?php echo $market_name; ?></label><span class="searchform-input-wrapper"><input name="q" id="q" value="Course, City or Zip"></span></div></div>
				</div>
				<div class="searchform-controls">
					<input type="submit" name="search" value="Search">
				</div>
			</form>
			<script>
				$("#writeareview #q").focus( function() {
					$(this).val('');	
				});
			</script>