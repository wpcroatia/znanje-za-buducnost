<?php
/**
 * Template for the Button Block view.
 *
 * @since 1.0.0
 * @package Znanje_za_buducnost\Blocks.
 */

namespace Znanje_za_buducnost\Blocks;

$this->render_block_view(
  '/components/button/button.php',
  [
    'blockClass' => $attributes['blockClass'] ?? '',
    'title' => $attributes['title'] ?? '',
    'url' => $attributes['url'] ?? '',
    'styleColor' => $attributes['styleColor'] ?? '',
    'styleSize' => $attributes['styleSize'] ?? '',
    'styleSizeWidth' => $attributes['styleSizeWidth'] ?? '',
  ]
);
