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

    <header id="masthead" class="site-header fixed top-0 left-0 w-full z-50 px-8 transition-all duration-300 ease-in-out">
        <div class="relative flex justify-center items-center">

            <div class="site-branding">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <div class="logo-light">
                    <?php 
                        $logo_path = get_template_directory() . '/assets/images/logo_light.svg';
                        if ( file_exists( $logo_path ) ) {
                            echo file_get_contents( $logo_path );
                        }
                    ?>
                    </div>
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_brown.png" alt="<?php bloginfo('name'); ?>" class="logo-dark hidden">
                </a>
            </div>
            
            <nav id="site-navigation" class="main-navigation absolute top-1/2 right-0 -translate-y-1/2">
                <?php
                wp_nav_menu( [
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'menu_class'     => 'flex items-center space-x-8 text-sm font-medium uppercase',
                ] );
                ?>
            </nav>
            
        </div>
    </header>

    <main id="content" class="site-content">