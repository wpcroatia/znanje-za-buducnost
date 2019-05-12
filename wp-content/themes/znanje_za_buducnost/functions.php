<?php
/**
 * Theme Name: Znanje za buducnost
 * Description: This is WP Boilerplate, a modern boilerplate / starter theme.
 * Author: Team Eightshift
 * Author URI:
 * Version: 1.0
 * Text Domain: znanje_za_buducnost
 *
 * @package Znanje_Za_Buducnost
 */

namespace Znanje_Za_Buducnost;

// If this file is called directly, abort.
if ( ! \defined( 'WPINC' ) ) {
  die;
}

/**
 * Global variable defining theme name generally used for naming assets handlers.
 *
 * @since 4.0.0
 */
\define( 'THEME_NAME', 'infinum' );

/**
 * Global variable defining theme version generally used for versioning assets handlers.
 *
 * @since 4.0.0
 */
\define( 'THEME_VERSION', '1.0.0' );

/**
 * Include the autoloader so we can dynamically include the rest of the classes.
 *
 * @since 1.0.0
 * @package Znanje_Za_Buducnost
 */
require get_template_directory() . '/vendor/autoload.php';

/**
 * Begins execution of the theme.
 *
 * Since everything within the theme is registered via hooks,
 * then kicking off the theme from this point in the file does
 * not affect the page life cycle.
 *
 * @since 4.0.0 Changing namespace.
 * @since 3.0.0 Shorten the theme initialization.
 * @since 2.0.0
 */
( new Core\Main() )->register();
