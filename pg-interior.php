<?php
/*
Template Name: Classic Elementor page with Intro block
*/
?>

<?php get_header(); ?>

<div class="c-interior-header">
  <div class="o-wrapper-wide">
    <div class="o-layout-row">
      <div class="c-interior-header__content">
        <h1 class="c-interior-header__title h2-style"><?php the_title(); ?></h1>
        <?php if( get_field('intro_text') ): ?>
          <div class="c-interior-header__intro">
            <p><?php the_field('intro_text'); ?></p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="o-layout-row
<?php if( get_field('dark_page') ) { echo 'u-dark'; }?>
">
  <main class="" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">
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
