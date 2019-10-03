<?php
/**
 * The file that defines the main start class.
 *
 * A class definition that includes attributes and functions used across both the
 * theme-facing side of the site and the admin area.
 *
 * @since   1.0.0
 * @package Znanje_za_buducnost\Core
 */

namespace Znanje_za_buducnost\Core;

use Eightshift_Libs\Core\Main as LibMain;

use Znanje_za_buducnost\Admin;
use Znanje_za_buducnost\Manifest;
use Znanje_za_buducnost\General;
use Znanje_za_buducnost\Blocks;
use Znanje_za_buducnost\Admin\Menu;
use Znanje_za_buducnost\Theme;

/**
 * The main start class.
 *
 * This is used to define admin-specific hooks, and
 * theme-facing site hooks.
 *
 * Also maintains the unique identifier of this theme as well as the current
 * version of the theme.
 *
 * @since 1.0.0
 */
class Main extends LibMain {

  /**
   * Get the list of services to register.
   *
   * A list of classes which contain hooks.
   *
   * @return array<string> Array of fully qualified class names.
   *
   * @since 1.0.0
   */
  protected function get_service_classes() : array {
    return [

      // Manifest.
      Manifest\Manifest::class,

      // Admin.
      Admin\Admin::class => [ Manifest\Manifest::class ],
      Admin\Login::class,
      Admin\Media::class,

      // Menu.
      Menu\Menu::class,

      // Blocks.
      Blocks\Enqueue::class => [ Manifest\Manifest::class ],
      Blocks\Blocks::class,

      // Theme.
      Theme\Theme::class => [ Manifest\Manifest::class ],
    ];
  }
}
