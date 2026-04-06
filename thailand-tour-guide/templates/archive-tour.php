<?php
/**
 * Template for displaying tour archive
 */

get_header();
?>

<div class="ttg-archive-container">
    <header class="ttg-archive-header">
        <?php if (is_tax('tour_city')): ?>
            <h1><?php single_term_title(); ?> <?php _e('Tours', 'thailand-tour-guide'); ?></h1>
        <?php elseif (is_tax('tour_duration')): ?>
            <h1><?php single_term_title(); ?> <?php _e('Tours', 'thailand-tour-guide'); ?></h1>
        <?php else: ?>
            <h1><?php _e('All Tours', 'thailand-tour-guide'); ?></h1>
        <?php endif; ?>

        <?php if (term_description()): ?>
            <div class="ttg-archive-description">
                <?php echo term_description(); ?>
            </div>
        <?php endif; ?>
    </header>

    <?php echo do_shortcode('[tour_list]'); ?>
</div>

<?php
get_footer();
?>
