=== WP Comment Auto Responder ===
Contributors: Ahlul Faradish Resha
Donate link: http://ahlul.web.id/blog/2009/04/19/wp-plugin-wordpress-comment-auto-responder.html
Tags: comments, autoresponder
Requires at least: 2.0.2
Tested up to: 2.9.1
Stable tag: 3.0.3

Send auto responder mail when you visitor leave a comment

== Description ==

This plugin will send a automatic mail message when you visitor leave a comment on your wordpress blog.

Other feature of this plugin is when you or other visitor reply your visitor comment from your dashboard this plugin will make automatic message,
and will tell to your visitor that their comment has replied.

NEW FEATURE ON 3.0:
- You can ignore or exclude replied comment
- You can define which post that will process by this plugin.

Need a custom plugin?
Just contact me at ceo.ahlul@yahoo.com

== Installation ==

Heuheu, just activate this on your dashboard and it will work for you.

== Changelog ==
* 3.0.3 - Add function to support Custom Content and Plugin Dir of Wordpress.(http://codex.wordpress.org/Determining_Plugin_and_Content_Directories)
* 3.0.2 - Add Email Comment Author for usable tag
* 3.0 - Change replied comment option, Add some new features
* 2.0 - Remove class mail & class smtp and now using wpmail function so i hope this will solve character error issue
* 1.6.1 - Little change on functions.php
* 1.6 - Added custom sender option
* 1.5 - Added some function to support PHP 4.x
* 1.4 - Add more or equal operator for date sort of comment
* 1.3 - Bug fix: Last ID become empty when process last comment
* 1.2 - Bug fix: script do not update last id if comment email author is empty
* 1.1 - Change from self table to wordpress option database

== Frequently Asked Questions ==

= What i can do with this plugin? =

* You can make your own message for auto responder
* You can use special tags on you message
* You can make mail signature for your message
* And More

= Why no email that send by your script when a visitor leave comment? =

Check the date limit on this plugin at your Dashboard, and please set it on the date before your visistor leave his/her comment.

= I get the following error in the footer: Parse error: parse error, unexpected T_STRING, expecting T_OLD_FUNCTION or T_FUNCTION or T_VAR or '}' in wp-content/plugins/wp-comment-auto-responder/class.phpmailer.php on line 45 =

If you using PHP 4.x you will get this error. But since Wp Comment Auto Responder 1.5 i have added some function so now you can use my plugin on PHP 
4.x. So if you still using Wp Comment Auto Responder 1.4 please upgrade.

= Me regional CZECH characters, appear  broken in the e-mail. Something wrong with the UTF-8 encoding? =

If remove previous mail function :) and now i using wpmail function to void any error when send an email (since version 2.0). Please upgrade your plugin to the newest :)

= How i tag a post? =

Just add "wp_car_tag" with value 1 at custom_fields on your post.

== Screenshots ==

1. screenshot-1.jpg
