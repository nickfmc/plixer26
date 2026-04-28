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

?>
