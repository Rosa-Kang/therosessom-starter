<?php
/**
 * Therosessom functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Therosessom
 */

// Theme version
if ( ! defined( 'THEME_VERSION' ) ) {
	define( 'THEME_VERSION', wp_get_theme()->get( 'Version' ) );
}

/**
 * Enqueue scripts and styles.
 */
function therosessom_asset_loader() {
	// Production: Load scripts from the manifest file
	$manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
	if ( file_exists( $manifest_path ) ) {
		$manifest = json_decode( file_get_contents( $manifest_path ), true );

		// Enqueue the main JS file
		if ( isset( $manifest['assets/js/main.js']['file'] ) ) {
			wp_enqueue_script( 'therosessom-main-js', get_template_directory_uri() . '/dist/' . $manifest['assets/js/main.js']['file'], [], THEME_VERSION, true );
		}

		// Enqueue CSS files for the main JS entry
		if ( isset( $manifest['assets/js/main.js']['css'] ) ) {
			foreach ( $manifest['assets/js/main.js']['css'] as $css_file ) {
				wp_enqueue_style( 'therosessom-' . basename($css_file, '.css'), get_template_directory_uri() . '/dist/' . $css_file, [], THEME_VERSION );
			}
		}

		// Enqueue the main CSS file
		if ( isset( $manifest['assets/css/style.scss']['file'] ) ) {
			wp_enqueue_style( 'therosessom-main-css', get_template_directory_uri() . '/dist/' . $manifest['assets/css/style.scss']['file'], [], THEME_VERSION );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'therosessom_asset_loader' );

/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function therosessom_setup() {
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );

	register_nav_menus(
		array(
			'primary'   => esc_html__( 'Primary Menu', 'therosessom' ),
			'secondary' => esc_html__( 'Secondary Menu', 'therosessom' ),
			'footer'    => esc_html__( 'Footer Menu', 'therosessom' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	add_theme_support( 'customize-selective-refresh-widgets' );

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 250,
			'width'       => 250,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);
}
add_action( 'after_setup_theme', 'therosessom_setup' );

/**
 * Register widget area.
 */
function therosessom_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'therosessom' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'therosessom' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'therosessom_widgets_init' );

/**
 * Enqueue scripts and styles with Vite.
 */
function vite_asset_loader() {
    // Check if the Vite dev server is running
    $is_dev = file_exists( get_template_directory() . '/.dev' );

    if ( $is_dev ) {
        // Development: Load scripts from Vite dev server
        // Vite dev server handles CSS through HMR (Hot Module Replacement)
        wp_enqueue_script( 'vite-client', VITE_DEV_SERVER . '/@vite/client', [], null, true );
        wp_enqueue_script( 'therosessom-main-js', VITE_DEV_SERVER . '/assets/js/main.js', [], THEME_VERSION, true );

    } else {
        // Production: Load scripts from the manifest file
        $manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
        if ( file_exists( $manifest_path ) ) {
            $manifest = json_decode( file_get_contents( $manifest_path ), true );

            // Enqueue the main JS file
            if ( isset( $manifest['assets/js/main.js']['file'] ) ) {
                wp_enqueue_script( 'therosessom-main-js', get_template_directory_uri() . '/dist/' . $manifest['assets/js/main.js']['file'], [], THEME_VERSION, true );
            }

            // Enqueue CSS files for the main JS entry
            if ( isset( $manifest['assets/js/main.js']['css'] ) ) {
                foreach ( $manifest['assets/js/main.js']['css'] as $css_file ) {
                    wp_enqueue_style( 'therosessom-' . basename($css_file, '.css'), get_template_directory_uri() . '/dist/' . $css_file, [], THEME_VERSION );
                }
            }

            // Enqueue the main CSS file
            if ( isset( $manifest['assets/css/style.scss']['file'] ) ) {
                wp_enqueue_style( 'therosessom-main-css', get_template_directory_uri() . '/dist/' . $manifest['assets/css/style.scss']['file'], [], THEME_VERSION );
            }
        }
    }
}
add_action( 'wp_enqueue_scripts', 'vite_asset_loader' );

/**
 * Add module type to the main script tag to support ES modules.
 */
add_filter('script_loader_tag', function (string $tag, string $handle, string $src) {
    if (in_array($handle, ['vite-client', 'therosessom-main-js'])) {
        return '<script type="module" src="' . esc_url($src) . '" defer></script>';
    }
    return $tag;
}, 10, 3);


/**
 * ACF JSON Save/Load Points
 * Enables version control for ACF fields
 */
add_filter('acf/settings/save_json', function($path) {
    return get_stylesheet_directory() . '/acf-json';
});

add_filter('acf/settings/load_json', function($paths) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;
});

/**
 * Auto-sync ACF JSON fields on admin init
 * Automatically syncs field groups from JSON files
 */
add_action('admin_init', function() {
    // Only run in admin area and if ACF is active
    if (!function_exists('acf_get_field_groups')) {
        return;
    }
    
    // Get all field groups from JSON
    $json_files = glob(get_stylesheet_directory() . '/acf-json/*.json');
    
    if (empty($json_files)) {
        return;
    }
    
    foreach ($json_files as $file) {
        $json = json_decode(file_get_contents($file), true);
        
        if (!$json || !isset($json['key'])) {
            continue;
        }
        
        // Check if field group exists in database
        $field_group = acf_get_field_group($json['key']);
        
        // If doesn't exist or modified time is different, import it
        if (!$field_group || (isset($json['modified']) && $field_group['modified'] != $json['modified'])) {
            acf_import_field_group($json);
        }
    }
});