<?php
// Deal of the Week

get_header(); ?>

		<div id="content">
      <div class="content-data">

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>


				<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				
					 <?php
					$deal_company = get_post_meta($post->ID, 'deal_company', true);
					$deal_logo = get_post_meta($post->ID, 'deal_logo', true);
					$deal_image = get_post_meta($post->ID, 'deal_image', true);
					$deal_link = get_post_meta($post->ID, 'deal_link', true);
					$deal_video = get_post_meta($post->ID, 'deal_video', true);
					$deal_promo_code = get_post_meta($post->ID, 'deal_promo_code', true);
					$deal_retail = get_post_meta($post->ID, 'deal_retail', true);
					$deal_price = get_post_meta($post->ID, 'deal_price', true);
					if($deal_retail !== '' && $deal_price !== '') { 
						$deal_discount = $deal_price/$deal_retail; 
						$deal_discount = number_format($deal_discount, 2, '.', '');
						$deal_discount = str_replace('0.','',$deal_discount); 
						$deal_discount.='%';
					}
					?>
				
					<?php 
					global $detect;
					$detect = new Mobile_Detect();
					if ($detect->isMobile() && !$detect->isIpad()) { ?>
						<div class="recent-reviews"><a href="<?php echo $_SERVER['HTTP_REFERER']; ?>" style="display:none;">&#171; Back</a><h1><?php the_title(); ?></h1></div>
					<?php } else { ?>
						<h1 class="entry-title"><?php if($deal_logo !== '') { ?><img src="<?php echo $deal_logo; ?>" class="deal-logo"/><?php } ?>
<?php the_title(); ?></h1>
					<?php } ?>
					
					<div class="entry-meta">
						Deal activated on <?php the_date('l F jS, Y'); ?>
					</div><!-- .entry-meta -->
					
					<div class="entry-content">
						<?php include('share-buttons.php'); ?>
						
						<?php if($deal_discount !== '' && $turnoff == 'true') { ?><div class="deal-percent"><?php echo $deal_discount; ?> off!</div><?php } ?>
						<?php if($deal_video !== '') { ?><div class="deal-video"><iframe width="673" height="372" src="<?php echo $deal_video; ?>" frameborder="0" allowfullscreen></iframe></div>
						<?php } elseif($deal_image !== '') { ?><div class="deal-image"><img src="<?php echo $deal_image; ?>" /></div><?php } ?>
												
						<div id="deal-content">
							<?php the_content(); ?>
							<strong><?php echo 'Promo code: '.$deal_promo_code;?></strong>
							<div class="clear"></div>
							<a href="<?php echo $deal_link; ?>" class="deal-more" style="width: 245px;">Buy Now</a>
						</div>
					</div><!-- .entry-content -->

					<div class="entry-utility">
						<?php edit_post_link( __( 'Edit', 'twentyten' ), '<span class="edit-link">', '</span>' ); ?>
					</div><!-- .entry-utility -->

				</div><!-- #post-## -->

				<div id="nav-below" class="navigation">
					<div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentyten' ) . '</span> %title' ); ?></div>
					<div class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentyten' ) . '</span>' ); ?></div>
				</div><!-- #nav-below -->


<?php endwhile; // end of the loop. ?>

</div>

		<?php get_sidebar(); ?>

      <br class="clear" />
    </div>
    <!--/content-->

<?php get_footer(); ?>
