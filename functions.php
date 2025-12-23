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

// Vite dev server URL
if ( ! defined( 'VITE_DEV_SERVER' ) ) {
	define( 'VITE_DEV_SERVER', 'http://localhost:3000' );
}

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
 * Check if Vite dev server is running
 */
function is_vite_dev_server_running() {
	// Check if dev server is accessible
	$ch = curl_init( VITE_DEV_SERVER );
	curl_setopt( $ch, CURLOPT_NOBODY, true );
	curl_setopt( $ch, CURLOPT_TIMEOUT, 1 );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_exec( $ch );
	$response_code = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
	curl_close( $ch );
	
	return $response_code >= 200 && $response_code < 400;
}

/**
 * Enqueue scripts and styles with Vite.
 */
function therosessom_enqueue_assets() {
	// Check if we're in development mode
	$is_dev = defined('WP_DEBUG') && WP_DEBUG && is_vite_dev_server_running();

	if ( $is_dev ) {
		// Development: Load scripts from Vite dev server
		wp_enqueue_script( 
			'vite-client', 
			VITE_DEV_SERVER . '/@vite/client', 
			[], 
			null, 
			true 
		);
		
		wp_enqueue_script( 
			'therosessom-main-js', 
			VITE_DEV_SERVER . '/assets/js/main.js', 
			[], 
			THEME_VERSION, 
			true 
		);
		
		// In dev mode, Vite handles CSS through HMR
	} else {
		// Production: Load scripts from the manifest file
		$manifest_path = get_template_directory() . '/dist/.vite/manifest.json';
		
		if ( file_exists( $manifest_path ) ) {
			$manifest = json_decode( file_get_contents( $manifest_path ), true );

			// Enqueue the main JS file
			if ( isset( $manifest['assets/js/main.js']['file'] ) ) {
				wp_enqueue_script( 
					'therosessom-main-js', 
					get_template_directory_uri() . '/dist/' . $manifest['assets/js/main.js']['file'], 
					[], 
					THEME_VERSION, 
					true 
				);
			}

			// Enqueue CSS files that are imported by main.js
			if ( isset( $manifest['assets/js/main.js']['css'] ) ) {
				foreach ( $manifest['assets/js/main.js']['css'] as $index => $css_file ) {
					wp_enqueue_style( 
						'therosessom-js-css-' . $index, 
						get_template_directory_uri() . '/dist/' . $css_file, 
						[], 
						THEME_VERSION 
					);
				}
			}

			// Enqueue the main CSS file (style.scss entry)
			if ( isset( $manifest['assets/css/style.scss']['file'] ) ) {
				wp_enqueue_style( 
					'therosessom-main-css', 
					get_template_directory_uri() . '/dist/' . $manifest['assets/css/style.scss']['file'], 
					[], 
					THEME_VERSION 
				);
			}
		} else {
			// Fallback: Log error if manifest doesn't exist
			error_log( 'Vite manifest file not found at: ' . $manifest_path );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'therosessom_enqueue_assets' );

/**
 * Add module type to script tags for ES modules support.
 */
function therosessom_add_module_to_script( $tag, $handle, $src ) {
	// Add type="module" to Vite scripts
	if ( in_array( $handle, ['vite-client', 'therosessom-main-js'], true ) ) {
		return '<script type="module" src="' . esc_url( $src ) . '"></script>' . "\n";
	}
	return $tag;
}
add_filter( 'script_loader_tag', 'therosessom_add_module_to_script', 10, 3 );

/**
 * ACF JSON Save Point
 * Enables version control for ACF fields
 */
function therosessom_acf_json_save_point( $path ) {
	return get_stylesheet_directory() . '/acf-json';
}
add_filter( 'acf/settings/save_json', 'therosessom_acf_json_save_point' );

/**
 * ACF JSON Load Point
 * Load ACF fields from JSON files
 */
function therosessom_acf_json_load_point( $paths ) {
	// Remove original path
	unset( $paths[0] );
	
	// Add custom path
	$paths[] = get_stylesheet_directory() . '/acf-json';
	
	return $paths;
}
add_filter( 'acf/settings/load_json', 'therosessom_acf_json_load_point' );

/**
 * Auto-sync ACF JSON fields on admin init
 * Automatically syncs field groups from JSON files
 */
function therosessom_acf_json_sync() {
	// Only run in admin area and if ACF is active
	if ( ! is_admin() || ! function_exists( 'acf_get_field_groups' ) ) {
		return;
	}
	
	// Get all field groups from JSON
	$json_files = glob( get_stylesheet_directory() . '/acf-json/*.json' );
	
	if ( empty( $json_files ) ) {
		return;
	}
	
	foreach ( $json_files as $file ) {
		$json = json_decode( file_get_contents( $file ), true );
		
		if ( ! $json || ! isset( $json['key'] ) ) {
			continue;
		}
		
		// Check if field group exists in database
		$field_group = acf_get_field_group( $json['key'] );
		
		// If doesn't exist or modified time is different, import it
		if ( ! $field_group || ( isset( $json['modified'] ) && $field_group['modified'] != $json['modified'] ) ) {
			acf_import_field_group( $json );
		}
	}
}
add_action( 'admin_init', 'therosessom_acf_json_sync' );