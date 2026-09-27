<?php
// ***************************  Brought over from past site

// disable google fonts
add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );

// ***************************  Brought over from past site
// update '1' to the ID of your form
add_filter( 'gform_pre_render_1', 'add_readonly_script' );
function add_readonly_script( $form ) {
    ?>
    <script type="text/javascript">
        jQuery(document).on('gform_post_render', function(){
            /* apply only to a input with a class of gf_readonly */
            jQuery(".gf_readonly input").attr("readonly","readonly");
        });
    </script>
    <?php
    return $form;
}

// update '2' to the ID of your form
add_filter( 'gform_pre_render_2', 'add_readonly_script_2' );
function add_readonly_script_2( $form ) {
    ?>
    <script type="text/javascript">
        jQuery(document).on('gform_post_render', function(){
            /* apply only to a input with a class of gf_readonly */
            jQuery(".gf_readonly input").attr("readonly","readonly");
        });
    </script>
    <?php
    return $form;
}

/*
 * to prevent the OneTrust cookie management script from appearing
 * on dev sites, only apply the script when publishing
 * https://developers.strattic.com/doc/check-for-preview-or-live-headers/
 */

// add_action(
//   'wp_head',
//   function () {
//       $headers = getallheaders();
//       if (isset($headers['publishType'])) {
//           echo '
//           <!-- OneTrust Cookies Consent Notice start for www.plixer.com -->
//           <script src="https://cdn.cookielaw.org/scripttemplates/otSDKStub.js"  type="text/javascript" charset="UTF-8" data-domain-script="a362e790-193e-4572-9a11-b2a3fe84988f" ></script>
//           <script type="text/javascript">
//               function OptanonWrapper() { }
//           </script>
//           <!-- OneTrust Cookies Consent Notice end for www.plixer.com -->

//           <!-- Google Tag Manager -->
//           <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({\'gtm.start\':
//           new Date().getTime(),event:\'gtm.js\'});var f=d.getElementsByTagName(s)[0],
//           j=d.createElement(s),dl=l!=\'dataLayer\'?\'&l=\'+l:\'\';j.async=true;j.src=
//           \'https://www.googletagmanager.com/gtm.js?id=\'+i+dl;f.parentNode.insertBefore(j,f);
//           })(window,document,\'script\',\'dataLayer\',\'GTM-5P2SGJX\');</script>
//           <!-- End Google Tag Manager -->

//           ';
//       }
//   }
// );

// add_action(
//   'wp_body_open',
//   function () {
//       $headers = getallheaders();
//       if (isset($headers['publishType'])) {
//           echo '
//           <!-- Start of HubSpot Embed Code --> <script type="text/javascript" id="hs-script-loader" async defer src="//js.hs-scripts.com/159093.js"></script> <!-- End of HubSpot Embed Code -->
          
//           <!-- Start of ZoomInfo WebSights-->
//           <noscript><img src="https://ws.zoominfo.com/pixel/jeupLiFDTWErtqGVMGAu" width="1" height="1" style="display: none;" /></noscript>
//           <!-- End of ZoomInfo WebSights-->

//           <!-- Google Tag Manager (noscript) -->
//           <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5P2SGJX"
//           height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
//           <!-- End Google Tag Manager (noscript) -->
//           ';
//       }
//   }
// );

/*
 * don't empty the trash automatically
 * we want to keep old, deleted posts in the trash as a backup 
 * should we need to restore them
*/
function wpb_remove_schedule_delete() {
  remove_action( 'wp_scheduled_delete', 'wp_scheduled_delete' );
}
add_action( 'init', 'wpb_remove_schedule_delete' );

# remove decimals for currency in Gravity Forms
add_filter( 'gform_currencies', function( $currencies ) {
  GFCommon::log_debug( __METHOD__ . '(): running.' );
  // Set decimals allowed for USD to 0.
  $currencies['USD']['decimals'] = 0;
  return $currencies;
} );





add_action( 'wp', function() {
    add_filter( 'generateblocks_media_query', function( $query ) {
        $query['desktop'] = '(min-width: 1401px)';
        $query['tablet'] = '(max-width: 1400px)';
        $query['tablet_only'] = '(max-width: 1400px) and (min-width: 980px)';
        $query['mobile'] = '(max-width: 980px)';

        return $query;
    } );
}, 20 );


// add_filter( 'strattic_enable_search_menu', '__return_true' );

/**
 * Custom functions for this project? If yes, drop them here!
 */

  // If using acf icon picker - https://github.com/houke/acf-icon-picker -  modify the path to the icons directory
//   add_filter( 'acf_icon_path_suffix', 'acf_icon_path_suffix' );

//   function acf_icon_path_suffix( $path_suffix ) {
//       return 'img/icons/';
//   }
  
//used for Stackable blocks support - match to wrapper width 
global $content_width;
$content_width = 920;

/**
 * Disable Yoast SEO schema output when custom schema field is populated
 * This prevents duplicate schema markup on pages
 */
function plixer_disable_yoast_schema_when_custom_exists( $data ) {
    // Only run on singular pages/posts
    if ( ! is_singular() ) {
        return $data;
    }
    
    // Check if ACF function exists and if custom schema field has content
    if ( function_exists( 'get_field' ) ) {
        $schema_markup = get_field( 'schema_json_ld' );
        
        // If custom schema exists, disable Yoast's schema
        if ( ! empty( trim( $schema_markup ) ) ) {
            return false;
        }
    }
    
    return $data;
}
add_filter( 'wpseo_json_ld_output', 'plixer_disable_yoast_schema_when_custom_exists', 10, 1 );

/**
 * Output Schema JSON-LD markup in the page head
 * Uses ACF field 'schema_json_ld' from the current page/post
 */
function plixer_output_schema_markup() {
    // Only run on singular pages/posts
    if ( ! is_singular() ) {
        return;
    }
    
    // Check if ACF function exists and get the field value
    if ( function_exists( 'get_field' ) ) {
        $schema_markup = get_field( 'schema_json_ld' );
        
        // Output the schema if it exists and is not empty
        if ( ! empty( $schema_markup ) ) {
            // Trim whitespace
            $schema_markup = trim( $schema_markup );
            
            // Validate it's valid JSON (optional but recommended)
            $is_valid_json = json_decode( $schema_markup );
            
            if ( $is_valid_json !== null ) {
                echo "\n<!-- Custom Schema.org JSON-LD Markup (Yoast schema disabled) -->\n";
                echo '<script type="application/ld+json">' . "\n";
                echo $schema_markup . "\n";
                echo '</script>' . "\n";
            }
        }
    }
}
add_action( 'wp_head', 'plixer_output_schema_markup', 99 );

/**
 * Disable Yoast SEO schema on specific resource-type taxonomy archive pages
 */
function plixer_disable_yoast_schema_for_resource_type_archives( $data ) {
    $targeted_terms = array( 'data-sheet', 'webinars', 'case-study', 'whitepaper' );

    if ( is_tax( 'resource-type' ) ) {
        $term = get_queried_object();
        if ( $term && isset( $term->slug ) && in_array( $term->slug, $targeted_terms, true ) ) {
            return false;
        }
    }

    return $data;
}
add_filter( 'wpseo_json_ld_output', 'plixer_disable_yoast_schema_for_resource_type_archives', 10, 1 );

/**
 * Output Schema JSON-LD markup for specific resource-type taxonomy archive pages
 * Covers: data-sheet, webinars, case-study, whitepaper
 */
function plixer_output_resource_type_schema() {
    if ( ! is_tax( 'resource-type' ) ) {
        return;
    }

    $term = get_queried_object();
    if ( ! $term || ! isset( $term->slug ) ) {
        return;
    }

    switch ( $term->slug ) {
        case 'data-sheet':
            $schema = <<<'JSON'
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "https://www.plixer.com/#organization",
      "name": "Plixer",
      "url": "https://www.plixer.com/",
      "logo": {
        "@type": "ImageObject",
        "url": "https://www.plixer.com/wp-content/uploads/plixer-logo.png"
      },
      "description": "Plixer provides network observability, performance monitoring, and security analytics solutions.",
      "sameAs": [
        "https://twitter.com/plixer",
        "https://www.youtube.com/plixerweb",
        "https://www.linkedin.com/company/plixer"
      ]
    },
    {
      "@type": "WebSite",
      "@id": "https://www.plixer.com/#website",
      "url": "https://www.plixer.com/",
      "name": "Plixer",
      "publisher": {
        "@id": "https://www.plixer.com/#organization"
      },
      "inLanguage": "en-US"
    },
    {
      "@type": "CollectionPage",
      "@id": "https://www.plixer.com/resource-type/data-sheet/#webpage",
      "url": "https://www.plixer.com/resource-type/data-sheet/",
      "name": "Data Sheets Archives \u2013 Plixer",
      "description": "Browse Plixer data sheets for product overviews, specifications, and related network observability and security resources.",
      "isPartOf": {
        "@id": "https://www.plixer.com/#website"
      },
      "about": {
        "@id": "https://www.plixer.com/#organization"
      },
      "breadcrumb": {
        "@id": "https://www.plixer.com/resource-type/data-sheet/#breadcrumb"
      },
      "inLanguage": "en-US"
    },
    {
      "@type": "BreadcrumbList",
      "@id": "https://www.plixer.com/resource-type/data-sheet/#breadcrumb",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "https://www.plixer.com/"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Resources",
          "item": "https://www.plixer.com/resources/"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "Data Sheets",
          "item": "https://www.plixer.com/resource-type/data-sheet/"
        }
      ]
    }
  ]
}
JSON;
            break;

        case 'webinars':
            $schema = <<<'JSON'
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "https://www.plixer.com/#organization",
      "name": "Plixer",
      "url": "https://www.plixer.com/",
      "logo": {
        "@type": "ImageObject",
        "url": "https://www.plixer.com/wp-content/uploads/plixer-logo.png"
      },
      "description": "Plixer provides network observability, performance monitoring, and security analytics solutions.",
      "sameAs": [
        "https://twitter.com/plixer",
        "https://www.youtube.com/plixerweb",
        "https://www.linkedin.com/company/plixer"
      ]
    },
    {
      "@type": "WebSite",
      "@id": "https://www.plixer.com/#website",
      "url": "https://www.plixer.com/",
      "name": "Plixer",
      "publisher": {
        "@id": "https://www.plixer.com/#organization"
      },
      "inLanguage": "en-US"
    },
    {
      "@type": "CollectionPage",
      "@id": "https://www.plixer.com/resource-type/webinars/#webpage",
      "url": "https://www.plixer.com/resource-type/webinars/",
      "name": "Webinars Archives \u2013 Plixer",
      "description": "Browse Plixer webinars covering network observability, security operations, analytics, and performance monitoring topics.",
      "isPartOf": {
        "@id": "https://www.plixer.com/#website"
      },
      "about": {
        "@id": "https://www.plixer.com/#organization"
      },
      "breadcrumb": {
        "@id": "https://www.plixer.com/resource-type/webinars/#breadcrumb"
      },
      "inLanguage": "en-US"
    },
    {
      "@type": "BreadcrumbList",
      "@id": "https://www.plixer.com/resource-type/webinars/#breadcrumb",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "https://www.plixer.com/"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Resources",
          "item": "https://www.plixer.com/resources/"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "Webinars",
          "item": "https://www.plixer.com/resource-type/webinars/"
        }
      ]
    }
  ]
}
JSON;
            break;

        case 'case-study':
            $schema = <<<'JSON'
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "https://www.plixer.com/#organization",
      "name": "Plixer",
      "url": "https://www.plixer.com/",
      "logo": {
        "@type": "ImageObject",
        "url": "https://www.plixer.com/wp-content/uploads/plixer-logo.png"
      },
      "description": "Plixer provides network observability, performance monitoring, and security analytics solutions.",
      "sameAs": [
        "https://twitter.com/plixer",
        "https://www.youtube.com/plixerweb",
        "https://www.linkedin.com/company/plixer"
      ]
    },
    {
      "@type": "WebSite",
      "@id": "https://www.plixer.com/#website",
      "url": "https://www.plixer.com/",
      "name": "Plixer",
      "publisher": {
        "@id": "https://www.plixer.com/#organization"
      },
      "inLanguage": "en-US"
    },
    {
      "@type": "CollectionPage",
      "@id": "https://www.plixer.com/resource-type/case-study/#webpage",
      "url": "https://www.plixer.com/resource-type/case-study/",
      "name": "Case Studies Archives \u2013 Plixer",
      "description": "Browse Plixer case studies showing how organizations use Plixer solutions to improve network visibility, reduce downtime, and strengthen security operations.",
      "isPartOf": {
        "@id": "https://www.plixer.com/#website"
      },
      "about": {
        "@id": "https://www.plixer.com/#organization"
      },
      "breadcrumb": {
        "@id": "https://www.plixer.com/resource-type/case-study/#breadcrumb"
      },
      "inLanguage": "en-US"
    },
    {
      "@type": "BreadcrumbList",
      "@id": "https://www.plixer.com/resource-type/case-study/#breadcrumb",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "https://www.plixer.com/"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Resources",
          "item": "https://www.plixer.com/resources/"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "Case Studies",
          "item": "https://www.plixer.com/resource-type/case-study/"
        }
      ]
    }
  ]
}
JSON;
            break;

        case 'whitepaper':
            $schema = <<<'JSON'
{
  "@context": "https://schema.org",
  "@graph": [
    {
      "@type": "Organization",
      "@id": "https://www.plixer.com/#organization",
      "name": "Plixer",
      "url": "https://www.plixer.com/",
      "logo": {
        "@type": "ImageObject",
        "url": "https://www.plixer.com/wp-content/uploads/plixer-logo.png"
      },
      "description": "Plixer provides network observability, performance monitoring, and security analytics solutions.",
      "sameAs": [
        "https://twitter.com/plixer",
        "https://www.youtube.com/plixerweb",
        "https://www.linkedin.com/company/plixer"
      ]
    },
    {
      "@type": "WebSite",
      "@id": "https://www.plixer.com/#website",
      "url": "https://www.plixer.com/",
      "name": "Plixer",
      "publisher": {
        "@id": "https://www.plixer.com/#organization"
      },
      "inLanguage": "en-US"
    },
    {
      "@type": "CollectionPage",
      "@id": "https://www.plixer.com/resource-type/whitepaper/#webpage",
      "url": "https://www.plixer.com/resource-type/whitepaper/",
      "name": "White Papers Archives \u2013 Plixer",
      "description": "Browse Plixer white papers covering network observability, security, analytics, and operational best practices.",
      "isPartOf": {
        "@id": "https://www.plixer.com/#website"
      },
      "about": {
        "@id": "https://www.plixer.com/#organization"
      },
      "breadcrumb": {
        "@id": "https://www.plixer.com/resource-type/whitepaper/#breadcrumb"
      },
      "inLanguage": "en-US"
    },
    {
      "@type": "BreadcrumbList",
      "@id": "https://www.plixer.com/resource-type/whitepaper/#breadcrumb",
      "itemListElement": [
        {
          "@type": "ListItem",
          "position": 1,
          "name": "Home",
          "item": "https://www.plixer.com/"
        },
        {
          "@type": "ListItem",
          "position": 2,
          "name": "Resources",
          "item": "https://www.plixer.com/resources/"
        },
        {
          "@type": "ListItem",
          "position": 3,
          "name": "White Papers",
          "item": "https://www.plixer.com/resource-type/whitepaper/"
        }
      ]
    }
  ]
}
JSON;
            break;

        default:
            return;
    }

    echo "\n<!-- Custom Schema.org JSON-LD Markup -->\n";
    echo '<script type="application/ld+json">' . "\n";
    echo $schema . "\n";
    echo '</script>' . "\n";
}
add_action( 'wp_head', 'plixer_output_resource_type_schema', 99 );

/************ RESOURCE HUB HELPERS *******************/

/**
 * Inline SVG icons for the Resource Hub anchor nav.
 * usage: echo plixer_hub_icon('news');
 */
function plixer_hub_icon( $name ) {
  $open  = '<svg class="c-hub-nav__icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 800" fill="currentColor" aria-hidden="true" focusable="false">';
  $close = '</svg>';

  switch ( $name ) {

    case 'article': // thought leadership
      $paths  = '<path d="M757.5,224.2l-54.3-54.3c-2.6-2.6-6.5-4.1-10.8-4.1s-8.2,1.5-10.8,4.1l-28.9,28.9,76,75.9,28.9-28.9c2.9-2.9,4.5-6.7,4.5-10.8s-1.5-7.9-4.5-10.8h0Z"/>';
      $paths .= '<path d="M664,158.3l-.7-1.6c-10.4-23.8-33.6-39.2-59.3-39.2H191.4c-35.8,0-65,29.1-65,65v93.6h419.7l117.9-117.9h0ZM182.6,209.6c0-5.7,4.6-10.3,10.3-10.3h25.6c5.7,0,10.3,4.6,10.3,10.3s-4.6,10.3-10.3,10.3h-25.6c-5.7,0-10.3-4.6-10.3-10.3ZM259.4,209.6c0-5.7,4.6-10.3,10.3-10.3h25.6c5.7,0,10.3,4.6,10.3,10.3s-4.6,10.3-10.3,10.3h-25.6c-5.7,0-10.3-4.6-10.3-10.3ZM372.1,219.9h-25.6c-5.7,0-10.3-4.6-10.3-10.3s4.6-10.3,10.3-10.3h25.6c5.7,0,10.3,4.6,10.3,10.3s-4.6,10.3-10.3,10.3Z"/>';
      $paths .= '<path d="M384.2,467.2c-5.4,5.4-9.2,12.2-10.9,19.7l-20.1,87.3,87.3-20.1c7.5-1.7,14.3-5.5,19.7-10.9l253.9-253.9-76-75.9-253.9,253.9h0Z"/>';
      $paths .= '<path d="M445.4,574.1l-103.6,23.9c-3.5.8-7.1-.2-9.6-2.8-2.5-2.5-3.6-6.1-2.8-9.6l23.9-103.4c2.6-11.2,8.3-21.5,16.4-29.7l155.9-155.9H126.4v324c0,35.8,29.1,65,65,65h412.7c35.8,0,65-29.1,65-65v-257.4l-194.3,194.3c-8.1,8.1-18.2,13.7-29.4,16.4h0Z"/>';
      break;

    case 'case-study':
      $paths  = '<path d="M740.9,628.5l-48-48c10.9-18.4,16.7-39.3,16.7-61.1,0-66.3-54-120.3-120.3-120.3s-120.3,54-120.3,120.3,54,120.3,120.3,120.3,42.7-5.8,61.1-16.7l48,48c5.9,5.9,13.6,8.8,21.2,8.8s15.4-2.9,21.2-8.8c11.7-11.7,11.7-30.8,0-42.5h0,0ZM657.5,500.1c-1.3.6-2.7.9-4,.9-3.9,0-7.5-2.2-9.2-6-6-13.6-16.8-24.4-30.4-30.4-5.1-2.2-7.3-8.1-5.1-13.2s8.2-7.4,13.2-5.1c18.1,8,32.6,22.5,40.6,40.6,2.2,5.1,0,11-5.1,13.2h0Z"/>';
      $paths .= '<path d="M529.2,218.7h74.3l-94.4-94.4v74.3c0,11.1,9,20.1,20,20.1Z"/>';
      $paths .= '<path d="M449,519.5c0-77.4,63-140.3,140.3-140.3s13.5.6,20,1.6v-142h-80.2c-22.1,0-40.1-18-40.1-40.1v-80.2H228.5c-22.1,0-40.1,18-40.1,40.1v481.2c0,22.1,18,40.1,40.1,40.1h340.8c15.1,0,28.1-8.5,34.9-20.8-4.9.5-9.9.8-14.9.8-77.4,0-140.3-63-140.3-140.3h0ZM368.8,208.7c0-5.5,4.5-10,10-10,49.8,0,90.2,40.5,90.2,90.2s-4.5,10-10,10h-80.2c-5.5,0-10-4.5-10-10v-80.2h0ZM398.9,599.7h-150.4c-5.5,0-10-4.5-10-10s4.5-10,10-10h150.4c5.5,0,10,4.5,10,10s-4.5,10-10,10ZM398.9,549.5h-150.4c-5.5,0-10-4.5-10-10s4.5-10,10-10h150.4c5.5,0,10,4.5,10,10s-4.5,10-10,10ZM398.9,499.4h-100.2c-5.5,0-10-4.5-10-10s4.5-10,10-10h100.2c5.5,0,10,4.5,10,10s-4.5,10-10,10ZM328.7,429.2c-49.8,0-90.2-40.5-90.2-90.2s40.5-90.2,90.2-90.2,10,4.5,10,10v70.2h70.2c5.5,0,10,4.5,10,10,0,49.8-40.5,90.2-90.2,90.2h0Z"/>';
      $paths .= '<path d="M388.9,219.5v59.4h59.4c-4.4-30.7-28.7-55-59.4-59.4h0Z"/>';
      $paths .= '<path d="M318.7,339v-69.4c-34,4.9-60.1,34.2-60.1,69.4s31.5,70.2,70.2,70.2,64.6-26.2,69.4-60.1h-69.4c-5.5,0-10-4.5-10-10h0Z"/>';
      break;

    case 'news':
      $paths  = '<path d="M661.8,417.4L366,121.4c-3-3-7.2-4.4-11.5-3.7-4.2.7-7.9,3.3-9.8,7.1l-218,424.5c-6.8,13.1-4.3,29,6.2,39.4l61.5,61.6c6.4,6.4,14.9,10,24,10s10.6-1.3,15.5-3.8l53-27.2,35.8,35.8c10.7,10.7,24.8,16.5,39.8,16.5s17.8-2.2,25.8-6.3l118.3-60.8c14.9-7.7,25.3-22.1,28-38.7,2.6-16.6-3-33.5-14.8-45.4l-13.7-13.7,152.5-78.3c3.8-1.9,6.4-5.6,7.1-9.8.7-4.2-.7-8.5-3.7-11.5h0ZM484.8,568.3c-.1.7-.5,1.3-1.2,1.7l-118.3,60.8c-2.3,1.2-5,.8-6.9-1.1l-24.3-24.3,125-64.2,25.1,25.2c.5.5.8,1.2.6,2h0ZM323.5,309.5l-113.9,199.5h0c-2.6,4.6-7.4,7.7-12.7,8.1-3.3.3-6.6-.5-9.4-2.1-7.8-4.5-10.5-14.4-6-22.2l113.9-199.5c2.2-3.8,5.7-6.5,9.9-7.6,1-.3,2-.4,3-.5,3.2-.3,6.5.4,9.4,2.1,7.8,4.5,10.5,14.4,6,22.2h0Z"/>';
      $paths .= '<path d="M695.3,279.2c-2.8-6.9-9.4-11.1-16.4-11.1s-4.4.4-6.5,1.3l-59.2,23.7c-9,3.6-13.5,13.9-9.8,23,2.7,6.8,9.2,11.1,16.4,11.1s4.5-.4,6.5-1.2l59.2-23.7c9-3.6,13.5-13.9,9.8-23h0Z"/>';
      $paths .= '<path d="M496.1,80c-2.1-.8-4.3-1.3-6.5-1.3s-4.7.5-7,1.4c-4.3,1.9-7.7,5.3-9.5,9.7l-23.7,59.2c-3.6,9.1.9,19.4,9.9,23h0c2.1.9,4.3,1.3,6.5,1.3,7.3,0,13.7-4.4,16.4-11.1l23.7-59.2c3.6-9-.8-19.3-9.9-23h0Z"/>';
      $paths .= '<path d="M691.5,83.9c-3.5-3.4-8-5.2-12.5-5.2s-9.1,1.7-12.5,5.2l-94.7,94.7c-6.9,6.9-6.9,18.1,0,25,3.3,3.3,7.8,5.2,12.5,5.2s9.2-1.8,12.5-5.2l94.7-94.7c6.9-6.9,6.9-18.1,0-25Z"/>';
      break;

    case 'webinar':
      $paths  = '<path fill-rule="evenodd" d="M202,174l28.6-18.6-28.6-18.6v37.2h0ZM253.9,163.8l-56.4,36.6c-4.6,2.9-10.6,1.7-13.6-2.9-1.1-1.6-1.6-3.5-1.6-5.4h0v-73.4c0-5.4,4.4-9.9,9.9-9.9s4.4.8,6,2l55.9,36.3c4.6,2.9,5.8,9.1,2.9,13.6-.8,1.2-1.9,2.3-3,3h0,0ZM433.1,322.6c-7.9-7.9-18.9-12.8-31-12.8s-23,4.9-31,12.8c-7.9,7.9-12.8,18.9-12.8,31s4.9,23,12.8,31c7.9,7.9,18.9,12.8,31,12.8s23-4.9,31-12.8c7.9-7.9,12.8-18.9,12.8-31s-4.9-23-12.8-31ZM680.8,530H119.9v29.6c0,2.2.9,4.1,2.3,5.6,1.4,1.4,3.4,2.3,5.6,2.3h545.2c2.2,0,4.1-.9,5.6-2.3s2.3-3.4,2.3-5.6v-29.6h0ZM671.5,227.4c5.4,0,9.9,4.4,9.9,9.9s-4.4,9.9-9.9,9.9h-146.1c-5.4,0-9.9-4.4-9.9-9.9s4.4-9.9,9.9-9.9h146.2,0ZM638.6,174c5.4,0,9.9,4.4,9.9,9.9s-4.4,9.9-9.9,9.9h-113.2c-5.4,0-9.9-4.4-9.9-9.9s4.4-9.9,9.9-9.9h113.2ZM534.3,324l55.7-34.1c1.6-1.2,3.6-1.8,5.7-1.8h110.7c1.9,0,3.6-.8,4.8-2s2-2.9,2-4.8v-141.5c0-1.9-.7-3.6-1.9-4.8s-2.9-2-4.8-2h-216.1c-1.9,0-3.6.8-4.8,2s-2,2.9-2,4.8v141.5c0,1.9.8,3.6,2,4.8s2.9,2,4.8,2h34.1c5.4,0,9.9,4.4,9.9,9.9v26.1h0ZM284.5,268.9l-56.3-34.5c-1.6-1-3.4-1.4-5.1-1.4h0s-110.7,0-110.7,0c-1.9,0-3.6-.8-4.8-2s-2-2.9-2-4.8V84.7c0-1.9.8-3.6,2-4.8s2.9-2,4.8-2h216.1c1.9,0,3.6.8,4.8,2s2,2.9,2,4.8v141.5c0,1.9-.8,3.6-2,4.8s-2.9,2-4.8,2h-34.1c-5.4,0-9.9,4.4-9.9,9.9v26.1h0ZM477.3,443.5c-11.8-15.4-28.1-27-46.9-32.9-8.5,4.2-18.1,6.6-28.3,6.6s-19.8-2.4-28.3-6.6c-18.8,5.9-35.1,17.6-46.9,32.9-12.2,16-19.5,35.9-19.5,57.4v9.4h189.4v-9.4c0-21.6-7.3-41.5-19.5-57.4h0ZM448.9,396.6c10.4-11.3,16.7-26.4,16.7-43s-7.1-33.4-18.6-44.9-27.4-18.6-44.9-18.6-33.4,7.1-44.9,18.6-18.6,27.4-18.6,44.9,6.4,31.7,16.7,43c-17.4,7.9-32.5,20-44,35-14.8,19.3-23.6,43.4-23.6,69.4v9.4h-136.8V252.7h69.5l68.3,41.8c1.6,1.2,3.6,1.8,5.7,1.8,5.4,0,9.9-4.4,9.9-9.9v-33.8h24.2c7.3,0,13.9-3,18.8-7.8s7.8-11.4,7.8-18.8v-5.7h108.9v60.9c0,7.3,3,13.9,7.8,18.8s11.5,7.8,18.8,7.8h24.2v33.8h0c0,1.8.5,3.5,1.4,5.1,2.8,4.6,8.9,6.1,13.5,3.3l68.9-42.2h54.8v202.5h-136.8v-9.4c0-26-8.8-50.1-23.6-69.4-11.5-15-26.6-27.1-44-35h0s0,0,0,0Z"/>';
      break;

    case 'video':
      $paths  = '<path d="M350.4,238.7l133.9,72.5-133.9,78.2v-150.7h0ZM679.8,193.1v279H119.2V193.1c0-17.1,13.9-31,31-31h498.7c17.1,0,31,13.9,31,31h0,0ZM504.9,310.8c-.1-7.5-4.3-14.3-10.8-17.8l-133.9-72.5c-6.5-3.5-14.1-3.4-20.4.4-6.3,3.8-10.1,10.4-10.1,17.8v150.6c0,7.5,3.9,14.2,10.4,17.9,3.2,1.9,6.8,2.8,10.3,2.8s7.1-1,10.4-2.9l133.9-78.1c6.4-3.8,10.4-10.7,10.3-18.2h0ZM119.2,492.7h560.7v113.6c0,17.1-13.9,31-31,31H150.2c-17.1,0-31-13.9-31-31v-113.6h0s0,0,0,0ZM354,559.8c0,5.4-.8,10.6-2.2,15.5h285.8c8.6,0,15.5-7,15.5-15.5s-7-15.5-15.5-15.5h-285.8c1.4,4.9,2.2,10.1,2.2,15.5ZM261,559.8c0,20,16.2,36.2,36.2,36.2s36.2-16.2,36.2-36.2-16.2-36.2-36.2-36.2-36.2,16.2-36.2,36.2h0ZM144.6,559.8c0,8.6,6.9,15.5,15.5,15.5h82.5c-1.4-4.9-2.2-10.1-2.2-15.5s.8-10.6,2.2-15.5h-82.5c-8.6,0-15.5,7-15.5,15.5Z"/>';
      break;

    case 'doc': // datasheets + whitepapers
    default:
      $paths  = '<path d="M247.4,558.4V183.9h-22.7c-14.9,0-26.6,11.7-26.6,26.6v414c0,14.9,11.7,26.6,26.6,26.6h309.1c14.9,0,26.6-11.7,26.6-26.6v-21.4h-268.2c-24.6,0-44.7-20.1-44.7-44.7h0Z"/>';
      $paths .= '<path d="M536.4,229.9h92l-113.4-113.4v92c0,11.7,9.7,21.4,21.4,21.4h0Z"/>';
      $paths .= '<path d="M496.8,208.5v-91.3h-204.7c-14.9,0-26.6,11.7-26.6,26.6v414.7c0,14.9,11.7,26.6,26.6,26.6h309c14.9,0,26.6-11.7,26.6-26.6V248h-91.3c-22,0-39.5-17.5-39.5-39.5ZM362.1,246.1h82.3c5.2,0,9.1,3.9,9.1,9.1s-3.9,9.1-9.1,9.1h-82.3c-5.2,0-9.1-3.9-9.1-9.1-.6-5.2,3.9-9.1,9.1-9.1ZM532.5,502h-170.4c-5.2,0-9.1-3.9-9.1-9.1s3.9-9.1,9.1-9.1h170.4c5.2,0,9.1,3.9,9.1,9.1s-4.5,9.1-9.1,9.1ZM532.5,423h-170.4c-5.2,0-9.1-3.9-9.1-9.1s3.9-9.1,9.1-9.1h170.4c5.2,0,9.1,3.9,9.1,9.1s-4.5,9.1-9.1,9.1ZM541.5,334.2c0,5.2-3.9,9.1-9.1,9.1h-170.4c-5.2,0-9.1-3.9-9.1-9.1s3.9-9.1,9.1-9.1h170.4c4.5,0,9.1,3.9,9.1,9.1Z"/>';
      break;

  }

  return $open . $paths . $close;
}


/**
 * Turn a YouTube / Vimeo watch URL into its embed URL.
 * Returns the original URL if it isn't a provider we recognise.
 * usage: echo plixer_video_embed_url( get_field('video_url') );
 */
function plixer_video_embed_url( $url ) {
  $url = trim( (string) $url );
  if ( ! $url ) {
    return '';
  }

  // already an embed URL
  if ( preg_match( '#(youtube\.com/embed/|player\.vimeo\.com/video/)#i', $url ) ) {
    return esc_url_raw( $url );
  }

  // youtu.be/ID  or  youtube.com/watch?v=ID  or  youtube.com/shorts/ID
  if ( preg_match( '#(?:youtu\.be/|youtube\.com/(?:watch\?(?:.*&)?v=|shorts/|live/))([A-Za-z0-9_-]{6,})#i', $url, $m ) ) {
    return 'https://www.youtube.com/embed/' . $m[1];
  }

  // vimeo.com/ID
  if ( preg_match( '#vimeo\.com/(?:video/)?([0-9]+)#i', $url, $m ) ) {
    return 'https://player.vimeo.com/video/' . $m[1];
  }

  return esc_url_raw( $url );
}


/**
 * Shared WP_Query args for the Resource Hub sections.
 * $term is a 'resource-type' slug, or '' to skip the tax query.
 */
function plixer_hub_query_args( $post_type, $count, $term = '' ) {
  $args = array(
    'post_type'           => $post_type,
    'posts_per_page'      => (int) $count,
    'post_status'         => 'publish',
    'ignore_sticky_posts' => true,
    'no_found_rows'       => true,
  );

  if ( $term ) {
    $args['tax_query'] = array(
      array(
        'taxonomy' => 'resource-type',
        'field'    => 'slug',
        'terms'    => $term,
      ),
    );
  }

  return $args;
}

?>
