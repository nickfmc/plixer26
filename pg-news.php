<?php
/*
Template Name: News Main Page
*/
?>


<?php get_header(); ?>

<div class="o-layout-row o-poly-header-news">
  <div class="o-wrapper-wide"><h1>Plixer <span class="u-green">News</span></div></h1>
</div>

<div class="o-layout-row o-dark-wave-grad u-dark">

<main id="main-content" class="" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">
    <div class="editor-content  clearfix">



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
              <div class="c-post-grid c-post-grid--news">
                  <?php while ($news_query->have_posts()) : $news_query->the_post(); ?>
          
            <article <?php post_class('c-post-card'); ?> role="article" itemscope itemtype="https://schema.org/BlogPosting">
            <a href="<?php the_permalink()?>"></a>
              <?php the_post_thumbnail('large'); ?> 
                
                <div class="c-card__content">
                          <div>
                              <h4><?php the_title(); ?></h4>
                              <!-- the excerpt -->
                              <p class="c-card__content-excerpt"><?php echo gdt_excerpt(20); ?>...</p>
                          </div>
                          
                              
                        </div>
              
              <!-- /editor-content -->
            </article>
                   <?php endwhile; ?>
               </div>
           <?php endif; ?>
           
          <?php /* Display navigation to next/previous pages when applicable */ ?>
        
        <?php $news_query = null; $news_query = $temp; ?>
        <?php wp_reset_postdata(); ?>
     




      <div class="c-news-archived" style="padding-top: 70px;">
        <h4>News Archive</h4>
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
              <article <?php post_class('c-archived-new-item'); ?> role="article" itemscope itemtype="https://schema.org/BlogPosting">
              <a href="<?php the_permalink()?>"></a>
                <?php the_post_thumbnail('large'); ?>
        
                  <div class="">
                            <div>
                                <p><a href="<?php the_permalink()?>"><?php the_title(); ?></a></p>
                                <!-- the excerpt -->
                            </div>
                          </div>
        
                <!-- /editor-content -->
              </article>
              <!-- /post-intro -->
            <?php endwhile; endif; ?>
            </div>
            <?php /* Display navigation to next/previous pages when applicable */ ?>
        
          <?php $news_query = null; $news_query = $temp; ?>
          <?php wp_reset_postdata(); ?>
      </div>





        </main>



</div>

<?php get_footer(); ?>