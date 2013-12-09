<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
 ?>
<form role="search" name="searchform" id="searchform" method="get"  action="<?php bloginfo('home'); ?>/search/">
		<li><span class="city-text-box"><input type="text" name="q" value="Search" id="q"  class="text-box-2"  onfocus="this.value='';" /></span></li>
		<li><input type="submit" class="search-btn-2"  value =""/></li>
	</form>