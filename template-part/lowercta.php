<?php
  $posts = get_field('selector');
  if( $posts ): ?>
      <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
        <div class="c-lower-cta">
          <div class="o-wrapper">
            <div class="lower-cta__content">
              <!-- Left Column: Text and Button -->
              <div class="lower-cta__text">
                <?php if( get_field('cta_title') ) { echo '<h2 class="h1-style">' . get_field('cta_title') . '</h2>'; }?>
                <?php if( get_field('cta_text') ) { echo '<p>' . get_field('cta_text') . '</p>'; }?>
                <?php if( get_field('field') ) { echo '<p>' . get_field('field') . '</p>'; }?>
                
                <?php 
                $link = get_field('cta_link');
                if( $link ): 
                    $link_url = $link['url'];
                    $link_title = $link['title'];
                    $link_target = $link['target'] ? $link['target'] : '_self';
                ?>
                    <div class="c-btn-primary c-btn-purple"><a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a></div>
                <?php endif; ?>
              </div>

              <!-- Right Column: Image -->
              <div class="lower-cta__image">
                <div class="c-header-img-clip">
                  <?php 
                    $image = get_field('cta_image');
                    if( $image ): 
                      echo wp_get_attachment_image( $image, 'full' );
                    else:
                      // Default image if none selected
                      echo '<img src="' . get_template_directory_uri() . '/img/cta.jpg" alt="' . esc_attr(get_field('cta_title')) . '" />';
                    endif; 
                  ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        
    <?php endforeach; ?>
    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
  <?php endif; ?> 