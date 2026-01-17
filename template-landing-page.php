<?php
/*
Template Name: Landing Page (Paid Ads)
Template Post Type: page
Description: High-converting landing page with logo, 2-column layout, and no header/footer navigation
*/
?>

<?php get_header(); ?>

<div class="landing-page-wrapper">
  
  <!-- Simple Logo Header -->
  <header class="landing-page-header" role="banner">
    <div class="landing-page-header__inner">
      <div class="landing-page-logo">
        <a href="/" rel="nofollow" aria-label="Plixer home">
          <svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 360 85.61">
            <path class="cls-1" d="M85.44,85.59c-7.33,0-12.47-3.06-12.47-12.84V.02h16.14v66.62c0,4.89,1.22,6.11,6.11,6.11h31.29v12.84h-41.07Z"/>
            <path class="cls-1" d="M133.84,85.59V.02h16.14v85.57h-16.14Z"/>
            <path class="cls-1" d="M206.86,85.59l-15.52-30.8-15.52,30.8h-19.19l24.33-43.39L157.6.02h19.19l14.55,29.58L205.89.02h19.19l-23.35,42.17,24.33,43.39h-19.19Z"/>
            <path class="cls-1" d="M284.56,85.59h-41.44c-7.33,0-12.47-3.06-12.47-12.84V12.86C230.65,3.08,235.78.02,243.12.02h40.95v12.83h-31.17c-3.38,0-6.11,2.74-6.11,6.11v16.5h36.06v12.83h-36.06v18.34c0,3.38,2.74,6.11,6.11,6.11h31.66v12.84Z"/>
            <path class="cls-1" d="M44.68,55.27h1.22c13.08,0,18.89-10.64,18.89-28.24S59.29.02,43.39.02H12.47C5.13.02,0,3.08,0,12.86v72.73h16.14V18.97c0-3.38,2.74-6.11,6.11-6.11h13.81c10.27,0,12.1,4.4,12.1,14.18s-1.34,15.77-10.27,15.77H7.03c-2.47,0-3.94,2.77-2.54,4.82l3.71,5.42c.96,1.4,2.54,2.23,4.23,2.23h32.24Z"/>
            <path class="cls-1" d="M338.57,55.88v-.61h1.22c13.08,0,18.5-10.64,18.5-28.24S352.79.02,336.9.02h-30.93c-7.33,0-12.47,3.06-12.47,12.83v72.73h16.14V18.97c0-3.38,2.74-6.11,6.11-6.11h13.81c10.27,0,12.1,4.4,12.1,14.18s-1.34,15.77-10.27,15.77h-14.06c-2.47,0-3.94,2.77-2.54,4.82l7.18,9.24c.2.33.42.65.64.98l5.38,7.83,14.15,19.92h17.85l-21.43-29.7Z"/>
          </svg>
        </a>
      </div>
    </div>
  </header>

  <!-- Main Content Area -->
  <main class="landing-page-main" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">
    <div class="landing-page-container">
      <div class="landing-page-grid">
        
        <!-- Left Column: Content -->
        <div class="landing-page-content">
          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            
            <?php if( get_field('landing_page_headline') ): ?>
              <h1 class="landing-page-headline"><?php the_field('landing_page_headline'); ?></h1>
            <?php else: ?>
              <h1 class="landing-page-headline"><?php the_title(); ?></h1>
            <?php endif; ?>
            
            <?php if( get_field('landing_page_subheadline') ): ?>
              <div class="landing-page-subheadline">
                <?php the_field('landing_page_subheadline'); ?>
              </div>
            <?php endif; ?>
            
            <div class="landing-page-body">
              <?php the_content(); ?>
            </div>
            
            <?php if( get_field('trust_badges') ): ?>
              <div class="landing-page-trust-badges">
                <?php the_field('trust_badges'); ?>
              </div>
            <?php endif; ?>
            
          <?php endwhile; endif; ?>
        </div>
        
        <!-- Right Column: Form -->
        <div class="landing-page-form">
          <div class="landing-page-form__inner">
            
            <?php 
            $form_image = get_field('form_image');
            if( $form_image ): ?>
              <div class="landing-page-form__image">
                <img src="<?php echo esc_url($form_image['url']); ?>" alt="<?php echo esc_attr($form_image['alt']); ?>" />
              </div>
            <?php endif; ?>
            
            <?php if( get_field('form_headline') ): ?>
              <h2 class="landing-page-form__title"><?php the_field('form_headline'); ?></h2>
            <?php endif; ?>
            
            <?php if( get_field('form_subtext') ): ?>
              <p class="landing-page-form__subtext"><?php the_field('form_subtext'); ?></p>
            <?php endif; ?>
            
            <div class="landing-page-form__embed">
              <?php 
              $form_embed = get_field('salesforce_form_embed', false, false);
              if( $form_embed ): 
                echo $form_embed;
              else: ?>
                <!-- Placeholder for Salesforce form embed -->
                <!-- Add your Salesforce form embed code in the ACF field 'salesforce_form_embed' -->
                <p style="padding: 20px; background: #f5f5f5; border-radius: 4px; text-align: center;">
                  <strong>Form Placeholder</strong><br>
                  Add your Salesforce form embed code in the Custom Fields editor.
                </p>
              <?php endif; ?>
            </div>
            
            <?php if( get_field('privacy_text') ): ?>
              <div class="landing-page-form__privacy">
                <?php the_field('privacy_text'); ?>
              </div>
            <?php endif; ?>
            
          </div>
        </div>
        
      </div>
    </div>
  </main>

  <!-- Minimal Footer (Optional Legal Links) -->
  <footer class="landing-page-footer" role="contentinfo">
    <div class="landing-page-footer__inner">
      <p>
        &copy; <?php echo date('Y'); ?> Plixer LLC. | 
        <a href="/privacy" aria-label="View Privacy Policy">Privacy Policy</a> | 
        <a href="/terms" aria-label="View Terms of Use">Terms of Use</a>
      </p>
    </div>
  </footer>

</div>

<?php get_footer(); ?>
