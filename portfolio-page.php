<?php
/**
 * Template Name: Portfolio Page
 * The template for displaying the studio page.
 *
 * @package Therosessom
 */

get_header(); ?>
        <div class="spacer bg-brown-dark py-16"></div>
<?php 
        get_template_part( 'template-parts/slider/project-slider' );
        get_template_part( 'template-parts/callout/callout-text' );
get_footer();