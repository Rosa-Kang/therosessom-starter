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
    $slider_items_key = 'project_slider_items';

?>

<section id="project-slider-<?php echo get_row_index(); ?>" class="project-slider-section bg-brown-dark py-16 md:py-24 overflow-hidden">
    <div class="container mx-auto px-4 max-w-5xl" data-aos="fade-in" data-aos-duration="300">

        <?php if ($section_title) : ?>
            <h2 class="text-cream-light text-xl md:text-2xl uppercase text-center mb-10 font-sans tracking-widest">
                <?php echo esc_html($section_title); ?>
            </h2>
        <?php endif; ?>

        <?php if (have_rows($slider_items_key)) : // ➡️ 새로운 Repeater 필드를 확인합니다. ?>
            <div class="project-swiper swiper relative" data-swiper-id="<?php echo get_row_index(); ?>">
                <div class="swiper-wrapper">

                <?php while (have_rows($slider_items_key)) : the_row();

                    $item_type = get_sub_field('item_type'); // ➡️ 항목 유형 (post 또는 custom)
                    $title = '';
                    $link = '';
                    $image = '';
                    $image_alt = '';

                    // 1️⃣ 포스트 선택
                    if ($item_type === 'post') :
                        $post_object = get_sub_field('project_post'); // ➡️ 포스트 오브젝트 필드
                        
                        if ($post_object) :
                            // get_sub_field('project_post')가 여러 개의 포스트를 반환할 수 있는 'multiple' 설정이었다면
                            // 반복문이 필요하지만, 여기서는 하나의 프로젝트를 선택하는 것으로 간주하고
                            // post_object가 배열이 아닌 하나의 포스트 객체라고 가정합니다.
                            $post_id = is_object($post_object) ? $post_object->ID : $post_object;
                            $title = get_the_title($post_id);
                            $link = get_permalink($post_id);
                            $image = get_the_post_thumbnail_url($post_id, 'large');
                            $image_alt = $title ?: '';
                        endif;

                    // 2️⃣ Custom Input
                    elseif ($item_type === 'custom') :
                        $title = get_sub_field('custom_title');
                        $link = get_sub_field('custom_link');
                        $custom_image_array = get_sub_field('custom_image');
                        $image = $custom_image_array['url'] ?? '';
                        $image_alt = $title ?: 'Custom Project Image';
                    endif;
                    
                    // --- 슬라이드 마크업 출력 ---
                    // item_type이 'post' 또는 'custom'이고 $title 또는 $image 중 하나라도 있으면 출력
                    if ( ( $item_type === 'post' && $post_object ) || $item_type === 'custom' ) :
                ?>
                        <div class="swiper-slide h-auto">
                            <div class="project-slide-item flex flex-col items-start">
                                <?php if ($image) : ?>
                                    <?php if ($link) : ?>
                                        <a href="<?php echo esc_url($link); ?>" class="block overflow-hidden mb-4 group">
                                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="min-w-[238px] aspect-[1/1.5] object-cover transition-transform duration-500 ease-out group-hover:scale-105" loading="lazy">
                                        </a>
                                    <?php else : ?>
                                        <div class="block overflow-hidden mb-4">
                                            <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($image_alt); ?>" class="min-w-[238px] aspect-[1/1.5] object-cover">
                                        </div>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <?php if ($link) : ?>
                                        <a href="<?php echo esc_url($link); ?>" class="block overflow-hidden mb-4 group">
                                            <div class="min-w-[238px] aspect-[1/1.5] bg-gray-200 flex items-center justify-center text-sm text-gray-500">No image</div>
                                        </a>
                                    <?php else : ?>
                                        <div class="min-w-[238px] aspect-[1/1.5] bg-gray-200 flex items-center justify-center text-sm text-gray-500">No image</div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php if ($title) : ?>
                                    <h3 class="font-sans text-sm tracking-wider text-taupe uppercase"><?php echo esc_html($title); ?></h3>
                                <?php endif; ?>

                                <?php if ($link) : ?>
                                    <a href="<?php echo esc_url($link); ?>" class="font-sans text-xs mt-1 text-cream-light hover:text-pink-light transition-colors duration-300 uppercase">VIEW PROJECT</a>
                                <?php endif; ?>
                            </div>
                        </div>
                <?php
                    endif;
                    // --- 슬라이드 마크업 출력 끝 ---

                endwhile; ?>

                </div>

                <div class="swiper-button-prev project-swiper-prev-<?php echo get_row_index(); ?> text-cream-light hover:text-pink-light transition-colors duration-300"></div>
                <div class="swiper-button-next project-swiper-next-<?php echo get_row_index(); ?> text-cream-light hover:text-pink-light transition-colors duration-300"></div>
            </div>
        <?php endif; ?>

    </div>
</section>

<?php endwhile; ?>