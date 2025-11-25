<?php get_header(); ?>

<div class="o-layout-row o-poly-header-bright">
  <div class="o-wrapper-wide"><h1>Plixer <span class="u-green">Blog</span></div></h1>
</div>

<div class="o-layout-row o-dark-wave-poly u-dark ">
  <main class="o-wrapper-wide" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">
  <div class="editor-content c-main-posts clearfix">

<div class="c-post-filters">
<div class="c-post-filter-titles">
  <a href="/blog/#category-filter">All</a>
  <?php
       echo '<span class="">' . single_cat_title('', false) . '</span>';
      ?>
</div>
        <?php
            $dropdown_args = array(
                'show_option_none' => 'Select Category',
                'hide_empty'       => 0,
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

<div class="c-post-grid">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article <?php post_class('c-post-card'); ?> role="article" itemscope itemtype="https://schema.org/BlogPosting">
            <a href="<?php the_permalink()?>"></a>
              <?php the_post_thumbnail('large'); ?> 
                
                <div class="c-card__content">
                          <h4><?php the_title(); ?></h4>
                          <!-- the excerpt -->
                          <p class="c-card__content-excerpt"><?php echo gdt_excerpt(25); ?>...</p>
                         
                             
                        </div>
              
              <!-- /editor-content -->
            </article>
      <!-- /article -->

      
    <?php endwhile; ?>
    </div>
      <?php get_template_part( 'template-part/post/post-nav' ); ?>

    <?php else : ?>

      <?php get_template_part( 'template-part/post/not-found' ); ?>

    <?php endif; ?>
    
    </div>
  </main>
</div>
<!-- /layout-row-->

<?php get_footer(); ?>
