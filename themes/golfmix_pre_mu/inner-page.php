<?php
/**
 * Template Name: Inner page Template
 *
 * A custom page template without sidebar.
 *
 * The "Template Name:" bit above allows this to be selectable
 * from a dropdown menu on the edit page screen.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

get_header(); ?>


		<!--content-->
			<div id="content">
			<div id="left-col">
			<div class="tab-container-main">
					<div id="tab-detail-box-1">
						<div class="reviews-comment-top"></div>
						<div class="reviews-comment-cen">
							<div class="tab-main">
								<ul>
									<li><a class="active" href="JavaScript:;" onclick="showIt('tab-data1')"><span>Overview</span></a></li>
									<li><a href="JavaScript:;" onclick="showIt('tab-data2')"><span>Photos</span></a></li>
									<li><a href="JavaScript:;" onclick="showIt('tab-data3')"><span>Reviews</span></a></li>
									<li><a href="JavaScript:;" onclick="showIt('tab-data4')"><span>Amenities</span></a></li>
									<li><a href="JavaScript:;" onclick="showIt('tab-data5')"><span>Add a Review</span></a></li>
								</ul>
								<a href="#"><img class="tab-img" src="<?php bloginfo( 'template_url' ); ?>/images/tab-like-img.gif" alt="" /></a> 
							</div>
							<br class="clear" />
							<div class="tab-detail-1">
							<div class="detail-holder" id="tab-data1">
							<div class="detail-holder-top-row">
							<div class="top-row-left-col">
									
<div id="featured">
									
	<ul class="ui-tabs-nav">
	<?php /*?><li class="ui-tabs-nav-item ui-tabs-selected" id="nav-fragment-1"><a href="#fragment-1">
	<img src="images/inner-thumb-1.jpg" alt="" border="0" /><span>15+ Excellent High Speed Photographs</span></a></li><?php */?>
	
	<?php
	$page_id = $post->ID;
		global $wpdb;
		$gallery = $wpdb->get_results("SELECT pageid,path,filename ,description,alttext

										FROM wp_ngg_gallery

										INNER JOIN wp_ngg_pictures

										ON wp_ngg_gallery.gid=wp_ngg_pictures.galleryid  where pageid=$page_id");
		  ?>
	
	<?php if ($gallery) :$counter=0;
		$innercount = 1 ;
					foreach ($gallery as $galry) :?>
		<li class="ui-tabs-nav-item ui-tabs-selected" id="nav-fragment-<?php echo $innercount ;?>">
              
               <a href="#fragment-<?php echo $innercount ;?>"><img src="<?php echo get_option('home').'/'.$galry->path."/".$galry->filename; ?>" width="48" height="44" class="image<?php echo $counter;?>">
            </a> </li> 
    <?php $innercount++ ; $counter++; endforeach; endif; ?> 
	
	</ul>
	
	
		    <!-- First Content -->
			<?php
	    $page_id = $post->ID;
		global $wpdb;
		$innercount2 =1 ;
		$gallery = $wpdb->get_results("SELECT pageid,path,filename ,description,alttext

										FROM wp_ngg_gallery

										INNER JOIN wp_ngg_pictures

										ON wp_ngg_gallery.gid=wp_ngg_pictures.galleryid  where pageid=$page_id");
		  ?>
		  <?php if ($gallery) :$counter=0;
	
					foreach ($gallery as $galry) :?>
					
	   <div id="fragment-<?php echo $innercount2 ;?>" class="ui-tabs-panel" style="">
			  <img src="<?php echo get_option('home').'/'.$galry->path."/".$galry->filename; ?>" width="363" height="225">
			
			 <div class="info" >
				<h2><a href="#" >15+ Excellent High Speed Photographs</a></h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla tincidunt condimentum lacus. Pellentesque ut diam....<a href="#" >read more</a></p>
			 </div>
	    </div>
		<?php $innercount2++ ; $counter++; endforeach; endif; ?> 
		 <?php /*?>
			    <div id="fragment-2" class="ui-tabs-panel" style="">
			<img src="<?php bloginfo( 'template_url' ); ?>/images/inner-slider-image-1.jpg" alt="" />
			 <div class="info" >
				<h2><a href="#" >15+ Excellent High Speed Photographs</a></h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla tincidunt condimentum lacus. Pellentesque ut diam....<a href="#" >read more</a></p>
			 </div>
	    </div><?php */?>
		
		


	</div>



									</div>
									<div class="top-row-right-col">
									
									<div class="reviews-tab">
										<h5><?php the_title();?></h5>
										<img src="<?php bloginfo( 'template_url' ); ?>/images/inner-star-7.gif" alt="" class="star-img-cl" />
										<span class="star-spa-review">Reviews (5)</span>
										<br class="clear" />
								        <?php getCustomField('Block #9'); ?>
										<!--<li>15215 N Kierland Blvd</li>
										<li>Ste 190, Pearl side</li>
										<li>Scottsdale, AZ 85254</li>
										<li>(480) 998-0202</li>
										<li><a href="#">www.chloescorneraz.com</a></li>-->
									
									</div>
									
                                    	
										<br class="clear" />
										
                                    </div>
								</div>
								<br clear="all" />
								<div class="detail-holder-bottom-row">
                                	<div class="cources-detail-cont">
                                    	<span class="course-detail-heading">Course Details :</span>
                                        <br class="clear" />
                                    	<ul>
                                            <li><span>Tee Times :</span><?php getCustomField('Block #1'); ?></li>
                                            <li><span>Yardage :</span><?php getCustomField('Block #2'); ?></li>
                                            <li><span>Green Fees :</span><?php getCustomField('Block #3'); ?> </li>
                                            <li><span>Course Designer :</span><?php getCustomField('Block #4'); ?></li>   
                                            <li><span>Facilities :</span><?php getCustomField('Block #5'); ?></li>
                                            <li><span>Par :</span><?php getCustomField('Block #5'); ?></li>
                                            <li><span>Holes :</span><?php getCustomField('Block #7'); ?></li> 
                                        </ul>
                                    </div>
                                    <div class="rating-cont">
                                    	<span class="ratings-heading">Ratings :</span>
										<ul>
										<li><img src="<?php bloginfo( 'template_url' ); ?>/images/inner-rating-1.gif" alt="" /><small>Value :</small>
										<span><img src="<?php bloginfo( 'template_url' ); ?>/images/yellow-inner-star.gif" alt="" /></span></li>
										
										<li><img src="<?php bloginfo( 'template_url' ); ?>/images/inner-rating-2.gif" alt="" /><small>Course conditions  :</small>
										<span><img src="<?php bloginfo( 'template_url' ); ?>/images/yellow-inner-star.gif" alt="" /></span></li>
										
										<li><img src="<?php bloginfo( 'template_url' ); ?>/images/inner-rating-3.gif" alt="" /><small>Design :</small>
										<span><img src="<?php bloginfo( 'template_url' ); ?>/images/yellow-inner-star.gif" alt="" /></span></li>
										
										<li><img src="<?php bloginfo( 'template_url' ); ?>/images/inner-rating-4.gif" alt="" /><small>Amenities :</small>
										<span><img src="<?php bloginfo( 'template_url' ); ?>/images/yellow-inner-star.gif" alt="" /></span></li>
										
										<li><img src="<?php bloginfo( 'template_url' ); ?>/images/inner-rating-5.gif" alt="" /><small>Pace of play :</small>
										<span><img src="<?php bloginfo( 'template_url' ); ?>/images/yellow-inner-star.gif" alt="" /></span></li>
										
										</ul>
                                    </div>
                                </div>
                                <br clear="all" />
								<div class="quick-fact-box">
									<a href="#" class="quick-fact">quick facts</a>
									<p><?php getCustomField('Block #8'); ?></p>
									<br class="clear" />
								</div>
                                <div class="reviews-box">
                                	<ul>
                                    	<li><a href="#" class="write-review">write a review</a></li>
                                        <li><a href="#" class="print-review">print this review</a></li>
                                    </ul>
                                </div>
                                <div class="social-links-container">
                                	<ul>
                                    	<li><a href="#" class="digsby">digsby</a></li>
                                        <li><a href="#" class="facebook-links">facebook</a></li>
                                        <li><a href="#" class="rss-links">rss</a></li>
                                        <li><a href="#" class="twitter-links">twitter</a></li>
                                    </ul>
                                </div>
							</div>
							
							
							
							
							
							
							<div class="detail-holder" id="tab-data2" style="display:none;">
							Tab 2
							</div>
							
							<div class="detail-holder" id="tab-data3" style="display:none;">
							Tab 3
							</div>
							
							<div class="detail-holder" id="tab-data4" style="display:none;">
							Tab 4
							</div>
							
							<div class="detail-holder" id="tab-data5" style="display:none;">
							Tab 5
							</div>
							
							
							
							  <script type="text/javascript">
		lastone=document.getElementById("tab-data1"); 
		function showIt(lyr) 
		{ 
		if (lastone!='empty') lastone.style.display='none'; 
			lastone=document.getElementById(lyr); 
			lastone.style.display='block';
		}
	</script>
							
							
							
							</div>
							<br class="clear" />
						</div>
						<div class="reviews-comment-bot"></div>	
						<br class="clear" /> 
					</div>
						<div class="inner-page-search-box">
							<span class="inner-page-search"><input type="text" value="Search Reviews" onfocus="if(this.value=='Search Reviews'){this.value=''};" onblur="if(this.value==''){this.value='Search Reviews'};" /></span>
							<span><input type="submit" value="" class="inner-page-search-btn" /></span>
						</div>
							<br class="clear" />

					<br class="clear" /> 
					</div>
					
					<div class="reviews-comment-1">
					<div class="reviews-comment-top"></div>
					<div class="reviews-comment-cen">
							<div class="inner-reviwes-left">
							<h3>5 reviews for Wilow Brook's Golf Course</h3>
						</div>
							<div class="inner-reviews-right">
							<ul>
									<li>Sort by:</li>
									<li><a class="active" href="#">Trend</a></li>
									<li><a href="#">Date</a></li>
									<li><a href="#">Rating</a></li>
									<li><a href="#">Elites'</a></li>
									<li class="no-sap"><a href="#">Facebook Friends'</a></li>
								</ul>
						</div>
							<br class="clear" />
							
							<?PHP if(function_exists('register_sidebar')&&dynamic_sidebar('Latest Reviews')){} ?>
						</div>
					<div class="reviews-comment-bot"></div>
				</div>
					<div class="inner-page-all-reviews-container">
					<div class="inner-reviwes-left">
							<h3>All Reviews <span>(5)</span></h3>
						</div>
					<div class="inner-reviews-right">
							<ul>
							<li>Sort by</li>
							<li>[<a class="active" href="#">Date</a>]</li>
							<li>[<a href="#">Rating</a>]</li>
						</ul>
						</div>
					<br class="clear" />
				</div>
				
					<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
									<?php the_content();?>
									<?php comments_template( '', true ); ?>
									
									<?PHP //if(function_exists('register_sidebar')&&dynamic_sidebar('Comment widget')){} ?>
									<?php endwhile; // end of the loop. ?>
									

				</div>
				</div>
			<div id="right-col">
					<div class="daily-box-container">
					<div class="inner-map-area">
							<div id="map_canvas" style="width: 427px; height:416px"></div>
							<a href="#" class="map-anker">View Larger Map/Directions >></a> </div>
					<div class="box-holder">
							<div class="daily-box-top">
							<h3>top  courses</h3>
						</div>
							<div class="daily-box-bottom-2">
							<div class="top-courses-box">
							<ul>
								<?php query_posts('cat=39'); ?>

							    <?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

								
									<li>
										<div class="top-courses-col-1">
										<?php  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
										<img src="<?php echo $image[0]; ?>" alt="" border="0" /></div>
										<div class="top-courses-col-2">
											<h5><?php the_title(); ?></h5>
											<p><?php getCustomField('Block #9'); ?></p>
										</div>
										<div class="top-courses-col-3">
											<ul>
												<li><a href="<?php getCustomField('rsslink'); ?>" class="rss-link-3">rss</a></li>
												<li><a href="<?php getCustomField('emaillink'); ?>" class="email-link-3">email</a></li>
												<li><a href="<?php getCustomField('refresh'); ?>" class="refresh-link-3">refresh</a></li>
												<li><a href="<?php getCustomField('teetime'); ?>" class="tee-time-btn-3">tee time</a></li>
											</ul>
										</div>
									</li>
									<?php endwhile ?>
								</ul>
									
								</div>
						</div>
							<br class="clear" />
						</div>
					<div class="box-holder">
							<div class="daily-box-top">
							<h3>sponsored ads</h3>
						</div>
							<div class="daily-box-bottom-2">
							<div class="top-courses-box"> <img src="<?php bloginfo( 'template_url' ); ?>/images/sponsor-ad-image.jpg" alt="" border="0" /> </div>
						</div>
							<br class="clear" />
						</div>
				</div>
				</div>
			<div class="clear"></div>
		</div>
			<!--/content--> 
			
		</div>
	<?php get_footer(); ?>
