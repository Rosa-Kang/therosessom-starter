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
        <div class="flex justify-between items-center h-20"> 
            <div class="z-[110] lg:w-[111px]">
                <button id="secondary-menu-toggle" aria-controls="secondary-menu-panel" aria-expanded="false"
                    class="relative w-5 h-3 flex flex-col justify-between items-center group transition-all duration-300 ease-in-out">
                    <span class="sr-only">Toggle menu</span>
                    <span class="bar w-full h-[1px] bg-cream-light transition-all duration-300 ease-in-out origin-center"></span>
                    <span class="bar w-full h-[1px] bg-cream-light transition-all duration-300 ease-in-out origin-center"></span>
                    <span class="bar w-full h-[1px] bg-cream-light transition-all duration-300 ease-in-out origin-center"></span>
                </button>
            </div>
            
            <div class="site-branding w-[87px]">
                <a class="flex items-center justify-center" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                    <div class="logo-light w-full">
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
            
            <nav id="site-navigation" class="main-navigation hidden lg:flex">
                <?php
                wp_nav_menu( [
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                    'menu_class'     => 'flex items-center space-x-8 text-sm font-medium uppercase',
                ] );
                ?>
            </nav>
            <div class="w-5 lg:hidden"></div>
            
        </div>
        <div id="secondary-menu-overlay" class="fixed inset-0 bg-black bg-opacity-50 z-[9] hidden" aria-hidden="true"></div>

<div id="secondary-menu-panel" class="fixed top-0 left-0 w-full max-w-md h-screen text-black p-8 transform -translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">    
    <nav id="secondary-navigation" class="relative pt-12 pl-6">
        <?php
        wp_nav_menu( [
            'theme_location' => 'secondary', // This uses the menu you created
            'menu_id'        => 'secondary-menu',
            'container'      => false,
            'menu_class'     => 'space-y-4 text-2xl uppercase', // Matches video style
        ] );
        ?>
    </nav>
</div>

    </header>

    <main id="content" class="site-content">