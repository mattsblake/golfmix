<?php
/**
 * Template Name: Mobile Rating Display
 *
**/
if(isset($_REQUEST['r'])) {
include('./wp-admin/admin-functions.php');

$rating = $_REQUEST['r'];
$rating = number_format($rating, 2, '.', '');
$rating = explode(".", $rating);
$rating[1] = '.'.$rating[1];

if(isset($_REQUEST['c'])) { $rating_cat = ucfirst($_REQUEST['c']); } else { $rating_cat = 'Overall'; }
?>
<style>
	body {
	margin:0;
	padding:0;
	}
<?php if(isset($_REQUEST['retina'])) { ?>
	.course-rating {
	background: transparent url('<?php bloginfo('template_url'); ?>/images/mobile/detail_number_back_retina.png') no-repeat;
	width: 144px;
	height: 144px;
	overflow: hidden;
	color: white;
	font-family: "Helvetica Neue", Helvetica, Arial;
	font-size: 90px;
	font-weight: bold;
	padding: 13px 20px;
	}
	.course-rating span {
	font-size: 40px;
	vertical-align: super;
	}
<?php } elseif(isset($_REQUEST['small'])) { ?>
	.course-rating {
	background: transparent url('<?php bloginfo('template_url'); ?>/images/mobile/detail_number_back_small.png') no-repeat;
	width: 50px;
	height: 50px;
	overflow: hidden;
	color: white;
	font-family: "Helvetica Neue", Helvetica, Arial;
	font-size: 33px;
	font-weight: bold;
	padding: 0px 5px;
	}
	.course-rating span {
	font-size: 15px;
	vertical-align: super;
	}
	.course-rating .rating-cat {
 	clear: both;
    font-size: 10px;
    margin-left: -5px;
    text-align: center;
    width: 100%;
    margin-top: -7px;
	}
<?php } else { ?>
	.course-rating {
	background: transparent url('<?php bloginfo('template_url'); ?>/images/mobile/detail_number_back.png') no-repeat;
    font-family: "Helvetica Neue",Helvetica,Arial;
    font-size: 45px;
    font-weight: bold;
    height: 72px;
    color: white;
    overflow: hidden;
    padding: 0 0 0 10px;
    width: 63px;
	}
	.course-rating span {
	font-size: 20px;
	vertical-align: super;
	}
	.course-rating .rating-cat {
 	clear: both;
    font-size: 10px;
    margin-left: -5px;
    text-align: center;
    width: 100%;
    margin-top: -3px;
	}
<?php } ?>
<?php 
if($rating[0]=='0') { 
	$rating[0] = 'N/A'; 
	$rating[1] = '';
	$rating_cat = '';
	
	if(isset($_REQUEST['small'])) { 
?>
	.course-rating {
 	font-size: 21px;
    height: 39px;
    padding: 12px 0 0 5px;
    width: 46px;
    }
<?php } else { ?>
	.course-rating { 
 	font-size: 26px;
    height: 65px;
    padding: 18px 0 0 12px;
    width: 63px;
	}
<?php }
} ?>
</style>
<div class="course-rating"><?php echo $rating[0]; ?><span><?php echo $rating[1]; ?></span><div class="rating-cat"><?php echo $rating_cat; ?></div></div>
<?php } else { exit; }?>