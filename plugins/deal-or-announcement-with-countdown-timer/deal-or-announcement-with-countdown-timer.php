<?php



/*

Plugin Name: deal or announcement with countdown timer

Plugin URI: http://www.gopiplus.com/work/2010/07/18/deal-or-announcement-with-countdown-timer/

Description:  This plug-in will display the announcement or deal or offer with countdown timer.

Author: Gopi.R

Version: 3.0

Author URI: http://www.gopiplus.com/work/2010/07/18/deal-or-announcement-with-countdown-timer/

Donate link: http://www.gopiplus.com/work/2010/07/18/deal-or-announcement-with-countdown-timer/

*/



//########################################################################################

//###### Project   : Deal or Announcement with countdown timer 						######

//###### File Name : deal-or-announcement-with-countdown-timer.php                  ######

//###### Purpose   : plugin main page												######

//###### Date      : July 12th 2009                  								######

//###### Updated   : July 25th 2010                  								######

//###### Author    : Gopi.R                        									######

//########################################################################################



global $wpdb, $wp_version;

define("WP_G_Countdown_TABLE", $wpdb->prefix . "gCountdown");



function deal_or_announcement_with_countdown_timer_show() 

{

	global $wpdb;

	$data = $wpdb->get_results("select * from ".WP_G_Countdown_TABLE." where gCountdisplay='YES' ORDER BY gCountid DESC LIMIT 0 , 1");

	if ( ! empty($data) ) 

	{

		$data = $data[0];

		if ( !empty($data)) $gCountid = $data->gCountid;

		if ( !empty($data)) $gCount = stripslashes($data->gCount); 

		if ( !empty($data)) $gCountmonth = $data->gCountmonth;

		if ( !empty($data)) $gCountdate = $data->gCountdate;

		if ( !empty($data)) $gCountyear = $data->gCountyear;

		if ( !empty($data)) $gCounthour = $data->gCounthour;

		if ( !empty($data)) $gCountzoon = $data->gCountzoon;

		if ( !empty($data)) $gCountdisplay = $data->gCountdisplay;

		

		$displayformats  = "<div> <span style='width:23px;display:inline-block;'>%%D%%</span> <span style='width:23px;display:inline-block;'>%%H%%</span> <span style='width:23px;display:inline-block;'>%%M%%</span> <span style='width:23px;display:inline-block;'>%%S%%</span> </div><div> <span style='width:23px;display:inline-block;'>Day</span> <span style='width:23px;display:inline-block;'>Hrs</span> <span style='width:23px;display:inline-block;'>Min</span> <span style='width:23px;display:inline-block;'>Sec</span> </div>"

		

		?>

        <script language="JavaScript">

        TargetDate = "<?php echo $gCountmonth;?>/<?php echo $gCountdate;?>/<?php echo $gCountyear;?> <?php echo $gCounthour;?>:00 <?php echo $gCountzoon;?>";

        BackColor = "";

        ForeColor = "<?php echo get_option('deal_or_announcement_with_countdown_timer_timer_color')?>";

        CountActive = true;

        CountStepper = -1;

        LeadingZero = true;

		DisplayFormat = "<?php echo $displayformats;?>";

        FinishMessage = "<div  style='padding:5px 0px 5px 0px;' class='over' align='center'>Time Out!</div>";

        </script>

        <div class="fre" style="padding:5px 0px 0px 0px;color:<?php echo get_option('deal_or_announcement_with_countdown_timer_text_color'); ?>" align="<?php echo get_option('deal_or_announcement_with_countdown_timer_text_align'); ?>">

        	<?php echo $gCount; ?>

        </div>

        <?php if(get_option('deal_or_announcement_with_countdown_timer_caption')<>"") { ?>

        		<div class="fre" align="<?php echo get_option('deal_or_announcement_with_countdown_timer_timer_align'); ?>" style="padding:10px 0px 3px 0px;color:<?php echo get_option('deal_or_announcement_with_countdown_timer_timer_color')?>"><?php echo get_option('deal_or_announcement_with_countdown_timer_caption'); ?></div>

        <?php } ?>

        <div class="announcementtime" id="announcementtime" style="padding:0px 0px 10px 0px;" align="<?php echo get_option('deal_or_announcement_with_countdown_timer_timer_align'); ?>">

            <script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/deal-or-announcement-with-countdown-timer/gCountdown.js"></script>

        </div>

        <?php

	}

	else

	{

		echo "<div style='padding:5px 0px 5px 0px;' class='over' align='center'>No data available in announcement!</div>";

	}

}

function deal_or_announcement_with_countdown_timer_install() 

{

	

	global $wpdb;



	//set the messages

	if($wpdb->get_var("show tables like '". WP_G_Countdown_TABLE . "'") != WP_G_Countdown_TABLE) 

	{

		$wpdb->query("

			CREATE TABLE IF NOT EXISTS `". WP_G_Countdown_TABLE . "` (

			  `gCountid` int(11) NOT NULL auto_increment,

			  `gCount` text  NOT NULL,

			  `gCountmonth` int(11) NOT NULL default '0',

			  `gCountdate` int(11) NOT NULL default '0',

			  `gCountyear` int(11) NOT NULL default '0',

			  `gCounthour` int(11) NOT NULL default '0',

			  `gCountzoon` varchar(5) NOT NULL default '',

			  `gCountdisplay` varchar(5) NOT NULL default '',

  			  PRIMARY KEY  (`gCountid`) )

			");

	}



	add_option('deal_or_announcement_with_countdown_timer_title', 'Announcement');

	add_option('deal_or_announcement_with_countdown_timer_timer_color', '#FF0000');

	add_option('deal_or_announcement_with_countdown_timer_timer_align', 'Center');

	add_option('deal_or_announcement_with_countdown_timer_text_color', '#FF0000');

	add_option('deal_or_announcement_with_countdown_timer_text_align', 'Center');

	add_option('deal_or_announcement_with_countdown_timer_caption', 'This is a limited time offer..');

}

function deal_or_announcement_with_countdown_timer_widget($args) 

{

	extract($args);

	echo $before_widget . $before_title;

	echo get_option('deal_or_announcement_with_countdown_timer_title');

	echo $after_title;

	deal_or_announcement_with_countdown_timer_show();

	echo $after_widget;

}

function deal_or_announcement_with_countdown_timer_control() 

{

		$deal_or_announcement_with_countdown_timer_title = get_option('deal_or_announcement_with_countdown_timer_title');

		$deal_or_announcement_with_countdown_timer_timer_color = get_option('deal_or_announcement_with_countdown_timer_timer_color');

		$deal_or_announcement_with_countdown_timer_timer_align = get_option('deal_or_announcement_with_countdown_timer_timer_align');

		$deal_or_announcement_with_countdown_timer_text_color = get_option('deal_or_announcement_with_countdown_timer_text_color');

		$deal_or_announcement_with_countdown_timer_text_align = get_option('deal_or_announcement_with_countdown_timer_text_align');

		$deal_or_announcement_with_countdown_timer_caption = get_option('deal_or_announcement_with_countdown_timer_caption');

		

		if ($_POST['deal_or_announcement_with_countdown_timer_submit']) 

		{

				$deal_or_announcement_with_countdown_timer_title = stripslashes($_POST['deal_or_announcement_with_countdown_timer_title']);

				$deal_or_announcement_with_countdown_timer_timer_color = stripslashes($_POST['deal_or_announcement_with_countdown_timer_timer_color']);

				$deal_or_announcement_with_countdown_timer_timer_align = stripslashes($_POST['deal_or_announcement_with_countdown_timer_timer_align']);

				$deal_or_announcement_with_countdown_timer_text_color = stripslashes($_POST['deal_or_announcement_with_countdown_timer_text_color']);

				$deal_or_announcement_with_countdown_timer_text_align = stripslashes($_POST['deal_or_announcement_with_countdown_timer_text_align']);

				$deal_or_announcement_with_countdown_timer_caption = stripslashes($_POST['deal_or_announcement_with_countdown_timer_caption']);

				

				update_option('deal_or_announcement_with_countdown_timer_title', $deal_or_announcement_with_countdown_timer_title );

				update_option('deal_or_announcement_with_countdown_timer_timer_color', $deal_or_announcement_with_countdown_timer_timer_color );

				update_option('deal_or_announcement_with_countdown_timer_timer_align', $deal_or_announcement_with_countdown_timer_timer_align );

				update_option('deal_or_announcement_with_countdown_timer_text_color', $deal_or_announcement_with_countdown_timer_text_color );

				update_option('deal_or_announcement_with_countdown_timer_text_align', $deal_or_announcement_with_countdown_timer_text_align );

				update_option('deal_or_announcement_with_countdown_timer_caption', $deal_or_announcement_with_countdown_timer_caption );

		}

		

		echo '<p>Sidebar title text:<br><input  style="width: 325px;" type="text" value="';

		echo $deal_or_announcement_with_countdown_timer_title . '" name="deal_or_announcement_with_countdown_timer_title" id="deal_or_announcement_with_countdown_timer_title" /></p>';

		

		echo '<p>Count down timer title text:<br><input  style="width: 325px;" type="text" value="';

		echo $deal_or_announcement_with_countdown_timer_caption . '" name="deal_or_announcement_with_countdown_timer_caption" id="deal_or_announcement_with_countdown_timer_caption" /></p>';



		echo '<p>Timer color:&nbsp;<input  style="width: 100px;" type="text" value="';

		echo $deal_or_announcement_with_countdown_timer_timer_color . '" name="deal_or_announcement_with_countdown_timer_timer_color" id="deal_or_announcement_with_countdown_timer_timer_color" />';

		

		echo '&nbsp;&nbsp;Text color:&nbsp;<input  style="width: 100px;" type="text" value="';

		echo $deal_or_announcement_with_countdown_timer_text_color . '" name="deal_or_announcement_with_countdown_timer_text_color" id="deal_or_announcement_with_countdown_timer_text_color" /></p>';



		echo '<p>Timer align:&nbsp;<input  style="width: 100px;" type="text" value="';

		echo $deal_or_announcement_with_countdown_timer_timer_align . '" name="deal_or_announcement_with_countdown_timer_timer_align" id="deal_or_announcement_with_countdown_timer_timer_align" />';

		

		echo '&nbsp;&nbsp;Text align:&nbsp;<input  style="width: 100px;" type="text" value="';

		echo $deal_or_announcement_with_countdown_timer_text_align . '" name="deal_or_announcement_with_countdown_timer_text_align" id="deal_or_announcement_with_countdown_timer_text_align" /></p>';



		echo '<input type="hidden" id="deal_or_announcement_with_countdown_timer_submit" name="deal_or_announcement_with_countdown_timer_submit" value="1" />';

		

		?>

		<h2><?php echo wp_specialchars( 'About Plugin' ); ?></h2>

		<a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/deal-or-announcement-with-countdown-timer/'>Click here</a> to see live demo. <br> 

		Plug-in created by <a target="_blank" href='http://www.gopiplus.com/'>Gopi</a>. <br> 

		<a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/deal-or-announcement-with-countdown-timer/'>Click here</a> to post suggestion or comments or feedback. <br> 

		<a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/deal-or-announcement-with-countdown-timer/'>Click here</a> to see live demo. <br> 

		<a target="_blank" href='http://www.gopiplus.com/work/plugin-list/'>Click here</a> to download my other plugins. <br> 

		<?php

}



function widget_deal_or_announcement_with_countdown_timer_management() 

{

	global $wpdb;

	?>

    <div class="wrap">

    <?php

    $title = __('Announcement or Offer or Deal with Countdown Timer');

    $mainurl = get_option('siteurl')."/wp-admin/options-general.php?page=deal-or-announcement-with-countdown-timer/deal-or-announcement-with-countdown-timer.php";



    $DID=@$_GET["DID"];

    $AC=@$_GET["AC"];

    $submittext = "Insert Message";



	if($AC <> "DEL" and trim($_POST['gCount']) <>"")

    {

			if($_POST['gCountid'] == "" )

			{

					$sql = "insert into ".WP_G_Countdown_TABLE.""

					. " set `gCount` = '" . mysql_real_escape_string(trim($_POST['gCount']))

					. "', `gCountmonth` = '" . $_POST['gCountmonth']

					. "', `gCountdate` = '" . $_POST['gCountdate']

					. "', `gCountyear` = '" . $_POST['gCountyear']

					. "', `gCounthour` = '" . $_POST['gCounthour']

					. "', `gCountzoon` = '" . $_POST['gCountzoon']

					. "', `gCountdisplay` = '" . $_POST['gCountdisplay']

					. "'";	

			}

			else

			{

					$sql = "update ".WP_G_Countdown_TABLE.""

					. " set `gCount` = '" . mysql_real_escape_string(trim($_POST['gCount']))

					. "', `gCountmonth` = '" . $_POST['gCountmonth']

					. "', `gCountdate` = '" . $_POST['gCountdate']

					. "', `gCountyear` = '" . $_POST['gCountyear']

					. "', `gCounthour` = '" . $_POST['gCounthour']

					. "', `gCountzoon` = '" . $_POST['gCountzoon']

					. "', `gCountdisplay` = '" . $_POST['gCountdisplay']

					. "' where `gCountid` = '" . $_POST['gCountid'] 

					. "'";	

			}

			

			if(trim($_POST['gCountdisplay'])=="YES")

			{

				$wpdb->get_results("update ".WP_G_Countdown_TABLE." set gCountdisplay='NO'");

			}

			$wpdb->get_results($sql);

    }

    

    if($AC=="DEL" && $DID > 0)

    {

        $wpdb->get_results("delete from ".WP_G_Countdown_TABLE." where gCountid=".$DID);

    }

    

    if($DID<>"" and $AC <> "DEL")

    {

        //select query

        $data = $wpdb->get_results("select * from ".WP_G_Countdown_TABLE." where gCountid=$DID limit 1");

    

        //bad feedback

        if ( empty($data) ) 

        {

           echo "<div id='message' class='error'><p>No data found on count down message, please create!</p></div>";

            return;

        }

        

        $data = $data[0];

        

        //encode strings

        if ( !empty($data) ) $gCountid_x = htmlspecialchars(stripslashes($data->gCountid)); 

        if ( !empty($data) ) $gCount_x = htmlspecialchars(stripslashes($data->gCount));

        if ( !empty($data) ) $gCountmonth_x = htmlspecialchars(stripslashes($data->gCountmonth));

        if ( !empty($data) ) $gCountdate_x = htmlspecialchars(stripslashes($data->gCountdate));

        if ( !empty($data) ) $gCountyear_x = htmlspecialchars(stripslashes($data->gCountyear));

        if ( !empty($data) ) $gCounthour_x = htmlspecialchars(stripslashes($data->gCounthour));

        if ( !empty($data) ) $gCountzoon_x = htmlspecialchars(stripslashes($data->gCountzoon));

        if ( !empty($data) ) $gCountdisplay_x = htmlspecialchars(stripslashes($data->gCountdisplay));

        

        $submittext = "Update Message";

    }

    ?>



    <h2><?php echo wp_specialchars( $title ); ?></h2>

	<script language="JavaScript" src="<?php echo get_option('siteurl'); ?>/wp-content/plugins/deal-or-announcement-with-countdown-timer/gCountdownform.js"></script>

    <form name="form1" method="post" action="<?php echo $mainurl; ?>"  onSubmit="return gCountdownform()">

    <table width="100%">

      <tr>

        <td colspan="2" align="left" valign="middle">Enter the message:</td>

      </tr>

      <tr>

        <td align="left" valign="middle"><textarea name="gCount" cols="60" rows="3" id="gCount"><?php echo $gCount_x; ?></textarea></td>

      	 <td align="center" valign="middle"> </td>

      </tr>

      <tr>

        <td colspan="2" align="left" valign="middle">Select the expiration:</td>

      </tr>

      <tr>

        <td colspan="2" align="left" valign="middle">

            

            <select name="gCountmonth" id="gCountmonth">

                <option value="">--Month--</option>

                <option value='1' <?php if($gCountmonth_x==1) { echo 'selected' ; } ?>>January</option>

                <option value='2' <?php if($gCountmonth_x==2) { echo 'selected' ; } ?>>February</option>

                <option value='3' <?php if($gCountmonth_x==3) { echo 'selected' ; } ?>>March</option>

                <option value='4' <?php if($gCountmonth_x==4) { echo 'selected' ; } ?>>April</option>

                <option value='5' <?php if($gCountmonth_x==5) { echo 'selected' ; } ?>>May</option>

                <option value='6' <?php if($gCountmonth_x==6) { echo 'selected' ; } ?>>June</option>

                <option value='7' <?php if($gCountmonth_x==7) { echo 'selected' ; } ?>>July</option>

                <option value='8' <?php if($gCountmonth_x==8) { echo 'selected' ; } ?>>August</option>

                <option value='9' <?php if($gCountmonth_x==9) { echo 'selected' ; } ?>>September</option>

                <option value='10' <?php if($gCountmonth_x==10) { echo 'selected' ; } ?>>October</option>

                <option value='11' <?php if($gCountmonth_x==11) { echo 'selected' ; } ?>>November</option>

                <option value='12' <?php if($gCountmonth_x==12) { echo 'selected' ; } ?>>December</option>

            </select>

            <select name="gCountdate" id="gCountdate">

                <option value="">--Date--</option>

                <?php 

                for($dd=1;$dd<=31;$dd++)

                {

                    ?>

                    <option value='<?php echo $dd?>' <?php if($gCountdate_x==$dd) { echo 'selected' ; } ?>><?php echo $dd?></option>

                    <?php

                }

                ?>

            </select>

            <select name="gCountyear" id="gCountyear">

                <option value="">--Year--</option>

                <?php 

                for($yy=2008;$yy<=2015;$yy++)

                {

                    ?>

                    <option value='<?php echo $yy?>' <?php if($gCountyear_x==$yy) { echo 'selected' ; } ?>><?php echo $yy?></option>

                    <?php

                }

                ?>

            </select>

            <select name="gCounthour" id="gCounthour">

                <option value="">--Time--</option>

                <?php 

                for($hh=1;$hh<=12;$hh++)

                {

                    ?>

                    <option value='<?php echo $hh?>' <?php if($gCounthour_x==$hh) { echo 'selected' ; } ?>><?php echo $hh?></option>

                    <?php

                }

                ?>

            </select>

            <select name="gCountzoon" id="gCountzoon">

                <option value="">--AM/PM--</option>

                <option value="AM" <?php if($gCountzoon_x=='AM') { echo 'selected' ; } ?>>AM</option>

                <option value="PM" <?php if($gCountzoon_x=='PM') { echo 'selected' ; } ?>>PM</option>

            </select>        </td>

      </tr>

      <tr>

        <td colspan="2" align="left" valign="middle">Display Status:</td>

      </tr>

      <tr>

        <td width="62%" align="left" valign="middle">

            <select name="gCountdisplay" id="gCountdisplay">

                <option value="">Select</option>

                <option value='YES' <?php if($gCountdisplay_x=='YES') { echo 'selected' ; } ?>>Yes</option>

                <option value='NO' <?php if($gCountdisplay_x=='NO') { echo 'selected' ; } ?>>No</option>

        </select>        </td>

        <td width="38%" align="right" valign="middle"><input name="publish" lang="publish" class="button-primary" value="<?php echo $submittext?>" type="submit" /></td>

      </tr>

      <tr>

        <td colspan="2" align="left" valign="middle">



		

		</td>

      </tr>

	<input name="gCountid" id="gCountid" type="hidden" value="<?php echo $gCountid_x; ?>">

    </table>

	</form>

    

	<div class="tool-box">  

    <?php

	$data = $wpdb->get_results("select * from ".WP_G_Countdown_TABLE." order by gCountid desc");

	if ( empty($data) ) 

	{ 

		echo "<div id='message' class='error'>No data found, please create using below form!</div>";

		return;

	}

	?>

	<script language="javascript" type="text/javascript">

	function _dealdelete(id)

	{

		if(confirm("Do you want to delete this record?"))

		{

			document.frm.action="options-general.php?page=deal-or-announcement-with-countdown-timer/deal-or-announcement-with-countdown-timer.php&AC=DEL&DID="+id;

			document.frm.submit();

		}

	}	

	</script>

    <form name="frm" method="post">

    <table width="100%" class="widefat" id="straymanage">

      <thead>

            <tr>

                <th align="left" scope="col">ID</td>

              <th align="left" scope="col">Message</td>

              <th align="left" scope="col">Expiration</td>

              <th align="left" scope="col">Display</td>

              <th align="left" scope="col">Action</td>            </tr>

        </thead>

		<?php 

        $i = 0;

        foreach ( $data as $data ) { 

		if($data->gCountdisplay=='YES') { $displayisthere="True"; }

        ?>

        <tbody>

            <tr class="<?php if ($i&1) { echo'alternate'; } else { echo ''; }?>">

                <td align="left" valign="middle"><?php echo(stripslashes($data->gCountid)); ?></td>

                <td align="left" valign="middle"><?php echo(stripslashes($data->gCount)); ?></td>

                <td align="left" valign="middle">

				<?php 

				echo($data->gCountmonth."/".$data->gCountdate."/".$data->gCountyear."<br>".$data->gCounthour.":00 ".$data->gCountzoon); 

				?>

              </td>

                <td align="left" valign="middle"><?php echo(stripslashes($data->gCountdisplay)); ?></td>

                <td align="left" valign="middle">

                    <a href="options-general.php?page=deal-or-announcement-with-countdown-timer/deal-or-announcement-with-countdown-timer.php&DID=<?php echo($data->gCountid); ?>">Edit</a> 

                    &nbsp; 

                    <a onClick="javascript:_dealdelete('<?php echo($data->gCountid); ?>')" href="javascript:void(0);">Delete</a> 

                </td>

            </tr>

        </tbody>

        <?php $i = $i+1; } ?>

       	<?php if($displayisthere<>"True") { ?>

        <tr>

            <td colspan="5" align="center" style="color:#FF0000" valign="middle">No Announcement available with display status 'Yes'! So in front end it will show 'No data available in announcement!' </td>

        </tr>

        <?php } ?>



    </table>

    

    </form>

	

	<h2><?php echo wp_specialchars( 'About Plugin' ); ?></h2>

	<a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/deal-or-announcement-with-countdown-timer/'>Click here</a> to see live demo. <br> 

	Plug-in created by <a target="_blank" href='http://www.gopiplus.com/'>Gopi</a>. <br> 

	<a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/deal-or-announcement-with-countdown-timer/'>Click here</a> to post suggestion or comments or feedback. <br> 

	<a target="_blank" href='http://www.gopiplus.com/work/2010/07/18/deal-or-announcement-with-countdown-timer/'>Click here</a> to see live demo. <br> 

	<a target="_blank" href='http://www.gopiplus.com/work/plugin-list/'>Click here</a> to download my other plugins. <br> 



    </div>  

</div>

    <?php



}



function deal_or_announcement_with_countdown_timer_widget_init() 

{

  	register_sidebar_widget(__('deal-or-announcement-with-countdown-timer'), 'deal_or_announcement_with_countdown_timer_widget');   

	

	if(function_exists('register_sidebar_widget')) 	

	{

		register_sidebar_widget('deal-or-announcement-with-countdown-timer', 'deal_or_announcement_with_countdown_timer_widget');

	}

	

	if(function_exists('register_widget_control')) 	

	{

		register_widget_control(array('deal-or-announcement-with-countdown-timer', 'widgets'), 'deal_or_announcement_with_countdown_timer_control',400,400);

	} 

}

function deal_or_announcement_with_countdown_timer_deactivation() 

{

	delete_option('deal_or_announcement_with_countdown_timer_title');

	delete_option('deal_or_announcement_with_countdown_timer_timer_color');

	delete_option('deal_or_announcement_with_countdown_timer_timer_align');

	delete_option('deal_or_announcement_with_countdown_timer_text_color');

	delete_option('deal_or_announcement_with_countdown_timer_text_align');

	delete_option('deal_or_announcement_with_countdown_timer_caption');

}



function deal_or_announcement_with_countdown_timer_add_to_menu() 

{

	add_options_page('Deal with countdown', 'Deal with countdown', 10, __FILE__, 'widget_deal_or_announcement_with_countdown_timer_management' );

}



add_action('admin_menu', 'deal_or_announcement_with_countdown_timer_add_to_menu');

add_action("plugins_loaded", "deal_or_announcement_with_countdown_timer_widget_init");

register_activation_hook(__FILE__, 'deal_or_announcement_with_countdown_timer_install');

register_deactivation_hook(__FILE__, 'deal_or_announcement_with_countdown_timer_deactivation');

add_action('init', 'deal_or_announcement_with_countdown_timer_widget_init');

?>