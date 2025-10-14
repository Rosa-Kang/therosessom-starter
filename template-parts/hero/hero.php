<?php
/**
 * Template part for displaying Hero section
 * Supports: Multiple images (slider), Single image, Video background
 *
 * @package Therosessom
 */

// Check if ACF is active
if (!function_exists('get_field')) {
    return;
}

// Get ACF fields
$hero_type = get_field('hero_type');

// Fallback if no hero_type is set
if (!$hero_type) {
    $hero_type = 'images'; // Default to images
}
?>

<section id="hero" class="hero-section relative w-full h-screen overflow-hidden bg-black">
    <?php if ($hero_type === 'video') : ?>
        <!-- Video Background -->
        <?php 
        $video = get_field('hero_video');
        $poster = get_field('hero_video_poster');
        ?>
        
        <?php if ($video) : ?>
            <div class="hero-video-bg relative w-full h-full">
                <video 
                    class="w-full h-full object-cover"
                    autoplay 
                    muted 
                    loop 
                    playsinline
                    <?php if ($poster) : ?>
                    poster="<?php echo esc_url($poster['sizes']['large'] ?? $poster['url']); ?>"
                    <?php endif; ?>
                >
                    <source src="<?php echo esc_url($video['url']); ?>" type="<?php echo esc_attr($video['mime_type']); ?>">
                    <?php if ($poster) : ?>
                        <img 
                            src="<?php echo esc_url($poster['url']); ?>" 
                            alt="<?php echo esc_attr($poster['alt'] ?: get_bloginfo('name')); ?>"
                            class="w-full h-full object-cover"
                        >
                    <?php endif; ?>
                </video>
                
                <!-- Video overlay for depth -->
                <div class="absolute inset-0 bg-black bg-opacity-20 pointer-events-none"></div>
            </div>
        <?php else : ?>
            <!-- Fallback if no video -->
            <div class="w-full h-full bg-cream flex items-center justify-center">
                <p class="text-brown text-lg">Please upload a hero video</p>
            </div>
        <?php endif; ?>
        
    <?php else : ?>
        <!-- Image(s) Background -->
        <?php 
        $hero_images = get_field('hero_images');
        
        if ($hero_images && is_array($hero_images) && count($hero_images) > 0) :
            $image_count = count($hero_images);
            $has_multiple_images = $image_count > 1;
        ?>
        
            <?php if ($has_multiple_images) : ?>
                <!-- Multiple Images - Swiper Slider -->
                <div class="swiper hero-swiper w-full h-full">
                    <div class="swiper-wrapper">
                        <?php foreach ($hero_images as $index => $image) : ?>
                            <div class="swiper-slide relative w-full h-full">
                                <img 
                                    src="<?php echo esc_url($image['sizes']['large'] ?? $image['url']); ?>"
                                    srcset="<?php echo esc_attr(wp_get_attachment_image_srcset($image['id'], 'full')); ?>"
                                    sizes="100vw"
                                    alt="<?php echo esc_attr($image['alt'] ?: get_bloginfo('name')); ?>"
                                    class="w-full h-full object-cover"
                                    loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>"
                                >
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Navigation -->
                    <div class="swiper-button-prev !text-white !w-12 !h-12 after:!text-2xl"></div>
                    <div class="swiper-button-next !text-white !w-12 !h-12 after:!text-2xl"></div>
                    
                    <!-- Pagination -->
                    <div class="swiper-pagination !bottom-8"></div>
                </div>
                
            <?php else : ?>
                <!-- Single Image Background -->
                <?php 
                $image = $hero_images[0];
                ?>
                <div class="hero-single relative w-full h-full">
                    <div 
                        class="w-full h-full bg-cover bg-center bg-no-repeat"
                        style="background-image: url('<?php echo esc_url($image['sizes']['large'] ?? $image['url']); ?>');"
                        role="img"
                        aria-label="<?php echo esc_attr($image['alt'] ?: get_bloginfo('name')); ?>"
                    ></div>
                </div>
            <?php endif; ?>
            
        <?php else : ?>
            <!-- Fallback if no images -->
            <div class="w-full h-full bg-cream flex items-center justify-center">
                <p class="text-brown text-lg">Please upload hero images</p>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</section>