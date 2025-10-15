<?php
/**
 * Template part for displaying Divider section
 * Split layout with left and right sections (e.g., STUDIO / SHOP)
 *
 * @package Therosessom
 */

// Check if ACF is active
if (!function_exists('get_field')) {
    return;
}

// Get ACF fields
$left_title = get_field('divider_left_title');
$right_title = get_field('divider_right_title');
$left_image = get_field('divider_left_image');
$right_image = get_field('divider_right_image');
$left_link = get_field('divider_left_link');
$right_link = get_field('divider_right_link');

// Return if no content
if (!$left_image && !$right_image) {
    return;
}
?>

<section id="divider" class="divider-section relative bg-green-light py-12 md:py-20">
    
    <div class="hidden md:block absolute left-1/2 top-0 bottom-0 w-[1px] bg-charcoal/30 transform -translate-x-1/2 z-0"></div>

    <div class="container mx-auto px-4 md:px-8 max-w-7xl">
        
        <div class="divider-container flex flex-col md:flex-row gap-8 md:gap-0">
            
            <div class="divider-left w-full md:w-1/2 md:pr-8 lg:pr-12 group" data-aos="fade-right" data-aos-duration="1000">
                <?php if ($left_title) : ?>
                    <h2 class="text-charcoal text-4xl md:text-5xl lg:text-6xl font-serif uppercase tracking-wider mb-4 text-center">
                        <?php echo esc_html($left_title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($left_image) : ?>
                    <div class="relative overflow-hidden mb-4">
                        <img 
                            src="<?php echo esc_url($left_image['sizes']['large'] ?? $left_image['url']); ?>"
                            srcset="<?php echo esc_attr(wp_get_attachment_image_srcset($left_image['id'], 'large')); ?>"
                            sizes="(max-width: 768px) 100vw, 50vw"
                            alt="<?php echo esc_attr($left_image['alt'] ?: $left_title); ?>"
                            class="w-full h-auto transition-transform duration-700 group-hover:scale-105"
                            loading="lazy"
                        >
                        
                        <!-- Hover Overlay with Link -->
                        <?php if ($left_link) : ?>
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-start pl-2">
                                <a href="<?php echo esc_url($left_link['url']); ?>"
                                   class="inline-flex items-center text-white text-sm md:text-base uppercase tracking-widest font-mono transform translate-y-4 group-hover:translate-y-0 transition-all duration-500"
                                   <?php echo $left_link['target'] ? 'target="' . esc_attr($left_link['target']) . '"' : ''; ?>>
                                    <span><?php echo esc_html($left_link['title'] ?: 'Explore'); ?></span>
                                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
            </div>
            
            <div class="divider-right w-full md:w-1/2 md:pl-8 lg:pl-12 group" data-aos="fade-left" data-aos-duration="1000">
                <?php if ($right_title) : ?>
                    <h2 class="text-charcoal text-4xl md:text-5xl lg:text-6xl font-serif uppercase tracking-wider mb-4 text-center">
                        <?php echo esc_html($right_title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($right_image) : ?>
                    <div class="relative overflow-hidden mb-4">
                        <img 
                            src="<?php echo esc_url($right_image['sizes']['large'] ?? $right_image['url']); ?>"
                            srcset="<?php echo esc_attr(wp_get_attachment_image_srcset($right_image['id'], 'large')); ?>"
                            sizes="(max-width: 768px) 100vw, 50vw"
                            alt="<?php echo esc_attr($right_image['alt'] ?: $right_title); ?>"
                            class="w-full h-auto transition-transform duration-700 group-hover:scale-105"
                            loading="lazy"
                        >
                        
                        <!-- Hover Overlay with Link -->
                        <?php if ($right_link) : ?>
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-end justify-start pl-2">
                                <a href="<?php echo esc_url($right_link['url']); ?>"
                                   class="inline-flex items-center text-white text-sm md:text-base uppercase tracking-widest font-mono transform translate-y-4 group-hover:translate-y-0 transition-all duration-500"
                                   <?php echo $right_link['target'] ? 'target="' . esc_attr($right_link['target']) . '"' : ''; ?>>
                                    <span><?php echo esc_html($right_link['title'] ?: 'Explore'); ?></span>
                                    <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
            </div>
            
        </div>
        
    </div>
</section>