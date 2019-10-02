<?php
/**
 * The login page specific functionality.
 *
 * @since   1.0.0
 * @package Znanje_za_buducnost\Admin
 */

namespace Znanje_za_buducnost\Admin;

use Eightshift_Libs\Core\Service;

/**
 * Class Login
 *
 * This class handles all login page options.
 *
 * @since 1.0.0
 */
class Login implements Service {

  /**
   * Register all the hooks
   *
   * @return void
   *
   * @since 1.0.0
   */
  public function register() {
    add_filter( 'login_headerurl', [ $this, 'custom_login_url' ] );
  }

  /**
   * Change default logo link with home url.
   *
   * @return string
   *
   * @since 1.0.0
   */
  public function custom_login_url() : string {
    return \home_url( '/' );
  }
}
