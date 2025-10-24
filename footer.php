<?php

/**
 * The template for displaying the footer.
 *
 * @package by Therosessom
 */
    $footer_copyright = get_field('footer_copyright', 'option');
	$footer_script = get_field('footer_script', 'option');

	$bg_class = ( is_front_page() || is_home() ) ? 'bg-primary-light' : 'bg-brown' 
	
?>

</main><!-- #content -->

		<footer id="colophon" role="contentinfo" class="relative z-20 <?php echo $bg_class;?> pt-16">

			<div class="ig-feed py-16">
				<?php get_template_part('template-parts/ig/ig-feed') ;?>
			</div>

			<div class="container lg:max-w-[1024px] mx-auto px-4 pb-8">
				<div class="flex justify-center items-center py-6 mx-auto px-4 sm:px-6 lg:px-8">
					<div id="footer-menu-container" class="space-y-2 font-sans w-[100%]">
						<?php wp_nav_menu(['menu' => 'Footer Menu', 'menu_id' => 'footer-menu', 'menu_class' => 'text-[10px] flex items-center justify-between uppercase font-medium']); ?>
					</div>
				</div>
				<?php if( $footer_copyright ): ?>
					<div>
						<div class="footer-bar text-neutral-500 text-xs text-center">
							<?php { echo $footer_copyright; } ?>
						</div>
					</div>
				<?php endif;?>
			</div>
		</footer>

</div> <!-- #page -->

<?php wp_footer(); ?>
<?php if( $footer_script ){ echo $footer_script; } ?>
</body>
</html>