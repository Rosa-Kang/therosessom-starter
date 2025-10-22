<?php
/**
 * Template part for displaying Studio Intro section
 * Centered Text with Button
 *
 * @package Therosessom
 */

// Check if ACF is active
if (!function_exists('get_field')) {
    return;
}

// Get ACF fields
$studio_intro_title = get_field('studio_intro_title');
$studio_intro_description = get_field('studio_intro_description');
$studio_intro_button = get_field('studio_intro_button');

// Return if no content
if (!$studio_intro_title && !$studio_intro_description) {
    return;
}

?>

<section id="studio-intro" class="studio-intro-section relative py-20 md:py-32 bg-brown">
    <div class="container mx-auto px-4 max-w-5xl text-cream-light">
        <div class="text-center">
            
            <!-- Main Title -->
            <?php if ($studio_intro_title) : ?>
                <h2 class="studio-intro-title font-serif text-xl text-cream-light uppercase leading-tight mb-[52px]" 
                    data-aos="fade-up" 
                    data-aos-duration="800" 
                    data-aos-delay="100">
                    <?php echo esc_html($studio_intro_title); ?>
                </h2>
            <?php endif; ?>
            
            <!-- Description -->
            <?php if ($studio_intro_description) : ?>
                <div class="studio-intro-description text-base leading-relaxed mx-auto mb-[127px] opacity-90" 
                     data-aos="fade-up" 
                     data-aos-duration="800" 
                     data-aos-delay="200">
                    <?php echo wp_kses_post($studio_intro_description); ?>
                </div>
            <?php endif; ?>
            
            <!-- CTA Button -->
            <?php if ($studio_intro_button) : 
                $button_url = $studio_intro_button['url'];
                $button_title = $studio_intro_button['title'];
                $button_target = $studio_intro_button['target'] ? $studio_intro_button['target'] : '_self';
            ?>
                <div class="studio-intro-cta" 
                     data-aos="fade-up" 
                     data-aos-duration="800" 
                     data-aos-delay="300">
                    <a href="<?php echo esc_url($button_url); ?>" 
                       target="<?php echo esc_attr($button_target); ?>"
                       class="btn-primary inline-block px-8 py-3 text-cream-light text-base uppercase tracking-wider transition-all duration-300">
                        <span><?php echo esc_html($button_title); ?></span>
                    </a>
                </div>
            <?php endif; ?>
            
        </div>
    </div>
    
    <!-- Optional decorative elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-20 h-20 opacity-5">
            <svg viewBox="0 0 100 100" fill="currentColor">
                <circle cx="50" cy="50" r="40" />
            </svg>
        </div>
        <div class="absolute bottom-10 right-10 w-20 h-20 opacity-5">
            <svg viewBox="0 0 100 100" fill="currentColor">
                <circle cx="50" cy="50" r="40" />
            </svg>
        </div>
    </div>
</section>