<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'im_expertreports');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'jaSs6mhHflHnYhsp');

/** MySQL hostname */
define('DB_HOST', '172.30.193.163');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'w1K0OF{L,tKM>(;md_Z)]6,^Prel;&,sn`U_N,!*p;[ppK.2233t~qAc,>bv`:U1');
define('SECURE_AUTH_KEY',  'wr~8IN+8p);]k?c?u-=}wJxqL%}.AO[GZciM~C};ahG!&|&srKi<EK#ue1J)xG=.');
define('LOGGED_IN_KEY',    ';OFKXc:7~j=)+W:`U9tU%G!3`9Rv6NB:!|h6gRZp#6J5-,OTH0n$m$cBG=]{Z%m<');
define('NONCE_KEY',        'OS~<Q@Gvm]+!wh-=7kf/)7sTYq!G*x;vi3GB*uc)vzmG5[o18g&$af2QVc}`/mk/');
define('AUTH_SALT',        'sY#EjH.Q`ouN;Srot6%a[cT+S2d}rJOdoTg+m2F.Il?{IRYM1=:kWuRIm)FRhD:6');
define('SECURE_AUTH_SALT', '!^ {EA0YB4!<&!6#+z1h;qu@K/<|h9(/;OyzUANN>@Rws;g-E@jMSCi &2B2`A+N');
define('LOGGED_IN_SALT',   '+jh|uBw0Q%%$11&ny`BgxOK{.!B,og0blN1@[S/3.=HglqzQC~i:4HsGWibp(p-K');
define('NONCE_SALT',       'tD>%Z6F~/Pb!?3U@#kz]USf9^FB+y^}V;f[l=FZ[5X&aCRx!wk7wM~u$!kk~vKRX');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'im_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
