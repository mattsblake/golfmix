			<div class="daily-box-top"><h3>Featured Offer</h3></div>

			<div class="daily-box-bottom-2">
				<?php 
				//if($blog_id !== '1') { global $switched; switch_to_blog(1); }

				$count = 0;
				$args = array( 'numberposts' => 1, 'offset'=> 0, 'post_type' => 'deals' );
				$deals = get_posts( $args );
				foreach( $deals as $post ) :	setup_postdata($post);
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
					<?php if($deal_logo !== '') { ?><img src="<?php echo $deal_logo; ?>" class="deal-logo"/><?php } ?>
					<div class="deal-title"><?php the_title(); ?></div>
					<?php if($deal_discount !== '' && $turnoff == 'true') { ?><div class="deal-percent"><?php echo $deal_discount; ?> off!</div><?php } ?>
					<?php if($deal_video !== '') { ?><div class="deal-video"><iframe width="100%" height="185" src="<?php echo $deal_video; ?>" frameborder="0" allowfullscreen></iframe></div>
					<?php } elseif($deal_image !== '') { ?><div class="deal-image"><img src="<?php echo $deal_image; ?>" /></div><?php } ?>
					
					<?php if($deal_promo_code !== '') { ?><div class="deal-promo"><em><strong><?php echo 'Promo code: '.$deal_promo_code;?></strong></em><a href="<?php the_permalink(); ?>" class="deal-more" id="more" style="width: 104px;float: right;margin-top: -11px;">Learn More</a></div><?php } else { ?>
					<a href="<?php the_permalink(); ?>" class="deal-more" id="more">Learn More</a>
					<?php } ?>
					
					
				<?php endforeach; 
				//if($blog_id !== '1') { restore_current_blog(); }
				?>	
										
			</div>
