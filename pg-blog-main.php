<?php
/*
Template Name: Blog Main Page
*/
?>

<?php get_header(); ?>

<div class="o-layout-row o-poly-header-bright">
  <div class="o-wrapper-wide"><h1>Plixer <span class="u-green">Blog</span></div></h1>
</div>

<div class="o-layout-row o-dark-wave-poly u-dark">
  <main class="" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">
    <div class="editor-content  clearfix">
    <div class="c-featured-posts">
  <h2 class="">Featured Entries</h2>
  <div class="c-featured-posts-grid">
    <?php
      $temp = $wp_query;
      $featured_query = new WP_Query(
        array(
          'posts_per_page' => 5,
        )
      );
      $counter = 0; // Initialize counter
    ?>
    <?php if ($featured_query->have_posts()) : while ($featured_query->have_posts()) : $featured_query->the_post(); $counter++; ?>
      <?php if($counter == 1) { echo '<div class="c-featured-posts-first">'; } // Open div for the first post ?>
      <?php if($counter == 2) { echo '</div><div class="c-featured-posts-last">'; } // Close div for the first post and open div for the last posts ?>
      <article <?php post_class('post-intro'); ?> role="article" itemscope itemtype="https://schema.org/BlogPosting">
        
      <?php 
      if($counter == 1) { 
        the_post_thumbnail('large'); 
      } else { 
        echo '<div class="c-post-thumbnail">';
        the_post_thumbnail('medium'); 
        echo '</div>';
      } 
    ?>
          <div>
            <h3 itemprop="headline"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
            <?php if($counter == 1) { echo '<p>'.gdt_content_excerpt( 290 ).'</p>'; echo '<a class="c-more-link" href="'.get_permalink().'">Continue Reading <svg xmlns="http://www.w3.org/2000/svg" width="256" height="256" viewBox="0 0 256 256"><path fill="currentColor" d="m218.83 130.83l-72 72a4 4 0 0 1-5.66-5.66L206.34 132H40a4 4 0 0 1 0-8h166.34l-65.17-65.17a4 4 0 0 1 5.66-5.66l72 72a4 4 0 0 1 0 5.66Z"/></svg></a>'; } ?>
            
          </div>
     
        <!-- /editor-content -->
      </article>
      <!-- /post-intro -->
    <?php endwhile; endif; ?>
    <?php if($counter >= 2) { echo '</div>'; } // Close div for the last posts ?>
    <!-- Rest of your code -->
  </div>
</div>
       
       
        <?php wp_reset_postdata(); ?>
     

<div class="c-fancy-hr" id="category-filter"><div></div><div></div></div>


<!-- Newsletter -->
<div class="c-newsletter">
  <h2>Don't miss a thing! </h2>
  
<p>Elevate your network performance and cybersecurity know-how. <a href="/subscribe">Sign up for our blog</a> to unlock exclusive insights, expert analysis, and actionable NMPD and NDR tips. <p>
  <div class="c-btn-primary">
  <a href="/subscribe">Sign Up</a>
  </div>
            </div>
      <!-- the rest -->
      <div class="c-main-posts" id="c-main-posts">
        
      <div class="c-post-filters">
      <div class="c-post-filter-titles">
  <span>All</span>
</div>
        <?php
            $dropdown_args = array(
                'show_option_none' => 'Select Category',
                'hide_empty'       => 1,
                'value_field'      => 'slug',
                'id'               => 'category-dropdown',
                'echo'             => 0
            );
            $category_dropdown = wp_dropdown_categories($dropdown_args);
            echo $category_dropdown;
          ?>
          <script type="text/javascript">
              var dropdown = document.getElementById("category-dropdown");
              dropdown.onchange = function() {
                  var selected_category_slug = dropdown.options[dropdown.selectedIndex].value;
                  if (selected_category_slug !== '') {
                      window.location.href = "<?php echo get_option('home'); ?>/blog/category/" + selected_category_slug;
                  }
              };
          </script>
      </div>

<div class="c-resources-grid">
   <?php 
   // Collect the IDs of the posts in the featured posts query
$featured_post_ids = array();
if ($featured_query->have_posts()) : while ($featured_query->have_posts()) : $featured_query->the_post();
  $featured_post_ids[] = get_the_ID();
  // Display your featured post
endwhile; endif;
   ; ?>
          <?php
            $temp = $wp_query;
            $wp_query = null;
            $wp_query = new WP_Query(
              array(
                'posts_per_page' => 9,
                'post__not_in' => $featured_post_ids,
                'paged' => $paged
              )
            );
          ?>
          <?php if ($wp_query->have_posts()) : while ($wp_query->have_posts()) : $wp_query->the_post(); ?>
            <article <?php post_class('c-resource-card'); ?> role="article" itemscope itemtype="https://schema.org/BlogPosting">
            <a href="<?php the_permalink()?>" class="c-resource-card__link"></a>
            
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
            <!-- /post-intro -->
            
          <?php endwhile; endif; ?>
          </div>
          <?php /* Display navigation to next/previous pages when applicable */ ?>
          <?php if ( $wp_query->max_num_pages > 1 ) : ?>
            
            <?php $max_page = $wp_query->max_num_pages; ?>
            <?php get_template_part( 'template-part/post/post-nav' ); ?>
          <?php endif; ?>

          
        
        <?php $wp_query = null; $wp_query = $temp; ?>
        <?php wp_reset_postdata(); ?>
      </div>

    </div>
    <!-- /editor-content -->
    </div>


  </main>
</div>
<!-- /layout-row -->

<?php get_footer(); ?>
