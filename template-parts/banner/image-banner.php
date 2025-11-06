<?php
/**
 * Template part for displaying Image Banner section
 *
 * @package Therosessom
 */


if (!function_exists('get_field')) {
    return;
}

$background_image = get_field('banner_background_image');

if (empty($background_image)) {
    return;
}

// Inline style for the background image
$bg_style = '
  background-image: url(' . esc_url($background_image) . ');
  background-position: center center;
  background-repeat: no-repeat;
  background-size: cover;
';

?>

<section id="image-banner" class="image-banner-section relative py-20 md:py-32 min-h-[450px] bg-brown bg-fixed" style="<?php echo $bg_style; ?>">

</section>