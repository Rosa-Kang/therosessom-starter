<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #page div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Therosessom
 */
?>

</main><!-- #content -->


    <footer id="colophon" class="site-footer bg-charcoal text-cream-light text-sm">
        <div class="container mx-auto py-12 text-center">
            <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All Rights Reserved.</p>
            <?php
            // Example of a privacy policy link, if it exists.
            if ( function_exists( 'the_privacy_policy_link' ) ) {
                the_privacy_policy_link( '<p class="mt-4">', '</p>' );
            }
            ?>
        </div><!-- .site-info -->
    </footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>