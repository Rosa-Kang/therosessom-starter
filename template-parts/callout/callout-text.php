<?php
/**
 * Template part for displaying Callout Text section
 * Left text/content, Right image split view
 *
 * @package Therosessom
 */

// Check if ACF is active
if (!function_exists('get_field')) {
    return;
}

// Get ACF fields
$title = get_field('callout_text_title');
$content = get_field('callout_text_content');
$button = get_field('callout_text_button');
$image = get_field('callout_text_image');

// Return if no essential content
if (!$title && !$content && !$image) {
    return;
}

if($button) {
    $button_text = esc_html($button['title']);
    $button_link = esc_url($button['url']);
}
?>

<section id="service-split" class="service-split-section text-cream-light bg-brown-dark overflow-hidden">
    <div class="flex flex-col md:flex-row">
        <div 
            class="content-col w-full md:w-1/2 p-12 lg:p-24 flex flex-col justify-center"
        >
            <?php if ($title) : ?>
                <h2 class="text-cream-light text-3xl lg:text-4xl font-sans mb-6">
                    <?php echo esc_html($title); ?>
                </h2>
            <?php endif; ?>

            <?php if ($content) : ?>
                <div class="text-sm leading-relaxed max-w-xl mb-12">
                    <?php echo wp_kses_post(wpautop($content)); ?>
                </div>
            <?php endif; ?>

            <?php if ($button_text && $button_link) : ?>
                <a 
                    href="<?php echo $button_link; ?>" 
                    class="group inline-flex items-center text-sm font-sans uppercase tracking-widest text-cream-light transition-colors duration-300"
                >
                    <?php echo $button_text; ?>
                    <svg class="w-4 h-4 ml-3 transform transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            <?php endif; ?>
        </div>

        <?php if ($image) : ?>
            <div 
                class="image-col w-full md:w-1/2 relative md:h-[718px]"
            >
                <img
                    src="<?php echo esc_url($image['sizes']['large'] ?? $image['url']); ?>"
                    srcset="<?php echo esc_attr(wp_get_attachment_image_srcset($image['id'], 'large')); ?>"
                    sizes="100vw, 50vw"
                    alt="<?php echo esc_attr($image['alt'] ?: $title); ?>"
                    class="inset-0 w-full object-cover md:h-[718px]"
                    loading="lazy"
                >

            </div>
        <?php endif; ?>
    </div>
</section>