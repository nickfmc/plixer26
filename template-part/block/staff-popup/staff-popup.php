<?php

/**
 * Staff Popup Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'staff-popup-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'c-staff-card';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}

// Get field values
$image = get_field('staff_image');
$name = get_field('staff_name');
$title = get_field('staff_title');
$bio = get_field('staff_bio');
$external_link = get_field('staff_external_link');

// Generate unique modal ID
$modal_id = 'staff-modal-' . $block['id'];

// Determine if this is an external link or popup
$is_external = !empty($external_link);

// Add data attributes and classes based on type
if( $is_external ) {
    $className .= ' c-staff-card--external';
}

?>
<div class="c-staff-card-wrapper">
    <?php if( $is_external ): ?>
        <a href="<?php echo esc_url($external_link); ?>" target="_blank" rel="noopener noreferrer" id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">
    <?php else: ?>
        <div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>" data-modal="<?php echo esc_attr($modal_id); ?>">
    <?php endif; ?>
        
        <?php if( $image ): ?>
            <div class="c-staff-card__image">
                <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ? $image['alt'] : $name); ?>" />
            </div>
        <?php endif; ?>
        
        <div class="c-staff-card__content">
            <?php if( $name ): ?>
                <h3 class="c-staff-card__name"><?php echo esc_html($name); ?></h3>
            <?php endif; ?>
            
            <?php if( $title ): ?>
                <p class="c-staff-card__title"><?php echo esc_html($title); ?></p>
            <?php endif; ?>
            
            <?php if( $is_external ): ?>
                <span class="c-staff-card__cta text-button">
                    View Profile
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="display: inline-block; margin-left: 4px; vertical-align: middle;">
                        <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                        <polyline points="15 3 21 3 21 9"></polyline>
                        <line x1="10" y1="14" x2="21" y2="3"></line>
                    </svg>
                </span>
            <?php else: ?>
                <button class="c-staff-card__cta text-button" aria-label="View <?php echo esc_attr($name); ?>'s bio">
                    View Bio
                </button>
            <?php endif; ?>
        </div>
        
    <?php if( $is_external ): ?>
        </a>
    <?php else: ?>
        </div>
    <?php endif; ?>
    
    <?php if( !$is_external && $bio ): ?>
    <!-- Modal Popup -->
    <div id="<?php echo esc_attr($modal_id); ?>" class="c-staff-modal" aria-hidden="true">
        <div class="c-staff-modal__overlay"></div>
        <div class="c-staff-modal__content">
            <button class="c-staff-modal__close" aria-label="Close modal">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
            
            <div class="c-staff-modal__inner">
                <div class="c-staff-modal__left">
                    <?php if( $image ): ?>
                        <div class="c-staff-modal__image">
                            <img src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt'] ? $image['alt'] : $name); ?>" />
                        </div>
                    <?php endif; ?>
                    
                    <div class="c-staff-modal__info">
                        <?php if( $name ): ?>
                            <h2 class="c-staff-modal__name"><?php echo esc_html($name); ?></h2>
                        <?php endif; ?>
                        
                        <?php if( $title ): ?>
                            <p class="c-staff-modal__title"><?php echo esc_html($title); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="c-staff-modal__right">
                    <?php if( $bio ): ?>
                        <div class="c-staff-modal__bio">
                            <?php echo wpautop($bio); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
