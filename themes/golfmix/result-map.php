<?php 
if($pstart > 10 && $count == 1) { $total = $total - $pstart + 1; }

if(isset($_REQUEST['debug'])) { echo 'map-count:'.$count.'total'.$total;}

if($count == 1) { ?>
<script type="text/javascript">
  function initialize() {
	var locations = [
		<?php 
		include('map-script-course.php');
		if($count==$total) { 
			include('map-script-end.php');
		} else { 
			echo ','; 
		}
} elseif($count == 10 || $count == $total) {
	include('map-script-course.php');
	include('map-script-end.php');
} else {
	include('map-script-course.php');
	echo ',';
} ?>