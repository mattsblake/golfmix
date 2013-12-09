<?php
/* Last updated with phpFlickr 1.3.2
 *
 * This example file shows you how to call the 100 most recent public
 * photos.  It parses through them and prints out a link to each of them
 * along with the owner's name.
 *
 * Most of the processing time in this file comes from the 100 calls to
 * flickr.people.getInfo.  Enabling caching will help a whole lot with
 * this as there are many people who post multiple photos at once.
 *
 * Obviously, you'll want to replace the "<api key>" with one provided 
 * by Flickr: http://www.flickr.com/services/api/key.gne
 */

require_once("phpFlickr.php");
$f = new phpFlickr("37eb5032134f95f57d29b3b363d489f9");

$recent = $f->photos_search(array("text"=>"'stone+creek+golf+club'","sort"=>"relevance"));

foreach ($recent['photo'] as $photo) {
	$pcount = $pcount + 1;
	if($pcount < 5) {
		$pid = $photo['id'];
		$pserver = $photo['server'];
		$pfarm = $photo['farm'];
		$ptitle = $photo['title'];
		$psecret = $photo['secret'];
?>
<li class="ui-tabs-nav-item ui-tabs-selected" id="nav-fragment-<?php echo $pcount;?>"><a href="#fragment-<?php echo $pcount;?>"> <img src="http://farm<?php echo $pfarm; ?>.static.flickr.com/<?php echo $pserver; ?>/<?php echo $pid; ?>_<?php echo $psecret; ?>_s.jpg" alt="" border="0"  style="height:44px;width:48px;"/><span><?php echo $ptitle; ?></span></a></li>
<?php }
}
?>
