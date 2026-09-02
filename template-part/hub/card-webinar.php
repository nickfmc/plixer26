<?php
/**
 * Resource Hub - Webinar row (title + excerpt + button)
 */
?>

<article <?php post_class( 'c-hub-webinar' ); ?> role="article" itemscope itemtype="https://schema.org/CreativeWork">

  <div class="c-hub-webinar__content">
    <h3 class="c-hub-webinar__title" itemprop="headline"><?php the_title(); ?></h3>
    <p class="c-hub-webinar__excerpt"><?php echo gdt_excerpt( 18 ); ?></p>
  </div>

  <a class="c-hub-webinar__button" href="<?php the_permalink(); ?>">
    See More<span class="u-visually-hidden">: <?php echo esc_html( get_the_title() ); ?></span>
  </a>

</article>
