<?php
/*
Plugin Name: Elementor YouTube Grid (RSS)
Plugin URI: https://www.abdullahwp.com
Description: Display latest YouTube videos from a channel or playlist using RSS feed with advanced controls, built-in lightboxes, and modern caching parameters.
Version: 1.3
Author: AbdullahWP
Author URI: https://www.abdullahwp.com
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: yt-grid-rss
Domain Path: /languages
Requires at least: 6.0
Requires PHP: 7.4
Requires Plugins: elementor
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

/**
 * Load plugin textdomain for localization.
 */
function ytgrid_rss_load_textdomain() {
    load_plugin_textdomain( 'yt-grid-rss', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'init', 'ytgrid_rss_load_textdomain' );

/**
 * Register core stylesheet and scripts cleanly to avoid duplicate inline outputs.
 */
function ytgrid_rss_register_assets() {
    wp_register_style(
        'yt-grid-rss-style',
        plugins_url( 'assets/css/yt-grid-rss.css', __FILE__ ),
        array(),
        '1.3'
    );

    wp_register_script(
        'yt-grid-rss-script',
        plugins_url( 'assets/js/yt-grid-rss.js', __FILE__ ),
        array( 'jquery' ),
        '1.3',
        true
    );
}
add_action( 'wp_enqueue_scripts', 'ytgrid_rss_register_assets' );
add_action( 'elementor/editor/after_enqueue_scripts', 'ytgrid_rss_register_assets' );

/**
 * Registers our upgraded YouTube Grid Widget with the Elementor framework.
 */
function ytgrid_rss_register_widget( $widgets_manager ) {
    require_once( __DIR__ . '/widgets/class-youtube-grid-rss.php' );
    $widgets_manager->register( new \YT_Grid_RSS_Widget() );
}
add_action( 'elementor/widgets/register', 'ytgrid_rss_register_widget' );

/**
 * Explain the Elementor dependency when it is unavailable.
 */
function ytgrid_rss_dependency_notice() {
    if ( ! current_user_can( 'activate_plugins' ) || did_action( 'elementor/loaded' ) ) {
        return;
    }

    echo '<div class="notice notice-warning"><p>' . esc_html__( 'Elementor YouTube Grid requires Elementor to be active.', 'yt-grid-rss' ) . '</p></div>';
}
add_action( 'admin_notices', 'ytgrid_rss_dependency_notice' );
