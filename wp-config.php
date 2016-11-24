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
define('DB_NAME', 'dev1web_hellodorado');

/** MySQL database username */
define('DB_USER', 'dev1web_hellodor');

/** MySQL database password */
define('DB_PASSWORD', 'Q2&1oL@p0DZk');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
define('FS_METHOD', 'direct');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'gOg9;X9Cj6#kAL->P@|~eHQR_]@#7#~!FeZ7Z58vv.XZP=]A=!v{)|$n>crgxSfu');
define('SECURE_AUTH_KEY',  'ijlSI)$sHOeF<~Y -iQDEg-0g?#Usy3asg1?1)}pXIS,i&s;w^NUmNZrC_7_g+Rl');
define('LOGGED_IN_KEY',    'eSd4a<VBB?<2fDTYv(3O>_Pj.2`}<t0,4S!YyaE+[E3qYp4:(DT3&-5gON>rvZ2.');
define('NONCE_KEY',        ' 8]=n2Zv$c.C}K03}(!0L0+Vv:KZdF3Y]kT$HpQlA|?A%`vSb)~btW8? tU0J|^y');
define('AUTH_SALT',        '~(AnU>^o)w0I|Rv.3P1AxDbZsfvj<s+;v.Yq+)&:`l|`n^O<Ju($v`gyq5/yP z]');
define('SECURE_AUTH_SALT', '#a3eNiH^uumGt9D?syOkaRHl9zI7gK-0!P`jFwd>QlP=R0lbT^mjV%EvA~/rz+?u');
define('LOGGED_IN_SALT',   'd_O:sQ*fpBU[-86t:MmU=th8?SIT&G&;(NgwFFwbiYYI8^J0,p}~FN(|rQAy3OSv');
define('NONCE_SALT',       'ha_+GZ[m|KT/(i?o1zruk!LAb*8E+?0%^5fEc!kr]R7-/yC6>(Lz)l9}[r}JXm8|');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'hdd_';

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
