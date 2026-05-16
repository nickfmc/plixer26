<?php get_header(); ?>

<div class="o-layout-row o-poly-bg o-poly-bg-fade u-dark">
  <main class="" id="main-content" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
     
        <header class="c-article-header c-blog-header">
          <div class="o-wrapper-wide">
              <div class="c-article-header-content">
                <div>
                  <div class="c-cat-list">
                    <span>Blog</span>
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
        <?php 
        // Check if TOC is enabled (needs to be outside article for sidebar access)
        $enable_toc = get_field('enable_toc');
        $toc_data = null;
        
        if ($enable_toc) {
            // Get TOC data
            $toc_data = get_table_of_contents(get_the_content(), get_the_ID());
        }
        ?>
        
        <div class="c-post-content <?php echo ($enable_toc && $toc_data && isset($toc_data['has_toc']) && $toc_data['has_toc']) ? 'has-toc-sidebar' : 'full-width'; ?>">
          <article <?php post_class(); ?> role="article">
            <?php 
            if ($enable_toc && $toc_data) {
                // Output processed content with anchors
                echo $toc_data['content'];
            } else {
                // Regular content without TOC
                the_content();
            }
            ?>

            <?php
        // Check if the article_author field is set and not empty
        $article_author = get_field('article_author');
        
        // Fallback: check if old field name still has data
        if (!$article_author) {
            $article_author = get_post_meta(get_the_ID(), 'post_author', true);
            
            // If we found old data, migrate it to the new field name
            if ($article_author) {
                update_field('article_author', $article_author, get_the_ID());
            }
        }
        
        if ($article_author) {
            // Handle both object and ID return formats
            $author_id = is_object($article_author) ? $article_author->ID : $article_author;
            
            // Get author details
            $author_name = get_the_title($author_id);
            $author_bio = get_field('bio', $author_id);
            $author_job_title = get_field('job_title', $author_id);
            $author_image = get_field('headshot', $author_id);
            $author_linkedin = get_field('linkedin_url', $author_id);
            
            // Output the author card with schema
            if ($author_name || $author_bio) {
                ?>
                <div class="c-author-card" itemscope itemtype="https://schema.org/Person">
                    
                    <div class="c-author-card__content">
                        <?php if($author_image): ?>
                            <div class="c-author-card__image">
                                <?php echo wp_get_attachment_image($author_image, 'medium', false, array('itemprop' => 'image')); ?>
                            </div>
                        <?php endif; ?>
                        
                        <div class="c-author-card__info">
                            <?php if ($author_name): ?>
                                <h3 class="c-author-card__name" itemprop="name"><?php echo esc_html($author_name); ?></h3>
                            <?php endif; ?>
                            
                            <?php if ($author_job_title): ?>
                                <p class="c-author-card__title" itemprop="jobTitle"><?php echo esc_html($author_job_title); ?></p>
                            <?php endif; ?>
                            
                            <?php if ($author_bio): ?>
                                <div class="c-author-card__bio" itemprop="description">
                                    <?php echo wp_kses_post($author_bio); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if ($author_linkedin): ?>
                                <a href="<?php echo esc_url($author_linkedin); ?>" 
                                   class="c-author-card__linkedin" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   itemprop="url">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                                        <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                                    </svg>
                                    Connect on LinkedIn
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
        
          </article>
          
              <?php if ($enable_toc && $toc_data && isset($toc_data['has_toc']) && $toc_data['has_toc']) : ?>
              <div class="c-blog-sidebar">
                <?php
                    global $table_of_contents;
                    echo $table_of_contents->get_toc_sidebar_html();
                ?>
                <?php get_sidebar(); // sidebar ?>
              </div>
              <?php endif; ?>
          
        </div><!-- /c-post-content -->
        
        <?php endwhile; ?>
              
        <?php else : ?>
          <?php get_template_part( 'template-part/post/not-found' ); ?>
        <?php endif; ?>

<!-- Grab Related post overrides and show here -->
<?php
$related_posts = get_field('related_content_overide');
$related_count = $related_posts ? count($related_posts) : 0;
$max_posts = 3;
$remaining_posts = $max_posts - $related_count;

// Get posts by category if no tags are present
$show_related = false;
if ($related_posts || $remaining_posts > 0) {
    $show_related = true;
    echo '<div class="related-posts"><h3>Related Posts</h3><div class="o-layout-row">';
}

// Display manual related posts
if ($related_posts) {
    foreach ($related_posts as $post) {
        setup_postdata($post); ?>
        <div class="c-related-card">
            <a href="<?php the_permalink(); ?>"></a>
            <?php the_post_thumbnail('medium'); ?>
            <div>
                <div class="c-card__content">
                    <h4><?php the_title(); ?></h4>
                    <p class="c-card__content-excerpt"><?php echo gdt_excerpt(25); ?></p>
                    <span class="entry-meta-author" itemprop="author" itemscope itemptype="https://schema.org/Person"><?php echo get_the_author(); ?></span>
                </div>
            </div>
        </div>
        <?php
    }
    wp_reset_postdata();
}

// Display automatic related posts if needed
if ($remaining_posts > 0) {
    $orig_post = $post;
    global $post;
    $tags = wp_get_post_tags($post->ID);
    
    // First try to get related posts by tags
    if ($tags) {
        $tag_ids = array();
        foreach ($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
        $args = array(
            'tag__in' => $tag_ids,
            'post__not_in' => array($post->ID),
            'posts_per_page' => $remaining_posts,
            'ignore_sticky_posts' => 1
        );
    } else {
        // If no tags, get posts from the same category
        $args = array(
            'category__in' => wp_get_post_categories($post->ID),
            'post__not_in' => array($post->ID),
            'posts_per_page' => $remaining_posts,
            'ignore_sticky_posts' => 1
        );
    }

    $my_query = new WP_Query($args);
    
    if ($my_query->have_posts()) {
        while ($my_query->have_posts()) {
            $my_query->the_post(); ?>
            <div class="c-related-card">
                <a href="<?php the_permalink(); ?>"></a>
                <?php the_post_thumbnail('medium'); ?>
                <div>
                    <div class="c-card__content">
                        <h4><?php the_title(); ?></h4>
                        <p class="c-card__content-excerpt"><?php echo gdt_excerpt(25); ?></p>
                        <span class="entry-meta-author" itemprop="author" itemscope itemptype="https://schema.org/Person"><?php echo get_the_author(); ?></span>
                    </div>
                </div>
            </div>
            <?php
        }
    } elseif (!$tags) {
        // If no related posts found by category, get recent posts
        $recent_args = array(
            'post__not_in' => array($post->ID),
            'posts_per_page' => $remaining_posts,
            'ignore_sticky_posts' => 1
        );
        
        $recent_query = new WP_Query($recent_args);
        
        if ($recent_query->have_posts()) {
            while ($recent_query->have_posts()) {
                $recent_query->the_post(); ?>
                <div class="c-related-card">
                    <a href="<?php the_permalink(); ?>"></a>
                    <?php the_post_thumbnail('medium'); ?>
                    <div>
                        <div class="c-card__content">
                            <h4><?php the_title(); ?></h4>
                            <p class="c-card__content-excerpt"><?php echo gdt_excerpt(25); ?></p>
                            <span class="entry-meta-author" itemprop="author" itemscope itemptype="https://schema.org/Person"><?php echo get_the_author(); ?></span>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        wp_reset_postdata();
    }
    wp_reset_postdata();
}

// Close the container divs only once
if ($show_related) {
    echo '</div></div>';
}
?>
      
      </section>
    
    
  </main>
</div>
<!-- /layout-row-->

<!-- Sticky Subscribe Button -->
<button class="c-subscribe-sticky <?php echo ($enable_toc && $toc_data) ? 'hidden-when-toc' : ''; ?>" aria-label="Subscribe to blog">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
    <polyline points="22,6 12,13 2,6"></polyline>
  </svg>
  <span>Subscribe</span>
</button>

<!-- Subscribe Flyout Modal -->
<div class="c-subscribe-flyout" aria-hidden="true">
  <div class="c-subscribe-flyout__overlay"></div>
  <div class="c-subscribe-flyout__content">
    <button class="c-subscribe-flyout__close" aria-label="Close subscribe form">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <line x1="18" y1="6" x2="6" y2="18"></line>
        <line x1="6" y1="6" x2="18" y2="18"></line>
      </svg>
    </button>
    <div class="c-subscribe-flyout__header">
      <h3>Subscribe to Our Blog</h3>
      <p>Stay updated with the latest insights and news</p>
    </div>
    <div class="c-salesforce-form">
      <iframe src="https://secure.plixer.com/l/1088472/2025-01-16/2rhw96" width="100%" height="900" type="text/html" frameborder="0" allowTransparency="true" style="border: 0"></iframe>
    </div>
  </div>
</div>

<?php get_footer(); ?>
