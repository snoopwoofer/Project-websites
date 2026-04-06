<?php
/**
 * Template for displaying single tour
 */

get_header();

while (have_posts()): the_post();
    $tour_id = get_the_ID();
    $price = ttg_get_tour_price($tour_id);
    $cities = get_the_terms($tour_id, 'tour_city');
    $durations = get_the_terms($tour_id, 'tour_duration');
    $itinerary = ttg_get_itinerary($tour_id);
    $is_customizable = ttg_is_customizable($tour_id);
    $custom_note = ttg_get_custom_note($tour_id);
?>

<article id="post-<?php the_ID(); ?>" <?php post_class('ttg-single-tour'); ?>>
    <div class="ttg-tour-hero">
        <?php if (has_post_thumbnail()): ?>
            <div class="ttg-hero-image">
                <?php the_post_thumbnail('full'); ?>
            </div>
        <?php endif; ?>

        <div class="ttg-hero-content">
            <h1 class="ttg-tour-title"><?php the_title(); ?></h1>

            <div class="ttg-tour-meta-info">
                <?php if ($cities && !is_wp_error($cities)): ?>
                    <span class="ttg-meta-item ttg-city">
                        <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M8 0C5.2 0 3 2.2 3 5c0 3.5 5 11 5 11s5-7.5 5-11c0-2.8-2.2-5-5-5zm0 7c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                        </svg>
                        <?php echo esc_html($cities[0]->name); ?>
                    </span>
                <?php endif; ?>

                <?php if ($durations && !is_wp_error($durations)): ?>
                    <span class="ttg-meta-item ttg-duration">
                        <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm4 9H8V4h1v4h3v1z"/>
                        </svg>
                        <?php echo esc_html($durations[0]->name); ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="ttg-tour-body">
        <div class="ttg-tour-main">
            <?php if (get_the_content()): ?>
                <div class="ttg-tour-description">
                    <h2><?php _e('Tour Overview', 'thailand-tour-guide'); ?></h2>
                    <?php the_content(); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($itinerary)): ?>
                <div class="ttg-tour-itinerary-full">
                    <h2><?php _e('Detailed Itinerary', 'thailand-tour-guide'); ?></h2>
                    <div class="ttg-itinerary-timeline">
                        <?php foreach ($itinerary as $index => $item): ?>
                            <div class="ttg-itinerary-item">
                                <div class="ttg-itinerary-marker">
                                    <span class="ttg-marker-number"><?php echo $index + 1; ?></span>
                                </div>
                                <div class="ttg-itinerary-content">
                                    <?php if (!empty($item['time'])): ?>
                                        <div class="ttg-itinerary-time"><?php echo esc_html($item['time']); ?></div>
                                    <?php endif; ?>

                                    <h3 class="ttg-itinerary-location"><?php echo esc_html($item['location']); ?></h3>

                                    <?php if (!empty($item['image_id'])): ?>
                                        <div class="ttg-itinerary-image">
                                            <?php echo wp_get_attachment_image($item['image_id'], 'large'); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($item['description'])): ?>
                                        <div class="ttg-itinerary-description">
                                            <?php echo wpautop(esc_html($item['description'])); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($is_customizable && !empty($custom_note)): ?>
                <div class="ttg-customization-note">
                    <div class="ttg-note-header">
                        <svg width="24" height="24" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M14.5 1.5l-3 3L13 6l3-3-1.5-1.5zM10 5L1 14h2l9-9-2-2zm-8 7l1.5 1.5L12 5 10.5 3.5 2 12z"/>
                        </svg>
                        <h3><?php _e('Customization Available', 'thailand-tour-guide'); ?></h3>
                    </div>
                    <p><?php echo wp_kses_post(wpautop($custom_note)); ?></p>
                </div>
            <?php endif; ?>
        </div>

        <aside class="ttg-tour-sidebar">
            <div class="ttg-booking-card">
                <div class="ttg-price-section">
                    <div class="ttg-price-from"><?php _e('From', 'thailand-tour-guide'); ?></div>
                    <div class="ttg-price-amount"><?php echo ttg_format_price($price); ?></div>
                    <div class="ttg-price-unit"><?php _e('per person', 'thailand-tour-guide'); ?></div>
                </div>

                <?php if ($is_customizable): ?>
                    <div class="ttg-customizable-info">
                        <svg width="20" height="20" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm1 12H7V7h2v5zm0-6H7V4h2v2z"/>
                        </svg>
                        <span><?php _e('This tour can be customized to your preferences', 'thailand-tour-guide'); ?></span>
                    </div>
                <?php endif; ?>

                <button class="ttg-contact-button" onclick="alert('<?php _e('Contact feature coming soon! For now, please use the contact form or phone number on the website.', 'thailand-tour-guide'); ?>')">
                    <?php _e('Contact Driver', 'thailand-tour-guide'); ?>
                </button>

                <div class="ttg-tour-features">
                    <h4><?php _e('What\'s Included', 'thailand-tour-guide'); ?></h4>
                    <ul>
                        <li><svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M13.5 2L6 9.5 2.5 6 1 7.5l5 5 9-9z"/></svg> <?php _e('Private transportation', 'thailand-tour-guide'); ?></li>
                        <li><svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M13.5 2L6 9.5 2.5 6 1 7.5l5 5 9-9z"/></svg> <?php _e('English-speaking driver', 'thailand-tour-guide'); ?></li>
                        <li><svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><path d="M13.5 2L6 9.5 2.5 6 1 7.5l5 5 9-9z"/></svg> <?php _e('Flexible itinerary', 'thailand-tour-guide'); ?></li>
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</article>

<?php
endwhile;

get_footer();
?>
