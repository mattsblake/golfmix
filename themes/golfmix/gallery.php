<?php
/**
 * Template Name: inside-inner-temp
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
get_header();
 ?>
<div class="gallery-pics">
		    <!--column-one ends-->
            <?php  $pageid=$post->ID;

		$aquery = 'SELECT * FROM wp_ngg_gallery where pageid="'.$pageid.'"';	
		$gallery = $wpdb->get_results($aquery);
		
			if ($gallery) :
			foreach ($gallery as $galry) :
				$gallerypath = $galry->path;
				$galleryid = $galry->gid;				
				$gallerytitle = $galry->title;	
				$desc = $galry->galdesc;
				$pageid=$galry->pageid;

		endforeach;
				
		endif;
				?>
                 <?php 
				  
				  $galleryquery = "SELECT * FROM wp_ngg_pictures WHERE galleryid = '$galleryid'" ;
		$images = $wpdb->get_results($galleryquery);
			
			
			foreach ($images as $picture) :
				$imagename = $picture->filename;					
				if ($images) : 
				  ?>
                  
       <a href="<?php bloginfo('url');?>/<?php echo $gallerypath; ?>/<?php echo $imagename;?>">
       <img src="<?php bloginfo( 'url' ); ?>/<?php echo $gallerypath; ?>/thumbs/thumbs_<?php echo $imagename;?>" class="float" width="207" height="140" /></a>
       
	  
                    <?php 	
			endif ;
			
			endforeach;
			?>
            
	     
   <!--column-two ends-->
        </div>
		<div class="clear"></div>

	
<?php get_footer(); ?>