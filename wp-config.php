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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'videmik' );

/** MySQL database username */
define( 'DB_USER', 'videmik' );
// define( 'DB_USER', 'root' );

/** MySQL database password */
// define( 'DB_PASSWORD', '' );
define( 'DB_PASSWORD', 'Cer.yoso1907' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );


define('WP_HOME','http://videmik.com');
define('WP_SITEURL','http://videmik.com');
define( 'FS_METHOD', 'direct' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'E&;4+Hr9>gf+JteCS_hCoO<u^>D+!`PPi} <;E?Nec.fRk$)VG0]Z74nU?[A:>No' );
define( 'SECURE_AUTH_KEY',  'bVBmiwWfRU~`BsQ{!>2s[`:(ufaV:C)y&P4Dr=*R$XcAoS%Z[w/K~^s&4F~?^[l?' );
define( 'LOGGED_IN_KEY',    'M~ZZM#)lZ)%;;*,eD&h:o.1b]ZZ~>.lD,$TEJ:;jY#a{8vR5iT/[J2N&iDxD/<8^' );
define( 'NONCE_KEY',        'G8SiMcABD1E9p$K)@B5(}-`rQF)a$%5!&S.|~NvpiwECHL[Z)%0z*?FzNJlp7MSZ' );
define( 'AUTH_SALT',        'w0fTWB?kRdF_@;7OE2uGOu3eVoq~m3rLf dl,RRD}MQ^J#fA^^@TA v.S,YU2=ip' );
define( 'SECURE_AUTH_SALT', 'M|wK~Z0L%Wo:r_wP)E8.:<Znn ([/%7h|`:2rcT$6 +z_bJEK1.R+|P,pwRa&_#7' );
define( 'LOGGED_IN_SALT',   'U@n~ymJQSW4-zj>ZtX&9/c>/DEOS-3RI{&H,A}OaA lFyvjd#d92qbm7z=XE9w%7' );
define( 'NONCE_SALT',       'CszBos#$hqIxL?Cbe_t9fl/{gYsqaP]9Hn%Ayfpi~OYDN#HCsC#8 oN]+.hAz=vE' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
