<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <main>.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Therosessom
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class('antialiased'); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'therosessom' ); ?></a>

    <header id="masthead" class="site-header sticky top-0 bg-white z-index-sticky shadow-md">
        <div class="container mx-auto flex justify-between items-center py-4">

            <div class="site-branding">
                <?php if ( has_custom_logo() ) : ?>
                    <div class="site-logo"><?php the_custom_logo(); ?></div>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" class="text-2xl font-bold tracking-tight"><?php bloginfo( 'name' ); ?></a>
                <?php endif; ?>
            </div><!-- .site-branding -->

            <nav id="site-navigation" class="main-navigation">
                <?php
                wp_nav_menu( [
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false, // Optional: removes the extra div container
                    'menu_class'     => 'flex items-center space-x-6 text-sm font-medium', // Example of adding Tailwind classes
                ] );
                ?>
            </nav><!-- #site-navigation -->

        </div>
    </header><!-- #masthead -->