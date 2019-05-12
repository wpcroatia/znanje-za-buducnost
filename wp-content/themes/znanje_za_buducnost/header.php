<?php
/**
 * Main header file
 *
 * @package Znanje_Za_Buducnost
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <?php
    get_template_part( 'views/header/head' );
    wp_head();
  ?>
</head>
<body <?php body_class(); ?>>

<?php get_template_part( 'views/header/header' ); ?>

<main class="main-content">
