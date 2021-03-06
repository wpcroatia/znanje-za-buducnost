<?php
/**
 * Template for the Section block.
 *
 * @since 1.0.0
 * @package Znanje_za_buducnost\Blocks.
 */

namespace Znanje_za_buducnost\Blocks;

$block_class = $attributes['blockClass'] ?? '';

?>

<div class="<?php echo esc_attr( $block_class ); ?>">
  <?php echo wp_kses_post( $inner_block_content ); ?>
</div>
