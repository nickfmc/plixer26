<?php get_header(); ?>

<div class="o-layout-row o-poly-bg o-poly-bg-fade u-dark">
  <main class="" id="main-content" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <section class="editor-content">
        <header class="c-article-header c-blog-header">
          <div class="c-article-header-content">
            <div>
              <div class="c-cat-list">
                <span>Blog</span>
              </div>
              <h1><?php the_title(); ?></h1>
            </div>

                    

          </div>
          <div>
            <?php the_post_thumbnail('large');?>
          </div>
          
        </header>









        <!-- /article-header -->
        <div class="c-post-content">
          <article <?php post_class(); ?> role="article">
            <?php the_content(); ?>

            <?php
        // Check if the post_author field is set and not empty
        $post_author = get_field('post_author');
        
        if ($post_author) {
          echo '<h2 class="mt-12 h4-style">Post Author</h2>';
            // Get the post title
            $author_title = get_the_title($post_author);
            
            // Get the bio field from the author post
            $author_bio = get_field('bio', $post_author);
            
            // Output the information
            if ($author_title || $author_bio) {
                ?>
                <div class="author-info">
               
                  <?php
                  $image = get_field('headshot', $post_author);
                  $size = 'medium';
                  if($image){
                  echo wp_get_attachment_image($image, $size);
                  };?>
                      
                
                 <div>
                  <?php if ($author_title) : ?>
                            <h3 class="author-title"><?php echo esc_html($author_title); ?></h3>
                        <?php endif; ?>
                      <?php if ($author_bio) : ?>
                          <div class="author-bio">
                  
                              <?php echo wp_kses_post($author_bio); ?>
                          </div>
                      <?php endif; ?>
                  </div>
                </div>
                <?php
            }
        }
        ?>
        
          </article>
          <?php endwhile; ?>
              
              <?php else : ?>
                <?php get_template_part( 'template-part/post/not-found' ); ?>
              <?php endif; ?>
             
          
              <div class="c-blog-sidebar">

              



              
  <div class="c-subscribe-box">
                  <h3>Subscribe</h3>
             <div class="c-salesforce-form">
             <iframe src="https://secure.plixer.com/l/1088472/2025-01-16/2rhw96" width="100%" height="900" type="text/html" frameborder="0" allowTransparency="true" style="border: 0"></iframe>
             </div>
             
                              
                </div>
                <?php get_sidebar(); // sidebar ?>
                
             </div>
      
    
        
      </section>
    
    
  </main>
</div>
<!-- /layout-row-->

<?php get_footer(); ?>
