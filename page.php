<?php get_header(); ?>

<div class="o-layout-row
<?php if( get_field('dark_page') ) { echo 'u-dark'; }?>
">
  <main id="main-content" class="" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <section class="editor-content  clearfix">
        <?php the_content(); ?>
      </section> 
      <!-- /editor-content -->
    <?php endwhile; endif; // END main loop (if/while) ?>
  </main>
  <!-- /container -->
</div>
<!-- /layout-row-->

<?php  get_template_part( 'template-part/lowercta' ); ?>

<?php get_footer(); ?>
