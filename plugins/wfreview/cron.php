<?php
ob_start();
require_once('../../../wp-config.php');
require_once(ABSPATH.'wp-admin/includes/admin.php');
require_once('wfreview.php');

$wpdb->show_errors(true);

@ini_set('auto_detect_line_endings', true); // Fixes issues with Mac line-endings
@setlocale(LC_ALL, 'en_US.UTF-8'); // force UTF-8
@set_time_limit(3600); // 1 hour
@ini_set('memory_limit','128M');
$memory_limit = ((int)ini_get('memory_limit')) * 1048576;

$jobs = WFReview::get_scheduled_jobs();
if(!$jobs)
{
	// No output to avoid cron emails
	exit;
}

header('Content-type: text/plain');

foreach($jobs as $job)
{
	$cancelled = false;

	// Check to make sure the job still needs to be run
	// A previously running job could have taken some time to run, and meanwhile another schedule cron was run
	$job = WFReview::job_get_by_id($job->ID);
	if($job->status > 0 && $job->run_at < time())
		continue;

	echo 'Importing '.$job->source_local.'... ';

	WFReview::clear_empty_category_names();
	
	// Mark the job as processing
	WFReview::job_update_status_start($job);

	// Populate the category cache
	WFReview::populate_category_cache($job);

	// Populate the users cache
	WFReview::populate_users_cache($job);

	// Populate the tags cache
	if($_wfr_import_custom_method){
		WFReview::populate_tags_cache($job);
	}

	$columns = array();
	$created = $job->progress_posts; $updated = 0; $deleted = 0;

	$filename = $job->source_local;
	if(!empty($job->source_url))
	{
		// If the source is a URL, we need to download the data locally
		set_time_limit(3600);
		$filename = basename($job->source_url);
		copy($url, ABSPATH.'/wp-content/uploads/'.$filename);
	}
	
	$filepath = ABSPATH.'/wp-content/uploads/'.$filename;

	echo "\nStarting at line #".$job->resume_at_row." and character #".$job->resume_at_char;
	if(get_option('wfr_autosplit') > 0){ echo " with an autosplit every ".get_option('wfr_autosplit')." lines"; }

	// Open the CSV	
	$csv = wfopen($filepath);
	$header = wfgets($filepath, $csv);
	
	$comma_size = count(explode(",", $header));
	$semicolon_size = count(explode(";", $header));
	$pipe_size = count(explode("|", $header));
	$tab_size = count(explode("\t", $header));
				
	if($comma_size > $semicolon_size && $comma_size > $pipe_size && $comma_size > $tab_size){
		$separator = ",";
	} else if($semicolon_size > $pipe_size && $semicolon_size > $tab_size) {
		$separator = ";";
	} else if($pipe_size > $tab_size) {
		$separator = "|";
	} else {
		$separator = "\t";
	}
	
	$columns = str_getcsv($header, $separator);
	
	if($job->resume_at_char && $job->resume_at_char > 0){
		wfseek($filepath, $csv, $job->resume_at_char);
	}

	$i = $job->resume_at_row; // Count the loop
	while($row = wfgets($filepath, $csv))
	{
		$row = str_replace(array(chr(176)), array('&deg;'), $row);
		
		while(substr_count($row, '"')%2 == 1){
			$row = $row . wfgets($filepath, $csv);
		}
		
		$row = str_getcsv($row, $separator);
		$i++;
		
		if(count($row) > 1){		

			if(get_option('wfr_autosplit') > 0 && $i > 0 && $i % get_option('wfr_autosplit') == 0){
				echo "\nPausing this job at row #".$i." for autosplit";
				WFReview::pause_job($job, $i, wftell($filepath, $csv));
				exit;
			}
		
			// If the memory usage is over 85% of the maximum, pause the job
			if($i % 50 == 0 && memory_get_usage() > ($memory_limit * 0.85))
			{
				echo "\nUsing ".number_format(memory_get_usage(), 0)." bytes of memory (".number_format($memory_limit, 0)." bytes maximum allowed), pausing this job at row #".$i;
				WFReview::pause_job($job, $i, wftell($filepath, $csv));
				exit;
			}

			WFReview::import_post_from_row($row, $columns, $job);
			$created++;

			// Update progress
			if(($_wfr_import_custom_method && $i % 100 == 0) || (!$_wfr_import_custom_method && $i % 10 == 0))
			{
				// Job cancelled?
				$jobcheck = WFReview::job_get_by_id($job->ID);
				if(!$jobcheck)
				{
					$cancelled = true;
					break;
				}

				WFReview::job_update_progress($job, $i);

				// Extend the execution timeout
				@set_time_limit(600); // 10 mins
			}
		}
	}

	if($cancelled)
	{
		echo "cancelled.\n";
	}
	else
	{
		// Mark the job as complete
		$description = 'Imported '.$created.' posts';
		WFReview::job_update_status_complete($job, $description, $created);
		WFReview::clear_empty_category_names();

		echo "done.\n";
	}
}
unset($jobs);
echo "All jobs completed.\n";

if($_wfr_import_custom_method)
{
	echo 'Deleting blog posts... ';
	WFReview::remove_scheduled_deleted_posts();
	echo "done.\n";

	// Update all the category and tag counts
	echo 'Updating category counts... ';
	foreach($_wfr_category_cache as $term)
	{
		$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id = %d", $term) );
		$wpdb->update( $wpdb->term_taxonomy, compact( 'count' ), array( 'term_taxonomy_id' => $term ) );
	}
	echo "done.\n";

	echo 'Updating tag counts... ';
	foreach($_wfr_tags_cache as $term)
	{
		$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->term_relationships WHERE term_taxonomy_id = %d", $term) );
		$wpdb->update( $wpdb->term_taxonomy, compact( 'count' ), array( 'term_taxonomy_id' => $term ) );
	}
	echo "done.\n";
}

exit; // Done
