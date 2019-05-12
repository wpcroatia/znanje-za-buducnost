<?php
/**
 * Single page for Posts
 *
 * @package Znanje_Za_Buducnost
 */

get_header();

if ( have_posts() ) {
  while ( have_posts() ) {
    the_post();
    get_template_part( 'views/single/post' );
  }
}

get_footer();
