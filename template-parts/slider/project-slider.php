<?php
/**
 * Template part for displaying Project Slider section
 *
 * @package Therosessom
 */

if (!function_exists('get_field')) return;
if (!have_rows('project_slider_sections')) return;

while (have_rows('project_slider_sections')) : the_row();

    $section_title = get_sub_field('project_slider_title');
    $project_items = get_sub_field('project_items');
    $slider_id = get_row_index();

    // Skip if no projects selected
    if (!$project_items || !is_array($project_items)) continue;

?>

<section id="project-slider-<?php echo $slider_id; ?>" class="project-slider-section bg-brown-dark py-16 md:py-24 overflow-hidden">
    <div class="container mx-auto px-4 max-w-5xl" data-aos="fade-in" data-aos-duration="300">

        <?php if ($section_title) : ?>
            <h2 class="text-cream-light text-xl md:text-2xl uppercase text-center mb-10 font-sans tracking-widest">
                <?php echo esc_html($section_title); ?>
            </h2>
        <?php endif; ?>

        <div class="project-swiper swiper relative" data-swiper-id="<?php echo $slider_id; ?>">
            <div class="swiper-wrapper">

            <?php foreach ($project_items as $post_object) : 
                // Since return_format is 'object', we get the post object directly
                $post_id = $post_object->ID;
                $title = get_the_title($post_id);
                $link = get_permalink($post_id);
                $image = get_the_post_thumbnail_url($post_id, 'large');
                $image_alt = $title ?: '';
            ?>
                <div class="swiper-slide h-auto">
                    <div class="project-slide-item flex flex-col items-start">
                        <?php if ($image) : ?>
                            <a href="<?php echo esc_url($link); ?>" class="block overflow-hidden mb-4 group">
                                <img src="<?php echo esc_url($image); ?>" 
                                     alt="<?php echo esc_attr($image_alt); ?>" 
                                     class="min-w-[238px] aspect-[1/1.5] object-cover transition-transform duration-500 ease-out group-hover:scale-105" 
                                     loading="lazy">
                            </a>
                        <?php else : ?>
                            <a href="<?php echo esc_url($link); ?>" class="block overflow-hidden mb-4 group">
                                <div class="min-w-[238px] aspect-[1/1.5] bg-gray-200 flex items-center justify-center text-sm text-gray-500">
                                    No image
                                </div>
                            </a>
                        <?php endif; ?>

                        <?php if ($title) : ?>
                            <h3 class="font-sans text-sm tracking-wider text-taupe uppercase">
                                <?php echo esc_html($title); ?>
                            </h3>
                        <?php endif; ?>

                        <a href="<?php echo esc_url($link); ?>" 
                           class="font-sans text-xs mt-1 text-cream-light hover:text-pink-light transition-colors duration-300 uppercase">
                            VIEW PROJECT
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>

            </div>
        </div>

        <div class="swiper-button-prev project-swiper-prev-<?php echo $slider_id; ?> text-cream-light hover:text-pink-light transition-colors duration-300"></div>
        <div class="swiper-button-next project-swiper-next-<?php echo $slider_id; ?> text-cream-light hover:text-pink-light transition-colors duration-300"></div>
    </div>
</section>

<?php endwhile; ?>