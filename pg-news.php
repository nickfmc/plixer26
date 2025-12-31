<?php
/*
Template Name: News Main Page
*/
?>


<?php get_header(); ?>

<div class="o-layout-row c-news-hero" style="background-color: #e5f0f4;">
  <div class="o-wrapper-wide">
    <div class="c-news-hero__content">
      <div class="c-news-hero__text">
        <div class="c-news-hero__label">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
          </svg>
          <span>Plixer News</span>
        </div>
        <h1>Stay Up to Date with <br class="hide-mobile"/>Plixer <span class="u-green">Announcements</span></h1>
        <p class="c-news-hero__tagline">Get the latest updates on product releases, company news, and industry insights</p>
      </div>
      <div class="c-news-hero__graphic">
        <div class="c-news-hero__graphic-bg"></div>
      </div>
    </div>
  </div>
</div>

<div class="o-layout-row u-light c-news-bg">

<main id="main-content" class="" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">
    <div class="editor-content clearfix">

          <?php
            $temp = $wp_query;
      $news_query = new WP_Query(
              array(
                'posts_per_page' => -1,
                'post_type' => 'news_type',
                'paged' => $paged,
                'date_query' => array(
                  array(
                      'after' => '1 year ago',
                  ),
              ),
              )
            );
          ?>
          <?php if ($news_query->have_posts()) : ?>
              <div class="c-news-grid">
                  <?php 
                  $post_count = 0;
                  while ($news_query->have_posts()) : $news_query->the_post(); 
                  $post_count++;
                  $is_featured = ($post_count === 1);
                  ?>
          
            <article <?php post_class($is_featured ? 'c-news-item c-news-item--featured' : 'c-news-item'); ?> role="article" itemscope itemtype="https://schema.org/NewsArticle">
              <a href="<?php the_permalink()?>" class="c-news-item__link"></a>
                
                <div class="c-news-item__content">
                  <div class="c-news-item__meta">
                    <time class="c-news-item__date" datetime="<?php echo get_the_date('c'); ?>" itemprop="datePublished">
                      <?php echo get_the_date('M j, Y'); ?>
                    </time>
                    <span class="c-news-item__badge">News</span>
                  </div>
                  
                  <h2 class="c-news-item__title"><?php the_title(); ?></h2>
                  
                  <p class="c-news-item__excerpt"><?php echo gdt_excerpt($is_featured ? 30 : 20); ?></p>
                  
                  <span class="c-news-item__read-more">Read more →</span>
                </div>
              
            </article>
                   <?php endwhile; ?>
               </div>
           <?php endif; ?>
           
          <?php $news_query = null; $news_query = $temp; ?>
          <?php wp_reset_postdata(); ?>
     




      <div class="c-news-archive">
        <div class="c-news-archive__header">
          <h3>News Archive</h3>
          <p>Previous announcements and updates</p>
        </div>
        
        <div class="c-news-archive__list">
        <?php
              $temp = $wp_query;
        $news_query = new WP_Query(
                array(
                  'posts_per_page' => -1,
                  'post_type' => 'news_type',
                  'paged' => $paged,
                  'date_query' => array(
                    array(
                        'before' => '1 year ago',
                    ),
                ),
                )
              );
            ?>
            <?php if ($news_query->have_posts()) : while ($news_query->have_posts()) : $news_query->the_post(); ?>
              <article <?php post_class('c-news-archive__item'); ?> role="article" itemscope itemtype="https://schema.org/NewsArticle">
                <a href="<?php the_permalink()?>" class="c-news-archive__item-link">
                  <time class="c-news-archive__date" datetime="<?php echo get_the_date('c'); ?>">
                    <?php echo get_the_date('M j, Y'); ?>
                  </time>
                  <h4 class="c-news-archive__title"><?php the_title(); ?></h4>
                  <span class="c-news-archive__arrow">→</span>
                </a>
              </article>
            <?php endwhile; endif; ?>
            </div>
        
          <?php $news_query = null; $news_query = $temp; ?>
          <?php wp_reset_postdata(); ?>
      </div>

        </main>

</div>

<?php get_footer(); ?>