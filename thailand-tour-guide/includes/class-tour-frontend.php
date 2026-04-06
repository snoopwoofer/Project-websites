<?php
/**
 * Tour Frontend Class
 */

class TTG_Tour_Frontend {

    /**
     * Initialize the class
     */
    public function init() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_shortcode('tour_list', array($this, 'tour_list_shortcode'));
        add_filter('template_include', array($this, 'tour_template'));
    }

    /**
     * Enqueue frontend scripts and styles
     */
    public function enqueue_scripts() {
        wp_enqueue_style('ttg-frontend', TTG_PLUGIN_URL . 'assets/css/frontend.css', array(), TTG_VERSION);
        wp_enqueue_script('ttg-frontend', TTG_PLUGIN_URL . 'assets/js/frontend.js', array('jquery'), TTG_VERSION, true);

        wp_localize_script('ttg-frontend', 'ttgAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('ttg_filter_nonce')
        ));
    }

    /**
     * Tour list shortcode
     */
    public function tour_list_shortcode($atts) {
        $atts = shortcode_atts(array(
            'posts_per_page' => -1,
            'city' => '',
            'duration' => ''
        ), $atts);

        ob_start();
        include TTG_PLUGIN_DIR . 'templates/tour-list.php';
        return ob_get_clean();
    }

    /**
     * Custom template for single tour
     */
    public function tour_template($template) {
        if (is_singular('tour')) {
            $plugin_template = TTG_PLUGIN_DIR . 'templates/single-tour.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }

        if (is_post_type_archive('tour') || is_tax('tour_city') || is_tax('tour_duration')) {
            $plugin_template = TTG_PLUGIN_DIR . 'templates/archive-tour.php';
            if (file_exists($plugin_template)) {
                return $plugin_template;
            }
        }

        return $template;
    }
}
