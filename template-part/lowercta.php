<?php
  $posts = get_field('selector');
  if( $posts ): ?>
      <?php foreach( $posts as $post): // variable must be called $post (IMPORTANT) ?>
        <?php if( !get_field('cta_type') == 'hubspot' ): ?>
        <div class="c-lower-cta lower-cta--hubspot ">
          <div class="o-wrapper-narrow">
            <?php if( get_field('cta_title') ) { echo '<h3 class="h1-style">' . get_field('cta_title') . '</h3>'; }?>
            <?php if( get_field('cta_text') ) { echo '<p>' . get_field('cta_text') . '</p>'; }?>
            <?php if( get_field('field') ) { echo '<p>' . get_field('field') . '</p>'; }?>
           
                <?php 
$link = get_field('cta_link');
if( $link ): 
    $link_url = $link['url'];
    $link_title = $link['title'];
    $link_target = $link['target'] ? $link['target'] : '_self';
    ?>
     <div class="c-btn-primary c-btn-purple"><a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a></div>
<?php endif; ?>
         
          </div>
        </div>
        <?php endif; ?>

        <?php if( get_field('cta_type') == 'hubspot' ): ?>
            <div class="c-lower-cta lower-cta--hubspot ">
                <div class="o-wrapper-narrow">
                    <?php if( get_field('cta_title') ) { echo '<h3 class="h1-style">' . get_field('cta_title') . '</h3>'; }?>
                    <?php if( get_field('cta_text') ) { echo '<p>' . get_field('cta_text') . '</p>'; }?>
                    <?php if( get_field('hubspot_code_lcta') ) { echo get_field('hubspot_code_lcta'); }?>
                </div>
            </div>
        <?php elseif( get_field('cta_type') == 'standard' ): ?>
            <div class="c-lower-cta lower-cta--standard">
                <div class="o-wrapper-narrow">
                    <?php if( get_field('cta_title') ) { echo '<h3 class="h1-style">' . get_field('cta_title') . '</h3>'; }?>
                    <?php if( get_field('cta_text') ) { echo '<p>' . get_field('cta_text') . '</p>'; }?>
                    <?php 
                    $link = get_field('cta_link');
                    if( $link ): 
                        $link_url = $link['url'];
                        $link_title = $link['title'];
                        $link_target = $link['target'] ? $link['target'] : '_self';
                    ?>
                        <div class="c-btn-primary c-btn-purple"><a href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>"><?php echo esc_html($link_title); ?></a>
                    <?php endif; ?>
                </div>
            </div>
            </div>
        <?php endif; ?>
        
    <?php endforeach; ?>
    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
  <?php endif; ?> 