<?php
/*
Template Name: Partners Page
*/
?>

<?php get_header(); ?>

<div class="o-layout-row o-poly-header">
  <div class="o-wrapper-wide"><h1>Technology Alliance <span class="u-green">Partners</span></div></h1>
</div>

<div class="o-layout-row o-dark-wave-grad u-dark">
  <main class="" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <section class="editor-content  clearfix">
        <div class="o-pad">
          <h2 class="c-partner-title"><?php the_title(); ?></h2>
        </div>
        <?php the_content(); ?>
      </section> 
      <!-- /editor-content -->
    <?php endwhile; endif; // END main loop (if/while) ?>
  </main>
  <!-- /container -->
</div>
<!-- /layout-row-->

<?php // IF USING PARTS -> get_template_part( 'template-part/name-of-part' ); ?>

<?php get_footer(); ?>

