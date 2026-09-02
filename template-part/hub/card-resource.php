<?php
/**
 * Resource Hub - image card (Case Studies)
 * Reuses the site-wide .c-resource-card component from _resources.scss
 *
 * @param bool   $args['show_badge'] show the resource-type badge
 * @param string $args['cta']        CTA label
 */

$args = ( isset( $args ) && is_array( $args ) ) ? $args : array();
$show_badge = ! empty( $args['show_badge'] );
$cta_label  = ! empty( $args['cta'] ) ? $args['cta'] : 'Learn More';
?>

<article <?php post_class( 'c-resource-card' ); ?> role="article" itemscope itemtype="https://schema.org/BlogPosting">

  <a href="<?php the_permalink(); ?>" class="c-resource-card__link" aria-label="<?php echo esc_attr( get_the_title() ); ?>"></a>

  <div class="c-resource-card__image">
    <?php the_post_thumbnail( 'large' ); ?>
    <div class="c-resource-card__overlay"></div>
  </div>

  <div class="c-resource-card__content">
    <?php
    if ( $show_badge ) {
      $terms = get_the_terms( get_the_ID(), 'resource-type' );
      if ( $terms && ! is_wp_error( $terms ) ) {
        $term = array_shift( $terms );
        echo '<span class="c-resource-badge">' . esc_html( $term->name ) . '</span>';
      }
    }
    ?>
    <h4><?php the_title(); ?></h4>
    <p class="c-resource-card__excerpt"><?php echo gdt_excerpt( 20 ); ?></p>
    <span class="c-resource-card__cta">
      <?php echo esc_html( $cta_label ); ?>
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 256 256" aria-hidden="true" focusable="false">
        <path fill="currentColor" d="m218.83 130.83l-72 72a4 4 0 0 1-5.66-5.66L206.34 132H40a4 4 0 0 1 0-8h166.34l-65.17-65.17a4 4 0 0 1 5.66-5.66l72 72a4 4 0 0 1 0 5.66Z"/>
      </svg>
    </span>
  </div>

</article>
