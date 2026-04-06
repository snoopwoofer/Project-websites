<?php
/**
 * Template for displaying a single tour card
 */

$tour_id = get_the_ID();
$price = ttg_get_tour_price($tour_id);
$cities = get_the_terms($tour_id, 'tour_city');
$durations = get_the_terms($tour_id, 'tour_duration');
$itinerary = ttg_get_itinerary($tour_id);
$is_customizable = ttg_is_customizable($tour_id);
?>

<div class="ttg-tour-card">
    <?php if (has_post_thumbnail()): ?>
        <div class="ttg-tour-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail('medium_large'); ?>
            </a>
        </div>
    <?php endif; ?>

    <div class="ttg-tour-content">
        <div class="ttg-tour-header">
            <h3 class="ttg-tour-title">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>

            <div class="ttg-tour-meta">
                <?php if ($cities && !is_wp_error($cities)): ?>
                    <span class="ttg-city">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M8 0C5.2 0 3 2.2 3 5c0 3.5 5 11 5 11s5-7.5 5-11c0-2.8-2.2-5-5-5zm0 7c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"/>
                        </svg>
                        <?php echo esc_html($cities[0]->name); ?>
                    </span>
                <?php endif; ?>

                <?php if ($durations && !is_wp_error($durations)): ?>
                    <span class="ttg-duration">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M8 0C3.6 0 0 3.6 0 8s3.6 8 8 8 8-3.6 8-8-3.6-8-8-8zm4 9H8V4h1v4h3v1z"/>
                        </svg>
                        <?php echo esc_html($durations[0]->name); ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <?php if (has_excerpt()): ?>
            <div class="ttg-tour-excerpt">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($itinerary)): ?>
            <div class="ttg-tour-itinerary-preview">
                <h4><?php _e('Itinerary Highlights:', 'thailand-tour-guide'); ?></h4>
                <ul class="ttg-itinerary-list">
                    <?php
                    $preview_count = min(3, count($itinerary));
                    for ($i = 0; $i < $preview_count; $i++):
                        $item = $itinerary[$i];
                    ?>
                        <li>
                            <?php if (!empty($item['image_id'])): ?>
                                <div class="ttg-itinerary-thumb">
                                    <?php echo wp_get_attachment_image($item['image_id'], 'thumbnail'); ?>
                                </div>
                            <?php endif; ?>
                            <div class="ttg-itinerary-info">
                                <?php if (!empty($item['time'])): ?>
                                    <span class="ttg-time"><?php echo esc_html($item['time']); ?></span>
                                <?php endif; ?>
                                <strong><?php echo esc_html($item['location']); ?></strong>
                            </div>
                        </li>
                    <?php endfor; ?>
                    <?php if (count($itinerary) > 3): ?>
                        <li class="ttg-more-stops">
                            <?php printf(__('+ %d more stops', 'thailand-tour-guide'), count($itinerary) - 3); ?>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="ttg-tour-footer">
            <div class="ttg-tour-price">
                <span class="ttg-price-label"><?php _e('From', 'thailand-tour-guide'); ?></span>
                <span class="ttg-price-amount"><?php echo ttg_format_price($price); ?></span>
                <span class="ttg-price-unit"><?php _e('per person', 'thailand-tour-guide'); ?></span>
            </div>

            <?php if ($is_customizable): ?>
                <div class="ttg-customizable-badge">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                        <path d="M14.5 1.5l-3 3L13 6l3-3-1.5-1.5zM10 5L1 14h2l9-9-2-2zm-8 7l1.5 1.5L12 5 10.5 3.5 2 12z"/>
                    </svg>
                    <?php _e('Customizable', 'thailand-tour-guide'); ?>
                </div>
            <?php endif; ?>

            <a href="<?php the_permalink(); ?>" class="ttg-view-details">
                <?php _e('View Details', 'thailand-tour-guide'); ?>
            </a>
        </div>
    </div>
</div>
