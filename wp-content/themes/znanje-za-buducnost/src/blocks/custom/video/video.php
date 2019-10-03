<?php
/**
 * Template for the Video Block view.
 *
 * @since 1.0.0
 * @package Znanje_za_buducnost\Blocks.
 */

namespace Znanje_za_buducnost\Blocks;

$this->render_block_view(
  '/components/video/video.php',
  [
    'blockClass' => $attributes['blockClass'] ?? '',
    'url' => $attributes['mediaUrl'] ?? '',
  ]
);
