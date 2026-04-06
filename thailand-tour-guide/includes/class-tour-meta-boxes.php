<?php
/**
 * Tour Meta Boxes Class
 */

class TTG_Tour_Meta_Boxes {

    /**
     * Initialize the class
     */
    public function init() {
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }

    /**
     * Add meta boxes
     */
    public function add_meta_boxes() {
        add_meta_box(
            'tour_details',
            __('Tour Details', 'thailand-tour-guide'),
            array($this, 'render_tour_details'),
            'tour',
            'normal',
            'high'
        );

        add_meta_box(
            'tour_itinerary',
            __('Itinerary', 'thailand-tour-guide'),
            array($this, 'render_tour_itinerary'),
            'tour',
            'normal',
            'high'
        );
    }

    /**
     * Render tour details meta box
     */
    public function render_tour_details($post) {
        wp_nonce_field('tour_details_nonce', 'tour_details_nonce');

        $price_per_person = get_post_meta($post->ID, '_tour_price_per_person', true);
        $customizable = get_post_meta($post->ID, '_tour_customizable', true);
        $custom_note = get_post_meta($post->ID, '_tour_custom_note', true);
        ?>
        <table class="form-table">
            <tr>
                <th><label for="tour_price_per_person"><?php _e('Price Per Person (THB)', 'thailand-tour-guide'); ?></label></th>
                <td>
                    <input type="number" id="tour_price_per_person" name="tour_price_per_person" value="<?php echo esc_attr($price_per_person); ?>" class="regular-text" step="0.01" min="0" />
                </td>
            </tr>
            <tr>
                <th><label for="tour_customizable"><?php _e('Customizable', 'thailand-tour-guide'); ?></label></th>
                <td>
                    <label>
                        <input type="checkbox" id="tour_customizable" name="tour_customizable" value="1" <?php checked($customizable, '1'); ?> />
                        <?php _e('This tour can be customized', 'thailand-tour-guide'); ?>
                    </label>
                </td>
            </tr>
            <tr>
                <th><label for="tour_custom_note"><?php _e('Customization Note', 'thailand-tour-guide'); ?></label></th>
                <td>
                    <textarea id="tour_custom_note" name="tour_custom_note" rows="3" class="large-text"><?php echo esc_textarea($custom_note); ?></textarea>
                    <p class="description"><?php _e('A message to travelers about customization options', 'thailand-tour-guide'); ?></p>
                </td>
            </tr>
        </table>
        <?php
    }

    /**
     * Render tour itinerary meta box
     */
    public function render_tour_itinerary($post) {
        wp_nonce_field('tour_itinerary_nonce', 'tour_itinerary_nonce');

        $itinerary = get_post_meta($post->ID, '_tour_itinerary', true);
        if (!is_array($itinerary)) {
            $itinerary = array();
        }
        ?>
        <div id="tour-itinerary-container">
            <div id="itinerary-items">
                <?php
                if (!empty($itinerary)) {
                    foreach ($itinerary as $index => $item) {
                        $this->render_itinerary_item($index, $item);
                    }
                } else {
                    $this->render_itinerary_item(0, array());
                }
                ?>
            </div>
            <button type="button" class="button button-secondary" id="add-itinerary-item">
                <?php _e('Add Stop', 'thailand-tour-guide'); ?>
            </button>
        </div>

        <script type="text/html" id="itinerary-item-template">
            <?php $this->render_itinerary_item('{{INDEX}}', array(), true); ?>
        </script>
        <?php
    }

    /**
     * Render a single itinerary item
     */
    private function render_itinerary_item($index, $item = array(), $template = false) {
        $time = isset($item['time']) ? $item['time'] : '';
        $location = isset($item['location']) ? $item['location'] : '';
        $description = isset($item['description']) ? $item['description'] : '';
        $image_id = isset($item['image_id']) ? $item['image_id'] : '';
        $image_url = $image_id ? wp_get_attachment_image_url($image_id, 'medium') : '';
        ?>
        <div class="itinerary-item" data-index="<?php echo esc_attr($index); ?>">
            <div class="itinerary-item-header">
                <h4><?php _e('Stop', 'thailand-tour-guide'); ?> <span class="item-number"><?php echo esc_html($index + 1); ?></span></h4>
                <button type="button" class="button button-link-delete remove-itinerary-item"><?php _e('Remove', 'thailand-tour-guide'); ?></button>
            </div>
            <table class="form-table">
                <tr>
                    <th><label><?php _e('Time', 'thailand-tour-guide'); ?></label></th>
                    <td>
                        <input type="text" name="itinerary[<?php echo esc_attr($index); ?>][time]" value="<?php echo esc_attr($time); ?>" class="regular-text" placeholder="<?php _e('e.g., 09:00 AM', 'thailand-tour-guide'); ?>" />
                    </td>
                </tr>
                <tr>
                    <th><label><?php _e('Location', 'thailand-tour-guide'); ?></label></th>
                    <td>
                        <input type="text" name="itinerary[<?php echo esc_attr($index); ?>][location]" value="<?php echo esc_attr($location); ?>" class="regular-text" placeholder="<?php _e('Location name', 'thailand-tour-guide'); ?>" />
                    </td>
                </tr>
                <tr>
                    <th><label><?php _e('Description', 'thailand-tour-guide'); ?></label></th>
                    <td>
                        <textarea name="itinerary[<?php echo esc_attr($index); ?>][description]" rows="3" class="large-text"><?php echo esc_textarea($description); ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th><label><?php _e('Location Photo', 'thailand-tour-guide'); ?></label></th>
                    <td>
                        <div class="itinerary-image-container">
                            <input type="hidden" name="itinerary[<?php echo esc_attr($index); ?>][image_id]" class="itinerary-image-id" value="<?php echo esc_attr($image_id); ?>" />
                            <div class="itinerary-image-preview">
                                <?php if ($image_url): ?>
                                    <img src="<?php echo esc_url($image_url); ?>" alt="" style="max-width: 200px; height: auto;" />
                                <?php endif; ?>
                            </div>
                            <button type="button" class="button upload-itinerary-image"><?php _e('Upload Image', 'thailand-tour-guide'); ?></button>
                            <button type="button" class="button remove-itinerary-image" <?php echo !$image_url ? 'style="display:none;"' : ''; ?>><?php _e('Remove Image', 'thailand-tour-guide'); ?></button>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <?php
    }

    /**
     * Save meta boxes
     */
    public function save_meta_boxes($post_id) {
        // Check nonces
        if (!isset($_POST['tour_details_nonce']) || !wp_verify_nonce($_POST['tour_details_nonce'], 'tour_details_nonce')) {
            return;
        }

        if (!isset($_POST['tour_itinerary_nonce']) || !wp_verify_nonce($_POST['tour_itinerary_nonce'], 'tour_itinerary_nonce')) {
            return;
        }

        // Check autosave
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        // Check permissions
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        // Save tour details
        if (isset($_POST['tour_price_per_person'])) {
            update_post_meta($post_id, '_tour_price_per_person', sanitize_text_field($_POST['tour_price_per_person']));
        }

        $customizable = isset($_POST['tour_customizable']) ? '1' : '0';
        update_post_meta($post_id, '_tour_customizable', $customizable);

        if (isset($_POST['tour_custom_note'])) {
            update_post_meta($post_id, '_tour_custom_note', sanitize_textarea_field($_POST['tour_custom_note']));
        }

        // Save itinerary
        if (isset($_POST['itinerary']) && is_array($_POST['itinerary'])) {
            $itinerary = array();
            foreach ($_POST['itinerary'] as $item) {
                $itinerary[] = array(
                    'time' => sanitize_text_field($item['time']),
                    'location' => sanitize_text_field($item['location']),
                    'description' => sanitize_textarea_field($item['description']),
                    'image_id' => absint($item['image_id'])
                );
            }
            update_post_meta($post_id, '_tour_itinerary', $itinerary);
        } else {
            delete_post_meta($post_id, '_tour_itinerary');
        }
    }

    /**
     * Enqueue admin scripts
     */
    public function enqueue_admin_scripts($hook) {
        if ($hook !== 'post.php' && $hook !== 'post-new.php') {
            return;
        }

        global $post;
        if ($post->post_type !== 'tour') {
            return;
        }

        wp_enqueue_media();
        wp_enqueue_script('jquery-ui-sortable');
        wp_enqueue_script('ttg-admin', TTG_PLUGIN_URL . 'assets/js/admin.js', array('jquery', 'jquery-ui-sortable'), TTG_VERSION, true);
        wp_enqueue_style('ttg-admin', TTG_PLUGIN_URL . 'assets/css/admin.css', array(), TTG_VERSION);
    }
}
