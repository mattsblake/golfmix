<?php
	$review = $dom->createElement("review");
	$reviews->appendChild($review);
		
		// create attribute node
		$r_id = $dom->createAttribute("ID");
		$review->appendChild($r_id);
		$r_id->appendChild($dom->createTextNode($comment->comment_ID));	
		
		$r_author = $dom->createElement("author");
		$review->appendChild($r_author);
		$r_author->appendChild($dom->createTextNode($comment->comment_author));
		
			$avatar = get_avatar( $comment->comment_author_email, 101 );
			if(!strpos('/avatars',$avatar)) { $avatar = str_replace('/avatars','http://golfmix.com/avatars',$avatar); }
		
			$r_avatar = $dom->createElement("avatar");
			$r_author->appendChild($r_avatar);
			$r_avatar->appendChild($dom->createTextNode($avatar));				
	
			$r_plays = $dom->createElement("plays");
			$r_author->appendChild($r_plays);
			$r_plays->appendChild($dom->createTextNode(trim(get_cimyFieldValue($comment->user_id, 'PLAYS'))));	
	
			$r_score = $dom->createElement("average_score");
			$r_author->appendChild($r_score);
			$r_score->appendChild($dom->createTextNode(trim(get_cimyFieldValue($comment->user_id, 'AVERAGE_SCORE'))));					
	
		$r_date = $dom->createElement("date");
		$review->appendChild($r_date);
		$r_date->appendChild($dom->createTextNode($comment->comment_date));			
	
		$r_content = $dom->createElement("content");
		$review->appendChild($r_content);
		$r_content->appendChild($dom->createTextNode($comment->comment_content));
		
		$rating = $dom->createElement("ratings");
		$review->appendChild($rating);	
	
			$ratings = get_comment_ratings($comment->comment_ID);
			//print_r($ratings);
	
			$value = $dom->createElement("value");
			$rating->appendChild($value);
			$value->appendChild($dom->createTextNode($ratings["Value"]));
	
			$conditions = $dom->createElement("course_conditions");
			$rating->appendChild($conditions);
			$conditions->appendChild($dom->createTextNode($ratings["Course Conditions"]));
	
			$design = $dom->createElement("design");
			$rating->appendChild($design);
			$design->appendChild($dom->createTextNode($ratings["Design"]));
	
			$amenities = $dom->createElement("amenities");
			$rating->appendChild($amenities);
			$amenities->appendChild($dom->createTextNode($ratings["Amenities"]));
	
			$pace = $dom->createElement("pace_of_play");
			$rating->appendChild($pace);
			$pace->appendChild($dom->createTextNode($ratings["Pace of Play"]));
	
			$overall = $dom->createElement("overall_experience");
			$rating->appendChild($overall);
			$overall->appendChild($dom->createTextNode($ratings["<strong>Overall Experience</strong>"]));	
?>