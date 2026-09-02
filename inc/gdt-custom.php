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
  $open  = '<svg class="c-hub-nav__icon" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">';
  $close = '</svg>';

  switch ( $name ) {

    case 'article': // thought leadership - document + pencil
      $paths = '<path d="M13 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-6"/>
                <path d="M7 8h5"/><path d="M7 12h4"/><path d="M7 16h3"/>
                <path d="M18.5 2.5a2.12 2.12 0 0 1 3 3L16 11l-3 1 1-3Z"/>';
      break;

    case 'case-study': // document + magnifier
      $paths = '<path d="M14 3H6a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h9a2 2 0 0 0 2-2v-4"/>
                <path d="M14 3v4a2 2 0 0 0 2 2h4"/><path d="M20 3h-6"/>
                <path d="M7 8h4"/><path d="M7 12h3"/>
                <circle cx="16.5" cy="14.5" r="3"/><path d="m21 19-2.4-2.4"/>';
      break;

    case 'news': // megaphone
      $paths = '<path d="m3 11 15-6v14L3 13Z"/><path d="M3 11v2a1 1 0 0 0 1 1h1v-4H4a1 1 0 0 0-1 1Z"/>
                <path d="M7 14v4a2 2 0 0 0 4 0v-3"/><path d="M20 9v4"/>';
      break;

    case 'webinar': // presentation screen
      $paths = '<rect x="2.5" y="4" width="19" height="12" rx="2"/>
                <path d="M12 16v4"/><path d="M8.5 20h7"/>
                <path d="m9 12 2.5-2.5L13.5 11 16 8"/>';
      break;

    case 'video': // play button
      $paths = '<rect x="2.5" y="5" width="19" height="14" rx="3"/>
                <path d="m10.5 9.5 4.5 2.5-4.5 2.5Z"/>';
      break;

    case 'doc': // datasheets + whitepapers
    default:
      $paths = '<path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8Z"/>
                <path d="M14 3v5h5"/><path d="M9 12h6"/><path d="M9 16h6"/>';
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
