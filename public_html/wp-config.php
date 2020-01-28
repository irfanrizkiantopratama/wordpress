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
define( 'DB_NAME', 'wordpress' );

/** MySQL database username */
define( 'DB_USER', 'admin' );

/** MySQL database password */
define( 'DB_PASSWORD', 'admin' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'W}JtNbSkgYX*QjY]j6Bh9 0^) rG*[TJKIX{]+?y]HgDhuuPNwTM,E?tcVw|d_XF' );
define( 'SECURE_AUTH_KEY',  'GE)xG.)ScUp}eAi2[8Y2h(ovv/|nq[!!<PG1j7 ^{~)JR*X9~DLTM;[F+!BQgq/-' );
define( 'LOGGED_IN_KEY',    'P<Z7VbS}TcaR}Gag=Oif$7eI9^Kyx2=|q/c&dtFW%L`4)cJV;lJm}s0M}pMsq6f=' );
define( 'NONCE_KEY',        'qxm@BbI]hoR$<[Na`$K p`{Z6a1SrM{_0?5<T7O~vps[U<Ah5Yl^T$9)iOL-t;fH' );
define( 'AUTH_SALT',        '`-?vX2`Tq]2jN=PqG%?}V[ycp*&0OSS_)hsgdHAZn-GZ5U}e:(OL|3yGRLWxYlE/' );
define( 'SECURE_AUTH_SALT', '{:F@OON:0pmpCdjgS#Bh;=,_-[GM<9YD[QmEOAwBV|I$CWY9HM$-txF]YV?CA_$^' );
define( 'LOGGED_IN_SALT',   ']^#`/*gL)hu2}P.0C:9+;UthK+s.Yp4ItQWKyG3&$&V16(bCR.n G=whT=}HBEQ?' );
define( 'NONCE_SALT',       '2`U|qP*Z/YLKkG62aOHYYz|s0_fz[{(/gBfu0>?dzQ[ qbryXK:-Zd?~L|BPSWKg' );

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
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
define('FS_METHOD', 'direct');
require_once( ABSPATH . 'wp-settings.php' );
