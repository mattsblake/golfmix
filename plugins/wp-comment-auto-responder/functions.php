<?php

function exwrapper($post_id,$excerpt_length=120, $allowedtags='<a>', $filter_type='none', $use_more_link=true, $more_link_text="(more...)", $force_more=true, $fakeit=1, $fix_tags=true, $no_more=false, $more_tag='div', $more_link_title='Continue reading this entry', $showdots=true) {
	if(preg_match('%^content($|_rss)|^excerpt($|_rss)%', $filter_type)) {
		$filter_type = 'the_' . $filter_type;
	}
	return get_exwrapper($post_id,$excerpt_length, $allowedtags, $filter_type, $use_more_link, $more_link_text, $force_more, $fakeit, $fix_tags, $no_more, $more_tag, $more_link_title, $showdots);
}

function get_exwrapper($post_id,$excerpt_length, $allowedtags, $filter_type, $use_more_link, $more_link_text, $force_more, $fakeit, $fix_tags, $no_more, $more_tag, $more_link_title, $showdots) {
	global $wpdb;
	$text = $wpdb->get_var("SELECT `post_content` FROM `".$wpdb->prefix."posts` WHERE `ID` = ".$post_id);
	$text = preg_replace( '|\[(.+?)\](.+?\[/\\1\])?|s', '', $text );

	if($excerpt_length < 0) {
		$output = $text;
	} else {
		if(!$no_more && strpos($text, '<!--more-->')) {
		    $text = explode('<!--more-->', $text, 2);
			$l = count($text[0]);
			$more_link = 1;
		} else {
			$text = explode(' ', $text);
			if(count($text) > $excerpt_length) {
				$l = $excerpt_length;
				$ellipsis = 1;
			} else {
				$l = count($text);
				$more_link_text = '';
				$ellipsis = 0;
			}
		}
		for ($i=0; $i<$l; $i++)
				$output .= $text[$i] . ' ';
	}

	if('all' != $allowedtags) {
		$output = strip_tags($output, $allowedtags);
	}

//	$output = str_replace(array("\r\n", "\r", "\n", "  "), " ", $output);

	$output = rtrim($output, "\s\n\t\r\0\x0B");
    $output = ($fix_tags) ? balanceTags($output, true) : $output;
	$output .= ($showdots && $ellipsis) ? '...' : '';
	$output = apply_filters($filter_type, $output);

	switch($more_tag) {
		case('div') :
			$tag = 'div';
		break;
		case('span') :
			$tag = 'span';
		break;
		case('p') :
			$tag = 'p';
		break;
		default :
			$tag = 'span';
	}

	if ($use_more_link && $more_link_text) {
		if($force_more) {
			$output .= ' <' . $tag . ' class="more-link"><a href="'. get_permalink($post_id) . '#more-' . $post_id .'" title="' . $more_link_title . '">' . $more_link_text . '</a></' . $tag . '>' . "\n";
		} else {
			$output .= ' <' . $tag . ' class="more-link"><a href="'. get_permalink($post_id) . '" title="' . $more_link_title . '">' . $more_link_text . '</a></' . $tag . '>' . "\n";
		}
	}

	return $output;
}

function sendmail( $to, $subject, $body = "", $from = "", $fromname = "" ) {
	if(empty($fromname)) { $fromname = get_option("blogname"); }
	if(empty($from)) { $from = 'no-reply@' . $_SERVER['SERVER_NAME']; }										 
	$message_headers = 'From: "' . $fromname . '" <'.$from.'>';
	return wp_mail($to, $subject, $body, $message_headers);
}
?>
