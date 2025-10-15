<?php
/**
 * Template part for displaying Callout Link section (Full Bleed Image)
 *
 * @package Therosessom
 */

// Ensure ACF is active
if (!function_exists('get_field')) {
    return;
}

// Get ACF fields
$title = get_field('callout_link_title');
$image = get_field('callout_link_image');
$links = get_field('callout_link_links');

// Abort if there's no essential content
if (!$title && !$image && !$links) {
    return;
}
?>

<section id="collection" class="callout-link-section bg-beige-light font-sans text-charcoal overflow-hidden">
    <div class="flex flex-col md:flex-row md:min-h-[600px] lg:min-h-[700px]">

        <div class="w-full md:w-1/2">
            <div class="container mx-auto max-w-7xl h-full flex flex-col justify-between py-12 px-4 md:px-8 lg:py-20">
                
                <div>
                    <?php if ($title) : ?>
                        <h2 class="text-2xl md:text-3xl text-charcoal/80 mb-16 md:mb-24">
                            <?php echo esc_html($title); ?>
                        </h2>
                    <?php endif; ?>
                </div>

                <?php if ($links) : ?>
                    <div class="w-full max-w-lg"> 
                        <ul class="space-y-3">
                            <?php
                            $link_index = 1;
                            foreach ($links as $row) :
                                $link = $row['link'];
                                if ($link) :
                                    $link_url = esc_url($link['url']);
                                    $link_title = esc_html($link['title']);
                                    $link_target = $link['target'] ? 'target="' . esc_attr($link['target']) . '"' : '';
                                    
                                    $formatted_index = str_pad($link_index, 2, '0', STR_PAD_LEFT);
                            ?>
                                <li>
                                    <a href="<?php echo $link_url; ?>" <?php echo $link_target; ?> class="group flex items-center justify-between py-2 border-b border-charcoal/30 hover:border-charcoal transition-colors duration-300">
                                        <span class="text-lg font-light tracking-wide group-hover:text-charcoal-dark">
                                            <?php echo $link_title; ?>
                                        </span>
                                        <span class="text-sm font-mono text-charcoal/70">
                                            <?php echo $formatted_index; ?>
                                        </span>
                                    </a>
                                </li>
                            <?php
                                    $link_index++;
                                endif;
                            endforeach;
                            ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="w-full md:w-1/2">
            <?php if ($image) : ?>
                <div class="h-full w-full min-h-[400px] md:min-h-0">
                    <img 
                        src="<?php echo esc_url($image['url']); ?>" 
                        alt="<?php echo esc_attr($image['alt']); ?>"
                        class="w-full h-full object-cover"
                        loading="lazy"
                    >
                </div>
            <?php endif; ?>
        </div>
        
    </div>
</section>