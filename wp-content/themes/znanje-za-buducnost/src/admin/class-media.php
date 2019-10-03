<?php
/**
 * The Media specific functionality.
 *
 * @since   1.0.0
 * @package Znanje_za_buducnost\Admin
 */

namespace Znanje_za_buducnost\Admin;

use Eightshift_Libs\Core\Service;

/**
 * Class Media
 *
 * This class handles all media options. Sizes, Types, Features, etc.
 *
 * @since 1.0.0
 */
class Media implements Service {

  /**
   * Register all the hooks
   *
   * @return void
   *
   * @since 1.0.0
   */
  public function register() {
    add_action( 'after_setup_theme', [ $this, 'add_theme_support' ], 20 );
    add_action( 'after_setup_theme', [ $this, 'add_custom_image_sizes' ], 20 );
  }

  /**
   * Enable theme support
   * for full list check: https://developer.wordpress.org/reference/functions/add_theme_support/
   *
   * @return void
   *
   * @since 1.0.0
   */
  public function add_theme_support() {
    \add_theme_support( 'title-tag', 'html5', 'post-thumbnails' );
  }

  /**
   * Create new image sizes
   *
   * @return void
   *
   * @since 1.0.0
   */
  public function add_custom_image_sizes() {
    \add_image_size( 'listing', 570, 320, true );
  }
}
