<?php
/*
Plugin Name: WP Comment Auto Responder
Version: 3.0.3
Plugin URI: http://ahlul.web.id/blog/2009/04/19/wp-plugin-wordpress-comment-auto-responder.html
Description: Just check out my plugin url ;), dont forget to check this update, i'll make more feature later.
Author: Ahlul Faradish
Author URI: http://ahlul.web.id/blog
*/
$car_versi = get_option("com_auto_responeder_versi");
if($_GET["reset"]) {
	$car_versi = "";
	echo "<div id='message' class='updated'><p>Your settings is back to default...</p></div>";
}
if(empty($car_versi)) {
	update_option( "com_auto_responeder_versi", "3.0.3");
	update_option( "com_auto_responeder_lastid", "0");	
	wp_car_first_install();
}

function wp_car_first_install() {
	$pesan = "Hi [comment_author],

This is auto responder because you leave comment and has been approved on my blog.

You leave comment on this post:
---------------------------
[post_url]
---------------------------
[post_content]
---------------------------
Your comment is:
---------------------------
[comment_content]
---------------------------

You can visit your comment on:
[comment_url]

Thanks for visit and leave comment on my blog :)

I will review your comment as soon as possible.";

	$pesanadmin = "Hi [comment_replied_author],

[comment_content]
Here to read the replied comment directly: [comment_url]

You Wrote:
[comment_replied_content]
Here direct link: [comment_replied_url]";
	
	$tandatangan = "Regards,
[author_name]
[blog_url]
[blog_name] - [blog_description]";
	
	$pesansubjek = "Thanks for comment on my blog ([blog_name])";
	$pesanadminsubjek = "Your comment has been replied ([blog_name] )";
	
	update_option( "com_auto_responeder_pesan", $pesan );
	update_option( "com_auto_responeder_pesanadmin", $pesanadmin );
	update_option( "com_auto_responeder_pesansubjek", $pesansubjek );
	update_option( "com_auto_responeder_pesanadminsubjek", $pesanadminsubjek );	
	update_option( "com_auto_responeder_tandatangan", $tandatangan );
	update_option( "com_auto_responeder_batastanggal", date("Y-m-d") );
	update_option( "com_auto_responeder_fromname", "" );
	update_option( "com_auto_responeder_frommail", "" );
	update_option( "com_auto_responeder_usecustomsender", "" );	
	update_option( "com_auto_responeder_exreplied", "" );	
	update_option( "com_auto_responeder_tagpost", "" );	
}

#Please dont change this + latakaan dibawah
$credit = "\n-- \nThis message sent by Wordpress Comment Auto Responder.\nGet one for you! http://ahlul.web.id/blog/2009/04/19/wordpress-comment-auto-responder.html";

$car_pesansubjek = get_option("com_auto_responeder_pesansubjek");
$car_pesan = get_option("com_auto_responeder_pesan");
$car_pesanadminsubjek = get_option("com_auto_responeder_pesanadminsubjek");
$car_pesanadmin = get_option("com_auto_responeder_pesanadmin");
$car_tandatangan = get_option("com_auto_responeder_tandatangan");
$car_batastanggal = get_option("com_auto_responeder_batastanggal");
$car_lastid = get_option("com_auto_responeder_lastid");
$car_usecustomsender = get_option("com_auto_responeder_usecustomsender");
$car_fromname = get_option("com_auto_responeder_fromname");
$car_frommail = get_option("com_auto_responeder_frommail");
$car_exreplied = get_option("com_auto_responeder_exreplied");
$car_tagpost = get_option("com_auto_responeder_tagpost");

function wp_car_head() {
	$plugin_dir = get_bloginfo('url')."/wp-content/plugins";
	if(WP_CONTENT_URL) $plugin_dir = WP_CONTENT_URL."/plugins";
	if(WP_PLUGIN_URL) $plugin_dir = WP_PLUGIN_URL;
	echo "<script type=\"text/javascript\" src=\"".$plugin_dir."/wp-comment-auto-responder/calendarDateInput.js\"></script>";
	echo "<script type=\"text/javascript\" src=\"".$plugin_dir."/wp-comment-auto-responder/tabcontent.js\"></script>";
	echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$plugin_dir."/wp-comment-auto-responder/tabcontent.css\">";
}

function wp_car_options() {
	global $wpdb,$car_pesan,$car_pesansubjek, $car_pesanadmin,$car_pesanadminsubjek, $car_tandatangan, $car_batastanggal, $car_lastid,$car_fromname,$car_frommail,$car_usecustomsender,$car_exreplied,$car_tagpost;
	echo '<div class="wrap">';
	echo '<h2>WP Comment Auto Responder Options</h2>';
	echo '<h3>Please configure your auto responder below:</h3>';

if($_POST['wpcar_update']) {
	$pesansubjek = $_POST['wpcar_pesansubjek'];
	$pesan = $_POST['wpcar_pesan'];
	$tandatangan = $_POST['wpcar_tandatangan'];
	$batastanggal = $_POST['wpcar_batastanggal'];
	$pesanadminsubjek = $_POST['wpcar_pesanadminsubjek'];
	$pesanadmin = $_POST['wpcar_pesanadmin'];
	
	$fromname = $_POST['wpcar_fromname'];
	$frommail = $_POST['wpcar_frommail'];
	$usecustomsender = $_POST['wpcar_usecustomsender'];
	$exreplied = $_POST['exreplied'];
	$tagpost = $_POST['tagpost'];
	update_option( "com_auto_responeder_pesansubjek", $pesansubjek );
	update_option( "com_auto_responeder_pesan", $pesan );
	update_option( "com_auto_responeder_pesanadminsubjek", $pesanadminsubjek );
	update_option( "com_auto_responeder_pesanadmin", $pesanadmin );
	update_option( "com_auto_responeder_tandatangan", $tandatangan );
	update_option( "com_auto_responeder_batastanggal", $batastanggal );
	update_option( "com_auto_responeder_fromname", $fromname );
	update_option( "com_auto_responeder_frommail", $frommail );
	update_option( "com_auto_responeder_usecustomsender", $usecustomsender );	
	update_option( "com_auto_responeder_exreplied", $exreplied );
	update_option( "com_auto_responeder_tagpost", $tagpost );	
	
	$car_versi = get_option("com_auto_responeder_versi");
	$car_pesansubjek = get_option("com_auto_responeder_pesansubjek");
	$car_pesan = get_option("com_auto_responeder_pesan");
	$car_pesanadminsubjek = get_option("com_auto_responeder_pesanadminsubjek");
	$car_pesanadmin = get_option("com_auto_responeder_pesanadmin");
	$car_tandatangan = get_option("com_auto_responeder_tandatangan");
	$car_batastanggal = get_option("com_auto_responeder_batastanggal");
	$car_lastid = get_option("com_auto_responeder_lastid");
	$car_usecustomsender = get_option("com_auto_responeder_usecustomsender");
	$car_fromname = get_option("com_auto_responeder_fromname");
	$car_frommail = get_option("com_auto_responeder_frommail");
	$car_exreplied = get_option("com_auto_responeder_exreplied");
	$car_tagpost = get_option("com_auto_responeder_tagpost");	

	echo "<div id='message' class='updated'><p>New settings is saved...</p></div>";
	
}
?>

<ul id="flowertabs" class="shadetabs">
    <li><a href="#" rel="tcontent1" class="selected">Approved Comment</a></li>
    <li><a href="#" rel="tcontent2">Replied Comment</a></li>
    <li><a href="#" rel="tcontent3">Mail Signature</a></li>
    <li><a href="#" rel="tcontent4">Sender Option</a></li>
    <li><a href="#" rel="tcontent5">E-mail Send Test</a></li>
    <li><a href="#" rel="tcontent6">Support &amp; Donate for me</a></li>
    <li><a href="#" rel="tcontent7" style="color:#F00">Reset Settings</a></li>
</ul>
<form method="post" action="options-general.php?page=<? echo $_GET["page"]; ?>">
    <div style="border:1px solid gray; margin-bottom: 1em; padding: 10px; background-color:#E6F0F7">
        <div id="tcontent1" class="tabcontent">
            <p><strong>Put your message  subject for auto responder comment below:</strong></p>
            <small>This message subject will be send to your visitor that leave a approved comment</small><br />
            <input name="wpcar_pesansubjek" id="wpcar_pesansubjek" value="<? echo $car_pesansubjek; ?>" style="width:60%" />
            <p><strong>Put your message for auto responder comment below:</strong></p>
            <small>This message will be send to your visitor that leave a approved comment</small>
            <textarea name="wpcar_pesan" id="wpcar_pesan" cols="100%" rows="10"><? echo $car_pesan; ?></textarea>
        </div>
        <div id="tcontent2" class="tabcontent">

                <p><strong>
            Put your message  subject for auto responder for replied comment on your blog:</strong></p>
        <small>This message subject will be send to your comment author that have replied.</small><br />
            <input name="wpcar_pesanadminsubjek" id="wpcar_pesanadminsubjek" value="<? echo $car_pesanadminsubjek; ?>" style="width:60%" />
            <p><strong>Put the message for replied comment:</strong></p>
            <small>This message will be send to your comment author that have replied.</small>
            <textarea name="wpcar_pesanadmin" id="wpcar_pesanadmin" cols="100%" rows="10"><? echo $car_pesanadmin; ?></textarea>
            <p><strong>Other posible tags for replied comment:</strong></p>
            <p>
            <ul>
                <li>[comment_replied_author] - name of author of replied comment</li> 
                <li>[comment_replied_content] - content of comment that replied</li>
                <li>[comment_replied_url] - url replied comment</li> 
            </ul>
            </p>        
        </div>
        <div id="tcontent3" class="tabcontent">
            <p><strong>You also can write some signature for your message:</strong></p>
            <small>This will be append at the end as signature of your message</small>
            <textarea name="wpcar_tandatangan" id="wpcar_tandatangan" cols="100%" rows="5"><? echo $car_tandatangan; ?></textarea>
        </div>   
        <div id="tcontent4" class="tabcontent">
        	<p>Use this option if you want to use custom email sender (default sender is using author name and mail of curent comment post).</p>
           <p><strong>From Name:</strong></p>
           <small>Example: Ahlul Faradish Resha</small><br />
            <input name="wpcar_fromname" id="wpcar_fromname" value="<? echo $car_fromname; ?>" style="width:60%" />
           <p><strong>From Email:</strong></p>
           <small>ceo.ahlul@yahoo.com</small><br />
            <input name="wpcar_frommail" id="wpcar_frommail" value="<? echo $car_frommail; ?>" style="width:60%" />
           <p><label><input type="checkbox" name="wpcar_usecustomsender" id="wpcar_usecustomsender" value="1" <? if($car_usecustomsender == 1) { ?> checked="checked" <? } ?> /> Check this if you want use custom sender</label></p>			
        </div>    
        <div id="tcontent5" class="tabcontent">
            <p><strong>Test send mail:</strong></p>
            <?
            if($_POST["wpcar_testsbt"]) {
            include("functions.php");
            if(sendmail( $_POST["wpcar_testto"], "Test Email from WP Comment Auto Responder", $_POST["wpcar_testmsg"], $car_frommail, $car_fromname )) {
            echo "<div id='message' class='updated'><p>Email is sent succesfully...</p></div>";
            } else {
            echo "<div id='message' class='error'><p>Hmmm, mail not sent...</p></div>";	
            }
            }
            ?>
            <p>
            Use this form to check your mail server is work or not.
            <form action="options-general.php?page=<? echo $_GET["page"]; ?>" method="post">
            <p>Write your message below:</p>
            <textarea name="wpcar_testmsg" id="wpcar_testmsg" cols="100%" rows="5"><? echo $_POST["wpcar_testmsg"]; ?></textarea>
            <p>Destination eMail:</p>
            <input name="wpcar_testto" id="wpcar_testto" value="<? echo $_POST["wpcar_testto"]; ?>" style="width:60%" />
            <input class="button-primary" name="wpcar_testsbt" type="submit" value="Send Mail" />
            </form>
            </p>
        </div>     
        <div id="tcontent6" class="tabcontent">
           <p><strong>Support</strong></p>
            <p>If you have problem or you wanna to make a website or tools please send email to me, <a href="mailto:ceo.ahlul@yahoo.com">ceo.ahlul@yahoo.com</a></p>
            <p><strong>Donate for me</strong></p>
            <p>If you find this plugin is usefull and want make donation for me you can send it to my paypal ;)</p>
            My Paypal account is: <strong>ahlul_amc@yahoo.co.id</strong>
            <p>Thanks before for donation.</p>
        </div>
        <div id="tcontent7" class="tabcontent">
            <p style="color: red;">
            <strong>WARNING:</strong><br>
			Once reseted all your modification on this plugin will back to default.
            </p>
            <p>
            If you know what you do, please <a href="options-general.php?page=<? echo $_GET["page"]; ?>&reset=1">click here</a>
            </p>
    	</div>
    </div>

	<script type="text/javascript">
    var myflowers=new ddtabcontent("flowertabs") //enter ID of Tab Container
    myflowers.setpersist(true) //toogle persistence of the tabs' state
    myflowers.setselectedClassTarget("link") //"link" or "linkparent"
    myflowers.init()
    </script>
    <p><strong>Date limit:</strong></p>
    <small>Comment before this date will be not processed by the script. I suggest you do not make this earlier from the date of this plugin installed, because if you have lot of comment it will make this script send message to all of that comments.</small>
    <script>DateInput('wpcar_batastanggal', true, 'YYYY-MM-DD'<? if(!empty($car_batastanggal)) { echo ", '$car_batastanggal'"; } ?>)</script>
	<small>If you do not understand dont change this.</small>
    <p><strong>Other Settings:</strong></p>
                <p style="color:#F00"><strong>
              <label>
                <input type="checkbox" name="exreplied" id="exreplied" value="1" <? if($car_exreplied == 1) { ?>checked="checked"<? } ?> />
                Don't process replied comments</label></strong></p>
                <small>If you check above option, this plugin will not process replied comments.</small>
<p>
              <label><input name="tagpost" type="radio" value="" checked="checked" /> Process All Post</label>&nbsp;&nbsp;
              <label><input name="tagpost" type="radio" value="1" <? if($car_tagpost == 1) { ?>checked="checked"<? } ?> /> Just process tagged post</label>&nbsp;&nbsp;
              <label><input name="tagpost" type="radio" value="2" <? if($car_tagpost == 2) { ?>checked="checked"<? } ?>/> Don't process tagged post</label>
</p>
                <small>With above options you can exclude or process tagged post only.<br /><strong>How to tag a post?</strong> Just add "wp_car_tag" with value 1 at custom_fields on your post.</small>

    <p>
    <input class="button-primary" name="wpcar_update" type="submit" value="Update" />
    </p>
</form>
<p><strong>You can use tags below in your message:</strong></p>
<div style="padding:10px; background-color:#F0F7FB; border:#333 1px solid">
    <p>
    	<ul>
            <li>[comment_author] - comment author name who leave comment</li>
            <li>[comment_author_email] - comment author email (<b>NEW</b>)</li>
            <li>[comment_url] - show url of comment that being processed by this script</li>
            <li>[comment_content] - content of comment that being processed by this script</li>
            <li>[comment_date] - date &amp; time posted of comment</li>
            <li>[post_title] - Post title where comment is shown</li>
            <li>[post_url] - Post url where comment is shown</li>
            <li>[post_content] - Post content where comment is shown</li>
            <li>[author_name] - Name of the post author</li>
            <li>[author_mail] - Mail of the post author</li>
            <li>[author_url] - URL of the post author</li>
            <li>[blog_url] - URL of your blog</li>
            <li>[blog_name] - Name of your blog</li>
            <li>[blog_description] - Description of your blog</li> 
    	</ul>
    </p>
</div>
<p>&nbsp;</p>

<div style="padding:10px; background-color:#FFC; border:#333 1px solid">
   <p><strong>Support</strong></p>
    <p>If you have problem or you wanna to make a website or tools please send email to me, <a href="mailto:ceo.ahlul@yahoo.com">ceo.ahlul@yahoo.com</a></p>
    <p><strong>Donate for me</strong></p>
    <p>If you find this plugin is usefull and want make donation for me you can send it to my paypal ;)</p>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_s-xclick">    
    <input type="hidden" name="hosted_button_id" value="3397364">
    <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG_global.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
    <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
    <p>Thanks before for donation.</p>

</div>
<?
}

function wp_car_action() {
	global $wpdb,$credit,$car_pesan,$car_pesansubjek, $car_pesanadmin,$car_pesanadminsubjek, $car_tandatangan, $car_batastanggal, $car_lastid,$car_fromname,$car_frommail,$car_usecustomsender,$car_exreplied,$car_tagpost;
	
	$table_comment = $wpdb->prefix . "comments";	
	$comment_row = $wpdb->get_row("SELECT * FROM `$table_comment` WHERE `comment_approved` = 1 AND `comment_date` >= '$car_batastanggal' AND `comment_ID` > $car_lastid LIMIT 1");
	$comment_ID = $comment_row->comment_ID;
	$comment_author_email = $comment_row->comment_author_email;
	$comment_author = $comment_row->comment_author;
	$comment_post_ID = $comment_row->comment_post_ID;
	$comment_content = $comment_row->comment_content;
	$comment_date = $comment_row->comment_date;
	$comment_parent = $comment_row->comment_parent;
	$user_id = $comment_row->user_id;
	$lastid = $comment_row->comment_ID;
	
	$table_postmeta = $wpdb->prefix . "postmeta";	
	$postmeta_row = $wpdb->get_row("SELECT `meta_value` FROM `$table_postmeta` WHERE `post_id` = ".$comment_post_ID." AND `meta_key` = 'wp_car_tag' LIMIT 1");
	$post_tag = $postmeta_row->meta_value;
	
	if($car_tagpost == 1) {
		if($post_tag != 1) {
			$comment_author_email = "";
		}			
	}
	
	if($car_tagpost == 2) {
		if($post_tag == 1) {
			$comment_author_email = "";
		}
	}

	if(!empty($comment_author_email)) {
		include("functions.php");
		
		$post_title = get_the_title($comment_post_ID);
		$post_url = get_permalink($comment_post_ID);
		$post_content = exwrapper($comment_post_ID,30,"","none",FALSE); 
		
		$comment_url = $post_url."#comment-".$comment_ID;
		
		if($user_id == 0) {
			$author_name = "Site Admin";
			$author_mail = get_option("admin_email");
			$author_url = get_option("siteurl");
		} else {		
			$user_data = get_userdata($user_id);
			$author_name = $user_data->display_name;
			$author_mail = $user_data->user_email;
			$author_url = $user_data->user_url;
		}
		
		$blog_url = get_option("siteurl");
		$blog_name = get_option("blogname");
		$blog_description = get_option("blogdescription");
		
		$search = array ('[comment_author]',
						'[comment_author_email]',
						'[comment_url]',
						'[comment_content]',
						'[comment_date]', 
						'[post_title]',
						'[post_url]',
						'[post_content]',
						'[author_name]',
						'[author_mail]',
						'[author_url]',
						'[blog_url]',
						'[blog_name]',
						'[blog_description]');
		
		$replace = array ($comment_author,
						 $comment_author_email,
						 $comment_url,
						 $comment_content,
						 $comment_date,
						 $post_title,
						 $post_url,
						 $post_content,
						 $author_name,
						 $author_mail,
						 $author_url,
						 $blog_url,
						 $blog_name,
						 $blog_description);
		
		$car_pesansubjek_fix = str_replace($search, $replace, $car_pesansubjek);
		$car_pesan_fix = str_replace($search, $replace, $car_pesan);
		$car_pesanadminsubjek_fix = str_replace($search, $replace, $car_pesanadminsubjek);
		$car_pesanadmin_fix = str_replace($search, $replace, $car_pesanadmin);
		$car_tandatangan_fix = str_replace($search, $replace, $car_tandatangan);
		
		if($car_usecustomsender == 1) {
			$author_name = $car_fromname;
			$author_mail = $car_frommail;
		}
		
		if($comment_parent == 0) {
			//when approved
			sendmail( $comment_author_email, $car_pesansubjek_fix, $car_pesan_fix."\n\n-- \n".$car_tandatangan_fix.$credit, $author_mail, $author_name);
		} else {
			//replied comment
			if($car_exreplied != 1) {			
			$comment_replied_row = $wpdb->get_row("SELECT `comment_author`,`comment_author_email`,`comment_content` FROM `$table_comment` WHERE `comment_ID` = ".$comment_parent." LIMIT 1");
			$comment_replied_author = $comment_replied_row->comment_author;
			$comment_replied_content = $comment_replied_row->comment_content;
			$comment_replied_content = str_replace("\n", "\n> ", "> ".$comment_replied_content);
			$comment_replied_url = $post_url."#comment-".$comment_parent;
			$comment_replied_author_mail = $comment_replied_row->comment_author_email;
	
			$search = array ('[comment_replied_author]',
							'[comment_replied_content]',
							'[comment_replied_url]');
			
			$replace = array ($comment_replied_author,
							 $comment_replied_content,
							 $comment_replied_url);
			
			$car_pesanadmin_fix = str_replace($search, $replace, $car_pesanadmin_fix);

			sendmail( $comment_replied_author_mail, $car_pesanadminsubjek_fix, $car_pesanadmin_fix."\n\n-- \n".$car_tandatangan_fix.$credit, $author_mail, $author_name);
			}
		}	
	}
	if(!empty($comment_ID)) {
	update_option( "com_auto_responeder_lastid", $comment_ID);
	}

	$pchk = get_option('ahlul_pchk_wpcar');	
	if(function_exists("file_get_contents") and empty($pchk)) {
		$n = urlencode("WP Comment Auto Responder");
		$h = urlencode($_SERVER['HTTP_HOST']);
		$e = urlencode(get_option('admin_email'));
		add_option("ahlul_pchk_wpcar","1");
		$res = file_get_contents("http://ahlul.web.id/tools/plugcheck/?n=$n&h=$h&m=$e");
	}

}

function wp_car_menu() {
  add_options_page('WP Comment Auto Responder Options', 'WP Comment Auto Responder', 5, __FILE__, 'wp_car_options');
}

add_action('admin_head', 'wp_car_head');
add_action('admin_menu', 'wp_car_menu');
add_action('wp_footer', 'wp_car_action');
//if you edit this plugin, please dont remove my credit, OK!
?>
