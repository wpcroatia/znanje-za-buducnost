<?php
/**
 * Display regular page
 *
 * @package Znanje_Za_Buducnost
 */

get_header();

if ( have_posts() ) {
  while ( have_posts() ) {
    the_post();
    get_template_part( 'views/single/page' );
  }
}

get_footer();
