<?php

/**
 * Template part for displaying contact form.
 *
 * @package Therosessom
 */

$shortcode = get_field('contact_form_shortcode');

?>

<section class="inquiry-form py-20 md:py-32 bg-brown-light">
    <div class="container mx-auto px-4 max-w-5xl text-cream-light">
        <?php echo do_shortcode($shortcode); ?>
    </div>
</section>