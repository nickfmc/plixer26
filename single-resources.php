<?php get_header(); ?>

<div class="o-layout-row o-poly-bg o-poly-bg-fade u-dark">
  <main id="main-content" class="" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
     
        <header class="c-article-header c-blog-header">
          <div class="o-wrapper-wide">
              <div class="c-article-header-content">
                <div>
                  <div class="c-cat-list">
                    <?php
                    $terms = get_the_terms(get_the_ID(), 'resource-type');
                    $separator = ' :: ';
                    $output = '';
                    if (!empty($terms)) {
                        foreach($terms as $term) {
                            $output .= '<span>' . esc_html($term->name) . '</span>' . $separator;
                        }
                        echo trim($output, $separator);
                    }
                    ?>
                  </div>
                  <h1><?php the_title(); ?></h1>
                </div>
                            <!-- AddToAny BEGIN -->
                <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                <a class="a2a_button_x"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 16"><path fill="currentColor" d="M9.294 6.928L14.357 1h-1.2L8.762 6.147L5.25 1H1.2l5.31 7.784L1.2 15h1.2l4.642-5.436L10.751 15h4.05L9.294 6.928ZM7.651 8.852l-.538-.775L2.832 1.91h1.843l3.454 4.977l.538.775l4.491 6.47h-1.843l-3.664-5.28Z"/></svg></a>
                <a class="a2a_button_facebook"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="38.41" viewBox="0 0 320 512"><path fill="currentColor" d="m279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"/></svg></a>
                <a class="a2a_button_linkedin"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="27.43" viewBox="0 0 448 512"><path fill="currentColor" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2c-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3c94 0 111.28 61.9 111.28 142.3V448z"/></svg></a>
                </div>
                <script async src="https://static.addtoany.com/menu/page.js"></script>
                <!-- AddToAny END -->
              </div>
              <div class="c-header-img-clip">
                <?php the_post_thumbnail('large');?>
              </div>
          </div>
          
        </header>

    <section class="editor-content">

        <!-- /article-header -->
        <div class="c-post-content">
          <article <?php post_class(); ?> role="article">
            <?php the_content(); ?>
          </article>
          <?php endwhile; ?>
              
              <?php else : ?>
                <?php get_template_part( 'template-part/post/not-found' ); ?>
              <?php endif; ?>
          
              <div class="c-blog-sidebar">

              


<!-- Grab Related posts and show here -->
<?php
$orig_post = $post;
global $post;
$tags = wp_get_post_tags($post->ID);

$show_related = false;
if ($tags) {
    $tag_ids = array();
    foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
    $args = array(
        'tag__in' => $tag_ids,
        'post__not_in' => array($post->ID),
        'posts_per_page' => 3,
        'ignore_sticky_posts' => 1
    );
    
    $my_query = new WP_Query($args);
    
    if ($my_query->have_posts()) {
        $show_related = true;
        echo '<div class="related-posts"><h3>Related Resources</h3><div class="o-layout-row">';
        
        while ($my_query->have_posts()) {
            $my_query->the_post(); ?>
            <div class="c-related-card">
                <a href="<?php the_permalink(); ?>"></a>
                <?php the_post_thumbnail('medium'); ?>
                <div>
                    <div class="c-card__content">
                        <h4><?php the_title(); ?></h4>
                        <p class="c-card__content-excerpt"><?php echo gdt_excerpt(25); ?></p>
                    </div>
                </div>
            </div>
            <?php
        }
        
        echo '</div></div>';
    }
}
$post = $orig_post;
wp_reset_postdata();
?>
                <?php get_sidebar(); // sidebar ?>
              </div>
        </div>
      </section>
    
    
  </main>
</div>
<!-- /layout-row-->



<?php get_footer(); ?>
