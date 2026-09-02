<?php
/**
 * Resource Hub - Video card. Opens the video in a lightbox (see src/js/resource-hub.js).
 * Renders a static card when no video URL has been set on the Video.
 */

$video_url = function_exists( 'get_field' ) ? get_field( 'video_url' ) : '';
$embed_url = $video_url ? plixer_video_embed_url( $video_url ) : '';
$duration  = function_exists( 'get_field' ) ? get_field( 'video_duration' ) : '';
$title     = get_the_title();
?>

<article <?php post_class( 'c-hub-video' ); ?> role="article" itemscope itemtype="https://schema.org/VideoObject">

  <?php if ( $embed_url ) : ?>
    <button type="button" class="c-hub-video__trigger" data-video="<?php echo esc_url( $embed_url ); ?>" data-video-title="<?php echo esc_attr( $title ); ?>">
  <?php else : ?>
    <span class="c-hub-video__trigger c-hub-video__trigger--static">
  <?php endif; ?>

    <span class="c-hub-video__image">
      <?php
      if ( has_post_thumbnail() ) {
        the_post_thumbnail( 'large', array( 'itemprop' => 'thumbnailUrl' ) );
      }
      ?>
      <span class="c-hub-video__play" aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 24 24" fill="currentColor" focusable="false">
          <path d="M8 5.5v13l11-6.5Z"/>
        </svg>
      </span>
      <?php if ( $duration ) : ?>
        <span class="c-hub-video__duration"><?php echo esc_html( $duration ); ?></span>
      <?php endif; ?>
    </span>

    <span class="c-hub-video__title" itemprop="name"><?php echo esc_html( $title ); ?></span>

  <?php if ( $embed_url ) : ?>
    </button>
  <?php else : ?>
    </span>
  <?php endif; ?>

</article>
