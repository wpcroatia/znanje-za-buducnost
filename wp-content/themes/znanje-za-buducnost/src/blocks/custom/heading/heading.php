<?php
/**
 * Template for the Heading Block view.
 *
 * @since 1.0.0
 * @package Znanje_za_buducnost\Blocks.
 */

namespace Znanje_za_buducnost\Blocks;

$this->render_block_view(
  '/components/heading/heading.php',
  [
    'blockClass' => $attributes['blockClass'] ?? '',
    'content' => $attributes['content'] ?? '',
    'level' => $attributes['level'] ?? '',
    'styleAlign' => $attributes['styleAlign'] ?? '',
    'styleColor' => $attributes['styleColor'] ?? '',
    'styleSize' => $attributes['styleSize'] ?? '',
  ]
);
