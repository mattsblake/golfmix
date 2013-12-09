<?php $theme_url = WP_CONTENT_URL . '/plugins/' . plugin_basename(dirname(__FILE__)); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title><?php echo get_option_nc_cs_top('seo_title'); ?></title>
        <meta charset="utf-8" />
        <meta name="description" content="<?php echo get_option_nc_cs_top('seo_description'); ?>" />
        <meta name="keywords" content="<?php echo get_option_nc_cs_top('seo_keywords'); ?>" />
        <link rel="shortcut icon" href="<?php echo get_option_nc_cs_top('favicon') ?>" />
        <link rel="stylesheet" href="<?php echo $theme_url; ?>/style.css" type="text/css" media="screen" />
        <script type="text/javascript" src="<?php echo $theme_url; ?>/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo $theme_url; ?>/js/rounded.js"></script>
        <script type="text/javascript" src="<?php echo $theme_url; ?>/js/theme.js"></script>
        <script type="text/javascript" src="<?php echo $theme_url; ?>/js/twitter.min.js"></script>
        <!--[if IE 7]><link rel="stylesheet" href="<?php echo $theme_url; ?>/css/ie/ie7.css" type="text/css" media="screen"><![endif]-->
        <!--[if lt IE 7]><link rel="stylesheet" href="<?php echo $theme_url; ?>/css/ie/ie6.css" type="text/css" media="screen"><![endif]-->
        <!--[if lt IE 6]><script type="text/javascript">DD_roundies.addRule('.pngfix');</script><![endif]-->
        <?php if(get_option_nc_cs_top('progress_percent') != ''): ?>
        <noscript>
        <style type="text/css">
            .percentage-text {
                width: <?php echo get_option_nc_cs_top('progress_percent'); ?>%;
            }
        </style>
        </noscript>
        <script type="text/javascript">
            $(document).ready(function(){
                $(".percentage-text").animate( { width:"<?php echo get_option_nc_cs_top('progress_percent'); ?>%" }, { queue:false, duration:2000} )
            })
        </script>
        <?php endif; ?>
    </head>
    <body>

        <div id="wrapper">

            <?php echo nc_cs_logo(); ?>

            <div id="container" class="clearfix">

                <div id="under-construction">&nbsp;</div>

                <div class="<?php if(get_option_nc_cs_top('module_message') == 'Enable' && get_option_nc_cs_top('module_countdown') == 'Enable'){echo 'half';}else{echo 'message-fix';} ?>">
                    <div class="content">
                        <?php echo nc_cs_message(); ?>
                    </div>
                </div><!-- /page-heading-message -->

                <div class="<?php if(get_option_nc_cs_top('module_message') == 'Enable' && get_option_nc_cs_top('module_countdown') == 'Enable'){echo 'half';}else{echo 'countdown-fix';} ?>">
                    <div class="content panel-right">
                        <?php echo nc_cs_countdown(); ?>
                    </div>
                </div><!-- /countdown-timer -->


                <br class="clear" />


                <div class="<?php if(get_option_nc_cs_top('module_twitter_feed') == 'Enable' && get_option_nc_cs_top('module_subscribe') == 'Enable'){echo 'half';} ?>">
                    <div class="content">
                        <?php echo nc_cs_twitter_feed(1); ?>
                    </div>
                </div><!-- /twitter-feeds -->


                <div class="<?php if(get_option_nc_cs_top('module_twitter_feed') == 'Enable' && get_option_nc_cs_top('module_subscribe') == 'Enable'){echo 'half';}else{echo 'email-fix';} ?>">
                    <div class="content panel-right">
                        <?php echo nc_cs_email(); ?>
                    </div>
                </div><!-- /email-form -->


                <br class="clear" />

                <?php echo nc_cs_progress(); ?>


                <span class="tl">&nbsp;</span>
                <span class="tr">&nbsp;</span>
                <span class="bl">&nbsp;</span>
                <span class="br">&nbsp;</span>

            </div><!-- /container -->

        </div><!-- /wrapper -->

        <?php if(get_option_nc_cs_top('module_footer') == 'Enable'): ?>
        <div id="footer">
            <?php echo get_option_nc_cs_top('footer_copyright') ?>
        </div>
        <?php endif; ?>



        <div id="social-meia">

            <?php if(get_option_nc_cs_top('module_social_media') == 'Enable'): ?>
            
            <?php if(get_option_nc_cs_top('facebook_url') != ''): ?>
            <a target="_blank" class="icon-facebook" href="<?php echo get_option_nc_cs_top('facebook_url'); ?>" title="">&nbsp;</a>
            <?php endif; ?>

            <?php if(get_option_nc_cs_top('twitter_url') != ''): ?>
            <a target="_blank" class="icon-twitter" href="<?php echo get_option_nc_cs_top('twitter_url'); ?>" title="">&nbsp;</a>
            <?php endif; ?>

            <?php if(get_option_nc_cs_top('rss_url') != ''): ?>
            <a target="_blank" class="icon-rss" href="<?php echo get_option_nc_cs_top('rss_url'); ?>" title="">&nbsp;</a>
            <?php endif; ?>

            <?php endif; ?>

            <?php if(get_option_nc_cs_top('module_contact_form') == 'Enable'): ?>
            <a class="icon-mail" href="<?php echo site_url(); ?>?show=contact" title="">&nbsp;</a>
            <?php endif; ?>
        </div>


<?php if (isset($_REQUEST['show']) && $_REQUEST['show'] == 'contact' || isset($_POST['send_message'])): ?>
        <div id="lightbox">&nbsp;</div>
        <?php echo nc_cs_contact(); ?>
<?php else: ?>
        <div id="lightbox" class="hidden">&nbsp;</div>
        <?php echo nc_cs_contact('hidden'); ?>
<?php endif; ?>


    </body>
</html>
