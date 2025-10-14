<?php
/**
 * The template for displaying the home page.
 *
 * @package Therosessom
 */

get_header();
?> 

    <?php 
        get_template_part( 'template-parts/hero/hero' );
        get_template_part( 'template-parts/intro/intro' );
        get_template_part( 'template-parts/divider/divider' );
        get_template_part( 'template-parts/callout/callout-link' );
    ?>

<?php
get_footer();