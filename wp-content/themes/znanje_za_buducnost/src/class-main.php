<?php
/**
 * The file that defines the main start class.
 *
 * A class definition that includes attributes and functions used across both the
 * theme-facing side of the site and the admin area.
 *
 * @since   4.0.0 Implementing Eightshift_Libs.
 * @since   1.0.0
 * @package Znanje_Za_Buducnost\Core
 */

namespace Znanje_Za_Buducnost\Core;

use Eightshift_Libs\Core\Main as LibMain;

use Znanje_Za_Buducnost\Admin;
use Znanje_Za_Buducnost\General;
use Znanje_Za_Buducnost\Admin\Menu;
use Znanje_Za_Buducnost\Theme;

/**
 * The main start class.
 *
 * This is used to define admin-specific hooks, and
 * theme-facing site hooks.
 *
 * Also maintains the unique identifier of this theme as well as the current
 * version of the theme.
 */
class Main extends LibMain {

  /**
   * Get the list of services to register.
   *
   * A list of classes which contain hooks.
   *
   * @return array<string> Array of fully qualified class names.
   */
  protected function get_service_classes() : array {
    return [
      General\Manifest::class,
      Admin\Admin::class,
      Admin\Login::class,
      Admin\Media::class,
      Admin\Widgets::class,
      Menu\Menu::class,
      Theme\Theme::class,
    ];
  }
}
