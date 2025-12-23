<?php
/**
 * Template part for displaying Divider section
 * Uses an ACF repeater to display a split layout with left and right sections.
 *
 * @package Therosessom
 */

// Check if ACF is active and the repeater field has rows.
if (!function_exists('get_field') || !have_rows('divider_items')) {
    return;
}

$divider_items = get_field('divider_items');

// Return if no content
if (empty($divider_items) || !is_array($divider_items)) {
    return;
}
?>

<section id="divider" class="divider-section relative bg-green-light py-12 md:py-20">
    
    <div class="hidden md:block absolute left-1/2 top-0 bottom-0 w-[1px] bg-charcoal/30 transform -translate-x-1/2 z-0"></div>

    <div class="container mx-auto px-4 md:px-8 max-w-7xl">
        
        <div class="divider-container flex flex-col justify-center md:flex-row gap-8 md:gap-0">
            
            <?php 
            $index = 0;
            foreach ($divider_items as $item) :
                $title = $item['title'];
                $image = $item['image'];
                $link = $item['link'];
                $aos_effect = ($index === 0) ? 'fade-right' : 'fade-left';
                $padding_class = ($index === 0) ? 'md:pr-8 lg:pr-12' : 'md:pl-8 lg:pl-12';
            ?>
            <div class="divider-item <?php echo $padding_class; ?> group" data-aos="<?php echo $aos_effect; ?>" data-aos-duration="1000">
                <?php if ($title) : ?>
                    <h2 class="text-xl font-serif uppercase font-normal tracking-wider mb-4 text-center">
                        <?php echo esc_html($title); ?>
                    </h2>
                <?php endif; ?>

                <?php if ($image) : ?>
                    <?php
                        $img_html = sprintf(
                            '<img src="%s" srcset="%s" sizes="(max-height: 519px)" alt="%s" class="max-h-[519px] transition-transform duration-700 group-hover:scale-105 aspect-[1/1.36]" loading="lazy">',
                            esc_url($image['sizes']['large'] ?? $image['url']),
                            esc_attr(wp_get_attachment_image_srcset($image['id'], 'large')),
                            esc_attr($image['alt'] ?: $title)
                        );
                    ?>
                    <div class="relative overflow-hidden m-4 group">
                        <?php if ($link) : ?>
                            <a href="<?php echo esc_url($link['url']); ?>" <?php echo $link['target'] ? 'target="' . esc_attr($link['target']) . '"' : ''; ?>>
                                <?php echo $img_html; ?>
                            </a>
                        <?php else : ?>
                            <?php echo $img_html; ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

            </div>
            <?php 
            $index++;
            endforeach; 
            ?>
            
        </div>
        
    </div>
</section>