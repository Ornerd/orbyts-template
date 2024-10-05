<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'coalitiontest_local' );

/** Database username */
define( 'DB_USER', 'coalitiontest' );

/** Database password */
define( 'DB_PASSWORD', 'wordpresstest' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'A^~rk!^/Vo)6:=_aX50i4m*P5wJDcH0(QHY{tGeYtJ4Mg38uRgp|Xr}^cu<L^^;*' );
define( 'SECURE_AUTH_KEY',  '):mr4 %sx(lG@gR.^WU%q._xo1exhwhU|)<=;e#sms#86uCT2q~MB&0T4OMm%kV&' );
define( 'LOGGED_IN_KEY',    'G4xGHY&);m B&9lSHA~C0MY0orKSDg2(;|MnwvNcR1Pvq$tBRQUx]sW0_a>z/b^D' );
define( 'NONCE_KEY',        'bT{[*B6w(jVsf PKd>2*e!iW0IY;:BeOpxY<e&YDG0E+/jSUUm]ITw9mg:eS&QC|' );
define( 'AUTH_SALT',        '#0pjYYVk=f:QLJn++n-Xh0/grKJIGdAzSqYo{,I&sM/86^*dLw:T[NQ>K(ZT]mW}' );
define( 'SECURE_AUTH_SALT', ']]Clt84CD^KC6 e:Pf=sjCRwYGi2qG[EeVCJ!*k_DNhiJ[jM}Vv.$)4d>u]7@fj+' );
define( 'LOGGED_IN_SALT',   '|h><gOtuAz?lEc4SS1;S)&7c(Y|=!GJupUV4jQ>aOkhi2`1:#5,~BXNQ_mWFk?>v' );
define( 'NONCE_SALT',       '=j)f5o0|#DJ4aC@BEi,@Y0~MAy?XXs1#Vc)c.&A}#z_]urW}{GJ!vXnM_oIxsTF}' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

define('WP_HOME', 'http://coalitiontest.local');
define('WP_SITEURL', 'http://coalitiontest.local');

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
