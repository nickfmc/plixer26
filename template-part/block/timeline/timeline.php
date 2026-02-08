<?php

/**
 * Timeline Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'timeline-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'c-timeline';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}

$heading = get_field('timeline_heading');
$subheading = get_field('timeline_subheading');

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    
    <?php if( $heading || $subheading ): ?>
    <div class="c-timeline__header">
        <?php if( $heading ): ?>
            <h2 class="c-timeline__heading"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>
        <?php if( $subheading ): ?>
            <p class="c-timeline__subheading"><?php echo esc_html($subheading); ?></p>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <?php if( have_rows('timeline_steps') ): ?>
    <div class="c-timeline__wrapper">
        <div class="c-timeline__line"></div>
        <div class="c-timeline__items">
        <?php 
        $step_count = 0;
        while( have_rows('timeline_steps') ): the_row(); 
            $step_count++;
            $year = get_sub_field('year');
            $content = get_sub_field('content');
            $side = ($step_count % 2 == 0) ? 'right' : 'left';
        ?>
            <div class="c-timeline__item c-timeline__item--<?php echo $side; ?>">
                <div class="c-timeline__content">
                    <?php if( $year ): ?>
                        <h3 class="c-timeline__year"><?php echo esc_html($year); ?></h3>
                    <?php endif; ?>
                    <?php if( $content ): ?>
                        <p class="c-timeline__text"><?php echo esc_html($content); ?></p>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
        </div>
    </div>
    <?php else: ?>
        <?php if( $is_preview ): ?>
            <p style="padding: 20px; background: #f0f0f0; text-align: center;">Add timeline steps in the block settings.</p>
        <?php endif; ?>
    <?php endif; ?>
    
</div>
