<?php
/*
Template Name: Resources Listing Page
*/
?>

<?php get_header(); ?>

<div class="o-layout-row o-poly-header-bright">
  <div class="o-wrapper-wide"><h1>Plixer <span class="u-green">Resources</span></div></h1>
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
          'post_type' => 'resources',
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
            <?php get_template_part( 'template-part/post/entry-meta' ); ?>
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




      <!-- the rest -->
      <div class="c-main-posts" id="c-main-posts">
        
      <div class="c-post-filters">
      <div class="c-post-filter-titles">
  <span>All</span>
</div>
<?php
$terms = get_terms( array(
    'taxonomy' => 'resource-type',
    'hide_empty' => false,
) );

if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
    echo '<select id="resource-type-dropdown">';
    echo '<option value="">Select Resource Type</option>';
    foreach ( $terms as $term ) {
        // Skip the terms "Solutions Briefs" and "Brochures"
        if ($term->name == 'Solutions Brief' || $term->name == 'Brochures') {
            continue;
        }
        echo '<option value="' . $term->slug . '">' . $term->name . '</option>';
    }
    echo '</select>';
}
?>
<script type="text/javascript">
    var dropdown = document.getElementById("resource-type-dropdown");
    dropdown.onchange = function() {
        var selected_term_slug = dropdown.options[dropdown.selectedIndex].value;
        if (selected_term_slug !== '') {
            window.location.href = "<?php echo get_option('home'); ?>/resource-type/" + selected_term_slug;
        }
    };
</script>
      </div>

<div class="c-post-grid">
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
      $resource_query = new WP_Query(
              array(
                'posts_per_page' => 9,
                'post_type' => 'resources',
                'post__not_in' => $featured_post_ids,
                'paged' => $paged
              )
            );
          ?>
          <?php if ($resource_query->have_posts()) : while ($resource_query->have_posts()) : $resource_query->the_post(); ?>
            <article <?php post_class('c-post-card'); ?> role="article" itemscope itemtype="https://schema.org/BlogPosting">
            <a href="<?php the_permalink()?>"></a>
              <?php the_post_thumbnail('large'); ?> 
              <?php 
                  $terms = get_the_terms( get_the_ID(), 'resource-type' );
                  if ( $terms && ! is_wp_error( $terms ) ) : 
                    $term = array_shift( $terms );
                    echo '<span class="c-card__content-term">'.$term->name.'</span>';
                  endif; 
                  ?>
                <div class="c-card__content">
                 
                          <h4><?php the_title(); ?></h4>
                          <!-- the excerpt -->
                          <p class="c-card__content-excerpt"><?php echo gdt_excerpt(25); ?>...</p>
                          
                        </div>
              
              <!-- /editor-content -->
            </article>
            <!-- /post-intro -->
          <?php endwhile; endif; ?>
          </div>
          <nav class="c-post-nav">
              <ul class="">
          <?php if ( $resource_query->max_num_pages > 1 ) : ?>
            <?php $max_page = $resource_query->max_num_pages; ?>
            <?php 
            $total_pages = $resource_query->max_num_pages;

            if ($total_pages > 1){
              $current_page = max(1, get_query_var('paged'));
              $prev_link = get_previous_posts_link(__('« prev'));
              $next_link = get_next_posts_link(__('next »'), $total_pages);
          
              if ($prev_link) {
                  echo '<li class="post-nav-prev">' . $prev_link . '</li>';
              }
              if ($next_link) {
                  echo '<li class="post-nav-next">' . $next_link . '</li>';
              }
          }?>
          </ul>
        </nav>





          <?php endif; ?>
        
        <?php $resource_query = null; $resource_query = $temp; ?>
        <?php wp_reset_postdata(); ?>
      </div>

    </div>
    <!-- /editor-content -->
    </div>


  </main>
</div>
<!-- /layout-row -->

<?php get_footer(); ?>
