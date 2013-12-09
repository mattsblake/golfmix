<?php
/**
 * Template Name: Search
 */

get_header(); ?>

<?php
global $page, $paged;
$paged = max( $paged, $page );

global $detect;
$detect = new Mobile_Detect();
if ($detect->isMobile() && !$detect->isIpad()) { 

	include('search-setup.php');
	
	if ( $search_query->have_posts() ) : 
	while ( $search_query->have_posts() ) : $search_query->the_post();			
				include('search-course-setup.php');
				$total = count($total);
				if(isset($_REQUEST['map'])) { include('result-map.php'); }
				else { include('result-course-mobile.php'); }
 	endwhile;
	?> 	
		 	<div class="post_nav">
				<?php if($paged - 1 !== 0) { $previouspage = $paged-1; ?><a href="<?php echo get_bloginfo('url').'/search/page/'.$previouspage.'/?page='.$previouspage; ?><?php if(isset($_REQUEST['q'])) { echo '&q='.$_REQUEST['q']; } ?><?php if(isset($_REQUEST['lat'])) { echo '&lat='.$_REQUEST['lat']; } ?><?php if(isset($_REQUEST['lon'])) { echo '&lon='.$_REQUEST['lon']; } ?><?php if(isset($_REQUEST['map'])) { echo '&map=1'; } ?>" class="next-page">previous page</a><?php } ?>
				<?php if($paged < $search_query->max_num_pages) { $nextpage = $paged+1; ?><a href="<?php echo get_bloginfo('url').'/search/page/'.$nextpage.'/?page='.$nextpage; ?><?php if(isset($_REQUEST['q'])) { echo '&q='.$_REQUEST['q']; } ?><?php if(isset($_REQUEST['lat'])) { echo '&lat='.$_REQUEST['lat']; } ?><?php if(isset($_REQUEST['lon'])) { echo '&lon='.$_REQUEST['lon']; } ?><?php if(isset($_REQUEST['map'])) { echo '&map=1'; } ?>" class="next-page">next page</a><?php } ?>
			</div> 	
 	<?php
 	endif;	

} else { ?>


<script language="javascript" type="text/javascript">
function submitForm(action){
document.getElementById("hdnvalue").value = action ;
document.searching12.submit() ;

}

</script>

<?php $beta = $_REQUEST['beta']; ?>

<?php include('search-setup.php'); ?>

			<?php 
			//if(isset($_REQUEST['debug'])) { print_r($search_query); }

			global $pstart; global $count; global $pgcount;
			$total = count($total);

			$search_term = $_REQUEST['cs-all-0'];
			if($search_term == '') { $search_term = wp_specialchars($_GET['s']);}
			if($search_term == '') { $search_term = wp_specialchars($_GET['q']);}
			if($search_term == '') { $search_term = wp_specialchars($_GET['zip']);}
			if($search_term == '') { $search_term = wp_specialchars($_GET['city']);}
			if($search_term == '') { $search_term = 'nearby';}
			
			$pstart = $paged*10-9;
			if($total < 10 || $total-$paged*10 < 10 ) { $pgcount = $total; } else { $pgcount = $paged * 10; }
            ?>

			<div id="content">
			<form method="post" action="" name="">
			<div id="search-result-for">
					<div class="search-1">Search Results for: <em>"<?php echo $search_term; ?>"</em></div>
					<div class="filters"></div>
					<div class="paging"><?php echo $pstart; ?> to <?php echo $pgcount; ?> of <?php echo $total; ?>
					<?php if($beta) { ?> - Jump to Page:
					<form action="">
						<select>
							<option>10</option>
							<option>20</option>
							<option>30</option>
						</select>
					</form>
					<?php } ?>
				</div>
				<?php if($beta) { ?>
					<div class="clear"></div>
					<div class="search-options">
					<h4>refine your search</h4>
					<div class="sort">
							<h5>Sort by :</h5>
							<ul>
							<form action="" method="post" name="order_record" >							
									<li><a href="#" onClick="submitForm('123');" class="overall">>> Best Overall Rating</a></li>
								
								
									<li><a href="#" onClick="submitForm('5');">Best Pace of Play</a></li>
									
								
									<li><a href="#" onClick="submitForm('3');">Best Design</a></li>
									
								
									<li><a href="#;" onClick="submitForm('1');">Best Value</a></li>
									
								
									<li><a href="#" onClick="submitForm('2');">Best Condition</a></li>
									
								
									<li><a href="#" onClick="submitForm('4');">Best Ammenities</a></li>
									
								</form>
						</ul>
						</div>
						
					<div class="cities">
							<h5>Cities :</h5>
							<ul>
							<li>
									<input type="checkbox" name="city1" value="Scottsdale" />
									<a href="#">Scottsdale</a></li>
							<li>
									<input type="checkbox" name="city2" value="Phenix" />
									<a href="#">Phenix</a></li>
						</ul>
						</div>
					<div class="distance">
							<h5>Distance:</h5>
							<ul>
							<li>
									<input type="checkbox" name="distance1" value="5 miles" />
									<a href="#">5 miles</a></li>
							<li>
									<input type="checkbox" name="distance2" value="10 miles" />
									<a href="#">10 miles</a></li>
							<li>
									<input type="checkbox" name="distance3" value="25 miles" />
									<a href="#">25 miles</a></li>
							<li>
									<input type="checkbox" name="distance4" value="50 miles" />
									<a href="#">50 miles</a></li>
						</ul>
						</div>
					<div class="feature">
							<h5>Features :</h5>
							<ul>
							<li>
									<input type="checkbox" name="feature1" value="Driving Range" />
									<a href="#">Driving Range</a></li>
							<li>
									<input type="checkbox" name="feature2" value="Clubhouse" />
									<a href="#">Clubhouse</a></li>
							<li>
									<input type="checkbox" name="feature3" value="Practice Greens" />
									<a href="#">Practice Greens</a></li>
							<li>
									<input type="checkbox" name="feature4" value="Restaurant" />
									<a href="#">Restaurant</a></li>
						</ul>
						</div>
					<div class="feature feature1">
							<h5></h5>
							<ul>
							<li>
									<input type="checkbox" name="feature5" value="Snack Bar" />
									<a href="#">Snack Bar</a></li>
							<li>
									<input type="checkbox" name="feature6" value="Cart Service" />
									<a href="#">Cart Service</a></li>
							<li>
									<input type="checkbox" name="feature7" value="GPS Carts" />
									<a href="#">GPS Carts</a></li>
						</ul>
						</div>
					<div class="price">
						<h5>Price:</h5>
							<ul>
							<li><input type="checkbox" name="price1" value="$$$$" /><a href="#">$$$$</a></li>
							<li><input type="checkbox" name="price2" value="$$$" /><a href="#">$$$</a></li>
							<li><input type="checkbox" name="price3" value="$$" /><a href="#">$$</a></li>
							<li><input type="checkbox" name="price4" value="$" /><a href="#">$</a></li>
						</ul>
					</div>
				</div>
					<input type="submit" value="Filter" name="Filter" class="filter-btn" />
				<?php } ?>
				</div>
				</form>
				
				
				
				
				
			<div id="left-col">
			
<?php if ( $search_query->have_posts() ) : 
	//	if($search_query !== ''):
?>

				<h1 class="page-title"><?php printf( __( '', 'twentyten' ), '<span>' . get_search_query() . '</span>' ); ?></h1>

	<?php $count = 0; ?>

	<?php while ( $search_query->have_posts() ) : $search_query->the_post();
	
				include('search-course-setup.php');	

				include('result-map.php');

	  endwhile; ?>

	<?php $count = 0; ?>

	<?php while ( $search_query->have_posts() ) : $search_query->the_post();	
		// foreach ($search_query as $post): setup_postdata($post);
		
				include('search-course-setup.php');
				 				
				include('result-course.php');		
		
				
	// endforeach;	
	  endwhile; ?>
				<!--end-->
	
 	<div class="post_nav">
		<?php if($paged - 1 !== 0) { $previouspage = $paged-1; ?><a href="<?php echo get_bloginfo('url').'/search/page/'.$previouspage.'/?q='.$_REQUEST['q'].'&page='.$previouspage; ?>" class="next-page">previous page</a><?php } ?>
		<?php if($paged < $search_query->max_num_pages) { $nextpage = $paged+1; ?><a href="<?php echo get_bloginfo('url').'/search/page/'.$nextpage.'/?q='.$_REQUEST['q'].'&page='.$nextpage; ?>" class="next-page">next page</a><?php } ?>
	</div> 	
				
				
			
<?php else : ?>
				<div id="post-0" class="post no-results not-found">
					<h2 class="entry-title"><?php _e( 'Nothing Found', 'twentyten' ); ?></h2>
					<div class="entry-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyten' ); ?></p>
						
					</div>
				</div>  
<?php endif; ?>
			</div> 
					
				</div>

			<?php get_sidebar(); ?>
				
			<div class="clear"></div>
		</div>
			<!--/content--> 
			
		</div>

<form name="searching12" method="post" action="" >
	<input type="hidden" name="hdnvalue" id="hdnvalue"  />
</form>
<?php
}

get_footer(); ?>
