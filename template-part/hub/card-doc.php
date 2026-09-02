<?php
/**
 * Resource Hub - text card with a coloured top rule (Whitepapers / Datasheets)
 *
 * @param string $args['variant'] 'whitepaper' (blue rule) or 'datasheet' (orange rule)
 */

$args = ( isset( $args ) && is_array( $args ) ) ? $args : array();
$variant = ! empty( $args['variant'] ) ? $args['variant'] : 'whitepaper';
?>

<article <?php post_class( 'c-hub-doc c-hub-doc--' . sanitize_html_class( $variant ) ); ?> role="article" itemscope itemtype="https://schema.org/CreativeWork">

  <a href="<?php the_permalink(); ?>" class="c-hub-doc__link" aria-label="<?php echo esc_attr( get_the_title() ); ?>"></a>

  <h4 class="c-hub-doc__title" itemprop="headline"><?php the_title(); ?></h4>

  <p class="c-hub-doc__excerpt"><?php echo gdt_excerpt( 20 ); ?></p>

  <span class="c-hub-doc__cta">Read More</span>

</article>
