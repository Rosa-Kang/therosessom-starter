<?php

/**
 * Template part for displaying instagram feed.
 *
 * @package by Therosessom
 */

$blurb = get_field('ig_blurb', 'option');
$short_code = get_field('ig_shortcode', 'option');
?>


<section 
  class="relative py-6" 
>
  <div class="container lg:max-w-[1024px] mx-auto px-4" data-aos="fade-in" data-aos-duration="650">
    <div class="flex flex-col items-center">
      <div class="mx-auto px-4 sm:px-6 lg:px-8"  >
        <?php if ($short_code): ?>
              <?php echo do_shortcode($short_code); ?>
        <?php endif; ?>
      </div>

      <div>
        <h3 class="inline-block">
         <?php if ($blurb): ?>
           <span 
           class="text-xs leading-[16.8px] font-normal text-black font-sans"><?= str_replace('. ', '.<br>', $blurb); ?></span>
         <?php endif; ?>
        </h3>
      </div>
    </div>
  </div>
</section>