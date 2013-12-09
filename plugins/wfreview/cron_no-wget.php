<?php
/*
 * If your hosting provider disables the "wget" command, then call this script directly
 * from the "php" command to call the cron job via curl
 */

// Change this URL to your site!
$url = 'http://yourdomin.com/wp-content/plugins/wfreview/cron.php';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, 'WFReview');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
echo curl_exec($ch);