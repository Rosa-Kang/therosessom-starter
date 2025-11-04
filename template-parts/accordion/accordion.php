<?php
/**
 * Template part for displaying Accordion section 
 *
 * @package Therosessom
 */

if (!function_exists('get_field')) return;
if (!have_rows('accordion_sections')) return;


while (have_rows('accordion_sections')) : the_row();

    $section_title = get_sub_field('section_title');
    $orientation = get_sub_field('layout_orientation'); 
    $description = get_sub_field('section_description');
    $image_array = get_sub_field('section_image');
    $image_url = $image_array['url'] ?? '';
    $image_alt = $image_array['alt'] ?: $section_title;
    
    
    $image_order_class = ($orientation === 'right-image') ? 'lg:order-2' : 'lg:order-1';
    $text_order_class = ($orientation === 'right-image') ? 'lg:order-1' : 'lg:order-2';
?>

    <section id="accordion-section-<?php echo get_row_index(); ?>" class="py-16 md:py-28 bg-brown-dark text-cream-light">
        <div class="container mx-auto px-4 max-w-7xl">
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 lg:grid-flow-col-dense">
    
                <div class="image-column <?php echo esc_attr($image_order_class); ?> lg:self-stretch">
                    <?php if ($image_url) : ?>
                        <div class="w-full h-full min-h-[400px] lg:min-h-0 overflow-hidden transition-all duration-500 ease-in-out">
                            <img 
                                src="<?php echo esc_url($image_url); ?>" 
                                alt="<?php echo esc_attr($image_alt); ?>" 
                                class="w-full h-full object-cover" 
                                loading="lazy"
                            >
                        </div>
                    <?php endif; ?>
                </div>

                <div class="content-column <?php echo esc_attr($text_order_class); ?>">
                    <?php if ($section_title) : ?>
                        <h2 class="text-3xl md:text-5xl font-serif mb-6 md:mb-10 text-cream-light">
                            <?php echo esc_html($section_title); ?>
                        </h2>
                    <?php endif; ?>

                    <?php if ($description) : ?>
                        <p class="text-sm md:text-base text-gray-400 mb-8"><?php echo $description; ?></p>
                    <?php endif; ?>

                    <?php if (have_rows('accordion_items')) : ?>
                        <div class="accordion-container space-y-4">
                            
                            <?php 
                            while (have_rows('accordion_items')) : the_row();
                                $item_title = get_sub_field('item_title');
                                $item_content = get_sub_field('item_content');
                                $item_id = 'acc-' . get_row_index() . '-' . get_the_ID(); 
                            ?>
                                
                                <div class="accordion-item border-b border-gray-700">
                                    <button 
                                        class="accordion-header uppercase w-full flex justify-between items-center py-4 text-left font-sans text-lg tracking-wider transition-colors duration-300 hover:text-pink-light" 
                                        aria-expanded="false" 
                                        aria-controls="<?php echo esc_attr($item_id); ?>"
                                        data-accordion-trigger
                                    >
                                        <?php echo esc_html($item_title); ?>
                                        <span class="accordion-icon ml-4 text-xl">&#x2295;</span> </button>
                                    
                                    <div 
                                        id="<?php echo esc_attr($item_id); ?>" 
                                        class="accordion-content overflow-hidden max-h-0 transition-max-height duration-500 ease-in-out" 
                                        data-accordion-content
                                    >
                                        <div class="py-4 text-sm text-gray-400">
                                            <?php echo $item_content; ?>
                                        </div>
                                    </div>
                                </div>

                            <?php endwhile; ?>

                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </section>

<?php endwhile; 
?> 
