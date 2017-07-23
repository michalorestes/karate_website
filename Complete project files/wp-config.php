<?php
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
define('DB_NAME', 'b18_8827041_Age_Kan');

/** MySQL database username */
define('DB_USER', 'b18_8827041');

/** MySQL database password */
define('DB_PASSWORD', 'jd4991');

/** MySQL hostname */
define('DB_HOST', 'sql201.byethost18.com');

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
define('AUTH_KEY',         'L[Q%EbT14c-[/|l5CFwN{&SN]##O:!x/[Q#Q9UOuC z?wq+|6(4ff-r(3V3J zVA');
define('SECURE_AUTH_KEY',  ']kq !Cx7P$4$OfW$XGTVSGs4jBdqA0wpKkc(&&p%*0{SgoE; 8}#6Ur*yWsw|~q+');
define('LOGGED_IN_KEY',    'tf~:4OisV%Y0Ec2~C7{Y+OEd/+V(*Hf]m.#{Mg|q021Y%0XN~LLPS9Se_?TMNs1F');
define('NONCE_KEY',        '@K9>S3r(3RV+}lv~ ~bw#>s9`=u0=5oR_g`bBVL_G^f?Y]2nP(8O,Itn=_5OJBtY');
define('AUTH_SALT',        '$E8yDOQ=*Bnk_xRPD8R~`HOf=8[dRW*<GR@f2@ f(MN`2SJbr(VIU/E6m&z9=Mo0');
define('SECURE_AUTH_SALT', '2Nj~Qx@edwcqf$c=O~~y+7RsYXvA+Wx4Z<AU%sZ8/,<b0^%pWutk*%vN*`k0DB=t');
define('LOGGED_IN_SALT',   'zrNilFP;!>um22z:5G52m>fU-@-s}NIns}jBU)v?,8<{bY)qIG+;^W(RoUp`MWV~');
define('NONCE_SALT',       'azY<v[.zVdp $08d8=qF]#s9P7;Z<iq_9-Jp.Rf>~1+FU=b@)~s$RZ=c&dx2lFZ-');

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
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
