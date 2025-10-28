<?php
/**
 * Template part for displaying Project Slider section
 *
 * @package Therosessom 
 * 
 * */

if (!function_exists('get_field')) {
    return;
}

if (have_rows('project_slider_sections')) :
    
    while (have_rows('project_slider_sections')) : the_row();
        
        $section_title = get_sub_field('project_slider_title');
        $project_items = get_sub_field('project_items');

        if (empty($project_items) || !is_array($project_items)) {
            continue;
        }
        ?>

        <section 
            id="project-slider-<?php echo get_row_index(); ?>" 
            class="project-slider-section bg-brown-dark py-16 md:py-24 overflow-hidden"
        >
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

                <div 
                    class="project-swiper swiper relative" 
                    data-aos="fade-up" 
                    data-aos-duration="1000" 
                    data-aos-delay="200"
                    data-swiper-id="<?php echo get_row_index(); ?>"
                >
                    <div class="swiper-wrapper">
                        
                        <?php 
                        foreach ($project_items as $project) : 
                            $post_id = $project->ID;
                            $title = get_the_title($post_id); 
                            $link  = get_permalink($post_id);
                            $image_url = get_the_post_thumbnail_url($post_id, 'large');
                            $image_alt = $title;
                        ?>
                            <div class="swiper-slide h-auto">
                                <div class="project-slide-item flex flex-col items-start">
                                    
                                    <?php if ($image_url) : ?>
                                        <a href="<?php echo esc_url($link); ?>" class="block overflow-hidden mb-4 group">
                                            <img 
                                                src="<?php echo esc_url($image_url); ?>"
                                                alt="<?php echo esc_attr($image_alt); ?>"
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
                    
                    <div class="swiper-button-prev project-swiper-prev-<?php echo get_row_index(); ?> text-cream-light hover:text-pink-light transition-colors duration-300"></div>
                    <div class="swiper-button-next project-swiper-next-<?php echo get_row_index(); ?> text-cream-light hover:text-pink-light transition-colors duration-300"></div>
                    
                </div>

            </div>
        </section>

<?php 
    endwhile;
endif;