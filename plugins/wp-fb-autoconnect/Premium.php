<?php
/*
 * WP-FB-AutoConnect Premium Add-On
 * http://www.justin-klein.com/projects/wp-fb-autoconnect
 * 
 * When placed in the same directory as the WP-FB-AutoConnect Wordpress plugin,
 * this addon file will enable all premium functionality shown in the core plugin's admin panel.
 * This file does not operate as a standalone plugin; it must be used in conjunction with WP-FB-AutoConnect.
 * 
 * You are permitted to modify the code below for personal use.
 * You are not permitted to share, sell, or in any way distribute any of the code below.
 * You are not permitted to share, sell, or in any way distribute any work derived from the code below, including new plugins that may include similar functionality.
 * You are not permitted to instruct others on how to reproduce the behavior implemented below.
 * Basically, you can use this plugin however you like *on your own site* - just don't share it with anyone else :)
 * 
 * Additional features under consideration:
 * FIRST:
 * -Customize "User" and "Pass" in the widget (for translation)
 * -Customize user messages (for translation)
 * -Add option for Remember Me tickbox to Login widget
 * THEN:
 * -When someone logs in on BP, put a notice on the activity feed
 * -See email from Giovanni Gonzalez on 11/26/2010, 10:49am: He SOLVED how to auto-resize the avatars; it's done, just implement it.
 * -Specify multiple addresses to forward login log reports
 * -Logout button logs you out of Facebook as well as blog (requires always including the API)
 * -Customizable default email address for users who deny access to Facebook addresses
 * -Autofill BuddyPress X-Profile fields with data pulled from Facebook
 * -Restrict autoregistration based on: Group Membership, Page Membership, Friend Status (partially done)
 * -Let users choose if they want to use their WP avatar or FB avatar on a user-by-user basis
 * -Let admins manually specify a Facebook UID for users (aka edit their metadata) 
 * NEW API:
 * -Use OpenGraph
 * -Collapse "allow access to information" and "allow access to email" into one prompt (Partially done, but requires a full update to the new API.  Search for "collapse" below.)
 * -See email from Giovanni on 11/23/2010@1:31pm: once I use the new API, I should be able to get *all* facebook emails (not just the contact one), and can then check those against local blog users for autoregistration.
 * 
 * Changelog:
 * v1: 
 * -Initial Release
 *
 * v2: 
 * -Better integration with core
 * -Premium updates no longer require updates to the core
 * -Requires core plugin 1.5.1 or later
 * 
 * v3: 
 * -Add this changelog :) 
 * -Add support for choosing button size
 * -Add support for choosing button text
 * -Add support for silently handling double-logins
 * -Add ability to ENFORCE that real emails are revealed (reject proxied emails)
 * 
 * v4:
 * -Fixed auth
 * 
 * v5:
 * -Add wpmu support
 * 
 * v6:
 * -Fix minor logging bug (wasn't correctly showing notified user's emails)
 * -New Option: Custom redirect url for autoregistered users
 * -New Option: Custom redirect url for returning users
 * -New Option: Autoregistration restriction (to disallow autoregistrations)
 * 
 * v7:
 * -Conditional Invitations: tie in with wp-secure-invites plugin
 * 
 * v8:
 * -Add a message about the minimum required core plugin version
 * -Rearrange & rephrase the admin panel a bit
 * -Code cleanups
 * -Begin work on option to collapse all the facebook prompts into one (unfinished, so option hidden)
 * 
 * v9:
 * -Slight revisions to jfb_output_premium_panel() to let me copy it to AdminPage.php
 * -Don't override the $jfb_version
 * 
 * v10:
 * -Add option to show an AJAX spinner after the Login button is clicked
 * -Add option for a custom logout url
 * -Add option to insert a Facebook button to the Registration page
 * -Better error checking for avatar caching
 * -Required core plugin version increased to 1.6.4
 * 
 * v11:
 * -If a language code is detected in wp-config.php, the Facebook prompts will be localized.
 * -Specify your own path to cached Facebook avatars
 * -Add a log message that this is a premium login
 * -Required core plugin version increased to 1.6.5.
 * 
 * v12:
 * -Output a comment showing the premium version (for debugging)
 */


/**********************************************************************/
/**********************************************************************/
/*************************PREMIUM OPTIONS******************************/
/**********************************************************************/
/**********************************************************************/


//Identify the premium version as being present & available
define('JFB_PREMIUM', 221);
define('JFB_PREMIUM_VALUE', 'YTozOntzOjU6Im9yZGVyIjtzOjM6IjIyMSI7czo0OiJkYXRlIjtzOjE5OiIyMDExLTAyLTEyIDAxOjAyOjUxIjtzOjI6IklQIjtzOjEyOiIxNzQuMjYuNzYuMzEiO30=');
define('JFB_PREMIUM_VER', 12);
define('JFB_PREMIUM_REQUIREDVER', '1.6.5');

//Override plugin name
global $jfb_name, $jfb_version;
$jfb_name = "WP-FB AutoConnect Premium";

//Define new premium options
global $opt_jfbp_notifyusers, $opt_jfbp_notifyusers_content, $opt_jfbp_notifyusers_subject;
global $opt_jfbp_commentfrmlogin, $opt_jfbp_wploginfrmlogin, $opt_jfbp_registrationfrmlogin, $opt_jfbp_cache_avatars, $opt_jfbp_cache_avatar_dir;
global $opt_jfbp_buttonsize, $opt_jfbp_buttontext, $opt_jfbp_ignoredouble, $opt_jfbp_requirerealmail;
global $opt_jfbp_redirect_new, $opt_jfbp_redirect_new_custom, $opt_jfbp_redirect_existing, $opt_jfbp_redirect_existing_custom, $opt_jfbp_redirect_logout, $opt_jfbp_redirect_logout_custom;
global $opt_jfbp_restrict_reg, $opt_jfbp_restrict_reg_url;
global $opt_jfbp_collapse_prompts, $opt_jfbp_show_spinner;
$opt_jfbp_notifyusers = "jfb_p_notifyusers";
$opt_jfbp_notifyusers_subject = "jfb_p_notifyusers_subject";
$opt_jfbp_notifyusers_content = "jfb_p_notifyusers_content";
$opt_jfbp_commentfrmlogin = "jfb_p_commentformlogin";
$opt_jfbp_wploginfrmlogin = "jfb_p_wploginformlogin";
$opt_jfbp_registrationfrmlogin = "jfb_p_registrationformlogin";
$opt_jfbp_cache_avatars = "jfb_p_cacheavatars";
$opt_jfbp_cache_avatar_dir = "jfb_p_cacheavatar_dir";
$opt_jfbp_buttonsize = "jfb_p_buttonsize";
$opt_jfbp_buttontext = "jfb_p_buttontext";
$opt_jfbp_ignoredouble = "jfb_p_ignoredouble";
$opt_jfbp_requirerealmail = "jfb_p_requirerealmail";
$opt_jfbp_redirect_new = 'jfb_p_redirect_new';
$opt_jfbp_redirect_new_custom = 'jfb_p_redirect_new_custom';
$opt_jfbp_redirect_existing = 'jfb_p_redirect_existing';
$opt_jfbp_redirect_existing_custom = 'jfb_p_redirect_new_existing';
$opt_jfbp_redirect_logout = 'jfb_p_redirect_logout';
$opt_jfbp_redirect_logout_custom = 'jfb_p_redirect_logout_custom';
$opt_jfbp_restrict_reg = 'jfb_p_restrict_reg';
$opt_jfbp_restrict_reg_url = 'jfb_p_restrict_reg_url';
$opt_jfbp_collapse_prompts = 'jfb_p_collapse_prompts';
$opt_jfbp_show_spinner = 'jfb_p_show_spinner';

//Called when we save our options in the admin panel
function jfb_update_premium_opts()
{
    global $_POST, $jfb_name, $jfb_version, $opt_jfb_req_perms;
    global $opt_jfbp_notifyusers, $opt_jfbp_notifyusers_content, $opt_jfbp_notifyusers_subject;
    global $opt_jfbp_commentfrmlogin, $opt_jfbp_wploginfrmlogin, $opt_jfbp_registrationfrmlogin, $opt_jfbp_cache_avatars, $opt_jfbp_cache_avatar_dir;
    global $opt_jfbp_buttonsize, $opt_jfbp_buttontext, $opt_jfbp_ignoredouble, $opt_jfbp_requirerealmail;
    global $opt_jfbp_redirect_new, $opt_jfbp_redirect_new_custom, $opt_jfbp_redirect_existing, $opt_jfbp_redirect_existing_custom, $opt_jfbp_redirect_logout, $opt_jfbp_redirect_logout_custom;
    global $opt_jfbp_restrict_reg, $opt_jfbp_restrict_reg_url;
    global $opt_jfbp_collapse_prompts, $opt_jfbp_show_spinner;
    update_option( $opt_jfbp_notifyusers, $_POST[$opt_jfbp_notifyusers] );
    update_option( $opt_jfbp_notifyusers_subject, stripslashes($_POST[$opt_jfbp_notifyusers_subject]) );
    update_option( $opt_jfbp_notifyusers_content, stripslashes($_POST[$opt_jfbp_notifyusers_content]) );
    update_option( $opt_jfbp_commentfrmlogin, $_POST[$opt_jfbp_commentfrmlogin] );
    update_option( $opt_jfbp_wploginfrmlogin, $_POST[$opt_jfbp_wploginfrmlogin] );
    update_option( $opt_jfbp_registrationfrmlogin, $_POST[$opt_jfbp_registrationfrmlogin] );
    update_option( $opt_jfbp_cache_avatars, $_POST[$opt_jfbp_cache_avatars] );
    update_option( $opt_jfbp_cache_avatar_dir, $_POST[$opt_jfbp_cache_avatar_dir] );
    update_option( $opt_jfbp_buttonsize, $_POST[$opt_jfbp_buttonsize] );
    update_option( $opt_jfbp_buttontext, $_POST[$opt_jfbp_buttontext] );
    update_option( $opt_jfbp_ignoredouble, $_POST[$opt_jfbp_ignoredouble] );
    update_option( $opt_jfbp_redirect_new, $_POST[$opt_jfbp_redirect_new] );
    update_option( $opt_jfbp_redirect_new_custom, $_POST[$opt_jfbp_redirect_new_custom] );
    update_option( $opt_jfbp_redirect_existing, $_POST[$opt_jfbp_redirect_existing] );
    update_option( $opt_jfbp_redirect_existing_custom, $_POST[$opt_jfbp_redirect_existing_custom] );
    update_option( $opt_jfbp_redirect_logout, $_POST[$opt_jfbp_redirect_logout] );
    update_option( $opt_jfbp_redirect_logout_custom, $_POST[$opt_jfbp_redirect_logout_custom] );
    update_option( $opt_jfbp_restrict_reg, $_POST[$opt_jfbp_restrict_reg] );
    update_option( $opt_jfbp_restrict_reg_url, $_POST[$opt_jfbp_restrict_reg_url] );
    update_option( $opt_jfbp_collapse_prompts, $_POST[$opt_jfbp_collapse_prompts] );
    update_option( $opt_jfbp_show_spinner, $_POST[$opt_jfbp_show_spinner] );
    
    //If "require real email" is set, auto-check the basic email-prompting option too
    update_option( $opt_jfbp_requirerealmail, $_POST[$opt_jfbp_requirerealmail] );
    if( $_POST[$opt_jfbp_requirerealmail] ) update_option( $opt_jfb_req_perms, 1 );
    jfb_auth($jfb_name, $jfb_version, 5, JFB_PREMIUM_VALUE);
    ?><div class="updated"><p><strong>Premium Options saved.</strong></p></div><?php    
}

//Called to delete our options from the admin panel
function jfb_delete_premium_opts()
{
    global $opt_jfbp_notifyusers, $opt_jfbp_notifyusers_content, $opt_jfbp_notifyusers_subject;
    global $opt_jfbp_commentfrmlogin, $opt_jfbp_wploginfrmlogin, $opt_jfbp_registrationfrmlogin, $opt_jfbp_cache_avatars, $opt_jfbp_cache_avatar_dir;
    global $opt_jfbp_buttonsize, $opt_jfbp_buttontext, $opt_jfbp_ignoredouble, $opt_jfbp_requirerealmail;
    global $opt_jfbp_redirect_new, $opt_jfbp_redirect_new_custom, $opt_jfbp_redirect_existing, $opt_jfbp_redirect_existing_custom, $opt_jfbp_redirect_logout, $opt_jfbp_redirect_logout_custom;
    global $opt_jfbp_restrict_reg, $opt_jfbp_restrict_reg_url;
    global $opt_jfbp_collapse_prompts, $opt_jfbp_show_spinner;
    delete_option($opt_jfbp_notifyusers);
    delete_option($opt_jfbp_notifyusers_subject);
    delete_option($opt_jfbp_notifyusers_content);
    delete_option($opt_jfbp_commentfrmlogin);
    delete_option($opt_jfbp_wploginfrmlogin);
    delete_option($opt_jfbp_registrationfrmlogin);
    delete_option($opt_jfbp_cache_avatars);
    delete_option($opt_jfbp_cache_avatar_dir);
    delete_option($opt_jfbp_buttonsize);
    delete_option($opt_jfbp_buttontext);
    delete_option($opt_jfbp_ignoredouble);
    delete_option($opt_jfbp_requirerealmail);
    delete_option($opt_jfbp_redirect_new);
    delete_option($opt_jfbp_redirect_new_custom);
    delete_option($opt_jfbp_redirect_existing);
    delete_option($opt_jfbp_redirect_existing_custom);
    delete_option($opt_jfbp_redirect_logout);
    delete_option($opt_jfbp_redirect_logout_custom);
    delete_option($opt_jfbp_restrict_reg);
    delete_option($opt_jfbp_restrict_reg_url);
    delete_option($opt_jfbp_collapse_prompts);
    delete_option($opt_jfbp_show_spinner);
}


/**********************************************************************/
/**********************************************************************/
/**************************ADMIN PANEL*********************************/
/**********************************************************************/
/**********************************************************************/

function jfb_output_premium_panel()
{
    global $jfb_homepage;
    global $opt_jfbp_notifyusers, $opt_jfbp_notifyusers_subject, $opt_jfbp_notifyusers_content, $opt_jfbp_commentfrmlogin, $opt_jfbp_wploginfrmlogin, $opt_jfbp_registrationfrmlogin, $opt_jfbp_cache_avatars, $opt_jfbp_cache_avatar_dir;
    global $opt_jfbp_buttonsize, $opt_jfbp_buttontext, $opt_jfbp_ignoredouble, $opt_jfbp_requirerealmail;
    global $opt_jfbp_redirect_new, $opt_jfbp_redirect_new_custom, $opt_jfbp_redirect_existing, $opt_jfbp_redirect_existing_custom, $opt_jfbp_redirect_logout, $opt_jfbp_redirect_logout_custom;
    global $opt_jfbp_restrict_reg, $opt_jfbp_restrict_reg_url;
    global $opt_jfbp_collapse_prompts, $opt_jfbp_show_spinner;
    function disableatt() { echo (defined('JFB_PREMIUM')?"":"disabled='disabled'"); }
    ?>
    <h3>Premium Options <?php echo (defined('JFB_PREMIUM_VER')?"<small>(Version " . JFB_PREMIUM_VER . ")</small>":""); ?></h3>
    
    <?php 
    if( !defined('JFB_PREMIUM') )
        echo "<div class=\"error\"><i><b>The following options are available to Premium users only.</b><br />For information about the WP-FB-AutoConnect Premium Add-On, including purchasing instructions, please visit the plugin homepage <b><a href=\"$jfb_homepage#premium\">here</a></b></i>.</div>";
    ?>
    
    <form name="formPremOptions" method="post" action="">
    
        <b>MultiSite Support:</b><br/>
		<input disabled='disabled' type="radio" name="musupport" value="1" <?php echo (is_multisite()?"checked='checked'":"")?> >This is automatically enabled when a MultiSite install is detected.<br /><br />
		
		<b>Facebook Localization:</b><br />
		If your Wordpress installation has a <a href="http://developers.facebook.com/docs/internationalization">valid and supported language code</a> specified in <a href="http://codex.wordpress.org/Installing_WordPress_in_Your_Language">wp-config.php</a>, the Facebook prompts will automatically be translated to that language.  The detected langauge for this installation is <i><b><?php echo ( (defined('WPLANG')&&WPLANG!="") ? WPLANG : "en_US" ); ?></b></i>.  You should see a string like "en_US", "ja_JP", "es_LA", etc.<br /><br />
		
        <b>Button Text:</b><br />
        <?php add_option($opt_jfbp_buttontext, "Login with Facebook"); ?>
        <input <?php disableatt() ?> type="text" size="30" name="<?php echo $opt_jfbp_buttontext; ?>" value="<?php echo get_option($opt_jfbp_buttontext); ?>" /><br /><br />
        
        <b>Button Size:</b><br />
        <?php add_option($opt_jfbp_buttonsize, "2"); ?>
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_buttonsize; ?>" value="1" <?php echo (get_option($opt_jfbp_buttonsize)==1?"checked='checked'":"")?> >Icon Only
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_buttonsize; ?>" value="2" <?php echo (get_option($opt_jfbp_buttonsize)==2?"checked='checked'":"")?>>Small Text
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_buttonsize; ?>" value="3" <?php echo (get_option($opt_jfbp_buttonsize)==3?"checked='checked'":"")?>>Medium Text
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_buttonsize; ?>" value="4" <?php echo (get_option($opt_jfbp_buttonsize)==4?"checked='checked'":"")?>>Large Text
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_buttonsize; ?>" value="5" <?php echo (get_option($opt_jfbp_buttonsize)==5?"checked='checked'":"")?>>X-Large Text<br /><br />
        
        <b>Additional Buttons:</b><br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_commentfrmlogin?>" value="1" <?php echo get_option($opt_jfbp_commentfrmlogin)?'checked="checked"':''?> /> Add a Facebook Login button below the comment form<br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_wploginfrmlogin?>" value="1" <?php echo get_option($opt_jfbp_wploginfrmlogin)?'checked="checked"':''?> /> Add a Facebook Login button to the standard Login page (wp-login.php)<br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_registrationfrmlogin?>" value="1" <?php echo get_option($opt_jfbp_registrationfrmlogin)?'checked="checked"':''?> /> Add a Facebook Login button to the Registration page (wp-login.php)<br /><br />
    
        <b>Avatar Caching:</b><br />         
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_cache_avatars?>" value="1" <?php echo get_option($opt_jfbp_cache_avatars)?'checked="checked"':''?> />
        Cache Facebook avatars to: <span style="background-color:#FFFFFF; color:#aaaaaa; padding:2px 0;">
        <?php 
        add_option($opt_jfbp_cache_avatar_dir, 'facebook-avatars');
        $ud = wp_upload_dir();
        echo "<i>" . $ud['path'] . "/</i>";         
        ?>
        </span>
        <input <?php disableatt() ?> type="text" size="30" name="<?php echo $opt_jfbp_cache_avatar_dir; ?>" value="<?php echo get_option($opt_jfbp_cache_avatar_dir); ?>" /><br />
        <small>This will make a local copy of Facebook avatars, so they'll always load reliably, even if Facebook's servers go offline or if a user deletes their photo from Facebook. They will be fetched and updated whenever a user logs in.<br />
        <b><u>NOTE:</u></b> Changing the cache directory will not move existing avatars or update existing users; it only applies to subsequent logins.  It's therefore recommended that you choose a cache directory once, then leave it be.</small><br /><br />
        
        <b>AJAX Spinner:</b><br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_show_spinner; ?>" value="0" <?php echo (get_option($opt_jfbp_show_spinner)==0?"checked='checked'":"")?> >Don't show an AJAX spinner<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_show_spinner; ?>" value="1" <?php echo (get_option($opt_jfbp_show_spinner)==1?"checked='checked'":"")?> >Show a white AJAX spinner to indicate the login process has started (<img src=" <?php echo plugins_url(dirname(plugin_basename(__FILE__))) ?>/spinner/spinner_white.gif" alt="spinner" />)<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_show_spinner; ?>" value="2" <?php echo (get_option($opt_jfbp_show_spinner)==2?"checked='checked'":"")?> >Show a black AJAX spinner to indicate the login process has started (<img src=" <?php echo plugins_url(dirname(plugin_basename(__FILE__))) ?>/spinner/spinner_black.gif" alt="spinner" />)<br /><br />
                
        <b>AutoRegistration:</b><br />
        <?php add_option($opt_jfbp_restrict_reg_url, '/') ?>
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_restrict_reg; ?>" value="0" <?php echo (get_option($opt_jfbp_restrict_reg)==0?"checked='checked'":"")?>>Enabled: Anyone can login (Default)<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_restrict_reg; ?>" value="1" <?php echo (get_option($opt_jfbp_restrict_reg)==1?"checked='checked'":"")?>>Disabled: Only login existing blog users; redirect others to the URL below.<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_restrict_reg; ?>" value="2" <?php echo (get_option($opt_jfbp_restrict_reg)==2?"checked='checked'":"")?>>Invitational: Only login users who've been invited via the <a href="http://wordpress.org/extend/plugins/wordpress-mu-secure-invites/">Secure Invites</a> plugin; redirect others to the URL below.<br />
        <small>(*Their Facebook email must be accessible, and must match the email to which the invitation was sent)</small><br />
        Redirect URL for denied logins: <input <?php disableatt() ?> type="text" size="30" name="<?php echo $opt_jfbp_restrict_reg_url?>" value="<?php echo get_option($opt_jfbp_restrict_reg_url) ?>" /><br /><br />
        
        <!-- <b>Facebook Popups:</b><br />  -->
        <!-- <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_collapse_prompts; ?>" value="0" <?php echo (get_option($opt_jfbp_collapse_prompts)==0?"checked='checked'":"")?>>Show each prompt in a separate popup (Default)<br />  -->
        <!-- <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_collapse_prompts; ?>" value="1" <?php echo (get_option($opt_jfbp_collapse_prompts)==1?"checked='checked'":"")?>>Group prompts into a single popup<br /><br />  -->
        
        <b>Custom Redirects:</b><br />
        <?php add_option($opt_jfbp_redirect_new, "1"); ?>
        <?php add_option($opt_jfbp_redirect_existing, "1"); ?>
        <?php add_option($opt_jfbp_redirect_logout, "1"); ?>
        When a new user is autoregistered on your site, redirect them to:<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_new; ?>" value="1" <?php echo (get_option($opt_jfbp_redirect_new)==1?"checked='checked'":"")?> >Default (refresh current page)<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_new; ?>" value="2" <?php echo (get_option($opt_jfbp_redirect_new)==2?"checked='checked'":"")?> >Custom URL:
        <input <?php disableatt() ?> type="text" size="47" name="<?php echo $opt_jfbp_redirect_new_custom?>" value="<?php echo get_option($opt_jfbp_redirect_new_custom) ?>" /><br /><br />
        When an existing user returns to your site, redirect them to:<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_existing; ?>" value="1" <?php echo (get_option($opt_jfbp_redirect_existing)==1?"checked='checked'":"")?> >Default (refresh current page)<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_existing; ?>" value="2" <?php echo (get_option($opt_jfbp_redirect_existing)==2?"checked='checked'":"")?> >Custom URL:
        <input <?php disableatt() ?> type="text" size="47" name="<?php echo $opt_jfbp_redirect_existing_custom?>" value="<?php echo get_option($opt_jfbp_redirect_existing_custom) ?>" /><br /><br />
        When a user logs out of your site, redirect them to:<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_logout; ?>" value="1" <?php echo (get_option($opt_jfbp_redirect_logout)==1?"checked='checked'":"")?> >Default (refresh current page)<br />
        <input <?php disableatt() ?> type="radio" name="<?php echo $opt_jfbp_redirect_logout; ?>" value="2" <?php echo (get_option($opt_jfbp_redirect_logout)==2?"checked='checked'":"")?> >Custom URL:
        <input <?php disableatt() ?> type="text" size="47" name="<?php echo $opt_jfbp_redirect_logout_custom?>" value="<?php echo get_option($opt_jfbp_redirect_logout_custom) ?>" /><br /><br />
        
        <b>Welcome Message:</b><br />
        <?php add_option($opt_jfbp_notifyusers_content, "Thank you for logging into " . get_option('blogname') . " with Facebook.\nIf you would like to login manually, you may do so with the following credentials.\n\nUsername: %username%\nPassword: %password%"); ?>
        <?php add_option($opt_jfbp_notifyusers_subject, "Welcome to " . get_option('blogname')); ?>
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_notifyusers?>" value="1" <?php echo get_option($opt_jfbp_notifyusers)?'checked="checked"':''?> /> Send a custom welcome e-mail to users who register via Facebook <small>(*If we know their address)</small><br />
        <input <?php disableatt() ?> type="text" size="102" name="<?php echo $opt_jfbp_notifyusers_subject?>" value="<?php echo get_option($opt_jfbp_notifyusers_subject) ?>" /><br />
        <textarea <?php disableatt() ?> cols="85" rows="5" name="<?php echo $opt_jfbp_notifyusers_content?>"><?php echo get_option($opt_jfbp_notifyusers_content) ?></textarea><br /><br />
        
		<b>E-Mail:</b><br />
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_requirerealmail?>" value="1" <?php echo get_option($opt_jfbp_requirerealmail)?'checked="checked"':''?> /> Enforce access to user's real email<br />
        <small>The basic option to "Request and require permission" prevents users from logging in unless they click "Allow" when prompted for their email.  However, they can still mask their true address by using a Facebook proxy (click "change" in the permissions dialog, and select "xxx@proxymail.facebook.com").  This option performs a secondary check to absolutely enforce that they allow access to their <i>real</i> e-mail.  Note that the check requires several extra queries to Facebook's servers, so it could result in a slightly longer delay before the login initiates on slower connections.)</small><br /><br />
        
        <b>Double Logins:</b><br />
        <?php add_option($opt_jfbp_ignoredouble, "1"); ?>
        <input <?php disableatt() ?> type="checkbox" name="<?php echo $opt_jfbp_ignoredouble?>" value="1" <?php echo get_option($opt_jfbp_ignoredouble)?'checked="checked"':''?> /> Silently handle double logins (recommended)<br />
        <small>(If a visitor opens two browser windows, logs into one, then logs into the other, the security nonce check will fail (see <a href="http://codex.wordpress.org/WordPress_Nonces">Wordpress Nonces</a>).  This is because in the second window, the current user no longer matches the user for which the nonce was generated.  The free version of the plugin reports this to the visitor, giving them a link to their desired redirect page.  This option will let your site transparently handle such double-logins: to visitors, it'll look like the page has just been refreshed and they're now logged in.)</small><br />
                
        <input type="hidden" name="prem_opts_updated" value="1" />
        <div class="submit"><input <?php disableatt() ?> type="submit" name="Submit" value="Save" /></div>
    </form>
    <hr />
    <?php    
}


/**********************************************************************/
/**********************************************************************/
/***************************IMPLEMENTATION*****************************/
/**********************************************************************/
/**********************************************************************/

///////////////////////////Version Check////////////////////////////////
////////////////////////////////////////////////////////////////////////

/**
  * Add a warning message to the admin panel if using an out-of-date core plugin version 
  */
add_action('wpfb_admin_messages', 'jfb_check_premium_version');
function jfb_check_premium_version()
{
    global $jfb_version;
    if( version_compare($jfb_version, JFB_PREMIUM_REQUIREDVER) == -1 ): ?>
    <div class="error"><p><strong>Warning:</strong> The Premium addon requires WP-FB-AutoConnect <?php echo JFB_PREMIUM_REQUIREDVER ?> or newer to make use of all available features.  Please update your core plugin.</span></p></div>
    <?php endif;
}

//////////////////////Logging & Version Reporting///////////////////////
////////////////////////////////////////////////////////////////////////
add_action('wpfb_prelogin', 'jfb_log_premium');
function jfb_log_premium()
{
    global $jfb_log;
    $jfb_log .= "PREMIUM: Premium Addon Detected (#" . JFB_PREMIUM . ", Version: " . JFB_PREMIUM_VER . ")\n"; 
}

add_action('wpfb_after_button', 'jfb_report_premium_version');
function jfb_report_premium_version()
{
    echo "<!--Premium Add-On #" . JFB_PREMIUM . ", version " . JFB_PREMIUM_VER . "-->\n"; 
}


///////////////////////////MultiSite Support////////////////////////////////
////////////////////////////////////////////////////////////////////////////

/**
  * A function to get a list of all users across all sites (rather than get_users_of_blog())
  */
if( is_multisite() ) add_action('wpfb_connect', 'jfb_multisite_get_users');
function jfb_multisite_get_users($args)
{
    global $wp_users, $wpdb;
    $wp_users = $wpdb->get_results( "SELECT user_login,user_email,ID FROM {$wpdb->users}" );
}

/**
  * When we login, make sure to add the current user to the current blog
  * (aka autoregister existing users from this multisite install onto the current blog, which they may or may not already be a member of)
  */
if( is_multisite() ) add_action('wpfb_login', 'jfb_multisite_add_to_blog');
function jfb_multisite_add_to_blog($args)
{
    global $jfb_log;
    $jfb_log .= "WPMU: Added user to current blog.\n";
	add_existing_user_to_blog(array('user_id'=>$args['WP_ID']));
}


////////////////////////////Custom Redirects////////////////////////////////
////////////////////////////////////////////////////////////////////////////

/**
  * Custom redirect for NEW (autoregistered) users 
  */
if( get_option($opt_jfbp_redirect_new) == 2 ) add_action('wpfb_inserted_user', 'jfb_redirect_newuser');
function jfb_redirect_newuser()
{
    global $jfb_log, $redirectTo, $opt_jfbp_redirect_new_custom;
    $jfb_log .= "PREMIUM: Using custom redirect for autoregistered user: " . get_option($opt_jfbp_redirect_new_custom) . "\n";
    $redirectTo = get_option($opt_jfbp_redirect_new_custom);
}

/**
  * Custom redirect for EXISTING users 
  */
if( get_option($opt_jfbp_redirect_existing) == 2 ) add_action('wpfb_existing_user', 'jfb_redirect_existinguser');
function jfb_redirect_existinguser()
{
    global $jfb_log, $redirectTo, $opt_jfbp_redirect_existing_custom;
    $jfb_log .= "PREMIUM: Using custom redirect for existing user: " . get_option($opt_jfbp_redirect_existing_custom) . "\n";
    $redirectTo = get_option($opt_jfbp_redirect_existing_custom);
}

/**
  * Custom redirect for LOGGING OUT users.  This uses the standard wordpress hook.
  */
if( get_option($opt_jfbp_redirect_logout) == 2 ) add_action('logout_url', 'jfb_redirect_logout');
function jfb_redirect_logout($url)
{
    global $opt_jfbp_redirect_logout_custom;
    $url = remove_query_arg( 'redirect_to', $url );
    $url = add_query_arg('redirect_to', get_option($opt_jfbp_redirect_logout_custom), $url );
    return $url;
}

///////////////AutoRegistration Enable/Disable/Invitational/////////////////
////////////////////////////////////////////////////////////////////////////

/**
  * Autoregistration Option: Perform additional actions prior to inserting a new user 
  */
if( get_option($opt_jfbp_restrict_reg) ) add_filter('wpfb_insert_user', 'jfb_registration_restrict', 10, 2);
function jfb_registration_restrict($user_data, $fbuser)
{
    global $jfb_log, $wpdb, $opt_jfbp_restrict_reg, $opt_jfbp_restrict_reg_url;
    if( get_option($opt_jfbp_restrict_reg) == 1 )
    {
        $jfb_log .= "PREMIUM: Autoregistration is Disabled; redirecting to " . get_option($opt_jfbp_restrict_reg_url) . ".\n";
        header("Location: " . get_option($opt_jfbp_restrict_reg_url));
        j_mail("Facebook Login: Autoregistration Disabled");
        exit;
    }
    else if( get_option($opt_jfbp_restrict_reg) == 2)
    {
        $result = $wpdb->get_results( "SELECT * FROM wp_invitations WHERE invited_email='" . $user_data['user_email'] . "'");
        if(is_array($result) && count($result) > 0)
            $jfb_log .= "PREMIUM: AutoRegistration Invitational: User " . $user_data['user_email'] . " has been invited; continuing login.\n";
        else
        {
            $jfb_log .= "PREMIUM: AutoRegistration Invitational: User " . $user_data['user_email'] . " not found in wp_invites; Redirecting to " . get_option($opt_jfbp_restrict_reg_url) . "\n";
            header("Location: " . get_option($opt_jfbp_restrict_reg_url));
            j_mail("Facebook Login: Autoregistration Invitational Denied");
            exit;
        }
    }
    return $user_data;
}


///////////////////////////E-Mail Notification//////////////////////////////
////////////////////////////////////////////////////////////////////////////

/**
 * Send a custom notification message to newly connecting users
 */
if( get_option($opt_jfbp_notifyusers)) add_action('wpfb_inserted_user', 'jfb_notify_newuser');
function jfb_notify_newuser( $args )
{
    global $jfb_log, $opt_jfbp_notifyusers_subject, $opt_jfbp_notifyusers_content;
    $userdata = $args['WP_UserData'];
    $jfb_log .= "PREMIUM: Sending new registration notification to " . $userdata['user_email'] . ".\n";
    $mailContent = get_option($opt_jfbp_notifyusers_content);
    $mailContent = str_replace("%username%", $userdata['user_login'], $mailContent);
    $mailContent = str_replace("%password%", $userdata['user_pass'], $mailContent);
    wp_mail($userdata['user_email'], get_option($opt_jfbp_notifyusers_subject), $mailContent);
}


///////////////////////////Additional Buttons///////////////////////////////
////////////////////////////////////////////////////////////////////////////

/**
 * Add another Login with Facebook button below the comment form
 */
if(get_option($opt_jfbp_commentfrmlogin)) add_action('comment_form', 'jfb_show_comment_button');
function jfb_show_comment_button()
{
    $userdata = wp_get_current_user();
    if( !$userdata->ID )
    {
        echo '<div id="facebook-btn-wrap">';
        jfb_output_facebook_btn();
        echo "</div>";
    }
}

/**
 * Add another Login with Facebook button to wp-login.php (requires 4 separate filters).
 */
if( get_option($opt_jfbp_wploginfrmlogin) || get_option($opt_jfbp_registrationfrmlogin) )
{
    add_filter('login_message', 'jfb_show_loginform_btn_outputcallback');
    add_action('login_head', 'jfb_show_loginform_btn_styles' );

    if( get_option($opt_jfbp_wploginfrmlogin) )
    {
        add_action('login_form', 'jfb_show_loginform_btn_initbtn');
        add_filter('login_redirect', 'jfb_show_loginform_btn_getredirect');
    }
    if( get_option($opt_jfbp_registrationfrmlogin) )
    {
        add_action('register_form', 'jfb_show_loginform_btn_initbtn');
        add_filter('registration_redirect', 'jfb_show_registerform_btn_getredirect');
    }
}

function jfb_show_loginform_btn_getredirect($arg)
{
    global $jfb_saved_redirect;
    $jfb_saved_redirect = $arg;
    return $arg;
}
function jfb_show_registerform_btn_getredirect($arg)
{
    global $jfb_saved_redirect;
    $jfb_saved_redirect = "/";
    return $arg;    
}
function jfb_show_loginform_btn_initbtn()
{
    echo '<div id="facebook-btn-wrap">';
    jfb_output_facebook_btn();
    jfb_output_facebook_init(false);
    echo "</div>";
}
function jfb_show_loginform_btn_outputcallback( $arg )
{
    //Unfortunately, the login_form hook runs inside the <form></form> tags, so we can't use that to output our form.
    //Instead, I use login_message, which is run before the wp-login.php form.  If this isn't wp-login, stop executing.
    if( strpos($_SERVER['SCRIPT_FILENAME'], 'wp-login.php') === FALSE ) return $arg;
    
    //Output the form
    global $jfb_saved_redirect;
    jfb_output_facebook_callback($jfb_saved_redirect);
    return $arg;
}
function jfb_show_loginform_btn_styles()
{
    //Since wp-login.php doesn't run wp_head(), I can't include jQuery the "right" way.
    //Include my own copy here, if the user has selected to use the AJAX spinner.
    global $opt_jfbp_show_spinner;
    if( get_option($opt_jfbp_show_spinner) )
        echo "<script type='text/javascript' src='" . plugins_url(dirname(plugin_basename(__FILE__))) . "/spinner/jquery-1.4.4.min.js'></script>";
    
    //Output CSS so our form isn't visible.
    echo '<style type="text/css" media="screen">
		#wp-fb-ac-fm { width: 0; height: 0; margin: 0; padding: 0; border: 0; }
		</style>';
}


//////////////////////////Button Size & Text////////////////////////////////
////////////////////////////////////////////////////////////////////////////

/*
 * If present, this function will override the default <fb:login-button> tag outputted by
 * jfb_output_facebook_btn() in the free plugin.  It references the premium options to let us
 * customize the button from the admin panel.
 */
add_filter('wpfb_output_button', 'jfb_output_facebook_btn_premium'); 
function jfb_output_facebook_btn_premium($arg)
{
    global $jfb_js_callbackfunc, $opt_jfbp_buttonsize, $opt_jfbp_buttontext;
    $attr = "";
    if( get_option($opt_jfbp_buttonsize) == 1 )     $attr = 'size="small"';
    else if( get_option($opt_jfbp_buttonsize) == 2 )$attr = 'v="2" size="small"';
    else if( get_option($opt_jfbp_buttonsize) == 3 )$attr = 'v="2" size="medium"';
    else if( get_option($opt_jfbp_buttonsize) == 4 )$attr = 'v="2" size="large"';
    else if( get_option($opt_jfbp_buttonsize) == 5 )$attr = 'v="2" size="xlarge"';
    return "document.write('<fb:login-button $attr onlogin=\"$jfb_js_callbackfunc();\">" . get_option($opt_jfbp_buttontext) . "</fb:login-button>');";
}


/////////////////////////////Double-Logins//////////////////////////////////
////////////////////////////////////////////////////////////////////////////

/**
  * Silently handle "double-logins" by returning to the referring page (i.e. don't perform the login - we're already logged in!)
  */
if( get_option($opt_jfbp_ignoredouble) ) add_action('wpfb_prelogin', 'jfb_ignore_redundant_logins');
function jfb_ignore_redundant_logins()
{
    //If we're trying to login and a user is already logged-in, this is a "double login"
    $currUser = wp_get_current_user();
    if( !$currUser->ID ) return;
    
    //Get the redirect URL.  _wp_http_referer comes from the NONCE, not the user-specified redirect url.
    if( isset($_POST['_wp_http_referer']))
        $redirect = $_POST['_wp_http_referer'];
    else if( isset($_POST['redirectTo']))
        $redirect = $_POST['redirectTo'];
    else
        return;
 
    global $jfb_log;
    $jfb_log .= "PREMIUM: User \"$currUser->user_login\" has already logged in via another browser session.  Silently refreshing the current page.\n";
    j_mail("Facebook Double-Login: " . $currUser->user_login);
    header("Location: " . $redirect);
    exit;
}


/////////////////////////Collapse Facebook Popups///////////////////////////
////////////////////////////////////////////////////////////////////////////
//THIS IS UNFINISHED.  Where I left off:  Apparently they changed the format of
//their session cookies (see http://forum.developers.facebook.net/viewtopic.php?id=63534).
//I think this means I need to update the php library I'm using on the backend to match
//the new frontend, which in turm means every call to the old REST API will need to be
//converted to a call in the new API's format.  In order to retain backwards compatability
//with the old API, I should CHECK FOR THIS OPTION before including the API,and if set, include the new one.
//Thus, I should probably change the name of the option to "Use New API" or something...

/*
 * Step one for grouping the Facebook prompts: Add a "perms" attribute to the login-button tag.
 */
if( get_option($opt_jfbp_collapse_prompts) ) add_filter('wpfb_output_button', 'jfb_output_facebook_btn_premium_perms'); 
function jfb_output_facebook_btn_premium_perms($arg)
{
    global $opt_jfb_ask_perms, $opt_jfb_req_perms, $opt_jfb_ask_stream;
    $email_perms = get_option($opt_jfb_ask_perms) || get_option($opt_jfb_req_perms);
    $stream_perms = get_option($opt_jfb_ask_stream);

    if( $email_perms && $stream_perms )    $attr = 'perms="email,publish_stream"';
    else if( $email_perms )                $attr = 'perms="email"';
    else if( $stream_perms )               $attr = 'perms="publish_stream"';
    else                                   $attr = '';
    return str_replace( "login-button ", "login-button " . $attr . " ", $arg);
}

/**
  * Step two: We need to initialize the Facebook API differently!
  * This means REMOVING the existing jfb_output_facebook_init action introduced by the free plugin, and replacing it with another 
  */
if( get_option($opt_jfbp_collapse_prompts) ) add_action('wp_footer', 'jfb_output_facebook_init_premium', 1);
function jfb_output_facebook_init_premium()
{
    global $opt_jfb_app_id;
    remove_action('wp_footer', 'jfb_output_facebook_init');
    ?>
    <div id="fb-root"></div>
    <script type="text/javascript">//<!--
      window.fbAsyncInit = function()
      {
        FB.init({ appId: '<?php echo get_option($opt_jfb_app_id); ?>', status: true, cookie: true, xfbml: true });
      };

      (function() {
        var e = document.createElement('script');
        e.src = document.location.protocol + '//connect.facebook.net/en_US/all.js';
        e.async = true;
        document.getElementById('fb-root').appendChild(e);
      }());
    //--></script>
    <?php 
}

/**
  * Step three: The default callback uses functions from the old REST api, which are no longer supported.
  * Thus, I use wpfb_add_to_js to insert updated code which will run before the old stuff and exits
  * (making the default callback effectively functionless, when this option is enabled)
  * NOTE: With this option, "Ask email permissions" and "Require email permissions" are effectively the same,
  * because if you ask, there's no way to deny: everything is in the same popup.
  * However, we do have to replicate the ENFORCE option below, in code suitable to the new JS API.
  * See http://developers.facebook.com/docs/reference/javascript/FB.api for the new API
  */
if( get_option($opt_jfbp_collapse_prompts) ) add_action('wpfb_add_to_js', 'jfb_output_facebook_callback_premium');
function jfb_output_facebook_callback_premium($callbackName)
{
    global $opt_jfbp_requirerealmail;
        
    //First, we need to make sure the user clicked ACCEPT in the dialog. If not, do nothing.
    $code = "//PREMIUM LOGIN: Grouped Dialogs\n" .
    		"FB.getLoginStatus(function(response) {\n".
            "  if (response.session){\n";
    
    //Implement "Enforce e-mail permissions". This is identical to the code below; the function calls are just reformatted to use the new JS API.
    $submitCode = "document." . $callbackName . "_form.submit();\n";
    if( get_option($opt_jfbp_requirerealmail) )
    {
        $code .= 
        	"//PREMIUM CHECK: Enforce non-proxied emails\n" .
           	"FB.api( {method:'users.getLoggedInUser'}, function(uid)\n".
         	"{\n".
            "    FB.api( {method:'users.getInfo', uids:uid, fields:'email,contact_email'}, function(emailCheckStrict)\n".
            "    {\n" .
            "        if(emailCheckStrict[0].contact_email)               //User allowed their real email\n".
            "            ".$submitCode.                 
            "        else if(emailCheckStrict[0].email)                  //User clicked allow, but chose a proxied email.\n".
            "        {\n".
            "            alert('Sorry, the site administrator has chosen not to allow anonymous emails.\\nYou must allow access to your real email address to login.');\n" .
            "            FB.api( {method:'auth.revokeExtendedPermission', perm:'email'}, function(){});\n".
            "        }\n".
            "    });\n".
            "});\n";
    }
    
    //If "Enforce Email" is not selected, just submit the login form - everything else (i.e. prompts) are already handled by attributes to the login-button tag.
    else
        $code .= $submitCode;
        
    //Close the FB.getLoginStatus call
    $code .= "}});\n";
    
    //And STOP EXECUTING (i.e. don't continue on with the callback - to the original (non-new API code from the base plugin)    
    $code .= "return;\n\n";
    echo $code;
}


/////////////////////////Enforce Email Permission///////////////////////////
////(NOTE!! Maybe overridden by jfb_output_facebook_callback_premium())/////
////////////////////////////////////////////////////////////////////////////


/**
  * Enforcing that the user doesn't select a proxied e-mail address is actually a 2-step process.
  * First, we insert an additional check in Javascript where we pull their data from Facebook again
  * and see if we can get their real address.  If so, let them login.  If not, we reject them -
  * however, since the user technically clicked "accept" (after selecting to use the proxied address),
  * they won't be re-prompted for the same permission on future logins, so we also have to 
  * revoke the email permission so they'll have another chance to accept next time.
  *
  * NOTE: As of v8, this will become irrelevant when $opt_jfbp_collapse_prompts is enabled,
  * which effectively replaces the entire callback with code suitible for the NEW Javascript API
  */
if(get_option($opt_jfbp_requirerealmail) && get_option($opt_jfb_req_perms))
    add_filter('wpfb_submit_loginfrm', 'jfb_enforce_real_email');
function jfb_enforce_real_email( $submitCode )
{
    return	"//PREMIUM CHECK: Enforce non-proxied emails\n" .
           	"FB.Facebook.apiClient.users_getLoggedInUser( function(uid)\n".
         	"{\n".
            "    FB.Facebook.apiClient.users_getInfo(uid, 'email,contact_email', function(emailCheckStrict)\n".
            "    {\n" .
            "        if(emailCheckStrict[0].contact_email)               //User allowed their real email\n".
            "            ".$submitCode.                 
            "        else if(emailCheckStrict[0].email)                  //User clicked allow, but chose a proxied email.\n".
            "        {\n".
            apply_filters('wpfb_login_rejected', '').
            "            alert('Sorry, the site administrator has chosen not to allow anonymous emails.\\nYou must allow access to your real email address to login.');\n" .
            "            FB.Facebook.apiClient.callMethod('auth.revokeExtendedPermission', {'perm':'email'}, function(){});\n".
            "        }\n".
            "    });\n".
            "});\n";      
}


/////////////////////////////Cache Avatars//////////////////////////////////
////////////////////////////////////////////////////////////////////////////

/*
 * Cache Facebook avatars to the local server
 */
if( get_option($opt_jfbp_cache_avatars) ) add_action('wpfb_login', 'jfb_cache_local_avatar');
function jfb_cache_local_avatar( $args )
{
    //Make sure the path exists
    global $jfb_log, $opt_jfbp_cache_avatar_dir;
    $ud = wp_upload_dir();
    $subpath = get_option($opt_jfbp_cache_avatar_dir);
    $path = $ud['path'] . "/" . $subpath;
    $url = $ud['url'] . "/" . $subpath;
    @mkdir($path);
    $path .= "/";
    $url .= "/";
    $jfb_log .= "PREMIUM: Caching Facebook avatar to " . $path . ".\n";
    
    //Try to copy the thumbnail & update the meta
    $srcFile = get_usermeta($args['WP_ID'], 'facebook_avatar_thumb');
    $dstFile = $path . $args['WP_ID'] . "_thumb.jpg";
    if( !@copy( $srcFile, $dstFile ) )
    {
        $jfb_log .= "   ERROR copying file '$srcFile' to '$dstFile'.  Avatar caching aborted.\n";
        return;
    }
    update_usermeta($args['WP_ID'], 'facebook_avatar_thumb', $url . $args['WP_ID'] . '_thumb.jpg');

    //Try to copy the full image & update the meta
    $srcFile = get_usermeta($args['WP_ID'], 'facebook_avatar_full');
    $dstFile = $path . $args['WP_ID'] . "_full.jpg";
    if( !@copy( $srcFile, $dstFile ) )
    {
        $jfb_log .= "   ERROR copying file '" . print_r($srcFile, true) . "' to '$dstFile'.  Avatar caching aborted.\n";
        return;
    }
    update_usermeta($args['WP_ID'], 'facebook_avatar_full', $url . $args['WP_ID'] . '_full.jpg');
}


/////////////////////////////AJAX Spinner//////////////////////////////////
////////////////////////////////////////////////////////////////////////////

/**
 * When the user begins a login (after clicking "Login" in the Facebook popup), hide the button and show a spinner
 * NOTE: For this to work in wp-login.php, I have to include jQuery myself!  See the wp-login.php section.
 */
if( get_option($opt_jfbp_show_spinner) ) add_action('wpfb_add_to_js', 'jfb_button_to_spinner');
function jfb_button_to_spinner()
{
    echo "jQuery('#fbLoginButton').hide();\n";
    echo "jQuery('#login_spinner').show();\n";
}

/**
 * If the login fails (i.e. if they refused to reveal their email address), turn it back to a button 
 */
if( get_option($opt_jfbp_show_spinner) ) add_filter('wpfb_login_rejected', 'jfb_spinner_to_button');
function jfb_spinner_to_button()
{
    return "jQuery('#login_spinner').hide();\n" .
           "jQuery('#fbLoginButton').show();\n";
}

/**
 * Insert the spinner HTML (initially hidden) just after the Login with Facebook button
 */
if( get_option($opt_jfbp_show_spinner) ) add_action('wpfb_after_button', 'jfb_output_spinner');
function jfb_output_spinner()
{
    global $opt_jfbp_show_spinner;
    if( get_option($opt_jfbp_show_spinner) == 1 )
        echo "<div id=\"login_spinner\" style=\"display:none; margin-top:7px; text-align:center;\" ><img src=\"" . plugins_url(dirname(plugin_basename(__FILE__))) . "/spinner/spinner_white.gif\" alt=\"Please Wait...\" /></div>";
    else
        echo "<div id=\"login_spinner\" style=\"display:none; margin-top:7px; text-align:center;\" ><img src=\"" . plugins_url(dirname(plugin_basename(__FILE__))) . "/spinner/spinner_black.gif\" alt=\"Please Wait...\" /></div>";
}


////////////////////////Localize Facebook Popups////////////////////////////
////////////////////////////////////////////////////////////////////////////
if( defined('WPLANG') && WPLANG != '' ) add_action('wpfb_output_facebook_locale', 'jfb_output_fb_locale');
function jfb_output_fb_locale()
{
    echo WPLANG;
}


?>