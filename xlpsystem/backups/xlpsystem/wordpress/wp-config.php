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
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'W2qgpsLtQt');

/** MySQL hostname */
define('DB_HOST', 'mariadb');

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
define('AUTH_KEY',         'ASW6vGal3%^mQyW0aZ<RZ=v}DhvaVp/l=25[xxc7Fi&;`),?BRgRFSH/xTjA_!yb');
define('SECURE_AUTH_KEY',  '{mMBn2o384x+1m)ekB<>0 e>ZNW_KSG)_I#j3dF<IV2AqCfs34Y27:yce2<C8`S)');
define('LOGGED_IN_KEY',    '6wGoN8:5C&|?F<Jj@cKRr]sF04yDXDYTeVtpIfE0P{$RIi>b%IY@!!!7`j~Tgq}7');
define('NONCE_KEY',        '}|Jn!+K@0I}q(GVj;!Z9~N0@56ENTfJ<?>YN$];Au|^{z>6jAzlBhF.PnG5Lg)D6');
define('AUTH_SALT',        '2z6{`7 p({o=:%ymvbEGPR0oG;PxP$?}Kf?c>G>WCt#`2+#ue[F=~;y+YS}*mG(H');
define('SECURE_AUTH_SALT', '|5VjO:ct;3_wM~(7kDL$Hz5y@y-fWDAkBe6#uK1jvH<gmIX$Z2SR9rw<P?qL23.C');
define('LOGGED_IN_SALT',   'SC+^]02$q1PJ*NRx%8UTSyPd[v^TPw _(?M1E!yE!0Oe9eA]bb=5d/i9qw;NM%7C');
define('NONCE_SALT',       'j6x2IO(tB`]WwcT*.QXn2fp]BOU81Kc<VNygo?Wo3ReB9waxNjh/T7R{rQ60(Lrk');

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

