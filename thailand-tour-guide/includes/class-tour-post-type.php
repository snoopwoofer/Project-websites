<?php
/**
 * Tour Post Type Class
 */

class TTG_Tour_Post_Type {

    /**
     * Initialize the class
     */
    public function init() {
        add_action('init', array($this, 'register_post_type'));
        add_action('init', array($this, 'register_taxonomies'));
    }

    /**
     * Register Tour custom post type
     */
    public function register_post_type() {
        $labels = array(
            'name'                  => __('Tours', 'thailand-tour-guide'),
            'singular_name'         => __('Tour', 'thailand-tour-guide'),
            'menu_name'             => __('Tours', 'thailand-tour-guide'),
            'name_admin_bar'        => __('Tour', 'thailand-tour-guide'),
            'add_new'               => __('Add New', 'thailand-tour-guide'),
            'add_new_item'          => __('Add New Tour', 'thailand-tour-guide'),
            'new_item'              => __('New Tour', 'thailand-tour-guide'),
            'edit_item'             => __('Edit Tour', 'thailand-tour-guide'),
            'view_item'             => __('View Tour', 'thailand-tour-guide'),
            'all_items'             => __('All Tours', 'thailand-tour-guide'),
            'search_items'          => __('Search Tours', 'thailand-tour-guide'),
            'parent_item_colon'     => __('Parent Tours:', 'thailand-tour-guide'),
            'not_found'             => __('No tours found.', 'thailand-tour-guide'),
            'not_found_in_trash'    => __('No tours found in Trash.', 'thailand-tour-guide')
        );

        $args = array(
            'labels'                => $labels,
            'public'                => true,
            'publicly_queryable'    => true,
            'show_ui'               => true,
            'show_in_menu'          => true,
            'query_var'             => true,
            'rewrite'               => array('slug' => 'tours'),
            'capability_type'       => 'post',
            'has_archive'           => true,
            'hierarchical'          => false,
            'menu_position'         => 5,
            'menu_icon'             => 'dashicons-location-alt',
            'supports'              => array('title', 'editor', 'thumbnail', 'excerpt'),
            'show_in_rest'          => true
        );

        register_post_type('tour', $args);
    }

    /**
     * Register custom taxonomies
     */
    public function register_taxonomies() {
        // Register City taxonomy
        $city_labels = array(
            'name'              => __('Cities', 'thailand-tour-guide'),
            'singular_name'     => __('City', 'thailand-tour-guide'),
            'search_items'      => __('Search Cities', 'thailand-tour-guide'),
            'all_items'         => __('All Cities', 'thailand-tour-guide'),
            'parent_item'       => __('Parent City', 'thailand-tour-guide'),
            'parent_item_colon' => __('Parent City:', 'thailand-tour-guide'),
            'edit_item'         => __('Edit City', 'thailand-tour-guide'),
            'update_item'       => __('Update City', 'thailand-tour-guide'),
            'add_new_item'      => __('Add New City', 'thailand-tour-guide'),
            'new_item_name'     => __('New City Name', 'thailand-tour-guide'),
            'menu_name'         => __('Cities', 'thailand-tour-guide'),
        );

        $city_args = array(
            'hierarchical'      => true,
            'labels'            => $city_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'city'),
            'show_in_rest'      => true
        );

        register_taxonomy('tour_city', array('tour'), $city_args);

        // Register Duration taxonomy
        $duration_labels = array(
            'name'              => __('Duration', 'thailand-tour-guide'),
            'singular_name'     => __('Duration', 'thailand-tour-guide'),
            'search_items'      => __('Search Durations', 'thailand-tour-guide'),
            'all_items'         => __('All Durations', 'thailand-tour-guide'),
            'edit_item'         => __('Edit Duration', 'thailand-tour-guide'),
            'update_item'       => __('Update Duration', 'thailand-tour-guide'),
            'add_new_item'      => __('Add New Duration', 'thailand-tour-guide'),
            'new_item_name'     => __('New Duration Name', 'thailand-tour-guide'),
            'menu_name'         => __('Duration', 'thailand-tour-guide'),
        );

        $duration_args = array(
            'hierarchical'      => true,
            'labels'            => $duration_labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array('slug' => 'duration'),
            'show_in_rest'      => true
        );

        register_taxonomy('tour_duration', array('tour'), $duration_args);

        // Pre-populate cities
        $this->populate_default_terms();
    }

    /**
     * Populate default terms
     */
    public function populate_default_terms() {
        // Add default cities
        $cities = array('Bangkok', 'Pattaya', 'Hua Hin', 'Ayutthaya');
        foreach ($cities as $city) {
            if (!term_exists($city, 'tour_city')) {
                wp_insert_term($city, 'tour_city');
            }
        }

        // Add default durations
        $durations = array('1 Day', '2 Days', '3 Days', '4 Days', '5 Days', '6 Days', '7+ Days');
        foreach ($durations as $duration) {
            if (!term_exists($duration, 'tour_duration')) {
                wp_insert_term($duration, 'tour_duration');
            }
        }
    }
}
