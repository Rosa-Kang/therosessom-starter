<?php
/**
 * Template part for displaying Intro section
 * Centered polaroid-style image with title and content
 *
 * @package Therosessom
 */

// Check if ACF is active
if (!function_exists('get_field')) {
    return;
}

// Get ACF fields
$intro_image = get_field('intro_image');
$intro_title = get_field('intro_title');
$intro_accent_title = get_field('intro_accent_title');
$intro_content = get_field('intro_content');

// Return if no content
if (!$intro_image && !$intro_title && !$intro_content) {
    return;
}
?>

<section id="intro" class="intro-section relative flex items-center justify-center py-16 md:py-24 bg-cream-light">
    <div class="container mx-auto px-4 max-w-2xl text-center">
        
        <!-- Polaroid Image -->
        <?php if ($intro_image) : ?>
            <div class="intro-polaroid mx-auto mb-4" data-aos="fade-up" data-aos-duration="1000">
                <div class="shadow-lg inline-block">
                    <img 
                        src="<?php echo esc_url($intro_image['sizes']['medium_large'] ?? $intro_image['url']); ?>"
                        srcset="<?php echo esc_attr(wp_get_attachment_image_srcset($intro_image['id'], 'large')); ?>"
                        sizes="(max-width: 189px) 189px, 600px"
                        alt="<?php echo esc_attr($intro_image['alt'] ?: $intro_title); ?>"
                        class="w-[189px] h-[271px]"
                        loading="lazy"
                    >
                    
                    <!-- Polaroid Caption -->
                    <?php if ($intro_image['caption']) : ?>
                        <p class="polaroid-caption text-sm leading-[18px] mt-3 font-mono">
                            <?php echo esc_html($intro_image['caption']); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Title Group -->
        <?php if ($intro_title) : ?>
            <div class="flex justify-center items-center intro-title-group mb-4" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
                <h2 class="font-normal text-lg leading-[43px] uppercase">
                    <?php echo esc_html($intro_title); ?>
                </h2>
                
                <?php if ($intro_accent_title) : ?>
                    <p class="font-cursive text-2xl italic ml-2 leading-[43px]">
                       <?php echo esc_html($intro_accent_title); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <!-- Content -->
        <?php if ($intro_content) : ?>
            <div class="intro-content text-sm leading-[18px] max-w-xl mx-auto" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="400">
                <?php echo wp_kses_post($intro_content); ?>
            </div>
        <?php endif; ?>
        
        <!-- Scroll Indicator (Optional) -->
        <div class="intro-scroll-indicator group cursor-pointer mt-16 md:mt-20" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="600">
            <svg class="w-6 h-6 mx-auto text-charcoal group-hover:animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
            </svg>
        </div>
        
    </div>
</section>