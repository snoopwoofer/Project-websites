<?php
/**
 * Plugin Name: Thailand Tour Guide
 * Plugin URI: https://example.com
 * Description: A tour guide website plugin for drivers to share itineraries with travelers in Thailand
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL v2 or later
 * Text Domain: thailand-tour-guide
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('TTG_VERSION', '1.0.0');
define('TTG_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('TTG_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once TTG_PLUGIN_DIR . 'includes/class-tour-post-type.php';
require_once TTG_PLUGIN_DIR . 'includes/class-tour-meta-boxes.php';
require_once TTG_PLUGIN_DIR . 'includes/class-tour-frontend.php';
require_once TTG_PLUGIN_DIR . 'includes/tour-functions.php';

/**
 * Initialize the plugin
 */
function ttg_init() {
    // Initialize custom post type
    $tour_post_type = new TTG_Tour_Post_Type();
    $tour_post_type->init();

    // Initialize meta boxes
    $tour_meta_boxes = new TTG_Tour_Meta_Boxes();
    $tour_meta_boxes->init();

    // Initialize frontend
    $tour_frontend = new TTG_Tour_Frontend();
    $tour_frontend->init();
}
add_action('plugins_loaded', 'ttg_init');

/**
 * Activation hook
 */
function ttg_activate() {
    // Trigger rewrite rules flush
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'ttg_activate');

/**
 * Deactivation hook
 */
function ttg_deactivate() {
    flush_rewrite_rules();
}
register_deactivation_hook(__FILE__, 'ttg_deactivate');
