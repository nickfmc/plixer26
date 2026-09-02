<?php
/**
 * Resource Hub - News & PR list item
 */
?>

<article <?php post_class( 'c-hub-news' ); ?> role="article" itemscope itemtype="https://schema.org/NewsArticle">

  <a href="<?php the_permalink(); ?>" class="c-hub-news__link" aria-label="<?php echo esc_attr( get_the_title() ); ?>"></a>

  <time class="c-hub-news__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished">
    <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
  </time>

  <h3 class="c-hub-news__title" itemprop="headline"><?php the_title(); ?></h3>

  <p class="c-hub-news__excerpt"><?php echo gdt_excerpt( 18 ); ?></p>

  <span class="c-hub-news__cta">Read More</span>

</article>
