<?php

/**

 * The template for displaying Comments.

 *

 * The area of the page that contains both current comments

 * and the comment form.  The actual display of comments is

 * handled by a callback to twentyten_comment which is

 * located in the functions.php file.

 *

 * @package WordPress

 * @subpackage Twenty_Ten

 * @since Twenty Ten 1.0

 */

?>



			<div class="reviews-container">

					

<?php if ( post_password_required() ) : ?>

				<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'twentyten' ); ?></p>

			</div>

			<!-- #comments -->

<?php

		/* Stop the rest of comments.php from being processed,

		 * but don't kill the script entirely -- we still have

		 * to fully load the template.

		 */

		return;

	endif;

?>



<?php

	// You can start editing here -- including this comment!

?>



<?php if ( have_comments() && !isset($_REQUEST['fb']) ) : ?>

			<?php /*?><h3 id="comments-title"><?php

			printf( _n( 'One Response to %2$s', '%1$s Responses to %2$s', get_comments_number(), 'twentyten' ),

			number_format_i18n( get_comments_number() ), '<em>' . get_the_title() . '</em>' );

			?></h3><?php */?>



<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>


		<?php if(function_exists('wp_paginate_comments')) {
			    wp_paginate_comments();
			} else { ?>
			<div class="navigation">
				<div class="alignright"><?php previous_post('<div>&raquo; %</div>', 'Newer Reviews', 'no'); ?></div>
				<div class="alignleft"><?php next_post('<div>% &laquo; </div>', 'Older Reviews', 'no'); ?></div>
			</div>
			<?php } ?>


<?php endif; // check for comment navigation ?>

			<div class="reviews-center">

				<?php wp_list_comments( array( 'callback' => 'twentyten_comment', 'reverse_top_level' => true) ); ?>

				<div class="inner-load-button"> <a href="#">Load more Reviews</a> </div>
				
			</div>


<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>

		<?php if(function_exists('wp_paginate_comments')) {
			    wp_paginate_comments();
			} else { ?>
			<div class="navigation">
				<div class="alignright"><?php previous_post('<div>&raquo; %</div>', 'Newer Reviews', 'no'); ?></div>
				<div class="alignleft"><?php next_post('<div>% &laquo; </div>', 'Older Reviews', 'no'); ?></div>
			</div>
			<?php } ?>
			

<?php endif; // check for comment navigation ?>



<?php else : // or, if we don't have comments:



	/* If there are no comments and comments are closed,

	 * let's leave a little note, shall we?

	 */

	if ( ! comments_open() ) :

?>

	<p class="nocomments"><?php _e( 'Comments are closed.', 'twentyten' ); ?></p>

<?php endif; // end ! comments_open() ?>



<?php endif; // end have_comments() ?>



<?php golfmix_comment_form(); ?>



</div><!-- #comments -->

