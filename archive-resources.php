<?php
/*
Template Name: Resources Listing Page
*/
?>

<?php get_header(); ?>

<!-- Modern Tech Resources Archive -->
<div class="c-resources-archive">
  
  <!-- Hero Section -->
  <div class="c-resources-hero">
    <div class="o-wrapper-wide">
      <div class="c-resources-hero__content">
        <h1>Plixer <span class="u-tech-accent">Resources</span></h1>
        <p class="c-resources-hero__subtitle">Explore our latest insights, case studies, and technical resources</p>
      </div>
    </div>
  </div>

  <main class="c-resources-main" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">
    <div class="o-wrapper-wide">
    
    <!-- Featured Resources Section -->
    <section class="c-featured-resources">
      <div class="c-section-header">
        <h2>Featured Resources</h2>
        <div class="c-section-header__line"></div>
      </div>
      <div class="c-featured-resources-grid">
        <?php
          $temp = $wp_query;
          $featured_query = new WP_Query(
            array(
              'post_type' => 'resources',
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
                $terms = get_the_terms(get_the_ID(), 'resource-type');
                if ($terms && !is_wp_error($terms)) : 
                  $term = array_shift($terms);
                  echo '<span class="c-resource-badge">'.$term->name.'</span>';
                endif; 
              ?>
              <h3 itemprop="headline"><?php the_title(); ?></h3>
              <?php get_template_part('template-part/post/entry-meta'); ?>
              <?php if ($counter == 1): ?>
                <p class="c-resource-excerpt"><?php echo gdt_content_excerpt(180); ?></p>
                <span class="c-resource-cta">
                  View Resource 
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
    </section>
       
    <?php wp_reset_postdata(); ?>

    <!-- All Resources Section -->
    <section class="c-all-resources">
      <div class="c-resources-toolbar">
        <div class="c-section-header">
          <h2>All Resources</h2>
          <div class="c-section-header__line"></div>
        </div>
        
        <div class="c-resources-filter">
          <?php
          $terms = get_terms(array(
            'taxonomy' => 'resource-type',
            'hide_empty' => false,
          ));

          if (!empty($terms) && !is_wp_error($terms)) {
            echo '<label for="resource-type-dropdown">Filter by Type:</label>';
            echo '<select id="resource-type-dropdown" class="c-filter-dropdown">';
            echo '<option value="">All Types</option>';
            foreach ($terms as $term) {
              if ($term->name == 'Solutions Brief' || $term->name == 'Brochures') {
                continue;
              }
              echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
            }
            echo '</select>';
          }
          ?>
        </div>
      </div>

      <div class="c-resources-grid">
        <?php 
        // Collect featured post IDs
        $featured_post_ids = array();
        if ($featured_query->have_posts()) : 
          while ($featured_query->have_posts()) : $featured_query->the_post();
            $featured_post_ids[] = get_the_ID();
          endwhile; 
        endif;
        
        $temp = $wp_query;
        $resource_query = new WP_Query(
          array(
            'posts_per_page' => 12,
            'post_type' => 'resources',
            'post__not_in' => $featured_post_ids,
            'paged' => $paged
          )
        );
        ?>
        
        <?php if ($resource_query->have_posts()) : while ($resource_query->have_posts()) : $resource_query->the_post(); ?>
          <article <?php post_class('c-resource-card'); ?> role="article" itemscope itemtype="https://schema.org/BlogPosting">
            <a href="<?php the_permalink(); ?>" class="c-resource-card__link"></a>
            
            <div class="c-resource-card__image">
              <?php the_post_thumbnail('large'); ?>
              <div class="c-resource-card__overlay"></div>
            </div>
            
            <div class="c-resource-card__content">
              <?php 
                $terms = get_the_terms(get_the_ID(), 'resource-type');
                if ($terms && !is_wp_error($terms)) : 
                  $term = array_shift($terms);
                  echo '<span class="c-resource-badge">'.$term->name.'</span>';
                endif; 
              ?>
              <h4><?php the_title(); ?></h4>
              <p class="c-resource-card__excerpt"><?php echo gdt_excerpt(20); ?></p>
              <span class="c-resource-card__cta">
                Learn More
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 256 256">
                  <path fill="currentColor" d="m218.83 130.83l-72 72a4 4 0 0 1-5.66-5.66L206.34 132H40a4 4 0 0 1 0-8h166.34l-65.17-65.17a4 4 0 0 1 5.66-5.66l72 72a4 4 0 0 1 0 5.66Z"/>
                </svg>
              </span>
            </div>
          </article>
        <?php endwhile; endif; ?>
      </div>
      </div>
      
      <!-- Pagination -->
      <?php if ($resource_query->max_num_pages > 1) : ?>
        <nav class="c-resources-pagination">
          <?php
          $total_pages = $resource_query->max_num_pages;
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
    
    <?php $resource_query = null; $resource_query = $temp; ?>
    <?php wp_reset_postdata(); ?>
    
    </div>
  </main>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var dropdown = document.getElementById('resource-type-dropdown');
  if (dropdown) {
    dropdown.onchange = function() {
      var selected_term_slug = dropdown.options[dropdown.selectedIndex].value;
      if (selected_term_slug !== '') {
        window.location.href = "<?php echo get_option('home'); ?>/resource-type/" + selected_term_slug;
      } else {
        window.location.href = "<?php echo get_post_type_archive_link('resources'); ?>";
      }
    };
  }
});
</script>

<?php get_footer(); ?>
