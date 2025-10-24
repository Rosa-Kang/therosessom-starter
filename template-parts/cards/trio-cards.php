<?php
/**
 * Template part for displaying Trio Cards section
 *
 * @package Therosessom
 */


if (!function_exists('get_field')) {
    return;
}

$cards = get_field('trio_cards');

if (!$cards || count($cards) !== 3) {
    if (current_user_can('edit_posts')) {
        echo '<p style="text-align: center; color: red; background: white; padding: 1rem;">Trio Cards Section: 이 섹션은 정확히 3개의 카드가 필요합니다.</p>';
    }
    return;
}

$card_left = $cards[0];
$card_right_top = $cards[1];
$card_right_bottom = $cards[2];

if (!function_exists('render_trio_card')) {
    
    function render_trio_card($card_data, $card_id, $card_layout_classes = '', $desc_classes = '', $image_inner_classes = '', $text_classes = '') {
        $image = $card_data['image'];
        $description = $card_data['description'];
        $link = $card_data['link'];

        if (!$image || !$description || !$link || !$link['url'] || !$link['title']) {
            return;
        }

        $link_url = esc_url($link['url']);
        $link_title = esc_html($link['title']);
        $link_target = $link['target'] ? 'target="' . esc_attr($link['target']) . '"' : '';
        
        $text_color = 'text-gray-300'; 
        
        ?>
        <div id="<?php echo esc_attr($card_id); ?>" class="trio-card w-full <?php echo esc_attr($card_layout_classes); ?>">
            
            <div class="image-wrapper">
                <img 
                    src="<?php echo esc_url($image['url']); ?>" 
                    alt="<?php echo esc_attr($image['alt']); ?>"
                    class="w-full h-full object-cover <?php echo esc_attr($image_inner_classes); ?>"
                    loading="lazy"
                    style="background-color: #F8E7E7;" 
                >
            </div>
            
            <div class="text-wrapper <?php echo esc_attr($text_classes); ?> <?php echo $text_color; ?>">
                <div class="h-full flex <?php echo esc_attr($desc_classes); ?>">
                    <div class="text-xs leading-relaxed md:text-sm md:leading-relaxed">
                        <?php 
                        echo strip_tags($description, '<a><b><strong><em><p><i>'); 
                        ?>
                    </div>
        
                    <a 
                        href="<?php echo $link_url; ?>" 
                        <?php echo $link_target; ?>
                        class="inline-flex items-center text-sm font-medium uppercase tracking-widest group text-white hover:text-gray-400 transition-colors"
                    >
                        <span><?php echo $link_title; ?></span>
                        
                        <svg 
                            class="ml-2 w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" 
                            xmlns="http://www.w3.org/2000/svg" 
                            fill="none" 
                            viewBox="0 0 24 24" 
                            stroke-width="1.5" 
                            stroke="currentColor"
                        >
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>
            </div>
            
        </div>
        <?php
    }
}
?>

<section id="trio-cards" class="bg-stone-800 text-white font-sans overflow-hidden py-20 lg:py-32">
    <div class="container mx-auto max-w-7xl px-4 md:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16 md:gap-16 lg:gap-24 items-center">
            
            <div class="flex flex-col justify-start">
                <?php 
                render_trio_card(
                    $card_left, 
                    'trio-card-1', 
                    'flex flex-col', 
                    'flex-col justify-end', 
                    'min-w-[321px] aspect-square', 
                    'mt-8' 
                ); 
                ?>
            </div>

            <div class="flex flex-col gap-16 md:gap-16 lg:gap-24">
                
                <div class="flex justify-start">
                    <?php 
                    render_trio_card(
                        $card_right_top, 
                        'trio-card-2', 
                        'grid grid-cols-[2fr_1fr] items-start gap-8', 
                        'flex-col-reverse justify-start', 
                        'min-w-[236px] aspect-[1/1.58]',
                        'h-full flex justify-end pt-16' 
                    ); 
                    ?>
                </div>
                
                <div class="flex justify-start">
                    <?php 
                    render_trio_card(
                        $card_right_bottom, 
                        'trio-card-3', 
                        'flex flex-col', 
                        'flex-col justify-end',
                        'min-w-[394px] aspect-[1.55/1] ',
                        'mt-8' 
                    ); 
                    ?>
                </div>
                
            </div>

        </div>
    </div>
</section>