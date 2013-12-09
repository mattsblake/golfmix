<?php
/**
 * TwentyTen functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, twentyten_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_theme_setup' );
 * function my_child_theme_setup() {
 *     // We are providing our own filter for excerpt_length (or using the unfiltered value)
 *     remove_filter( 'excerpt_length', 'twentyten_excerpt_length' );
 *     ...
 * }
 * </code>
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 *
 * Used to set the width of images and content. Should be equal to the width the theme
 * is designed for, generally via the style.css stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640;

/** Tell WordPress to run twentyten_setup() when the 'after_setup_theme' hook is run. */
add_action( 'after_setup_theme', 'twentyten_setup' );

if ( ! function_exists( 'twentyten_setup' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override twentyten_setup() in a child theme, add your own twentyten_setup to your child theme's
 * functions.php file.
 *
 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
 * @uses register_nav_menus() To add support for navigation menus.
 * @uses add_custom_background() To add support for a custom background.
 * @uses add_editor_style() To style the visual editor.
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_custom_image_header() To add support for a custom header.
 * @uses register_default_headers() To register the default custom header images provided with the theme.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_setup() {

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
	load_theme_textdomain( 'twentyten', TEMPLATEPATH . '/languages' );

	$locale = get_locale();
	$locale_file = TEMPLATEPATH . "/languages/$locale.php";
	if ( is_readable( $locale_file ) )
		require_once( $locale_file );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'twentyten' ),
	) );

	// This theme allows users to set a custom background
	add_custom_background();

	// Your changeable header business starts here
	define( 'HEADER_TEXTCOLOR', '' );
	// No CSS, just IMG call. The %s is a placeholder for the theme template directory URI.
	define( 'HEADER_IMAGE', '%s/images/headers/path.jpg' );

	// The height and width of your custom header. You can hook into the theme's own filters to change these values.
	// Add a filter to twentyten_header_image_width and twentyten_header_image_height to change these values.
	define( 'HEADER_IMAGE_WIDTH', apply_filters( 'twentyten_header_image_width', 940 ) );
	define( 'HEADER_IMAGE_HEIGHT', apply_filters( 'twentyten_header_image_height', 198 ) );

	// We'll be using post thumbnails for custom header images on posts and pages.
	// We want them to be 940 pixels wide by 198 pixels tall.
	// Larger images will be auto-cropped to fit, smaller ones will be ignored. See header.php.
	set_post_thumbnail_size( HEADER_IMAGE_WIDTH, HEADER_IMAGE_HEIGHT, true );

	// Don't support text inside the header image.
	define( 'NO_HEADER_TEXT', true );

	// Add a way for the custom header to be styled in the admin panel that controls
	// custom headers. See twentyten_admin_header_style(), below.
	add_custom_image_header( '', 'twentyten_admin_header_style' );

	// ... and thus ends the changeable header business.

	// Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.
	register_default_headers( array(
		'berries' => array(
			'url' => '%s/images/headers/berries.jpg',
			'thumbnail_url' => '%s/images/headers/berries-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Berries', 'twentyten' )
		),
		'cherryblossom' => array(
			'url' => '%s/images/headers/cherryblossoms.jpg',
			'thumbnail_url' => '%s/images/headers/cherryblossoms-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Cherry Blossoms', 'twentyten' )
		),
		'concave' => array(
			'url' => '%s/images/headers/concave.jpg',
			'thumbnail_url' => '%s/images/headers/concave-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Concave', 'twentyten' )
		),
		'fern' => array(
			'url' => '%s/images/headers/fern.jpg',
			'thumbnail_url' => '%s/images/headers/fern-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Fern', 'twentyten' )
		),
		'forestfloor' => array(
			'url' => '%s/images/headers/forestfloor.jpg',
			'thumbnail_url' => '%s/images/headers/forestfloor-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Forest Floor', 'twentyten' )
		),
		'inkwell' => array(
			'url' => '%s/images/headers/inkwell.jpg',
			'thumbnail_url' => '%s/images/headers/inkwell-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Inkwell', 'twentyten' )
		),
		'path' => array(
			'url' => '%s/images/headers/path.jpg',
			'thumbnail_url' => '%s/images/headers/path-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Path', 'twentyten' )
		),
		'sunset' => array(
			'url' => '%s/images/headers/sunset.jpg',
			'thumbnail_url' => '%s/images/headers/sunset-thumbnail.jpg',
			/* translators: header image description */
			'description' => __( 'Sunset', 'twentyten' )
		)
	) );
}
endif;

if ( ! function_exists( 'twentyten_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * Referenced via add_custom_image_header() in twentyten_setup().
 *
 * @since Twenty Ten 1.0
 */
function twentyten_admin_header_style() {
?>
<style type="text/css">
/* Shows the same border as on front end */
#headimg {
	border-bottom: 1px solid #000;
	border-top: 4px solid #000;
}
/* If NO_HEADER_TEXT is false, you would style the text with these selectors:
	#headimg #name { }
	#headimg #desc { }
*/
</style>
<?php
}
endif;

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 *
 * To override this in a child theme, remove the filter and optionally add
 * your own function tied to the wp_page_menu_args filter hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_page_menu_args( $args ) {
	$args['show_home'] = true;
	return $args;
}
add_filter( 'wp_page_menu_args', 'twentyten_page_menu_args' );

/**
 * Sets the post excerpt length to 40 characters.
 *
 * To override this length in a child theme, remove the filter and add your own
 * function tied to the excerpt_length filter hook.
 *
 * @since Twenty Ten 1.0
 * @return int
 */
function twentyten_excerpt_length( $length ) {
	return 40;
}
add_filter( 'excerpt_length', 'twentyten_excerpt_length' );

/**
 * Returns a "Continue Reading" link for excerpts
 *
 * @since Twenty Ten 1.0
 * @return string "Continue Reading" link
 */
function twentyten_continue_reading_link() {
	return ' <a href="'. get_permalink() . '">' . __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'twentyten' ) . '</a>';
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and twentyten_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string An ellipsis
 */
function twentyten_auto_excerpt_more( $more ) {
	return ' &hellip;' . twentyten_continue_reading_link();
}
add_filter( 'excerpt_more', 'twentyten_auto_excerpt_more' );

/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 *
 * @since Twenty Ten 1.0
 * @return string Excerpt with a pretty "Continue Reading" link
 */
function twentyten_custom_excerpt_more( $output ) {
	if ( has_excerpt() && ! is_attachment() ) {
		$output .= twentyten_continue_reading_link();
	}
	return $output;
}
add_filter( 'get_the_excerpt', 'twentyten_custom_excerpt_more' );

/**
 * Remove inline styles printed when the gallery shortcode is used.
 *
 * Galleries are styled by the theme in Twenty Ten's style.css.
 *
 * @since Twenty Ten 1.0
 * @return string The gallery style filter, with the styles themselves removed.
 */
function twentyten_remove_gallery_css( $css ) {
	return preg_replace( "#<style type='text/css'>(.*?)</style>#s", '', $css );
}
add_filter( 'gallery_style', 'twentyten_remove_gallery_css' );

if ( ! function_exists( 'twentyten_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own twentyten_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_comment( $comment, $args, $depth ) {
	if(isset($_REQUEST['beta'])) {$beta = true; }
	$live = true;
		
	$plays = get_cimyFieldValue($comment->user_id, 'PLAYS');
	$average_score = get_cimyFieldValue($comment->user_id, 'AVERAGE_SCORE');

	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case '' :
		
			include('review-result.php');
			break;
			
		case 'pingback'  :
		case 'trackback' :
			break;
	endswitch;
}
endif;

/**
 * Register widgetized areas, including two sidebars and four widget-ready columns in the footer.
 *
 * To override twentyten_widgets_init() in a child theme, remove the action hook and add your own
 * function tied to the init hook.
 *
 * @since Twenty Ten 1.0
 * @uses register_sidebar
 */
function twentyten_widgets_init() {
	// Area 1, located at the top of the sidebar.
	register_sidebar( array(
		'name' => __( 'Primary Widget Area', 'twentyten' ),
		'id' => 'primary-widget-area',
		'description' => __( 'The primary widget area', 'twentyten' ),
		'before_widget' => '<div class="box-holder">',
		'after_widget' => '</div></div>',
		'before_title' => '<div class="daily-box-top"><h3>',
		'after_title' => '</h3></div><div class="daily-box-bottom-2">',
	) );
	register_sidebar( array(
		'name' => __( 'Featured Header', 'twentyten' ),
		'id' => 'Featured Header',
		'description' => __( 'Featured Header Text', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
	register_sidebar( array(
		'name' => __( 'Recent Pics', 'twentyten' ),
		'id' => 'Recent Pics',
		'description' => __( 'Recent Pics', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
	register_sidebar( array(
		'name' => __( 'Deal of the day', 'twentyten' ),
		'id' => 'Deal of the day',
		'description' => __( 'Deal of the day', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
register_sidebar( array(
		'name' => __( 'Search', 'twentyten' ),
		'id' => 'Search',
		'description' => __( 'Search ', 'twentyten' ),
		'before_widget' => '',
		'after_widget' => '',
		'before_title' => '',
		'after_title' => '',
	) );
}
/** Register sidebars by running twentyten_widgets_init() on the widgets_init hook. */
add_action( 'widgets_init', 'twentyten_widgets_init' );

/**
 * Removes the default styles that are packaged with the Recent Comments widget.
 *
 * To override this in a child theme, remove the filter and optionally add your own
 * function tied to the widgets_init action hook.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'twentyten_remove_recent_comments_style' );

if ( ! function_exists( 'twentyten_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post—date/time and author.
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_on() {
	printf( __( '<span class="%1$s">Posted on</span> %2$s <span class="meta-sep">by</span> %3$s', 'twentyten' ),
		'meta-prep meta-prep-author',
		sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><span class="entry-date">%3$s</span></a>',
			get_permalink(),
			esc_attr( get_the_time() ),
			get_the_date()
		),
		sprintf( '<span class="author vcard">%1$s</span>',
			get_the_author()
		)
	);
}
endif;

if ( ! function_exists( 'twentyten_posted_in' ) ) :
/**
 * Prints HTML with meta information for the current post (category, tags and permalink).
 *
 * @since Twenty Ten 1.0
 */
function twentyten_posted_in() {
	// Retrieves tag list of current post, separated by commas.
	$tag_list = get_the_tag_list( '', ', ' );
	if ( $tag_list ) {
		$posted_in = __( 'This entry was posted in %1$s and tagged %2$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} elseif ( is_object_in_taxonomy( get_post_type(), 'category' ) ) {
		$posted_in = __( 'This entry was posted in %1$s. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	} else {
		$posted_in = __( 'Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'twentyten' );
	}
	// Prints the string, replacing the placeholders.
	printf(
		$posted_in,
		get_the_category_list( ', ' ),
		$tag_list,
		get_permalink(),
		the_title_attribute( 'echo=0' )
	);
}
endif;
// Get Custom Field Template Values
function getCustomField($theField) {
	global $post;
	$block = get_post_meta($post->ID, $theField);
	if($block){
		foreach(($block) as $blocks) {
			echo $blocks;
		}
	}
}
//get total comments
function get_total_comments_by_author(){
return count(get_comments(array(
'author_email' => get_comment_author_email()
)));
}

//comment form

function golfmix_comment_form( $args = array(), $post_id = null ) {
	global $user_identity;
	global $id;

	if ( null === $post_id )
		$post_id = $id;
	else
		$id = $post_id;

	$commenter = wp_get_current_commenter();
	//wp_set_current_user( null, null );

	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$fields =  array(
	
					
		'author' => '<ul class="inner-page-information-area"><li>' . '<label for="author"class="author">' . __( 'Name *' ) . '</label> ' . ( $req ? '<span class="required"></span>' : '' ) .
		            '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></li>',
		'email'  => '<li>'  . '<label for="author" class="author">' . __( 'Email *' ) . '</label> ' . ( $req ? '<span class="required"></span>' : '' ) .
		            '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></li><input id="url" name="url" type="hidden" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" size="30"' . $aria_req . ' />',
	);

	$required_text = sprintf( ' ' . __('Required fields are marked %s'), '<span class="required">*</span>' );
	
	require_once("Mobile_Detect.php");
	global $detect;
	$detect = new Mobile_Detect();
	if ($detect->isMobile() && !$detect->isIpad()) { $redirect_link = 'http://golfmix.com/m/a/?id='.$post_id; } else { $redirect_link = get_permalink( $post_id ); }
	
	$defaults = array(
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field'        => '<li><span id="comm" class="class-vertical-allign" style="font-weight:bold;">' . _x( 'In a few sentences, how would you describe this course to another golfer - the good, the bad, the ugly?', 'noun' ) . '</span><textarea id="comment" class="text-area-new" name="comment" cols="45" rows="8" aria-required="true" style="clear:both;margin-top:5px;"></textarea></li></ul>',
		'must_log_in'          => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment. Or you can also log in with Facebook:' ), wp_login_url( apply_filters( 'the_permalink', $redirect_link ) ) ) . '</p>',
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', $redirect_link ) ) ) . '</p>',
		'comment_notes_before' => '<p class="comment-notes">' . __( 'Your email address will not be published.' ) . ( $req ? $required_text : '' ) . '</p>',
		'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( '' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
		'id_form'              => 'commentform',
		'id_submit'            => 'submit',
		'title_reply'          => __( 'Add a new Review' ),
		'title_reply_to'       => __( 'Leave a Review to %s' ),
		'cancel_reply_link'    => __( 'Cancel Review' ),
		'label_submit'         => __( 'Post Review' ),
	);

	$args = wp_parse_args( $args, apply_filters( 'comment_form_defaults', $defaults ) );

	?>
		<?php if ( comments_open() ) : ?>
			<?php do_action( 'comment_form_before' ); ?>
			
			<br class="clear">
			<div class="new-reviwes-containder" id="addreview">
							<div class="new-reviwes-top"> </div>
							<div class="new-reviwes-cen" id="loader" style="display:none;"><img src="http://golfmix.com/wp-content/themes/golfmix/images/ajax-loader.gif" style="margin: 50px 310px;" /></div>
							<div class="new-reviwes-cen" id="review_form">
				<h3 id="reply-title"><?php comment_form_title( $args['title_reply'], $args['title_reply_to'] ); ?> <small><?php cancel_comment_reply_link( $args['cancel_reply_link'] ); ?></small></h3>
				<?php if ( get_option( 'comment_registration' ) && !is_user_logged_in() ) : ?>
					<?php echo $args['must_log_in']; ?>
						<div id="comment-user-details" style="margin:10px 0;"><?php
							jfb_output_facebook_btn();
							jfb_output_facebook_init();
							jfb_output_facebook_callback();
							?>
						</div>
						<?php do_action( 'comment_form_must_log_in_after' ); ?>
						</div>
						<div class="new-reviwes-bot"></div>
				<?php else : ?>
					<form action="<?php echo site_url( '/wp-comments-post.php' ); ?>" method="post" id="<?php echo esc_attr( $args['id_form'] ); ?>">
						<?php do_action( 'comment_form_top' ); ?>
						<?php if ( is_user_logged_in() ) : ?>
							<?php echo apply_filters( 'comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity ); ?>
							<?php do_action( 'comment_form_logged_in_after', $commenter, $user_identity ); ?>
						<?php else : ?>
							<?php echo $args['comment_notes_before']; ?>
							<?php
							do_action( 'comment_form_before_fields' );
							foreach ( (array) $args['fields'] as $name => $field ) {
								echo apply_filters( "comment_form_field_{$name}", $field ) . "\n";
							}
							do_action( 'comment_form_after_fields' );
							?>
						<?php endif; ?>
						<?php echo apply_filters( 'comment_form_field_comment', $args['comment_field'] ); ?>
						<?php echo $args['comment_notes_after']; ?>
						<li style="margin-top:15px;"><span id="comm" class="class-vertical-allign" style="font-weight:bold;">Please rate this course in the following sub-categories along with an overall rating:</span></li>
						</div>
						<div class="new-reviwes-bot">
						<p class="form-submit">
							<input name="submit" type="submit" class="submit-area-inner" id="<?php echo esc_attr( $args['id_submit'] ); ?>" value="Submit Review" />
							<?php comment_id_fields(); ?>
						</p>
						<?php do_action( 'comment_form', $post_id ); ?></div>
					</form>
				<?php endif; ?>
			<br class="clear" />
			</div><!-- #respond -->
			<?php do_action( 'comment_form_after' ); ?>
		<?php else : ?>
			<?php do_action( 'comment_form_comments_closed' ); ?>
		<?php endif; ?>
	<?php
}


/*Custom Rewrite Rules*/
function add_query_vars($aVars) {
	// represents the name of the variable being passed in URL		
	$aVars[] = "sortby";    
	$aVars[] = "find"; 

	
	return $aVars;
}
// hook add_query_vars function into query_vars
add_filter('query_vars', 'add_query_vars');

function add_rewrite_rules($aRules) {
	$aNewRules = array(
	'golf-courses/(.*?)/([^/]+)/?$' => 'index.php?pagename=golf-courses&sortby=$matches[1]&find=$matches[2]',
	);
	$aRules = $aNewRules + $aRules;
	return $aRules;
}

// hook add_rewrite_rules function into rewrite_rules_array
add_filter('rewrite_rules_array', 'add_rewrite_rules');



/// Add ne user profile fields
//add_action( 'show_user_profile', 'my_show_extra_profile_fields' );
//add_action( 'edit_user_profile', 'my_show_extra_profile_fields' );

function my_show_extra_profile_fields( $user ) { ?>

	<h3>Your Golf Profile</h3>

	<table class="form-table">

		<tr>
			<th><label for="average_score">What is your average score?</label></th>

			<td>
				<input type="text" name="average_score" id="average_score" value="<?php echo esc_attr( get_the_author_meta( 'average_score', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your average score.</span>
			</td>
		</tr>
		
		<tr>
			<th><label for="plays">How often do you play?</label></th>

			<td>
				<?php $plays = esc_attr( get_the_author_meta( 'plays', $user->ID ) ); ?>
				<select name="plays" id="plays">
				  <option value="Daily" <?php if($plays == 'Daily') { echo 'selected';} ?>>Daily</option>
				  <option value="2+ Times a Week" <?php if($plays == '2+ Times a Week') { echo 'selected'; }?>>2+ Times a Week</option>
				  <option value="Weekly" <?php if($plays == 'Weekly') { echo 'selected';}?>>Weekly</option>
				  <option value="2+ Times a Month" <?php if($plays == '2+ Times a Month') { echo 'selected';}?>>2+ Times a Month</option>
				  <option value="Monthly" <?php if($plays == 'Monthly') { echo 'selected';}?>>Monthly</option>
				  <option value="Less Than 10 a Year" <?php if($plays == 'Less Than 10 a Year') { echo 'selected';}?>>Less Than 10 a Year</option>
				</select>
			</td>
		</tr>
		
	</table>
<?php }

//add_action( 'personal_options_update', 'my_save_extra_profile_fields' );
//add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' );

function my_save_extra_profile_fields( $user_id ) {

	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;

	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_usermeta( $user_id, 'average_score', $_POST['average_score'] );
	update_usermeta( $user_id, 'plays', $_POST['plays'] );
}


function add_delete_contactmethod( $contactmethods ) {
    // Add new ones
	//$contactmethods['sex'] = 'Sex';
	//$contactmethods['birthday'] = 'Birthday';
	//$contactmethods['zip'] = 'Zip Code';

  unset($contactmethods['aim']);
  unset($contactmethods['jabber']);
  unset($contactmethods['yim']);
  return $contactmethods;
}
add_filter('user_contactmethods','add_delete_contactmethod',10,1);


add_action( 'init', 'create_post_type' );
function create_post_type() {
	register_post_type( 'blog',
		array(
			'labels' => array(
				'name' => __( 'Blog' ),
				'singular_name' => __( 'Blog' ),
				'all_items' => __( 'All Blogs' ),
				'add_new_item' => __( 'Add New Blog' )
			),
		'public' => true,
		'supports' => array('title','editor','author','thumbnail','excerpt','comments')	,
		'has_archive' => true, 
   		'hierarchical' => true,
   		'taxonomies' => array('category','post_tag'),
   		'exclude_from_search' => true	
		)
	);
	register_post_type( 'news',
		array(
			'labels' => array(
				'name' => __( 'News' ),
				'singular_name' => __( 'News' ),
				'all_items' => __( 'All News' ),
				'add_new_item' => __( 'Add New News' )
			),
		'public' => true,
		'supports' => array('title','editor','author','thumbnail','excerpt','comments')	,
		'has_archive' => true, 
   		'hierarchical' => true,
   		'taxonomies' => array('category','post_tag'),
   		'exclude_from_search' => true	
		)
	);
	register_post_type( 'deals',
		array(
			'labels' => array(
				'name' => __( 'Deals' ),
				'singular_name' => __( 'Deal' ),
				'all_items' => __( 'All Deals' ),
				'add_new_item' => __( 'Add New Deal' )
			),
		'public' => true,
		'supports' => array('title','editor','author','thumbnail','excerpt','comments')	,
		'has_archive' => true, 
   		'hierarchical' => true,
   		'taxonomies' => array('category','post_tag'),
   		'exclude_from_search' => true	
		)
	);
}


/* Define the custom box */
add_action( 'add_meta_boxes', 'deal_add_custom_box' );

/* Do something with the data entered */
add_action( 'save_post', 'deal_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function deal_add_custom_box() {
    add_meta_box( 
        'deal',
        __( 'Add Deal Details', 'deal_text' ),
        'deal_inner_custom_box',
        'deals' 
    );
}

/* Prints the box content */
function deal_inner_custom_box( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'deal_noncename' );

  // The actual fields for data entry
  echo '<label for="deal_company">';
       _e("Deal Company:", 'deal_company' );
  echo '</label> ';
  echo '<input type="text" id="deal_company" name="deal_company" value="'.get_post_meta($post->ID, 'deal_company', true).'" size="75" />';
  echo '<br />';
  echo '<label for="deal_logo">';
       _e("Deal Logo:", 'deal_logo' );
  echo '</label> ';
  echo '<input type="text" id="deal_logo" name="deal_logo" value="'.get_post_meta($post->ID, 'deal_logo', true).'" size="75" />';
  echo '<br />';
  echo '<label for="deal_retail">';
       _e("Deal Retail Price:", 'deal_retail' );
  echo '</label> ';
  echo '<input type="text" id="deal_retail" name="deal_retail" value="'.get_post_meta($post->ID, 'deal_retail', true).'" size="75" />';
  echo '<br />';
    echo '<label for="deal_discount_price">';
       _e("Deal Discount Price:", 'deal_price' );
  echo '</label> ';
  echo '<input type="text" id="deal_price" name="deal_price" value="'.get_post_meta($post->ID, 'deal_price', true).'" size="75" />';
  echo '<br />';
  echo '<label for="deal_link">';
       _e("Deal URL (full url):", 'deal_link' );
  echo '</label> ';
  echo '<input type="text" id="deal_link" name="deal_link" value="'.get_post_meta($post->ID, 'deal_link', true).'" size="75" />';
  echo '<br />';
  echo '<label for="deal_promo_code">';
       _e("Deal Promo Code:", 'deal_promo_code' );
  echo '</label> ';
  echo '<input type="text" id="deal_promo_code" name="deal_promo_code" value="'.get_post_meta($post->ID, 'deal_promo_code', true).'" size="75" />';  
  echo '<br />';
  echo '<label for="deal_image">';
       _e("Upload an image and put a link to it here to display with the deal", 'deal_image' );
  echo '</label> ';
  echo '<input type="text" id="deal_image" name="deal_image" value="'.get_post_meta($post->ID, 'deal_image', true).'" size="75" />';
  echo '<br />';
  echo '<label for="deal_image">';
       _e("Deal video link:", 'deal_video' );
  echo '</label> ';
  echo '<input type="text" id="deal_video" name="deal_video" value="'.get_post_meta($post->ID, 'deal_video', true).'" size="75" />';
}


/* When the post is saved, saves our custom data */
function deal_save_postdata( $post_id ) {
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  if ( !wp_verify_nonce( $_POST['deal_noncename'], plugin_basename( __FILE__ ) ) )
      return;
      
  // OK, we're authenticated: we need to find and save the data
  update_post_meta($post_id, 'deal_company', $_POST['deal_company']);
  update_post_meta($post_id, 'deal_logo', $_POST['deal_logo']);
  update_post_meta($post_id, 'deal_link', $_POST['deal_link']);
  update_post_meta($post_id, 'deal_promo_code', $_POST['deal_promo_code']);
  update_post_meta($post_id, 'deal_image', $_POST['deal_image']);
  update_post_meta($post_id, 'deal_video', $_POST['deal_video']);
  update_post_meta($post_id, 'deal_retail', $_POST['deal_retail']);
  update_post_meta($post_id, 'deal_price', $_POST['deal_price']);

}


/*Start of Theme Options*/
 
$themename = "Review of the Day";
$shortname = "gm";
$options = array (
 
array( "name" => "Review of the Day",
	"type" => "title"),
 
array( "type" => "open"),
	
array( "name" => "Date 1",
	"desc" => "Enter Date (mm/dd/yyyy)",
	"id" => $shortname."_date1",
	"type" => "text",
	"std" => ""),	
	 
array( "name" => "Email 1",
	"desc" => "Reviewer Email Address",
	"id" => $shortname."_email1",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Post ID 1",
	"desc" => "The Post ID that this review appears on",
	"id" => $shortname."_postid1",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Prize Course Name 1",
	"desc" => "Enter Prize Course Name",
	"id" => $shortname."_prizename1",
	"type" => "text",
	"std" => ""),	
	
array( "name" => "Prize URL 1",
	"desc" => "Enter url for course prize",
	"id" => $shortname."_prizeurl1",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Date 2",
	"desc" => "Enter Date (mm/dd/yyyy)",
	"id" => $shortname."_date2",
	"type" => "text",
	"std" => ""),	
	 
array( "name" => "Email 2",
	"desc" => "Reviewer Email Address",
	"id" => $shortname."_email2",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Post ID 2",
	"desc" => "The Post ID that this review appears on",
	"id" => $shortname."_postid2",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Prize Course Name 2",
	"desc" => "Enter Prize Course Name",
	"id" => $shortname."_prizename2",
	"type" => "text",
	"std" => ""),	
	
array( "name" => "Prize URL 2",
	"desc" => "Enter url for course prize",
	"id" => $shortname."_prizeurl2",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Date 3",
	"desc" => "Enter Date (mm/dd/yyyy)",
	"id" => $shortname."_date3",
	"type" => "text",
	"std" => ""),	
	 
array( "name" => "Email 3",
	"desc" => "Reviewer Email Address",
	"id" => $shortname."_email3",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Post ID 3",
	"desc" => "The Post ID that this review appears on",
	"id" => $shortname."_postid3",
	"type" => "text",
	"std" => ""),
	
array( "name" => "Prize Course Name 3",
	"desc" => "Enter Prize Course Name",
	"id" => $shortname."_prizename3",
	"type" => "text",
	"std" => ""),	
	
array( "name" => "Prize URL 3",
	"desc" => "Enter url for course prize",
	"id" => $shortname."_prizeurl3",
	"type" => "text",
	"std" => ""),	
	
array( "type" => "close")
 
);

function mytheme_add_admin() {
 
global $themename, $shortname, $options;
 
if ( $_GET['page'] == basename(__FILE__) ) {
 
if ( 'save' == $_REQUEST['action'] ) {
 
foreach ($options as $value) {
update_option( $value['id'], $_REQUEST[ $value['id'] ] ); }
 
foreach ($options as $value) {
if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); } }
 
header("Location: themes.php?page=functions.php&saved=true");
die;
 
} else if( 'reset' == $_REQUEST['action'] ) {
 
foreach ($options as $value) {
delete_option( $value['id'] ); }
 
header("Location: themes.php?page=functions.php&reset=true");
die;
 
}
}
 
add_theme_page($themename." Options", "".$themename." Options", 'edit_themes', basename(__FILE__), 'mytheme_admin');
 
}
 
function mytheme_admin() {
 
global $themename, $shortname, $options;
 
if ( $_REQUEST['saved'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings saved.</strong></p></div>';
if ( $_REQUEST['reset'] ) echo '<div id="message" class="updated fade"><p><strong>'.$themename.' settings reset.</strong></p></div>';
 
?>
<div class="wrap">
<h2><?php echo $themename; ?> Settings</h2>
 
<form method="post">
 
<?php foreach ($options as $value) {
switch ( $value['type'] ) {
 
case "open":
?>
<table width="100%" border="0" style="background-color:#eef5fb; padding:10px;">
 
<?php break;
 
case "close":
?>
 
</table><br />
 
<?php break;
 
case "title":
?>
<table width="100%" border="0" style="background-color:#dceefc; padding:5px 10px;"><tr>
<td colspan="2"><h3 style="font-family:Georgia,'Times New Roman',Times,serif;"><?php echo $value['name']; ?></h3></td>
</tr>
 
<?php break;
 
case 'text':
?>
 
<tr>
<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
<td width="80%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?>" /></td>
</tr>
 
<tr>
<td><small><?php echo $value['desc']; ?></small></td>
</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
 
<?php
break;
 
case 'textarea':
?>
 
<tr>
<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
<td width="80%"><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:200px;" type="<?php echo $value['type']; ?>" cols="" rows=""><?php if ( get_settings( $value['id'] ) != "") { echo get_settings( $value['id'] ); } else { echo $value['std']; } ?></textarea></td>
 
</tr>
 
<tr>
<td><small><?php echo $value['desc']; ?></small></td>
</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
 
<?php
break;
 
case 'select':
?>
<tr>
<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
<td width="80%"><select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_settings( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select></td>
</tr>
 
<tr>
<td><small><?php echo $value['desc']; ?></small></td>
</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
 
<?php
break;
 
case "checkbox":
?>
<tr>
<td width="20%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
<td width="80%"><?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
<input type="checkbox" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" value="true" <?php echo $checked; ?> />
</td>
</tr>
 
<tr>
<td><small><?php echo $value['desc']; ?></small></td>
</tr><tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #000000;">&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td></tr>
 
<?php break;
 
}
}
?>
 
<p class="submit">
<input name="save" type="submit" value="Save changes" />
<input type="hidden" name="action" value="save" />
</p>
</form>
<form method="post">
<p class="submit">
<input name="reset" type="submit" value="Reset" />
<input type="hidden" name="action" value="reset" />
</p>
</form>
 
<?php
}

add_action('admin_menu', 'mytheme_add_admin');


/* Get Rid of Admin Bar */

function my_function_admin_bar($content) {
    return ( current_user_can("administrator") ) ? $content : false;
}
add_filter( 'show_admin_bar' , 'my_function_admin_bar');


/* Share This Review After Review is Submitted */
add_filter('comment_post_redirect', 'redirect_after_comment');
function redirect_after_comment($location){
	$newurl = substr($location, 0, strpos($location, "#comment"));
	$current_user = wp_get_current_user();
	$referral = md5($current_user->user_email.$current_user->ID);
	
	$args = array(
		'number' => '1',
		'user_id' => $current_user->ID
	);
	$comments = get_comments($args);
	foreach($comments as $comment) :
		$comment_id = $comment->comment_ID;
	endforeach;
	
	require_once("Mobile_Detect.php");
	global $detect;
	$detect = new Mobile_Detect();
	if ($detect->isMobile() && !$detect->isIpad()) { 
		$mobile_url = $_SERVER['HTTP_REFERER'];
		$mobile_url = str_replace('/a/','/r/',$mobile_url);
		
		return $mobile_url; 
	} else { 
		return $newurl . '?share=1&r='.$comment_id.'&referred_by='.$referral;
	}
}

// Add Orderby post__in for distance
add_filter( 'posts_orderby', 'sort_query_by_post_in', 10, 2 );
	
function sort_query_by_post_in( $sortby, $thequery ) {
	if ( !empty($thequery->query_vars['post__in']) && isset($thequery->query_vars['orderby']) && $thequery->query_vars['orderby'] == 'post__in' )
		$sortby = "find_in_set(ID, '" . implode( ',', $thequery->query_vars['post__in'] ) . "')";
	
	return $sortby;
}

// To search a multi-array
function recursiveArraySearch($haystack, $needle, $index = null)
{
    $aIt   = new RecursiveArrayIterator($haystack);
    $it    = new RecursiveIteratorIterator($aIt);

    while($it->valid())
    {
        if (((isset($index) AND ($it->key() == $index)) OR (!isset($index))) AND ($it->current() == $needle)) {
            return $aIt->key();
        }

        $it->next();
    }

    return false;
}


/* Custom Meta Box */
add_action( 'add_meta_boxes', 'bestof_add_custom_box' );

/* Do something with the data entered */
add_action( 'save_post', 'bestof_save_postdata' );

/* Adds a box to the main column on the Post and Page edit screens */
function bestof_add_custom_box() {
    add_meta_box(
        'bestof_sectionid',
        __( 'Best of Custom', 'bestof_city' ), 
        'bestof_inner_custom_box',
        'page'
    );
}

/* Prints the box content */
function bestof_inner_custom_box( $post ) {

  // Use nonce for verification
  wp_nonce_field( plugin_basename( __FILE__ ), 'bestof_noncename' );

  // The actual fields for data entry
  echo '<label for="bestof_new_field">';
       _e("Best of City", 'bestof_textdomain' );
  echo '</label> ';
  echo '<input type="text" id="bestof_city" name="bestof_city" value="'.get_post_meta($post->ID, 'bestof_city', true).'" size="25" />';
}

/* When the post is saved, saves our custom data */
function bestof_save_postdata( $post_id ) {
  // verify if this is an auto save routine. 
  // If it is our form has not been submitted, so we dont want to do anything
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
      return;

  // verify this came from the our screen and with proper authorization,
  // because save_post can be triggered at other times

  if ( !wp_verify_nonce( $_POST['bestof_noncename'], plugin_basename( __FILE__ ) ) )
      return;

  
  // Check permissions
  if ( 'page' == $_POST['post_type'] ) 
  {
    if ( !current_user_can( 'edit_page', $post_id ) )
        return;
  }

  // OK, we're authenticated: we need to find and save the data
   update_post_meta($post_id, 'bestof_city', $_POST['bestof_city']);
  
}
?>
