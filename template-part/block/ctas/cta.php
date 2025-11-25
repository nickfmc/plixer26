<?php

/**
 * Custom CTAs Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'c-hp-ctas-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'c-hp-ctas';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}

// Get the animation class
$animation_class = get_field('animation_style');
if(empty($animation_class)) {
    $animation_class = 'animation-1'; // Default animation
}

// Get CTA data
$icon = get_field('icon');
$button_text = get_field('button_text');
$button_url = get_field('button_url');

?>
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="c-hp-cta <?php echo esc_attr($animation_class); ?>">
        <span class="c-box-corner c-box-corner-tl"></span>
        <span class="c-box-corner c-box-corner-tr"></span>
        <span class="c-box-corner c-box-corner-bl"></span>
        <span class="c-box-corner c-box-corner-br"></span>
       
        <div class="c-hp-cta-inner">
            <?php if(!empty($icon)): ?>
            <div class="c-hp-cta-icon">
                <?php echo $icon; ?>
            </div>
            <?php endif; ?>
            
            <div class="c-hp-cta-content">
                <?php 
                // Setup the InnerBlocks
                $allowed_blocks = array('core/heading', 'core/paragraph', 'core/list', 'core/image', 'generateblocks/text');
                $template = array(
                    array('core/heading', array(
                        'level' => 2,
                        'placeholder' => 'Add Title...',
                        'className' => 'cta-title'
                    )),
                    array('core/paragraph', array(
                        'placeholder' => 'Add content...',
                        'className' => 'cta-paragraph'
                    ))
                );
                
                // Output the InnerBlocks with our template
                echo '<InnerBlocks 
                    allowedBlocks="' . esc_attr(wp_json_encode($allowed_blocks)) . '" 
                    template="' . esc_attr(wp_json_encode($template)) . '"
                    templateLock="false"
                />';
                ?>
            </div>
            
            <?php if(!empty($button_text) && !empty($button_url)): ?>
            <div class="c-btn-newgreen">
                <a href="<?php echo esc_url($button_url); ?>"><?php echo esc_html($button_text); ?></a>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>