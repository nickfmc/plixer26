<?php get_header(); ?>

<div class="o-layout-row o-poly-header-bright">
  <div class="o-wrapper-wide"><h1>
  <?php
$term = get_queried_object();
$termName = $term->name; // Get the term name
?>
  Plixer <span class="u-green"><?php echo $termName; ?></span></div></h1>
</div>

<div class="o-layout-row o-dark-wave-poly u-dark ">
  <main class="o-wrapper-wide" role="main" itemscope itemprop="mainContentOfPage" itemtype="https://schema.org/WebPageElement">




  <div class="editor-content c-main-posts clearfix">



<div class="c-post-filters">
<div class="c-post-filter-titles">
  <a href="/resources/">View all Resources</a>

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



    <!-- if resource-type term equals webinars -->
    <?php if ( is_tax( 'resource-type', 'webinars' ) ) { ?>
      <div class="c-upcoming-webinars-wrapper">
      <h5>Upcoming Webinars</h5>
  
      <?php 
date_default_timezone_set('America/New_York'); // Set your timezone
$current_date = date('Y-m-d H:i:s'); // Get current date and time
if( have_rows('upcoming_webinars', 'options') ): 
echo '<div class="c-upcoming-webinars">';
  $webinar_count = 0; // Initialize counter
        
        while( have_rows('upcoming_webinars', 'options') ): the_row(); 
       
        $webinar_date = get_sub_field('webinar_date'); // Get webinar date
      ?>
      
<?php 
        // Get webinar date
        $webinar_date = get_sub_field('webinar_date');

        // Create DateTime object from webinar date in UTC
        $webinar_date_obj = new DateTime($webinar_date, new DateTimeZone('UTC'));

        // Convert webinar date to 'America/New_York' timezone
        $webinar_date_obj->setTimezone(new DateTimeZone('America/New_York'));

        // Now you can compare $webinar_date_obj with $current_date_obj
        if($webinar_date_obj > $current_date_obj):
    ?>
        <div class="c-upcoming-webinar-item">
            <h6><?php echo get_sub_field('webinar_title'); ?></h6>
            <p><?php echo $webinar_date_obj->format('F j, Y g:i a'); ?> EST</p>
            <?php if( get_sub_field('registration_link') ) { echo '<a target="_blank" class="c-upcoming-webinar-link" href="' . get_sub_field('registration_link') . '">Register Now <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512"><!--!Font Awesome Pro 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc.--><path d="M336 0c-8.8 0-16 7.2-16 16s7.2 16 16 16H457.4L212.7 276.7c-6.2 6.2-6.2 16.4 0 22.6s16.4 6.2 22.6 0L480 54.6V176c0 8.8 7.2 16 16 16s16-7.2 16-16V16c0-8.8-7.2-16-16-16H336zM64 32C28.7 32 0 60.7 0 96V448c0 35.3 28.7 64 64 64H416c35.3 0 64-28.7 64-64V304c0-8.8-7.2-16-16-16s-16 7.2-16 16V448c0 17.7-14.3 32-32 32H64c-17.7 0-32-14.3-32-32V96c0-17.7 14.3-32 32-32H208c8.8 0 16-7.2 16-16s-7.2-16-16-16H64z"/></svg></a>'; }?>
        </div>
    <?php 
    $webinar_count++; // Increment counter
        endif;
        endwhile; 
        if($webinar_count == 0) {
          echo '<p class="u-text-center">There are no upcoming webinars at this time.</p>';

      }
    ?>
    </div>
<?php endif; ?>

<?php if( !have_rows('upcoming_webinars', 'options') ): 

  echo '<p class="u-text-center">There are no upcoming webinars at this time.</p>';

endif; ?>

    </div>
  <?php } ;?>



<div class="c-post-grid">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <article <?php post_class('c-post-card'); ?> role="article" itemscope itemtype="https://schema.org/BlogPosting">
            <a href="<?php the_permalink()?>"></a>
              <?php the_post_thumbnail('large'); ?> 
                
                <div class="c-card__content">
                          <h4><?php the_title(); ?></h4>
                          <!-- the excerpt -->
                          <p class="c-card__content-excerpt"><?php echo gdt_excerpt(25); ?>...</p>
                          <span><time datetime="<?php the_time('Y-m-d'); ?>" itemprop="datePublished"><?php the_time('d F y'); ?></time></span>
                              
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
