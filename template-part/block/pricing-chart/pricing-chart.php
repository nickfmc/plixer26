<?php

/**
 * Pricing Comparison Chart Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'pricing-chart-' . $block['id'];
if ( ! empty( $block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'c-pricing-chart';
if ( ! empty( $block['className'] ) ) {
    $className .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $className .= ' align' . $block['align'];
}
if ( $is_preview ) {
    $className .= ' is-admin';
}

// Get field values.
$col1_name          = get_field( 'pc_col1_name' ) ?: 'Product 1';
$col2_name          = get_field( 'pc_col2_name' ) ?: 'Product 2';
$col2_recommended   = get_field( 'pc_col2_recommended' );
$col1_logo          = get_field( 'pc_col1_logo' );
$col2_logo          = get_field( 'pc_col2_logo' );
$col1_footer_type   = get_field( 'pc_col1_footer_type' ) ?: 'button';
$col1_button_text   = get_field( 'pc_col1_button_text' ) ?: 'Purchase';
$col1_button_url    = get_field( 'pc_col1_button_url' );
$col1_price_amount  = get_field( 'pc_col1_price_amount' );
$col1_price_subtext = get_field( 'pc_col1_price_subtext' );
$col2_footer_type   = get_field( 'pc_col2_footer_type' ) ?: 'button';
$col2_button_text   = get_field( 'pc_col2_button_text' ) ?: 'Purchase';
$col2_button_url    = get_field( 'pc_col2_button_url' );
$col2_price_amount  = get_field( 'pc_col2_price_amount' );
$col2_price_subtext = get_field( 'pc_col2_price_subtext' );

/**
 * Render a cell value.
 * "check" → blue checkmark icon
 * ""      → em dash
 * other   → escaped text
 */
if ( ! function_exists( 'pc_render_value' ) ) {
    function pc_render_value( $value ) {
        $trimmed = trim( (string) $value );
        if ( $trimmed === 'check' ) {
            return '<span class="c-pricing-chart__check" aria-label="Included">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                    <circle cx="12" cy="12" r="11"/>
                    <polyline points="7,12.5 10.5,16 17,9" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" fill="none" stroke="white"/>
                </svg>
            </span>';
        }
        if ( $trimmed === '' ) {
            return '<span class="c-pricing-chart__dash" aria-label="Not included">&mdash;</span>';
        }
        return '<span class="c-pricing-chart__value">' . esc_html( $trimmed ) . '</span>';
    }
}

?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $className ); ?>">
    <div class="c-pricing-chart__inner">

        <?php if ( $col2_recommended ) : ?>
            <div class="c-pricing-chart__badge">RECOMMENDED</div>
        <?php endif; ?>

        <!-- Header row -->
        <div class="c-pricing-chart__header">
            <div class="c-pricing-chart__header-label">PURCHASING OPTIONS</div>

            <div class="c-pricing-chart__header-col c-pricing-chart__header-col--1">
                <?php if ( $col1_logo ) : ?>
                    <img src="<?php echo esc_url( $col1_logo['url'] ); ?>"
                         alt="<?php echo esc_attr( $col1_logo['alt'] ?: $col1_name ); ?>" />
                <?php else : ?>
                    <span class="c-pricing-chart__col-name"><?php echo esc_html( $col1_name ); ?></span>
                <?php endif; ?>
            </div>

            <div class="c-pricing-chart__header-col c-pricing-chart__header-col--2">
                <?php if ( $col2_logo ) : ?>
                    <img src="<?php echo esc_url( $col2_logo['url'] ); ?>"
                         alt="<?php echo esc_attr( $col2_logo['alt'] ?: $col2_name ); ?>" />
                <?php else : ?>
                    <span class="c-pricing-chart__col-name"><?php echo esc_html( $col2_name ); ?></span>
                <?php endif; ?>
            </div>
        </div><!-- /header row -->

        <!-- Body sections -->
        <?php if ( have_rows( 'pc_sections' ) ) : ?>
        <div class="c-pricing-chart__body">
            <?php while ( have_rows( 'pc_sections' ) ) : the_row();
                $section_heading = get_sub_field( 'section_heading' );
            ?>

                <?php if ( $section_heading ) : ?>
                <div class="c-pricing-chart__section-row">
                    <div class="c-pricing-chart__section-title"><?php echo esc_html( $section_heading ); ?></div>
                    <div class="c-pricing-chart__section-col c-pricing-chart__section-col--1"></div>
                    <div class="c-pricing-chart__section-col c-pricing-chart__section-col--2"></div>
                </div>
                <?php endif; ?>

                <?php if ( have_rows( 'rows' ) ) :
                    while ( have_rows( 'rows' ) ) : the_row();
                        $label = get_sub_field( 'row_label' );
                        $val1  = get_sub_field( 'col1_value' );
                        $val2  = get_sub_field( 'col2_value' );
                ?>
                <div class="c-pricing-chart__row">
                    <div class="c-pricing-chart__row-label"><?php echo esc_html( $label ); ?></div>
                    <div class="c-pricing-chart__row-col c-pricing-chart__row-col--1"><?php echo pc_render_value( $val1 ); ?></div>
                    <div class="c-pricing-chart__row-col c-pricing-chart__row-col--2"><?php echo pc_render_value( $val2 ); ?></div>
                </div>
                <?php   endwhile;
                endif; ?>

            <?php endwhile; ?>
        </div><!-- /body -->

        <?php elseif ( $is_preview ) : ?>
            <p class="c-pricing-chart__empty-notice">Add sections and rows in the block settings panel.</p>
        <?php endif; ?>

        <!-- Footer row -->
        <div class="c-pricing-chart__footer">
            <div class="c-pricing-chart__footer-empty"></div>
            <div class="c-pricing-chart__footer-col c-pricing-chart__footer-col--1">
                <?php if ( $col1_footer_type === 'price_text' ) : ?>
                    <?php if ( $col1_price_amount || $col1_price_subtext ) : ?>
                        <div class="c-pricing-chart__price">
                            <?php if ( $col1_price_amount ) : ?>
                                <span class="c-pricing-chart__price-amount"><?php echo esc_html( $col1_price_amount ); ?></span>
                            <?php endif; ?>
                            <?php if ( $col1_price_subtext ) : ?>
                                <span class="c-pricing-chart__price-subtext"><?php echo wp_kses( $col1_price_subtext, [ 'br' => [] ] ); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php elseif ( $col1_button_url ) : ?>
                    <div class="c-btn-primary c-btn--green c-pricing-chart__btn"><a href="<?php echo esc_url( $col1_button_url ); ?>">
                        <?php echo esc_html( $col1_button_text ); ?>
                    </a></div>
                <?php endif; ?>
            </div>
            <div class="c-pricing-chart__footer-col c-pricing-chart__footer-col--2">
                <?php if ( $col2_footer_type === 'price_text' ) : ?>
                    <?php if ( $col2_price_amount || $col2_price_subtext ) : ?>
                        <div class="c-pricing-chart__price">
                            <?php if ( $col2_price_amount ) : ?>
                                <span class="c-pricing-chart__price-amount"><?php echo esc_html( $col2_price_amount ); ?></span>
                            <?php endif; ?>
                            <?php if ( $col2_price_subtext ) : ?>
                                <span class="c-pricing-chart__price-subtext"><?php echo wp_kses( $col2_price_subtext, [ 'br' => [] ] ); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php elseif ( $col2_button_url ) : ?>
                    <div class="c-btn-primary c-btn--green c-pricing-chart__btn"><a href="<?php echo esc_url( $col2_button_url ); ?>">
                        <?php echo esc_html( $col2_button_text ); ?>
                    </a></div>
                <?php endif; ?>
            </div>
        </div><!-- /footer -->

    </div><!-- /inner -->
</div>
