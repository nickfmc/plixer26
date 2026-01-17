<?php get_header(); ?>

<!-- Modern Tech Blog Archive -->
<div class="c-resources-archive c-blog-archive">
  
  <!-- Hero Section -->
  <div class="c-resources-hero">
    <div class="o-wrapper-wide">
      <div class="c-resources-hero__content">
        <h1>Plixer <span class="u-tech-accent">Blog</span></h1>
        <p class="c-resources-hero__subtitle">
          <?php 
          if (is_category()) {
            echo 'Category: ' . single_cat_title('', false);
          } else {
            echo 'Insights, updates, and technical deep dives from our team';
          }
          ?>
        </p>
      </div>
    </div>
  </div>

  <main class="c-resources-main" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">
    <div class="o-wrapper-wide">
    
    <!-- Featured Posts Section -->
    <?php if (!is_category() && !is_paged()) : ?>
    <section class="c-featured-resources">
      <div class="c-section-header">
        <h2>Featured Posts</h2>
        <div class="c-section-header__line"></div>
      </div>
      <div class="c-featured-resources-grid">
        <?php
          $temp = $wp_query;
          $featured_query = new WP_Query(
            array(
              'post_type' => 'post',
              'posts_per_page' => 3,
            )
          );
          $counter = 0;
        ?>
        <?php if ($featured_query->have_posts()) : while ($featured_query->have_posts()) : $featured_query->the_post(); $counter++; ?>
          <article class="c-resource-featured-card <?php echo $counter == 1 ? 'c-resource-featured-card--hero' : ''; ?>" role="article" itemscope itemtype="https://schema.org/BlogPosting">
            <a href="<?php the_permalink(); ?>" class="c-resource-featured-card__link"></a>
            
            <div class="c-resource-featured-card__image">
              <?php the_post_thumbnail($counter == 1 ? 'large' : 'medium'); ?>
            </div>
            
            <div class="c-resource-featured-card__content">
              <?php 
                $categories = get_the_category();
                if (!empty($categories)) : 
                  $category = $categories[0];
                  echo '<span class="c-resource-badge">'.$category->name.'</span>';
                endif; 
              ?>
              <h3 itemprop="headline"><?php the_title(); ?></h3>
              <?php get_template_part('template-part/post/entry-meta'); ?>
              <?php if ($counter == 1): ?>
                <p class="c-resource-excerpt"><?php echo gdt_content_excerpt(180); ?></p>
                <span class="c-resource-cta">
                  Read More 
                  <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 256 256">
                    <path fill="currentColor" d="m218.83 130.83l-72 72a4 4 0 0 1-5.66-5.66L206.34 132H40a4 4 0 0 1 0-8h166.34l-65.17-65.17a4 4 0 0 1 5.66-5.66l72 72a4 4 0 0 1 0 5.66Z"/>
                  </svg>
                </span>
              <?php endif; ?>
            </div>
          </article>
        <?php endwhile; endif; ?>
      </div>
    </section>
       
    <?php wp_reset_postdata(); ?>
    <?php endif; ?>

    <!-- All Posts Section -->
    <section class="c-all-resources">
      <div class="c-resources-toolbar">
        <div class="c-section-header">
          <h2>
            <?php 
            if (is_category()) {
              echo single_cat_title('', false) . ' Posts';
            } else {
              echo 'All Posts';
            }
            ?>
          </h2>
          <div class="c-section-header__line"></div>
        </div>
        
        <div class="c-resources-filter">
          <label for="category-dropdown">Filter by Category:</label>
          <?php
            $dropdown_args = array(
                'show_option_all' => 'All Categories',
                'hide_empty'       => 0,
                'value_field'      => 'slug',
                'id'               => 'category-dropdown',
                'class'            => 'c-filter-dropdown',
                'echo'             => 0
            );
            $category_dropdown = wp_dropdown_categories($dropdown_args);
            echo $category_dropdown;
          ?>
        </div>
      </div>

 
      <div class="c-resources-grid">
        <?php 
        // Collect featured post IDs if on first page
        $featured_post_ids = array();
        if (!is_category() && !is_paged() && isset($featured_query) && $featured_query->have_posts()) : 
          while ($featured_query->have_posts()) : $featured_query->the_post();
            $featured_post_ids[] = get_the_ID();
          endwhile; 
        endif;
        wp_reset_postdata();
        ?>
        
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
          <?php if (!in_array(get_the_ID(), $featured_post_ids)) : ?>
          <article <?php post_class('c-resource-card'); ?> role="article" itemscope itemtype="https://schema.org/BlogPosting">
            <a href="<?php the_permalink(); ?>" class="c-resource-card__link"></a>
            
            <div class="c-resource-card__image">
              <?php the_post_thumbnail('large'); ?>
              <div class="c-resource-card__overlay"></div>
            </div>
            
            <div class="c-resource-card__content">
              <?php 
                $categories = get_the_category();
                if (!empty($categories)) : 
                  $category = $categories[0];
                  echo '<span class="c-resource-badge">'.$category->name.'</span>';
                endif; 
              ?>
              <h4><?php the_title(); ?></h4>
              <p class="c-resource-card__excerpt"><?php echo gdt_excerpt(20); ?></p>
              <span class="c-resource-card__cta">
                Read More
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 256 256">
                  <path fill="currentColor" d="m218.83 130.83l-72 72a4 4 0 0 1-5.66-5.66L206.34 132H40a4 4 0 0 1 0-8h166.34l-65.17-65.17a4 4 0 0 1 5.66-5.66l72 72a4 4 0 0 1 0 5.66Z"/>
                </svg>
              </span>
            </div>
          </article>
          <?php endif; ?>
        <?php endwhile; else : ?>
          <?php get_template_part('template-part/post/not-found'); ?>
        <?php endif; ?>
      </div>
      
      <!-- Pagination -->
      <?php
      global $wp_query;
      if ($wp_query->max_num_pages > 1) : ?>
        <nav class="c-resources-pagination">
          <?php
          $total_pages = $wp_query->max_num_pages;
          $current_page = max(1, get_query_var('paged'));
          
          echo paginate_links(array(
            'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
            'total' => $total_pages,
            'current' => $current_page,
            'format' => '?paged=%#%',
            'show_all' => false,
            'end_size' => 1,
            'mid_size' => 2,
            'prev_next' => true,
            'prev_text' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 256 256"><path fill="currentColor" d="M168.49 199.51a12 12 0 0 1-17 17l-80-80a12 12 0 0 1 0-17l80-80a12 12 0 0 1 17 17L97 128Z"/></svg> Previous',
            'next_text' => 'Next <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 256 256"><path fill="currentColor" d="M184.49 136.49l-80 80a12 12 0 0 1-17-17L159 128L87.51 56.49a12 12 0 1 1 17-17l80 80a12 12 0 0 1 0 17Z"/></svg>',
            'type' => 'list',
          ));
          ?>
        </nav>
      <?php endif; ?>
      
    </section>
    
    </div>
  </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var dropdown = document.getElementById('category-dropdown');
  if (dropdown) {
    dropdown.onchange = function() {
      var selected_category_slug = dropdown.options[dropdown.selectedIndex].value;
      if (selected_category_slug !== '') {
        window.location.href = "<?php echo get_option('home'); ?>/category/" + selected_category_slug;
      } else {
        window.location.href = "<?php echo get_option('home'); ?>/blog/";
      }
    };
  }
});
</script>

<?php get_footer(); ?>
