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

?>
