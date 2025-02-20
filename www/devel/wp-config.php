<?php
define( 'WPCACHEHOME', '/home/catalunydc/www/devel/wp-content/plugins/wp-super-cache/' );



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
define('DB_NAME', 'catalunydc907');

/** MySQL database username */
define('DB_USER', 'catalunydc907');

/** MySQL database password */
define('DB_PASSWORD', 'QmfyV7KHtNXk');

/** MySQL hostname */
define('DB_HOST', 'catalunydc907.mysql.db:3306');

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
define('AUTH_KEY',         'IDkUP4CL9nqq1ltI3XxVOhqo2+2QDPigXdOlFtBzebQvMY9I5epc3mMQHyFp');
define('SECURE_AUTH_KEY',  'KIxa0gpQ+H6F47EqKA4lD7vC/8vlDfshyLr55n7W2kzHkyqBxzw330lSWUMQ');
define('LOGGED_IN_KEY',    'EF/8XA1SERtiJnCicsToDJLcgL4CKd5UNtmpGss8CoEkTci/beOkARZFlMuP');
define('NONCE_KEY',        'OSn1Ew65m42yEMAyQyvAIuxOSd51pvWyXgXeWUX1x7Crx60ctgvMClzRMVMG');
define('AUTH_SALT',        '7LAJZq74olgMopg24F7sPx5sz+Jn2+Wx1mIPhC+fqeNBxnM4m/wCrNicU63S');
define('SECURE_AUTH_SALT', 'jBbOsGstD9dO7CbZOIAKwb8bIjm3Yu5QNlla4xdvu+s5XjxrGuUrJI7rJqGe');
define('LOGGED_IN_SALT',   'PY0wWWK/LtzsSB6qDzA4Gb5SBGXQkCzb0BKhePR3R8U3vQqEvW4WR9NZhRxJ');
define('NONCE_SALT',       'W7gzs26iCe1AlBD+IWR4oefkMuKugz3EVKmxyO9raKFHNFQaJBOPCC5Gn+i9');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'mod126_';

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

/* Fixes "Add media button not working", see http://www.carnfieldwebdesign.co.uk/blog/wordpress-fix-add-media-button-not-working/ */
define('CONCATENATE_SCRIPTS', false );

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
