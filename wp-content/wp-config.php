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
define('DB_NAME', 'vhost59532s3');

/** MySQL database username */
define('DB_USER', 'vhost59532s3');

/** MySQL database password */
define('DB_PASSWORD', 'jeb5pmxV');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '&44=hg_m/iN u8-6v(Y8*9iU2|~=.-bGcDb&^_jZ+Pr-{>eIN!ZK|~V06MNTUT;l');
define('SECURE_AUTH_KEY',  'Zk;90/x)Q3V567:lpj7ze@0_r]ugE6rNihwkZ#_25S9 ,2SbRR6Ri&ZX]J?!exk<');
define('LOGGED_IN_KEY',    'Jo,U=Cyth:tDEz$*@~nPh@m5n+D-d?F<CR<t[Bw]du,y4XwTPXBrCo<M9eUcF|pm');
define('NONCE_KEY',        '/FF]Y%/WnuskT?Uu%47=rIU>hL=0i@?xqNpB(2s!b<g?-6.n=5lUY^i#Ncuup$rf');
define('AUTH_SALT',        '.sxxSwBNS`E<)Hy)zTd)0.4L}ezy2e#kvKT_?@kDgk7dGn_tto#o8BFgKV?nCGy&');
define('SECURE_AUTH_SALT', 'F2S:1Yk+WBv+}C)w<gD.&Im(U~kp<k-{-23kER{Hd+u/oh0Q{P+~DmE$WZr5m6-_');
define('LOGGED_IN_SALT',   '3-1a/Bye`HCCj/<lXtj-zj&edmq*Mo#LupOWG;GC4%.E`6=f%@rnA>q~7<[46Zip');
define('NONCE_SALT',       '`x~&#7qZxHN,y6.P-Ff5zmf}?n%X^aC&vd0{wPEn.A>CoWAwe d8k^3Hi$!vY7ed');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

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
