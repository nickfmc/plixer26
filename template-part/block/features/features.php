<?php

/**
 * fancy-divider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'feature-chart-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'c-feature-chart';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
<div class="c-chart-header">
    <div></div>
    <div><img src="<?php bloginfo( 'template_url' ) ?>/img/PlixerOneCore2.png" alt="Plixer One Core Logo" /></div>
    <div><img src="<?php bloginfo( 'template_url' ) ?>/img/PlixerOneNetwork2.png" alt="Plixer One Network Logo" /></div>
    <div><img src="<?php bloginfo( 'template_url' ) ?>/img/PlixerOneSecurity2.png" alt="Plixer One Security Logo" /></div>
</div>
<div class="c-chart-body">

<?php if( have_rows('features') ): ?>
          

    <div>
        <ul>
        <?php 
        $rows = get_field('features');
        $total_rows = count($rows);
        while( have_rows('features') ): the_row(); 
            $class = '';
            if( get_row_index() == 1 ) $class = 'first';
            if( get_row_index() == $total_rows ) $class = 'last';
        ?>
            <li class="<?php echo $class; ?>">
                <div><?php echo get_sub_field('feature_title'); ?></div>
                <?php if( get_sub_field('core') ): ?>
                    <div><span>✓</span></div>
                <?php else: ?>
                    <div><span class="c-chart-feature-dissabled">X</span></div>
                <?php endif; ?>
                <?php if( get_sub_field('network') ): ?>
                    <div><span>✓</span></div>
                <?php else: ?>
                    <div><span class="c-chart-feature-dissabled">X</span></div>
                <?php endif; ?>
                <?php if( get_sub_field('security') ): ?>
                    <div><span>✓</span></div>
                <?php else: ?>
                    <div><span class="c-chart-feature-dissabled">X</span></div>
                <?php endif; ?>
            </li>
        <?php endwhile; ?>
        </ul>
    </div>


              

<?php endif; ?>

</div>
</div>
