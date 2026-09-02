<?php
/**
 * Resource Hub - Thought Leadership card
 *
 * @param bool $args['featured'] renders the wide, image-right variant
 */

$args = ( isset( $args ) && is_array( $args ) ) ? $args : array();
$featured = ! empty( $args['featured'] );
$classes  = 'c-hub-article' . ( $featured ? ' c-hub-article--featured' : '' );

// author card data - same ACF fields as single.php
$article_author = function_exists( 'get_field' ) ? get_field( 'article_author' ) : false;
$author_id      = is_object( $article_author ) ? $article_author->ID : $article_author;
$author_name    = $author_id ? get_the_title( $author_id ) : '';
$author_title   = $author_id ? get_field( 'job_title', $author_id ) : '';
$author_image   = $author_id ? get_field( 'headshot', $author_id ) : '';
?>

<article <?php post_class( $classes ); ?> role="article" itemscope itemtype="https://schema.org/BlogPosting">

  <a href="<?php the_permalink(); ?>" class="c-hub-article__link" aria-label="<?php echo esc_attr( get_the_title() ); ?>"></a>

  <?php if ( has_post_thumbnail() ) : ?>
    <div class="c-hub-article__image">
      <?php the_post_thumbnail( $featured ? 'large' : 'medium_large', array( 'itemprop' => 'image' ) ); ?>
    </div>
  <?php endif; ?>

  <div class="c-hub-article__content">

    <h3 class="c-hub-article__title" itemprop="headline"><?php the_title(); ?></h3>

    <time class="c-hub-article__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished">
      <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?>
    </time>

    <p class="c-hub-article__excerpt"><?php echo gdt_excerpt( $featured ? 34 : 22 ); ?></p>

    <span class="c-hub-article__cta">
      Learn More
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 256 256" aria-hidden="true" focusable="false">
        <path fill="currentColor" d="m218.83 130.83l-72 72a4 4 0 0 1-5.66-5.66L206.34 132H40a4 4 0 0 1 0-8h166.34l-65.17-65.17a4 4 0 0 1 5.66-5.66l72 72a4 4 0 0 1 0 5.66Z"/>
      </svg>
    </span>

    <?php if ( $author_name ) : ?>
      <div class="c-hub-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
        <?php if ( $author_image ) : ?>
          <div class="c-hub-author__image">
            <?php echo wp_get_attachment_image( $author_image, 'thumbnail', false, array( 'itemprop' => 'image', 'alt' => esc_attr( $author_name ) ) ); ?>
          </div>
        <?php endif; ?>
        <div class="c-hub-author__info">
          <span class="c-hub-author__name" itemprop="name"><?php echo esc_html( $author_name ); ?></span>
          <?php if ( $author_title ) : ?>
            <span class="c-hub-author__title" itemprop="jobTitle"><?php echo esc_html( $author_title ); ?></span>
          <?php endif; ?>
        </div>
      </div>
    <?php endif; ?>

  </div>

</article>
