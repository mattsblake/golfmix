<?php

/*
Plugin Name: Timeago Date/Time
Plugin URI: http://wpsplash.com/wordpress-timeago-fuzzy-dates-plugin/
Description: Twitter-like "x days ago", "y hours ago" date and times. Uses microformats!
Author: Asad Khan
Version: 1.0
Author URI: http://wpsplash.com
*/

/**
Dual GPL / MIT license. 

Copyright (c) 2010 Asad Khan

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.

*/

class wpTimeAgo
{
	var $_defaultFormat = 'l, F jS, Y h:i a';
	var $_gmtOffset = '';

	function wpTimeAgo() {

		// get the GMT offset
		$offset = get_option('gmt_offset');
		if ($offset == 0) {

			// check the server timezone and if it's PHP5, use it
			$offset = date('P');
			if ($offset) {
				$this->_gmtOffset = ' GMT ' . $offset;
			}

			return;
		}

		$offset = ($offset > 0 ? '+' . $offset : $offset);	
		$this->_gmtOffset = ' GMT ' . $offset;
	}

	function headScript() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('timeago', WP_PLUGIN_URL . '/timeago/jquery.timeago.js');
	}

	function headCss() {
		echo '<link rel="stylesheet" href="'. WP_PLUGIN_URL .'/timeago/timeago.css" type="text/css" />' . "\r\n";
	}

	function time($date = '') 
	{
		global $post;

		if ($date == '') {
			return;
		}

		if (preg_match('#^[0-9]+:[0-9]+(|\sam|\spm)$#i', $date)) {
			return $date;
		}

		return "<abbr class='timeago' title='{$post->post_date_gmt}Z'>". mysql2date($this->_defaultFormat, $post->post_date) . $this->_gmtOffset ."</abbr>";
	}

	function commentDate($format = '') 
	{
		global $comment;
		
		return "<abbr class='timeago' title='{$comment->comment_date_gmt}Z'>". mysql2date($this->_defaultFormat, $comment->comment_date) . $this->_gmtOffset ."</abbr>";
	}
}

$timeAgo = new wpTimeAgo();

function the_time_ago($format = '')
{
	global $post, $comment, $timeAgo;

	// use comments date if available
	$theDate = ($comment->comment_date ? $comment->comment_date : $post->post_date);

	// have a format?
	if ($format == '') {
		$date = mysql2date(($timeAgo->_defaultFormat ? $timeAgo->_defaultFormat : get_option('date_format')), $theDate);
	}
	else {
		$date = mysql2date($format, $theDate);
	}

	echo "<abbr class='timeago' title='{$post->post_date_gmt}Z'>{$date}{$timeAgo->_gmtOffset}</abbr>";
}

add_filter('the_time', array($timeAgo, 'time'), 100);

// for comments
add_filter('get_comment_date', array($timeAgo, 'commentDate'), 100);

add_action('init', array($timeAgo, 'headScript'), 100);
add_action('wp_head', array($timeAgo, 'headCss'), 100);



