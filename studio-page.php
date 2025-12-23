<?php
/**
 * Template Name: Studio Page
 * The template for displaying the studio page.
 *
 * @package Therosessom
 */

get_header();

        get_template_part( 'template-parts/hero/hero' );
        get_template_part( 'template-parts/intro/studio-intro' );
        get_template_part( 'template-parts/cards/trio-cards' );
        get_template_part( 'template-parts/slider/project-slider' );
        get_template_part( 'template-parts/callout/callout-text' );
        
get_footer();