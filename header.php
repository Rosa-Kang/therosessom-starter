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
        <div class="relative flex items-center justify-between h-20 xl:max-w-[1420px] mx-auto px-4"> 
    <!-- Left: Menu button -->
    <div class="z-[110] lg:hidden">
        <button id="secondary-menu-toggle" aria-controls="secondary-menu-panel" aria-expanded="false"
            class="relative w-5 h-3 flex flex-col justify-between items-center group transition-all duration-300 ease-in-out">
            <span class="sr-only">Toggle menu</span>
            <span class="bar w-full h-[1px] bg-cream-light transition-all duration-300 ease-in-out origin-center"></span>
            <span class="bar w-full h-[1px] bg-cream-light transition-all duration-300 ease-in-out origin-center"></span>
            <span class="bar w-full h-[1px] bg-cream-light transition-all duration-300 ease-in-out origin-center"></span>
        </button>
    </div>

    <!-- Center: Logo (absolute centered) -->
    <div class="site-branding">
        <a class="flex items-center justify-center" href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
            <div class="logo-light w-full">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_light.svg" alt="<?php bloginfo('name'); ?>" class="h-[27px] md:h-[39px]">
            </div>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_brown.svg" alt="<?php bloginfo('name'); ?>" class="h-[27px] md:h-[39px] logo-dark hidden">
        </a>
    </div>


    <!-- Right: Navigation -->
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

    <!-- Right spacer for mobile -->
    <div class="w-5 lg:hidden"></div>
</div>

    <div id="secondary-menu-overlay" class="fixed inset-0 hidden" aria-hidden="true"></div>

    <div id="secondary-menu-panel" class="fixed top-0 left-0 w-full max-w-md h-screen text-black p-8 transform -translate-x-full transition-transform duration-300 ease-in-out overflow-y-auto">    
        <div id="menu-panel-header" class="relative flex items-center h-20 px-8 border-b border-gray-200">
            <button id="submenu-back-btn" class="absolute flex items-center space-x-2 text-xl font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                <span id="back-button-label" class="uppercase"></span>
            </button>
        </div>
        
        <div id="menu-levels-container" class="relative w-full h-[calc(100vh-5rem)] overflow-hidden">
            
            <nav id="secondary-navigation" class="menu-level-0 absolute top-0 left-0 w-full h-full p-8 pt-0 transition-transform duration-300 ease-in-out">
                <?php
                wp_nav_menu( [
                    'theme_location' => 'secondary', 
                    'menu_id'        => 'secondary-menu',
                    'container'      => false,
                    'menu_class'     => 'space-y-4 text-2xl uppercase', 
                ] );
                ?>
            </nav>
            
        </div>
    </div>

    </header>

    <main id="content" class="site-content">