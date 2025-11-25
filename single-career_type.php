<?php get_header(); ?>

<div class="o-layout-row o-poly-header">
  <div class="o-wrapper-wide"><h1>Plixer <span class="u-green">Careers</span></div></h1>
</div>

<div class="o-layout-row o-dark-wave-grad u-dark">
  <main id="main-content" class="" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
      <section class="editor-content">
        <header class="c-article-header c-news-header">
          <div class="c-article-header-content">
            <div>
              <h2 class="mb-12"><?php the_title(); ?><br /><?php if( get_field('location') ) { echo '<span>' . get_field('location') . '</span>'; }?></h2>
            </div>
          </div>
    
        </header>
        <!-- /article-header -->
        <div class="c-post-content">
          <article <?php post_class(); ?> role="article">
          <?php if( get_field('job_description') ) { echo '<h2>Description</h2>'. get_field('job_description'); }?>
          
          <?php if( have_rows('responsibilities') ): ?>
            <h2 class="mt-10"> Responsibilities</h2>
            <ul>
           <?php while( have_rows('responsibilities') ): the_row(); ?>
         <li>
          <?php echo get_sub_field('responsibility'); ?>
          </li>
          <?php endwhile; ?>
          </ul>
          <?php endif; ?>

          <?php if( have_rows('qualifications_&_experience') ): ?>
            <h2 class="mt-10"> Qualifications & Experience</h2>
            <ul>
           <?php while( have_rows('qualifications_&_experience') ): the_row(); ?>
         <li>
          <?php echo get_sub_field('qualifications_&_experience_item'); ?>
          </li>
          <?php endwhile; ?>
          </ul>
          <?php endif; ?>


          <?php if( have_rows('bonus_experience') ): ?>
            <h2 class="mt-10">Bonus Experience</h2>
            <ul>
           <?php while( have_rows('bonus_experience') ): the_row(); ?>
         <li>
          <?php echo get_sub_field('bonus_experience_item'); ?>
          </li>
          <?php endwhile; ?>
          </ul>
          <?php endif; ?>

          <h2 class="mt-10">How to apply</h2>
          <p>To apply for the <?php echo the_title();?> position, please email your résumé to <a href="mailto:careers@plixer.com?subject=<?php echo the_title();?>">careers@plixer.com</a> and include “<?php echo the_title();?>” in the subject line.</p>

           <div class="c-btn-primary mt-20"><a href="mailto:careers@plixer.com?subject=<?php echo the_title();?>">Submit your resume</a></div>
          </article>
          <?php endwhile; ?>
              
              <?php else : ?>
                <?php get_template_part( 'template-part/post/not-found' ); ?>
              <?php endif; ?>
  
        </div>
  
      </section>
    
    
  </main>
</div>
<!-- /layout-row-->

<?php get_footer(); ?>
