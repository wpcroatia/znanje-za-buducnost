<?php
/**
 * The Language specific functionality.
 *
 * @since   1.0.0
 * @package Znanje_za_buducnost\Language
 */

namespace Znanje_za_buducnost\Language;

use Eightshift_Libs\Core\Service;

/**
 * Class Language
 *
 * This class handles theme or admin languages.
 *
 * @since 1.0.0
 */
class Language implements Service {

  /**
   * Register all the hooks
   *
   * @return void
   *
   * @since 1.0.0
   */
  public function register() {
    add_action( 'after_setup_theme', [ $this, 'load_theme_textdomain' ] );
  }

  /**
   * Load the plugin text domain for translation.
   *
   * @return void
   *
   * @since 1.0.0
   */
  public function load_theme_textdomain() {
    \load_theme_textdomain( ZZB_THEME_NAME, \get_template_directory() . '/languages' );
  }

}
