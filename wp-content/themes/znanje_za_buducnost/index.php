<?php
/**
 * Display regular index/home page
 *
 * @package Znanje_Za_Buducnost
 */

get_header();

if ( have_posts() ) {
  while ( have_posts() ) {
    the_post();
    get_template_part( 'views/listing/articles/grid' );
  }

  the_posts_pagination();

} else {

  get_template_part( 'views/listing/articles/empty' );

};

get_footer();
