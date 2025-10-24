<?php
/**
 * Template part for displaying Project Slider section
 * Swiper slider for displaying project items
 *
 * @package Therosessom
 */

// Check if ACF is active
if (!function_exists('get_field')) {
    return;
}

// Get ACF fields
$section_title = get_field('project_slider_title');
$project_items = get_field('project_items');

// Return if no projects
if (empty($project_items) || !is_array($project_items)) {
    return;
}

// The Swiper library will be initialized via initProjectSwiper() in the main JS file.
?>

<section id="project-slider" class="project-slider-section bg-brown-dark py-16 md:py-24 overflow-hidden">
    <div class="container mx-auto px-4 max-w-5xl">

        <?php if ($section_title) : ?>
            <h2 
                class="text-cream-light text-xl md:text-2xl uppercase text-center mb-10 font-sans tracking-widest"
                data-aos="fade-up" 
                data-aos-duration="1000"
            >
                <?php echo esc_html($section_title); ?>
            </h2>
        <?php endif; ?>

        <div class="project-swiper swiper relative" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="200">
            <div class="swiper-wrapper">
                
                <?php foreach ($project_items as $project) : 
                    $image = $project['project_image'] ?? null;
                    $title = $project['project_title'] ?? 'VIEW PROJECT';
                    $link  = $project['project_link'] ?? '#';
                ?>
                    <div class="swiper-slide h-auto">
                        <div class="project-slide-item flex flex-col items-start">
                            
                            <?php if ($image) : ?>
                                <a href="<?php echo esc_url($link); ?>" class="block overflow-hidden mb-4 group">
                                    <img 
                                        src="<?php echo esc_url($image['sizes']['large'] ?? $image['url']); ?>"
                                        alt="<?php echo esc_attr($image['alt'] ?: $title); ?>"
                                        class="min-w-[238px] aspect-[1/1.5] object-cover transition-transform duration-500 ease-out group-hover:scale-105"
                                        loading="lazy"
                                    >
                                </a>
                            <?php endif; ?>
                            
                            <h3 class="font-sans text-sm tracking-wider text-taupe uppercase">
                                <?php echo esc_html($title); ?>
                            </h3>
                            <a href="<?php echo esc_url($link); ?>" class="font-sans text-xs mt-1 text-cream-light hover:text-pink-light transition-colors duration-300 uppercase">
                                VIEW PROJECT
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div> 

            <div class="swiper-button-prev project-swiper-prev text-cream-light hover:text-pink-light transition-colors duration-300"></div>
            <div class="swiper-button-next project-swiper-next text-cream-light hover:text-pink-light transition-colors duration-300"></div>
            
            </div>

    </div>
</section>