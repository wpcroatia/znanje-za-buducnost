<?php
/**
 * The Theme specific functionality.
 *
 * @since   1.0.0
 * @package Znanje_za_buducnost\Theme
 */

namespace Znanje_za_buducnost\Theme;

use Eightshift_Libs\Core\Service;
use Eightshift_Libs\Manifest\Manifest_Data;

/**
 * Class Theme
 *
 * @since 1.0.0
 */
class Theme implements Service {

  /**
   * Instance variable of manifest data.
   *
   * @var object
   *
   * @since 1.0.0
   */
  protected $manifest;

  /**
   * Create a new admin instance that injects manifest data for use in assets registration.
   *
   * @param Manifest_Data $manifest Inject manifest which holds data about assets from manifest.json.
   *
   * @since 1.0.0
   */
  public function __construct( Manifest_Data $manifest ) {
      $this->manifest = $manifest;
  }

  /**
   * Register all the hooks
   *
   * @return void
   *
   * @since 1.0.0
   */
  public function register() {
    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
    add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
  }

  /**
   * Register the Stylesheets for the theme area.
   *
   * @return void
   *
   * @since 1.0.0
   */
  public function enqueue_styles() {

    // Main style file.
    \wp_register_style( ZZB_THEME_NAME . '-style', $this->manifest->get_assets_manifest_item( 'application.css' ), [], ZZB_THEME_VERSION );
    \wp_enqueue_style( ZZB_THEME_NAME . '-style' );

  }

  /**
   * Register the JavaScript for the theme area.
   *
   * First jQuery that is loaded by default by WordPress will be deregistered and then
   * 'enqueued' with empty string. This is done to avoid multiple jQuery loading, since
   * one is bundled with webpack and exposed to the global window.
   *
   * @return void
   *
   * @since 1.0.0
   */
  public function enqueue_scripts() {

    // Main Javascript file.
    \wp_register_script( ZZB_THEME_NAME . '-scripts', $this->manifest->get_assets_manifest_item( 'application.js' ), [], ZZB_THEME_VERSION, true );
    \wp_enqueue_script( ZZB_THEME_NAME . '-scripts' );

    // Global variables for ajax and translations.
    \wp_localize_script(
      ZZB_THEME_NAME . '-scripts',
      'themeLocalization',
      [
        'ajaxurl' => \admin_url( 'admin-ajax.php' ),
      ]
    );
  }

}
