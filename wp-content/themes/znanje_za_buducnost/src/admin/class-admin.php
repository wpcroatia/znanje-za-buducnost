<?php
/**
 * The Admin specific functionality.
 *
 * @since   4.0.0 Major refactor.
 * @since   1.0.0
 * @package Znanje_Za_Buducnost\Admin
 */

namespace Znanje_Za_Buducnost\Admin;

use Eightshift_Libs\Core\Service;

use Znanje_Za_Buducnost\General\Manifest;

/**
 * Class Admin
 *
 * This class handles enqueue scripts and styles and some
 * admin facing functionality.
 */
class Admin implements Service {

  /**
   * Register all the hooks
   *
   * @return void
   *
   * @since 4.0.0 Adding Register hooks.
   * @since 1.0.0
   */
  public function register() : void {
    add_action( 'login_enqueue_scripts', [ $this, 'enqueue_styles' ] );
    add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ], 50 );
    add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
    add_filter( 'get_user_option_admin_color', [ $this, 'set_admin_color_based_on_env' ] );
  }

  /**
   * Register the Stylesheets for the admin area.
   *
   * @return void
   *
   * @since 4.0.0 Chaning handler variable.
   * @since 1.0.0
   */
  public function enqueue_styles() : void {

    // Main style file.
    \wp_register_style( THEME_NAME . '-style', Manifest::get_manifest_assets_data( 'applicationAdmin.css' ), [], THEME_VERSION );
    \wp_enqueue_style( THEME_NAME . '-style' );

  }

  /**
   * Register the JavaScript for the admin area.
   *
   * @return void
   *
   * @since 4.0.0 Chaning handler variable.
   * @since 1.0.0
   */
  public function enqueue_scripts() : void {

    // Main Java script file.
    \wp_register_script( THEME_NAME . '-scripts', Manifest::get_manifest_assets_data( 'applicationAdmin.js' ), [], THEME_VERSION, true );
    \wp_enqueue_script( THEME_NAME . '-scripts' );

  }

  /**
   * Method that changes admin colors based on environment variable. Must have ZZB_ENV global variable set.
   *
   * @param string $color_scheme Color scheme string.
   * @return string              Modified color scheme.
   *
   * @since 1.0.0
   *
   * // TODO: Handle better.
   */
  public function set_admin_color_based_on_env( $color_scheme ) {
    if ( ! \defined( 'ZZB_ENV' ) ) {
      return false;
    }

    if ( ZZB_ENV === 'production' ) {
      $color_scheme = 'sunrise';
    } elseif ( ZZB_ENV === 'staging' ) {
      $color_scheme = 'blue';
    } else {
      $color_scheme = 'fresh';
    }

    return $color_scheme;
  }

}
