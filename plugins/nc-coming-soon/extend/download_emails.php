<?php
require_once( dirname(__FILE__) . '../../../../../wp-load.php');
global $wpdb;
$table = $wpdb->prefix.'coming_soon_emails';
$query = $wpdb->get_results("SELECT email_address FROM $table");
$file_name = "email_subscribers.csv";
header("Content-type: text/x-csv");
header("Content-Disposition: attachment; filename=$file_name");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Pragma: no-cache");
header("Expires: 0");
foreach ($query as $data){
    echo $data->email_address .","."\t\n";
}
?>
