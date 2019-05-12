<?php
/**
 * Google Rich Snippets
 *
 * @package Znanje_Za_Buducnost\Template_Parts\Parts
 *
 * TODO: Create this as a class with attributes.
 */

use Znanje_Za_Buducnost\General\Manifest;

$logo_img = Manifest::get_manifest_assets_data( 'images/logo.svg' );
?>

<!-- Google Rich Snippets -->
<script type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@type": "NewsArticle",
    "mainEntityOfPage": {
      "@type": "WebPage",
      "@id": "https://google.com/article"
    },
    "headline": "<?php the_title(); ?>",
  "image": {
    "@type": "ImageObject",
    "url": "<?php echo esc_html( $image['image'] ); ?>",
    "height": <?php echo esc_html( $image['height'] ); ?>,
    "width": <?php echo esc_html( $image['width'] ); ?>
  },
  "datePublished": "<?php echo esc_html( get_the_time( 'c' ) ); ?>",
  "dateModified": "<?php echo esc_html( date( 'c', strtotime( $post->post_modified ) ) ); ?>",
  "author": {
    "@type": "Person",
    "name": "<?php echo get_the_author(); ?>"
  },
    "publisher": {
    "@type": "Organization",
    "name": "<?php echo esc_html( get_bloginfo( 'name' ) ); ?>",
    "logo": {
    "@type": "ImageObject",
    "url": "<?php echo esc_url( $logo_img ); ?>",
    "width": 220,
    "height": 60
    }
  },
  "description": "<?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?>"
  }
</script>
