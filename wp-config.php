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
define( 'DB_NAME', 'wordpress_form' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         'jh}@vxv_qge>a1uhw[`*pCtwsZ=PSl|H*el(-z-#`+$91FxMagICrHVg,[:s2=0~' );
define( 'SECURE_AUTH_KEY',  'u5PlN[iqViYCTABB6efGNfSp2[Hih)z#ABLSFH^k2C$;.U{XQX]sKB5/n?%Ix&HU' );
define( 'LOGGED_IN_KEY',    'UBvlL[6 t!gQ8I$YN3ZGT2j`p|JDn!KCt(Ji_yY}y1hwBoS8D~7g_afN .+@tGpd' );
define( 'NONCE_KEY',        '-EX*Po-y5O:yY+F1mf;j_C/i7^/^H2EFo<)>!7|zsFzD,.,k4_>Exvyi SF|tJ%U' );
define( 'AUTH_SALT',        'GNaf$F]CsPu0E88K8M<0M[j3!9!Wl&m!UZUfX|yW9*$T:`P8ljd(Mn~[FrsiG9v?' );
define( 'SECURE_AUTH_SALT', '&Pw33Ndzw9n#Y[@N@ *a_Cz)mf;wP.k,Pe_aD[CHQ%c6yMEMc3j+lS.(44.]mg(u' );
define( 'LOGGED_IN_SALT',   'nTppj9,(+;;:t8 Gp~QJAFno*?magRxkRdpHZeVGSe7JGC<GgsnyGI;CeRs;$s_4' );
define( 'NONCE_SALT',       '!.LtJw &f&tuv@!r)*&]rcaX-;:5_kX/t%Iw*mmdjI=4gMnv2[]xS5rVp:0`{G!{' );

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
