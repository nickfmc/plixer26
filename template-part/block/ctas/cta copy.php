<?php

/**
 * fancy-divider Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'c-hp-ctas-' . $block['id'];
if( !empty($block['anchor']) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$className = 'c-hp-ctas';
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
<div id="<?php echo esc_attr($id); ?>" class="<?php echo esc_attr($className); ?>">

<div class="c-hp-cta">
    <span class="c-box-corner c-box-corner-tl"></span>
    <span class="c-box-corner c-box-corner-tr"></span>
    <span class="c-box-corner c-box-corner-bl"></span>
    <span class="c-box-corner c-box-corner-br"></span>
   
    <div class="c-hp-cta-inner">
        <div class="c-hp-cta-icon">
        <svg id="Capa_1" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 512 512">
  <!-- Generator: Adobe Illustrator 29.3.1, SVG Export Plug-In . SVG Version: 2.1.0 Build 151)  -->
  <defs>
    <style>
      .st0 {
        fill: #fff;
      }
    </style>
  </defs>
  <path class="st0" d="M512,52.8H0v316.3h512V52.8ZM132.7,105.7h30v30h-30v-30ZM76.2,105.7h30v30h-30v-30ZM435.8,226h-35.1c-6.7,25.7-13.4,45.2-20.4,59.3-3.8,7.7-15.2,31-35.6,31s-31.9-23.3-35.6-31c-6.9-14.1-13.6-33.6-20.4-59.3h-65.3c-6.7,25.7-13.4,45.2-20.4,59.3-3.8,7.7-15.2,31-35.6,31s-31.9-23.3-35.6-31c-6.9-14.1-13.6-33.6-20.4-59.3h-35.1v-30h123.8c6.7-25.7,13.4-45.2,20.4-59.3,3.8-7.7,15.2-31,35.6-31,20.4,0,31.9,23.3,35.6,31,6.9,14.1,13.6,33.6,20.4,59.3h123.8v30h0ZM349.3,135.7v-30h86.5v30h-86.5Z"/>
  <path class="st0" d="M167.3,285.5c3.3-3.1,12.6-15.1,24.9-59.5h-49.8c12.3,44.4,21.6,56.5,24.9,59.5h0Z"/>
  <path class="st0" d="M171,429.1h-38.3v30h246.6v-30h-38.3v-30h-170v30Z"/>
  <path class="st0" d="M256,136.5c-3.3,3.1-12.6,15.1-24.9,59.5h49.8c-12.3-44.4-21.6-56.5-24.9-59.5h0Z"/>
  <path class="st0" d="M344.7,285.5c3.3-3.1,12.6-15.1,24.9-59.5h-49.9c12.3,44.4,21.6,56.5,24.9,59.5h0Z"/>
</svg>
        </div>
        <h2>Collect</h2>
        <p>Aggregate network data across hybrid cloud and datacenter environments.<p>
        <p>Easily ingest NetFlow, IPFIX, SNMP, logs, and other data sources.</p>
        <!-- <div class="c-btn-newgreen">
            <a href="#">Learn More</a>
        </div> -->
    </div>
</div>


<div class="c-hp-cta">
    <span class="c-box-corner c-box-corner-tl"></span>
    <span class="c-box-corner c-box-corner-tr"></span>
    <span class="c-box-corner c-box-corner-bl"></span>
    <span class="c-box-corner c-box-corner-br"></span>
   
    <div class="c-hp-cta-inner">
        <div class="c-hp-cta-icon">
        <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 512 512">
  <!-- Generator: Adobe Illustrator 29.3.1, SVG Export Plug-In . SVG Version: 2.1.0 Build 151)  -->
  <defs>
    <style>
      .st0 {
        fill: #fff;
      }
    </style>
  </defs>
  <path class="st0" d="M140.6,236.2c0,9.8-8,17.8-17.8,17.8s-17.8-8-17.8-17.8,8-17.8,17.8-17.8,17.8,8,17.8,17.8ZM179.4,160.5c0,9.8,8,17.8,17.8,17.8s17.8-8,17.8-17.8-8-17.8-17.8-17.8-17.8,8-17.8,17.8ZM271.7,218.4c-9.8,0-17.8,8-17.8,17.8s8,17.8,17.8,17.8,17.8-8,17.8-17.8-8-17.8-17.8-17.8ZM298.6,219.2c3.1,4.9,4.9,10.7,4.9,17,0,17.6-14.3,31.8-31.8,31.8s-31.8-14.3-31.8-31.8,1.9-12.2,5.1-17.2l-30.9-31.5c-4.9,3.1-10.6,4.8-16.8,4.8s-11.9-1.8-16.8-4.8l-31,31.4c3.2,5,5.1,10.9,5.1,17.2,0,17.6-14.3,31.8-31.8,31.8s-31.8-14.3-31.8-31.8,14.3-31.8,31.8-31.8,11.9,1.8,16.8,4.8l31-31.5c-3.2-5-5.1-10.9-5.1-17.2,0-17.5,14.3-31.8,31.8-31.8s31.8,14.3,31.8,31.8-1.9,12.2-5.1,17.2l30.9,31.5c4.9-3,10.6-4.8,16.8-4.8s12.1,1.8,17,4.9l28.1-28.1c-14.3-52.6-62.5-91.4-119.6-91.4s-124,55.6-124,124,55.6,124,124,124,124-55.6,124-124-.4-10.8-1-16.1l-21.5,21.5ZM320.8,337.3c49-49,62.8-120.2,41.3-181.6l-29.8,29.8c1.9,9.1,2.9,18.5,2.9,28.2,0,76.1-61.9,138-138,138S59.3,289.8,59.3,213.7,121.2,75.8,197.3,75.8s112.5,39.5,130.8,94.2l28.4-28.4c-8.4-18.7-20.3-36.2-35.6-51.5-68.1-68.1-179-68.1-247.2,0-68.1,68.1-68.1,179,0,247.2,33,33,76.9,51.2,123.6,51.2s90.6-18.2,123.6-51.2h0ZM401.4,116.4c4,2.3,8.6,3.7,13.6,3.7,15,0,27.1-12.2,27.1-27.1s-12.2-27.2-27.1-27.2-27.1,12.2-27.1,27.2,1.3,9.6,3.6,13.6l-35.1,35.1c2.1,4.6,4,9.4,5.7,14.1l39.3-39.3h0ZM314.8,22h20.3c3.9,0,7-3.1,7-7s-3.1-7-7-7h-20.3c-3.9,0-7,3.1-7,7s3.1,7,7,7ZM362.5,22h72.7c3.9,0,7-3.1,7-7s-3.1-7-7-7h-72.7c-3.9,0-7,3.1-7,7s3.1,7,7,7ZM314.8,45.2h120.4c3.9,0,7-3.1,7-7s-3.1-7-7-7h-120.4c-3.9,0-7,3.1-7,7s3.1,7,7,7ZM314.8,68.5h65.2c3.9,0,7-3.1,7-7s-3.1-7-7-7h-65.2c-3.9,0-7,3.1-7,7s3.1,7,7,7ZM98.1,416.8c-3.9,0-7,3.1-7,7s3.1,7,7,7h7.5c3.9,0,7-3.1,7-7s-3.1-7-7-7h-7.5ZM205.7,416.8h-72.7c-3.9,0-7,3.1-7,7s3.1,7,7,7h72.7c3.9,0,7-3.1,7-7s-3.1-7-7-7ZM205.7,440.1h-107.8c-3.9,0-7,3.1-7,7s3.1,7,7,7h107.8c3.9,0,7-3.1,7-7s-3.1-7-7-7ZM156.3,463.3h-58.4c-3.9,0-7,3.1-7,7s3.1,7,7,7h58.4c3.9,0,7-3.1,7-7s-3.1-7-7-7ZM476.8,432l-82.4-82.4-59.7,59.7,82.4,82.4c8.2,8.2,19,12.3,29.8,12.3s21.6-4.1,29.8-12.3c7.9-7,12.4-16.9,12.7-27.9.4-11.9-4.2-23.5-12.6-31.9h0ZM384.2,339.4c0,0,0,0-.2-.1l-29.8-20.6c-6.7,10.1-14.6,19.7-23.4,28.6-8.3,8.3-17.2,15.7-26.6,22.2l20.3,29.4h0s0,0,0,0c0,0,0,.1.1.2,0,.1.2.2.3.3l59.7-59.7c-.1-.1-.2-.2-.3-.3h0Z"/>
</svg>
        </div>
        <h2>Analyze</h2>
        <p>Examine real-time and historical data with analytics and AI/ML algorithms.</p>
        <p>Train models to proactively detect congestion, anomalies, and threats.</p>
        <!-- <div class="c-btn-newgreen">
            <a href="#">Learn More</a>
        </div> -->
    </div>

</div>



<div class="c-hp-cta">
    <span class="c-box-corner c-box-corner-tl"></span>
    <span class="c-box-corner c-box-corner-tr"></span>
    <span class="c-box-corner c-box-corner-bl"></span>
    <span class="c-box-corner c-box-corner-br"></span>
   
    <div class="c-hp-cta-inner">
        <div class="c-hp-cta-icon">
        <svg id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" viewBox="0 0 448 448">
  <!-- Generator: Adobe Illustrator 29.3.1, SVG Export Plug-In . SVG Version: 2.1.0 Build 151)  -->
  <defs>
    <style>
      .st0 {
        fill: #fff;
      }
    </style>
  </defs>
  <path class="st0" d="M288,216c-4.8,0-8,3.2-8,8v24c0,4.8-3.2,8-8,8s-8-3.2-8-8v-32c0-4.8-3.2-8-8-8s-8,3.2-8,8v24c0,4.8-3.2,8-8,8s-8-3.2-8-8v-32c0-4.8-3.2-8-8-8s-8,3.2-8,8v24c0,4.8-3.2,8-8,8s-8-3.2-8-8v-88c0-2.4-.8-4-2.4-5.6-1.6-1.6-3.2-2.4-5.6-2.4-4.8,0-8,3.2-8,8v120c0,4.8-3.2,8-8,8s-8-3.2-8-8v-24c0-4.8-3.2-8-8-8s-8,3.2-8,8v56c0,40,32,72,72,72s72-32,72-72v-72c0-4.8-3.2-8-8-8Z"/>
  <path class="st0" d="M192,72c-35.2,0-64,28.8-64,64s16,49.6,40,59.2v-17.6c-7.2-4-13.6-10.4-17.6-17.6-13.6-23.2-5.6-52,17.6-65.6,23.2-13.6,52-5.6,65.6,17.6s5.6,52-17.6,65.6v8c5.6-1.6,11.2-1.6,16,0,15.2-12,24-30.4,24-49.6,0-35.2-28.8-64-64-64Z"/>
  <path class="st0" d="M216,115.2c-12-13.6-32-14.4-44.8-3.2-13.6,12-14.4,32-3.2,44.8v-12.8c0-13.6,10.4-24,24-24s24,10.4,24,24v12.8c10.4-12,10.4-29.6,0-41.6Z"/>
  <path class="st0" d="M224,0C100,0,0,100,0,224s100,224,224,224,224-100,224-224S348,0,224,0ZM312,296c0,48.8-39.2,88-88,88s-88-39.2-88-88v-56c0-13.6,10.4-24,24-24s5.6.8,8,1.6v-4.8c-12.8-4-24.8-11.2-33.6-20.8-30.4-32-29.6-82.4,2.4-112.8,32-30.4,82.4-29.6,112.8,2.4s29.6,82.4-2.4,112.8c10.4-4,23.2,0,28.8,9.6,3.2-2.4,8-3.2,12-3.2,13.6,0,24,10.4,24,24v71.2Z"/>
</svg>
        </div>
        <h2>Respond</h2>
        <p>Activate timely responses, NetOps workflows, and SecOps playbooks.</p>
        <p>Trigger remediation and policy enforcement with integrated IT tools.</p>
        <!-- <div class="c-btn-newgreen">
            <a href="#">Learn More</a>
        </div> -->
    </div>

</div>


<div class="c-hp-cta">
    <span class="c-box-corner c-box-corner-tl"></span>
    <span class="c-box-corner c-box-corner-tr"></span>
    <span class="c-box-corner c-box-corner-bl"></span>
    <span class="c-box-corner c-box-corner-br"></span>
   
    <div class="c-hp-cta-inner">
        <div class="c-hp-cta-icon">
        <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 512 512">
  <!-- Generator: Adobe Illustrator 29.3.1, SVG Export Plug-In . SVG Version: 2.1.0 Build 151)  -->
  <defs>
    <style>
      .st0 {
        fill: #fff;
        fill-rule: evenodd;
      }
    </style>
  </defs>
  <path class="st0" d="M504,117.1v269.2c0,11.3-9.2,20.5-20.5,20.5h-57.3v-146c0-12.7-10.3-23-23-23h-32.2c-12.7,0-23,10.3-23,23v146h-7.6v-102.4c0-12.7-10.3-23-23-23h-32.2c-12.7,0-23,10.3-23,23v102.4h-7.6v-53.9c0-12.7-10.3-23-23-23h-32.2c-12.7,0-23,10.3-23,23v53.9h-7.6v-7.5c0-12.7-10.3-23-23-23h-32.2c-12.7,0-23,10.3-23,23v7.5H28.5c-11.3,0-20.5-9.2-20.5-20.5V117.1h496ZM152.9,399.4c0-3.9-3.1-7-7-7h-32.2c-3.9,0-7,3.1-7,7v74.6c0,3.9,3.1,7,7,7h32.2c3.9,0,7-3.1,7-7v-74.6ZM192.4,474c0,3.9,3.1,7,7,7h32.2c3.9,0,7-3.1,7-7v-121.1c0-3.9-3.1-7-7-7h-32.2c-3.9,0-7,3.1-7,7v121.1ZM278.2,474c0,3.9,3.1,7,7,7h32.2c3.9,0,7-3.1,7-7v-169.5c0-3.9-3.1-7-7-7h-32.2c-3.9,0-7,3.1-7,7v169.5ZM410.2,474v-213.2c0-3.9-3.1-7-7-7h-32.2c-3.9,0-7,3.1-7,7v213.2c0,3.9,3.1,7,7,7h32.2c3.9,0,7-3.1,7-7ZM28.5,31h454.9c11.3,0,20.5,9.2,20.5,20.5v49.6H8v-49.6c0-11.3,9.2-20.5,20.5-20.5h0ZM73.9,58.1c-6.6,0-12,5.4-12,12s5.4,12,12,12,12-5.4,12-12-5.4-12-12-12ZM166,58.1c-6.6,0-12,5.4-12,12s5.4,12,12,12,12-5.4,12-12-5.4-12-12-12ZM119.9,58.1c-6.6,0-12,5.4-12,12s5.4,12,12,12,12-5.4,12-12-5.4-12-12-12ZM373.7,164.1l14.5-.8c-43.8,38.5-89.6,70.3-135.7,96.6-51.2,29.2-103,51.7-153.2,69.2-4.2,1.5-6.4,6-4.9,10.2s6,6.4,10.2,4.9c51.1-17.8,103.7-40.7,155.8-70.4,47.2-26.9,94-59.5,138.8-98.9l-2.1,14.7c-.6,4.4,2.4,8.4,6.8,9s8.4-2.4,9-6.8l5.3-36.6h0c0-.5,0-1,0-1.5-.2-4.4-4-7.8-8.4-7.6l-36.9,2c-4.4.2-7.8,4-7.6,8.4.2,4.4,4,7.8,8.4,7.6h0ZM112,189.3c-17.7,0-32,14.3-32,32s14.3,32,32,32,32-14.3,32-32-14.3-32-32-32ZM124,161l-4.7-12.1h-14.5l-4.7,12.1c-8.1,1.6-15.7,4.8-22.3,9.3l-11.9-5.3-10.2,10.2,5.3,11.9c-4.5,6.6-7.7,14.2-9.3,22.3l-12.1,4.7v14.5l12.1,4.7c1.6,8.1,4.8,15.7,9.3,22.3l-5.3,11.9,10.2,10.2,11.9-5.3c6.6,4.5,14.2,7.7,22.3,9.2l4.7,12.1h14.5l4.7-12.1c8.1-1.6,15.7-4.8,22.3-9.3l11.9,5.3,10.2-10.2-5.3-11.9c4.5-6.6,7.7-14.2,9.2-22.3l12.1-4.7v-14.5l-12.1-4.7c-1.6-8.1-4.8-15.7-9.3-22.3l5.3-11.9-10.2-10.2-11.9,5.3c-6.6-4.5-14.2-7.7-22.3-9.3h0Z"/>
</svg>
        </div>
        <h2>Optimize</h2>
        <p>Consolidate tools, reduce tasks, and maximize IT stack effectiveness.</p>
        <p>Ensure precision detection, planning, and response with less effort.</p>
        <!-- <div class="c-btn-newgreen">
            <a href="#">Learn More</a>
        </div> -->
    </div> 

</div>

</div>
