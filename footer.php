<footer id="c-page-footer" class="o-section c-page-footer" role="contentinfo" itemscope itemtype="https://schema.org/WPFooter">
    <div class="o-wrapper-wide">
    <div class=" c-footer-top">
        <div class=" c-footer-logo-wrap ">
        <div class="c-logo-footer">
          <img width="300" height="71.35" src="<?php bloginfo('template_url') ?>/img/logo.svg" alt="<?php bloginfo('name'); ?>" />
        </div>
          <?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
            <?php dynamic_sidebar( 'footer-1' ); ?>
          <?php endif; ?>
        </div>
        <div class="c-footer-menus">
          <div><?php gdt_nav_menu( 'footer-menu-one', 'c-footer-nav' ); // Adjust using Menus in WordPress Admin ?></div>
          <div><?php gdt_nav_menu( 'footer-menu-two', 'c-footer-nav' ); // Adjust using Menus in WordPress Admin ?></div>
          <div><?php gdt_nav_menu( 'footer-menu-three', 'c-footer-nav' ); // Adjust using Menus in WordPress Admin ?></div>

              <?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
                <?php dynamic_sidebar( 'footer-2' ); ?>
              <?php endif; ?>
        </div>
      </div>
      <!-- /.c-footer-widgets -->
      <div class="c-lower-footer">
     <div class="c-footer-location" role="contentinfo" aria-label="Copyright and Legal Information">
         <!-- copyright -->
         <p>
             <span aria-label="Copyright">&copy;</span> 1999 - <?php echo date('Y'); ?> Plixer LLC.<br />
             <span aria-label="Company Address">68 Main St Ste 4, Kennebunk, ME 04043</span><br />
             <a href="/privacy" aria-label="View Privacy Policy">Privacy Policy</a> | 
             <a href="/terms" aria-label="View Terms of Use">Terms of Use</a>
         </p>
     </div>
     
      <div class="c-footer-social" role="navigation" aria-label="Social Media Links">
          <a target="_blank" href="https://twitter.com/plixer" aria-label="Visit Plixer on Twitter">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 16" role="img" aria-hidden="true">
                  <path fill="currentColor" d="M9.294 6.928L14.357 1h-1.2L8.762 6.147L5.25 1H1.2l5.31 7.784L1.2 15h1.2l4.642-5.436L10.751 15h4.05L9.294 6.928ZM7.651 8.852l-.538-.775L2.832 1.91h1.843l3.454 4.977l.538.775l4.491 6.47h-1.843l-3.664-5.28Z"/>
              </svg>
          </a>
          <a target="_blank" href="https://www.youtube.com/plixerweb" aria-label="Visit Plixer on YouTube">
              <svg xmlns="http://www.w3.org/2000/svg" width="576" height="512" viewBox="0 0 576 512" role="img" aria-hidden="true">
                  <path fill="currentColor" d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597c-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821c11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205l-142.739 81.201z"/>
              </svg>
          </a>
          <a target="_blank" href="https://www.linkedin.com/company/plixer" aria-label="Visit Plixer on LinkedIn">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="27.43" viewBox="0 0 448 512" role="img" aria-hidden="true">
                  <path fill="currentColor" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2c-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3c94 0 111.28 61.9 111.28 142.3V448z"/>
              </svg>
          </a>
      </div>
      
      </div>
      <!-- /.c-logo-copy-wrap -->
    </div>
    <!-- /.o-wrapper-wide -->
  </footer>

  <!-- /.c-page-footer -->
<div id="search-popup" 
     class="search-popup" 
     role="dialog" 
     aria-hidden="true" 
     aria-label="Search popup">
    <div class="search-content">
       <h2 id="search-title" class="u-text-center mb-4">Search Plixer</h2>
       
 
        
        
        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
            <input style="flex-grow:1;" type="search" 
                   id="search-input"
                   class="search-field" 
                   placeholder="Search …" 
                   value="" 
                   name="s"
                   aria-labelledby="search-title" />
            <input type="submit" 
                   class="search-submit" 
                   value="Search" />
        </form>
        <p class="u-text-center mt-14">
            Looking for documentation? 
            <a style="color:#000; text-decoration:underline; font-weight:700;" 
               target="_blank" 
               href="https://docs.plixer.com/en/latest/">
                Visit our documentation site
            </a>
        </p>
        <button type="button" 
                class="close" 
                aria-label="Close search popup">
                <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512"><!--!Font Awesome Pro 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc.--><path d="M378.4 71.4c8.5-10.1 7.2-25.3-2.9-33.8s-25.3-7.2-33.8 2.9L192 218.7 42.4 40.6C33.9 30.4 18.7 29.1 8.6 37.6S-2.9 61.3 5.6 71.4L160.7 256 5.6 440.6c-8.5 10.2-7.2 25.3 2.9 33.8s25.3 7.2 33.8-2.9L192 293.3 341.6 471.4c8.5 10.1 23.7 11.5 33.8 2.9s11.5-23.7 2.9-33.8L223.3 256l155-184.6z"/></svg>
        </button>
    </div>
</div>

<?php if(get_field('enable_fixed_bar')): ?>
  <div class="c-fixed-bar" role="complementary">
    <div class="c-fixed-bar-content">
       
      <?php if(get_field('fixed_bar_text')): ?>
        <div class="c-fixed-bar-text">
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 7h2v2h-2zm0 4h2v6h-2zm1-9C6.48 2 2 6.48 2 12s4.48 10 10 10s10-4.48 10-10S17.52 2 12 2m0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8"/></svg>
          <?php echo get_field('fixed_bar_text'); ?>
        </div>
      <?php endif; ?>
      
      <?php 
      $button = get_field('fixed_bar_button');
      if($button): 
        $button_url = $button['url'];
        $button_title = $button['title'];
        $button_target = $button['target'] ? $button['target'] : '_self';
      ?>
        <a href="<?php echo esc_url($button_url); ?>" 
           class="c-fixed-bar-button gbp-button--primary" 
           target="<?php echo esc_attr($button_target); ?>">
          <?php echo esc_html($button_title); ?>
        </a>
      <?php endif; ?>
      
      <button type="button" class="c-fixed-bar-close  " aria-label="Close fixed bar">
        <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512">
          <path d="M378.4 71.4c8.5-10.1 7.2-25.3-2.9-33.8s-25.3-7.2-33.8 2.9L192 218.7 42.4 40.6C33.9 30.4 18.7 29.1 8.6 37.6S-2.9 61.3 5.6 71.4L160.7 256 5.6 440.6c-8.5 10.2-7.2 25.3 2.9 33.8s25.3 7.2 33.8-2.9L192 293.3 341.6 471.4c8.5 10.1 23.7 11.5 33.8 2.9s11.5-23.7 2.9-33.8L223.3 256l155-184.6z"/>
        </svg>
      </button>
    </div>
  </div>
<?php endif; ?>

  <?php if( get_field('enable_popup', 'options') ) : ?>
      <?php
      $limit_to_resources = get_field('limit_popup_to_the_resources_section', 'options');
      $is_resources_post_type = (get_post_type() == 'resources');
  
      if (!$limit_to_resources || ($limit_to_resources && $is_resources_post_type)) :
      ?>
          <div id="info-popup-trigger" class="c-info-popup-trigger" aria-haspopup="dialog" aria-controls="info-popup" aria-expanded="false">
              <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                  <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                      <g>
                          <path stroke-dasharray="4" stroke-dashoffset="4" d="M12 3v2">
                              <animate fill="freeze" attributeName="stroke-dashoffset" dur="0.2s" values="4;0"/>
                          </path>
                          <path stroke-dasharray="28" stroke-dashoffset="28" d="M12 5c-3.31 0 -6 2.69 -6 6l0 6c-1 0 -2 1 -2 2h8M12 5c3.31 0 6 2.69 6 6l0 6c1 0 2 1 2 2h-8">
                              <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.2s" dur="0.4s" values="28;0"/>
                          </path>
                          <animateTransform fill="freeze" attributeName="transform" begin="0.9s" dur="6s" keyTimes="0;0.05;0.15;0.2;1" type="rotate" values="0 12 3;3 12 3;-3 12 3;0 12 3;0 12 3"/>
                      </g>
                      <path stroke-dasharray="8" stroke-dashoffset="8" d="M10 20c0 1.1 0.9 2 2 2c1.1 0 2 -0.9 2 -2">
                          <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.6s" dur="0.2s" values="8;0"/>
                          <animateTransform fill="freeze" attributeName="transform" begin="1.1s" dur="6s" keyTimes="0;0.05;0.15;0.2;1" type="rotate" values="0 12 8;6 12 8;-6 12 8;0 12 8;0 12 8"/>
                      </path>
                      <path stroke-dasharray="6" stroke-dashoffset="6" d="M22 6v4">
                          <animate fill="freeze" attributeName="stroke-dashoffset" begin="0.9s" dur="0.2s" values="6;0"/>
                          <animate attributeName="stroke-width" begin="1.8s" dur="3s" keyTimes="0;0.1;0.2;0.3;1" repeatCount="indefinite" values="2;3;3;2;2"/>
                      </path>
                      <path stroke-dasharray="2" stroke-dashoffset="2" d="M22 14v0.01">
                          <animate fill="freeze" attributeName="stroke-dashoffset" begin="1.1s" dur="0.2s" values="2;0"/>
                          <animate attributeName="stroke-width" begin="2.1s" dur="3s" keyTimes="0;0.1;0.2;0.3;1" repeatCount="indefinite" values="2;3;3;2;2"/>
                      </path>
                  </g>
              </svg>
          </div>
          <div id="info-popup" class="c-info-popup" role="dialog" aria-labelledby="info-popup-title" aria-hidden="true">
              <span class="c-info-popup-close" role="button" aria-label="Close popup">
                  <svg xmlns="http://www.w3.org/2000/svg" height="16" width="12" viewBox="0 0 384 512">
                      <!--!Font Awesome Pro 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc.-->
                      <path d="M378.4 71.4c8.5-10.1 7.2-25.3-2.9-33.8s-25.3-7.2-33.8 2.9L192 218.7 42.4 40.6C33.9 30.4 18.7 29.1 8.6 37.6S-2.9 61.3 5.6 71.4L160.7 256 5.6 440.6c-8.5 10.2-7.2 25.3 2.9 33.8s25.3 7.2 33.8-2.9L192 293.3 341.6 471.4c8.5 10.1 23.7 11.5 33.8 2.9s11.5-23.7 2.9-33.8L223.3 256l155-184.6z"></path>
                  </svg>
              </span>
              <?php if( get_field('title', 'options') ) { echo '<h3 id="info-popup-title">' . get_field('title', 'options') . '</h3>'; }?>
              <?php if( get_field('intro_text', 'options') ) { echo '<p>' . get_field('intro_text', 'options') . '</p>'; }?>
              <?php if( have_rows('info_links', 'options') ): ?>
                  <?php while( have_rows('info_links', 'options') ): the_row(); ?>
                      <div class="c-info-popup-links">
                          <?php if( get_sub_field('link_intro_text', 'options') ) { echo '<p>' . get_sub_field('link_intro_text', 'options') . '</p>'; }?>
                          <?php 
                          $link = get_sub_field('link', 'options');
                          if( $link ): 
                              $link_url = $link['url'];
                              $link_title = $link['title'];
                              $link_target = $link['target'] ? $link['target'] : '_self';
                          ?>
                              <a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                          <?php endif; ?>
                      </div>
                  <?php endwhile; ?>
              <?php endif; ?>
          </div>
      <?php endif; ?>
  <?php endif; ?>
  <!-- / info popup -->


  <?php get_template_part( 'template-part/navigation/nav-modal' ); ?>

  <!-- all js scripts are loaded in lib/gdt-enqueues.php -->
  <?php wp_footer(); ?>


<script type='text/javascript'>
piAId = '1089472';
piCId = '';
piHostname = 'secure.plixer.com';
 
(function() {
	function async_load(){
		var s = document.createElement('script'); s.type = 'text/javascript';
		s.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + piHostname + '/pd.js';
		var c = document.getElementsByTagName('script')[0]; c.parentNode.insertBefore(s, c);
	}
	if(window.attachEvent) { window.attachEvent('onload', async_load); }
	else { window.addEventListener('load', async_load, false); }
})();
</script>

</body>
</html>
