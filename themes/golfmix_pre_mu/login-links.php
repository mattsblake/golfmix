<li><a href="<?php bloginfo('url'); ?>/login?action=register"><?php if(!is_user_logged_in()) { echo 'Register'; } else { echo 'My Profile'; } ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;</li>
<li><?php if(!is_user_logged_in()) { ?><a href="<?php echo wp_login_url( home_url() ); ?>" title="Login">Login</a><?php } else { ?><a href="<?php echo wp_logout_url(''); ?>" title="Logout">Logout</a><?php } ?></li>
