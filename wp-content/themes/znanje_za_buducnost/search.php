<?php
/**
 * Display regular search page with
 * title and regular listing sorted by date
 *
 * @package Znanje_Za_Buducnost
 */

get_header();

if ( have_posts() ) { ?>

  <!-- Page Title -->
  <header>
    <h1>
      <?php
      // translators: 1: Search Query.
      printf( esc_html__( 'Search Results for: %s', 'znanje_za_buducnost' ), '<span>' . get_search_query() . '</span>' );
      ?>
    </h1>
  </header>
<?php } ?>

<!-- Listing Section -->

<?php
if ( have_posts() ) {
  while ( have_posts() ) {
    the_post();
    get_template_part( 'views/listing/articles/grid' );
  };

  the_posts_pagination();

} else {
  get_template_part( 'views/listing/articles/empty' );

};

get_footer();
