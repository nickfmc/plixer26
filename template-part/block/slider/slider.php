<?php

/**
 * blockname Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'c-logoslider-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'c-logoslider';
if( !empty($block['className']) ) {
    $className .= ' ' . $block['className'];
}
if( !empty($block['align']) ) {
    $className .= ' align' . $block['align'];
}
if( $is_preview ) {
    $className .= ' is-admin';
}


?>

 
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?> ">

<div class="splide">
  <div class="splide__track">
    <span class="c-top-left"></span>
    <span class="c-bottom-right"></span>
    <div class="splide__list">
      <?php if( have_rows('slides') ): ?>
       <?php while( have_rows('slides') ): the_row(); ?>
       <div class="splide__slide">
    <?php
    $image = get_sub_field('slide_image');
    $size = 'full';
    $image_width = get_sub_field('image_width');
    if($image){
        if($image_width){
            $style = 'width:' . $image_width . 'px;'; // Add style attribute if image_width is filled in
        } else {
            $style = '';
        }
        echo wp_get_attachment_image($image, $size, false, array('style' => $style));
    }
    ?>
</div>
      <?php if( get_field('image_width') ) { echo '<p>' . get_field('image_width') . '</p>'; }?>
      <?php endwhile; ?>
      <?php endif; ?>
    </div>
  </div>


  
</div>

</div>

<style>
  .my-slider-progress {
    background: #ccc;
  }

</style>
