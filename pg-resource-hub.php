<?php
/*
Template Name: Resource Hub Page
*/
?>

<?php get_header(); ?>

<?php
/* ==========================================================================
   RESOURCE HUB CONFIG - everything you'll want to tweak lives here
   ========================================================================== */

// "See more" button destinations. TODO: point these at the real archive pages.
$hub_links = array(
  'thought-leadership' => '#',
  'case-studies'       => '#',
  'news-pr'            => '#',
  'webinars'           => '#',
  'whitepapers'        => '#',
  'datasheets'         => '#',
);

// How many items each section pulls.
$hub_counts = array(
  'thought-leadership' => 3, // first one renders as the wide featured card
  'case-studies'       => 4,
  'news-pr'            => 4,
  'webinars'           => 3,
  'videos'             => -1, // all of them - the section is a coverflow carousel
  'whitepapers'        => 4,
  'datasheets'         => 4,
);

// Leave empty for the latest blog posts. Set a category slug to narrow it later.
$hub_tl_category = '';

// resource-type term slugs.
$hub_terms = array(
  'case-studies' => 'case-study',
  'webinars'     => 'webinars',
  'whitepapers'  => 'whitepaper',
  'datasheets'   => 'data-sheet',
);

// Anchor nav. 'id' must match the section id it scrolls to.
$hub_nav = array(
  array( 'id' => 'thought-leadership',      'icon' => 'article',    'label' => array( 'Thought', 'Leadership' ) ),
  array( 'id' => 'case-studies',            'icon' => 'case-study', 'label' => array( 'Case', 'Studies' ) ),
  array( 'id' => 'news-pr',                 'icon' => 'news',       'label' => array( 'News & PR' ) ),
  array( 'id' => 'webinars',                'icon' => 'webinar',    'label' => array( 'Webinars' ) ),
  array( 'id' => 'videos',                  'icon' => 'video',      'label' => array( 'Videos' ) ),
  array( 'id' => 'datasheets-whitepapers',  'icon' => 'doc',        'label' => array( 'Datasheets &', 'Whitepapers' ) ),
);
?>

<main id="main-content" class="c-hub" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">

  <?php /* HERO - built with the page builder */ ?>
  <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <section class="editor-content clearfix">
      <?php the_content(); ?>
    </section>
  <?php endwhile; endif; ?>


  <?php /* ==========================================================
          ANCHOR NAV - sticky + scrollspy (src/js/resource-hub.js)
          ========================================================== */ ?>
  <div class="c-hub-nav-wrap">
    <nav class="c-hub-nav" aria-label="Resource sections">
      <div class="o-wrapper-wide">
        <ul class="c-hub-nav__list">
          <?php foreach ( $hub_nav as $item ) : ?>
            <li class="c-hub-nav__item">
              <a class="c-hub-nav__link" href="#<?php echo esc_attr( $item['id'] ); ?>" data-hub-target="<?php echo esc_attr( $item['id'] ); ?>">
                <?php echo plixer_hub_icon( $item['icon'] ); // phpcs:ignore - static inline svg ?>
                <span class="c-hub-nav__label">
                  <?php foreach ( $item['label'] as $line ) : ?>
                    <span><?php echo esc_html( $line ); ?></span>
                  <?php endforeach; ?>
                </span>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </nav>
  </div>


  <?php /* ==========================================================
          1. THOUGHT LEADERSHIP - latest blog posts
          ========================================================== */ ?>
  <?php
  $tl_args = plixer_hub_query_args( 'post', $hub_counts['thought-leadership'] );
  if ( $hub_tl_category ) {
    $tl_args['category_name'] = $hub_tl_category;
  }
  $tl_query = new WP_Query( $tl_args );
  ?>
  <?php if ( $tl_query->have_posts() ) : ?>
    <section id="thought-leadership" class="c-hub-section c-hub-section--thought-leadership">
      <div class="o-wrapper-wide">

        <div class="c-hub-section__header">
          <h2 class="c-hub-section__title">Thought Leadership</h2>
          <div class="c-btn-primary c-hub-section__more">
            <a href="<?php echo esc_url( $hub_links['thought-leadership'] ); ?>">See More Thought Leadership Articles</a>
          </div>
        </div>

        <div class="c-hub-article-grid">
          <?php
          $tl_counter = 0;
          while ( $tl_query->have_posts() ) :
            $tl_query->the_post();
            $tl_counter++;
            get_template_part( 'template-part/hub/card-article', null, array( 'featured' => ( 1 === $tl_counter ) ) );
          endwhile;
          ?>
        </div>

      </div>
    </section>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>


  <?php /* ==========================================================
          2. CASE STUDIES
          ========================================================== */ ?>
  <?php $cs_query = new WP_Query( plixer_hub_query_args( 'resources', $hub_counts['case-studies'], $hub_terms['case-studies'] ) ); ?>
  <?php if ( $cs_query->have_posts() ) : ?>
    <section id="case-studies" class="c-hub-section c-hub-section--case-studies">
      <div class="o-wrapper-wide">

        <div class="c-hub-section__header">
          <h2 class="c-hub-section__title">Case Studies</h2>
          <div class="c-btn-primary c-hub-section__more">
            <a href="<?php echo esc_url( $hub_links['case-studies'] ); ?>">See More Case Studies</a>
          </div>
        </div>

        <div class="c-resources-grid">
          <?php
          while ( $cs_query->have_posts() ) :
            $cs_query->the_post();
            get_template_part( 'template-part/hub/card-resource', null, array( 'cta' => 'Learn More' ) );
          endwhile;
          ?>
        </div>

      </div>
    </section>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>


  <?php /* ==========================================================
          3. NEWS & PR  +  WEBINARS - one band, two columns
          ========================================================== */ ?>
  <?php
  $news_query    = new WP_Query( plixer_hub_query_args( 'news_type', $hub_counts['news-pr'] ) );
  $webinar_query = new WP_Query( plixer_hub_query_args( 'resources', $hub_counts['webinars'], $hub_terms['webinars'] ) );
  ?>
  <?php if ( $news_query->have_posts() || $webinar_query->have_posts() ) : ?>
    <section class="c-hub-section c-hub-section--news">
      <div class="o-wrapper-wide">
        <div class="c-hub-split">

          <?php if ( $news_query->have_posts() ) : ?>
            <div id="news-pr" class="c-hub-split__col c-hub-split__col--news">
              <div class="c-hub-section__header">
                <h2 class="c-hub-section__title">News &amp; PR</h2>
                <div class="c-btn-primary c-hub-section__more">
                  <a href="<?php echo esc_url( $hub_links['news-pr'] ); ?>">See More News &amp; PR</a>
                </div>
              </div>
              <div class="c-hub-news-list">
                <?php
                while ( $news_query->have_posts() ) :
                  $news_query->the_post();
                  get_template_part( 'template-part/hub/card-news' );
                endwhile;
                ?>
              </div>
            </div>
          <?php endif; ?>

          <?php if ( $webinar_query->have_posts() ) : ?>
            <div id="webinars" class="c-hub-split__col c-hub-split__col--webinars">
              <div class="c-hub-section__header">
                <h2 class="c-hub-section__title">Webinars</h2>
                <div class="c-btn-primary c-hub-section__more">
                  <a href="<?php echo esc_url( $hub_links['webinars'] ); ?>">See More Webinars</a>
                </div>
              </div>
              <div class="c-hub-webinar-list">
                <?php
                while ( $webinar_query->have_posts() ) :
                  $webinar_query->the_post();
                  get_template_part( 'template-part/hub/card-webinar' );
                endwhile;
                ?>
              </div>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </section>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>


  <?php /* ==========================================================
          4. VIDEOS
          ========================================================== */ ?>
  <?php $video_query = new WP_Query( plixer_hub_query_args( 'video_type', $hub_counts['videos'] ) ); ?>
  <?php if ( $video_query->have_posts() ) : ?>
    <section id="videos" class="c-hub-section c-hub-section--videos">
      <div class="o-wrapper-wide">

        <div class="c-hub-section__header c-hub-section__header--stacked">
          <h2 class="c-hub-section__title">Videos</h2>
        </div>

        <?php /* every video, as a coverflow carousel - falls back to a plain
                 scrolling row until the JS upgrades it (src/js/resource-hub.js) */ ?>
        <div class="c-hub-coverflow" data-coverflow>

          <button type="button" class="c-hub-coverflow__nav c-hub-coverflow__nav--prev" data-coverflow-prev aria-label="Previous video">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
              <path d="m15 18-6-6 6-6"/>
            </svg>
          </button>

          <div class="c-hub-coverflow__stage" data-coverflow-stage>
            <?php
            while ( $video_query->have_posts() ) :
              $video_query->the_post();
              get_template_part( 'template-part/hub/card-video' );
            endwhile;
            ?>
          </div>

          <button type="button" class="c-hub-coverflow__nav c-hub-coverflow__nav--next" data-coverflow-next aria-label="Next video">
            <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">
              <path d="m9 18 6-6-6-6"/>
            </svg>
          </button>

          <p class="c-hub-coverflow__caption" data-coverflow-caption aria-live="polite"></p>

        </div>

      </div>
    </section>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>


  <?php /* ==========================================================
          5. WHITEPAPERS + DATASHEETS - one band, two columns
          ========================================================== */ ?>
  <?php
  $wp_query_papers = new WP_Query( plixer_hub_query_args( 'resources', $hub_counts['whitepapers'], $hub_terms['whitepapers'] ) );
  $ds_query        = new WP_Query( plixer_hub_query_args( 'resources', $hub_counts['datasheets'], $hub_terms['datasheets'] ) );
  ?>
  <?php if ( $wp_query_papers->have_posts() || $ds_query->have_posts() ) : ?>
    <section id="datasheets-whitepapers" class="c-hub-section c-hub-section--docs">
      <div class="o-wrapper-wide">
        <div class="c-hub-split">

          <?php if ( $wp_query_papers->have_posts() ) : ?>
            <div class="c-hub-split__col">
              <div class="c-hub-section__header c-hub-section__header--stacked">
                <h2 class="c-hub-section__title">Whitepapers</h2>
              </div>
              <div class="c-hub-doc-grid">
                <?php
                while ( $wp_query_papers->have_posts() ) :
                  $wp_query_papers->the_post();
                  get_template_part( 'template-part/hub/card-doc', null, array( 'variant' => 'whitepaper' ) );
                endwhile;
                ?>
              </div>
              <div class="c-btn-primary c-hub-section__more c-hub-section__more--center">
                <a href="<?php echo esc_url( $hub_links['whitepapers'] ); ?>">See More Whitepapers</a>
              </div>
            </div>
          <?php endif; ?>

          <?php if ( $ds_query->have_posts() ) : ?>
            <div class="c-hub-split__col">
              <div class="c-hub-section__header c-hub-section__header--stacked">
                <h2 class="c-hub-section__title">Datasheets</h2>
              </div>
              <div class="c-hub-doc-grid">
                <?php
                while ( $ds_query->have_posts() ) :
                  $ds_query->the_post();
                  get_template_part( 'template-part/hub/card-doc', null, array( 'variant' => 'datasheet' ) );
                endwhile;
                ?>
              </div>
              <div class="c-btn-primary c-hub-section__more c-hub-section__more--center">
                <a href="<?php echo esc_url( $hub_links['datasheets'] ); ?>">See More Datasheets</a>
              </div>
            </div>
          <?php endif; ?>

        </div>
      </div>
    </section>
  <?php endif; ?>
  <?php wp_reset_postdata(); ?>


  <?php /* VIDEO LIGHTBOX - filled in by src/js/resource-hub.js */ ?>
  <div class="c-hub-modal" id="c-hub-modal" role="dialog" aria-modal="true" aria-hidden="true" aria-label="Video player" hidden>
    <div class="c-hub-modal__backdrop" data-hub-modal-close></div>
    <div class="c-hub-modal__inner">
      <button type="button" class="c-hub-modal__close" data-hub-modal-close aria-label="Close video">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true" focusable="false">
          <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
        </svg>
      </button>
      <h2 class="c-hub-modal__title" id="c-hub-modal-title"></h2>
      <div class="c-hub-modal__frame">
        <iframe class="c-hub-modal__iframe" src="" title="Video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
      </div>
    </div>
  </div>

</main>

<?php get_template_part( 'template-part/lowercta' ); ?>

<?php get_footer(); ?>
