<?php

/**
 * Partner Hero Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'partner-hero-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'c-partner-hero';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}

$eyebrow       = get_field('partner_hero_eyebrow');
$heading       = get_field('partner_hero_heading');
$heading_tag   = get_field('partner_hero_heading_level') === 'h2' ? 'h2' : 'h1';
$body          = get_field('partner_hero_body');
$logo          = get_field('partner_hero_logo');
$callout       = get_field('partner_hero_callout');
$btn1_text     = get_field('partner_hero_btn1_text');
$btn1_popup    = get_field('partner_hero_btn1_popup');
$btn1_url      = get_field('partner_hero_btn1_url');
$btn2          = get_field('partner_hero_btn2');

$has_btn1 = $btn1_text && ( $btn1_popup || $btn1_url );
$has_btn2 = !empty($btn2['url']) && !empty($btn2['title']);

?>
<section id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <div class="c-partner-hero__inner">

        <div class="c-partner-hero__panel">
            <div class="c-partner-hero__content">
                <?php if( $eyebrow ): ?>
                    <p class="c-partner-hero__eyebrow"><?php echo esc_html($eyebrow); ?></p>
                <?php endif; ?>

                <?php if( $heading ): ?>
                    <<?php echo $heading_tag; ?> class="c-partner-hero__heading"><?php echo esc_html($heading); ?></<?php echo $heading_tag; ?>>
                <?php endif; ?>

                <?php if( $body ): ?>
                    <div class="c-partner-hero__body"><?php echo wp_kses_post($body); ?></div>
                <?php endif; ?>
            </div>

            <?php if( $logo ): ?>
                <div class="c-partner-hero__logo">
                    <?php echo wp_get_attachment_image($logo, 'medium_large'); ?>
                </div>
            <?php endif; ?>

            <div class="c-partner-hero__slashes" aria-hidden="true">
                <span></span><span></span><span></span><span></span><span></span><span></span>
            </div>
        </div>

        <?php if( $callout || $has_btn1 || $has_btn2 ): ?>
        <div class="c-partner-hero__callout">
            <?php if( $callout ): ?>
                <p class="c-partner-hero__callout-text"><?php echo esc_html($callout); ?></p>
            <?php endif; ?>

            <?php if( $has_btn1 || $has_btn2 ): ?>
            <div class="c-partner-hero__buttons">
                <?php if( $has_btn1 ): ?>
                    <?php if( $btn1_popup ): ?>
                        <a href="#" class="c-partner-hero__btn popup-demo"><?php echo esc_html($btn1_text); ?></a>
                    <?php else: ?>
                        <a href="<?php echo esc_url($btn1_url); ?>" class="c-partner-hero__btn"><?php echo esc_html($btn1_text); ?></a>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if( $has_btn2 ): ?>
                    <a href="<?php echo esc_url($btn2['url']); ?>" class="c-partner-hero__btn"<?php echo !empty($btn2['target']) ? ' target="' . esc_attr($btn2['target']) . '" rel="noopener noreferrer"' : ''; ?>><?php echo esc_html($btn2['title']); ?></a>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>
</section>
