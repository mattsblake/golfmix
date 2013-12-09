<?php define('WP_CACHE', true);
/** Enable W3 Total Cache **/
 // Added by W3 Total Cache

/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'golfmix_golfmix');

/** MySQL database username */
define('DB_USER', 'golfmix_golfmix');

/** MySQL database password */
define('DB_PASSWORD', 'HD$i,N98PWZJ');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'l@MaDjk@z+Z&fNBNbNMg;5JJV1Hg_4I@7UpZexPwG,1^Pfuj7HVT8Ev6*$zVjkJI');
define('SECURE_AUTH_KEY',  '$<nGUFFte|tCqx6|F/bwH[KR2B`H3nwNq=:XRTR{4mhx.()Mx[+:fzy s!shlwBG');
define('LOGGED_IN_KEY',    'EvzX=!3&xF>Dv|Oiqetya6B^)<^m_JJ pXJ+)WNe@8{3q3XR;`cQ.{{ceswsAPQj');
define('NONCE_KEY',        'r$iELb rFJm%uMS#|0~O#-]kP6$N!y|V[NC3z/+fxV=|oZ&)+-DJ?bSihna3JhIz');
define('AUTH_SALT',        'D-H1p4k)yp}+sdwImgMpXryknx~(*JrQqk wCtrg:-Tnt-)W<78)DCF,X&=2`X+D');
define('SECURE_AUTH_SALT', 'bMSt1(I^kFGjf.G$KP5^_YxMk+j!ZU4@Q{3cW1ne/HvNFCG-0-7$][1M:y^aS- h');
define('LOGGED_IN_SALT',   '--:Hi?ddmy&>c2j-Dbk4G+gs] 2Q-/*rg#sDSWU5H+aA3-=!]*I<$@JdBGX1oiu>');
define('NONCE_SALT',       '5Nh$rh8d+&&=+>(EbGR2Z3y4 D[dDk,a!nJeWkn|-Ag]A&e}gs~DM2<Do5BG~.e,');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress.  A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de.mo to wp-content/languages and set WPLANG to 'de' to enable German
 * language support.
 */
define ('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

define('MULTISITE', true);
define('SUBDOMAIN_INSTALL', false);
$base = '/';
define('DOMAIN_CURRENT_SITE', 'golfmix.com');
define('PATH_CURRENT_SITE', '/');
define('SITE_ID_CURRENT_SITE', 1);
define('BLOG_ID_CURRENT_SITE', 1);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
