<?php
/**
 * Demo Popup System
 * Portable popup component for Gravity Forms
 * 
 * SETUP INSTRUCTIONS:
 * 1. Include this file in your theme's functions.php
 * 2. Make sure Gravity Forms plugin is installed
 * 3. Create your Gravity Form and note the form ID
 * 4. Use the shortcode or function to add the popup to your page
 * 5. Add class 'popup-demo' to any element to trigger the popup
 * 
 * USAGE:
 * - Add to any link/button: <a href="#" class="popup-demo">Get Demo</a>
 * - Use shortcode: [demo_popup_button text="Get Started"]
 * - Use PHP function: echo demo_popup_trigger_button('Get Started');
 */

// Note: JavaScript is loaded via site.js webpack bundle
// Note: Styles are compiled into main.bundle.css via site.scss

/**
 * Render the popup HTML with Gravity Form
 * This outputs the popup structure on every page
 */
function plixer_demo_popup_html() {
    // Get the form ID from theme options or use default
    // You can customize this to pull from ACF or theme customizer
    $form_id = apply_filters('demo_popup_form_id', 9); // Change '1' to your actual form ID
    
    ?>
    <div id="demo-popup-overlay" class="demo-popup-overlay">
        <div class="demo-popup-container">
            <button class="demo-popup-close" aria-label="Close popup">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <div class="demo-popup-content">
                <div class="demo-popup-details">
                    <div class="demo-popup-badge">BOOK A DEMO</div>
                    <h2 class="demo-popup-title mb-2">What to expect</h2>
                    <p class="demo-popup-intro">Buying technology is often complicated and exhausting. We like to make it easy and straightforward. Here’s what to expect from our process:</p>
                    <ul class="demo-popup-benefits">
                        <li>
                            <svg class="check-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M16.6667 5L7.50004 14.1667L3.33337 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div>
                                <strong>Confirmation of your request and scheduling</strong>
                            </div>
                        </li>
                        <li>
                            <svg class="check-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M16.6667 5L7.50004 14.1667L3.33337 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div>
                                <strong>A brief discovery call to learn about your needs</strong>
                               
                            </div>
                        </li>
                        <li>
                            <svg class="check-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M16.6667 5L7.50004 14.1667L3.33337 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div>
                                <strong>Live demonstration and Q&A with a sales engineer</strong>
                             
                            </div>
                        </li>
                        <li>
                            <svg class="check-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M16.6667 5L7.50004 14.1667L3.33337 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div>
                                <strong>A brief conversation to determine next steps</strong>
                             
                            </div>
                        </li>
                        <li>
                            <svg class="check-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M16.6667 5L7.50004 14.1667L3.33337 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div>
                                <strong>A qualified proof of concept in your environment</strong>
                             
                            </div>
                        </li>
                        <li>
                            <svg class="check-icon" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                <path d="M16.6667 5L7.50004 14.1667L3.33337 10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div>
                                <strong>Timeline and action plan</strong>
                             
                            </div>
                        </li>
                    </ul>
                    <p class="demo-popup-intro mt-6">We're here for you throughout the process and want to make this as smooth and as thorough as possible.</p>
                </div>
                <div class="demo-popup-form">
                    <div class="demo-popup-form-inner">
                        <?php 
                        // Check if Gravity Forms is active
                        if (class_exists('GFForms')) {
                            gravity_form($form_id, false, false, false, '', true);
                        } else {
                            echo '<div class="gravity-form-placeholder">';
                            echo '<p><strong>Gravity Forms Not Found</strong></p>';
                            echo '<p>Please install Gravity Forms and create a form.</p>';
                            echo '<p>Then update the form ID in <code>inc/demo-popup.php</code></p>';
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}
add_action('wp_footer', 'plixer_demo_popup_html');

/**
 * Shortcode to create a popup trigger button
 * Usage: [demo_popup_button text="Get Started" class="custom-class"]
 */
function plixer_demo_popup_button_shortcode($atts) {
    $atts = shortcode_atts(array(
        'text' => 'Get Demo',
        'class' => '',
    ), $atts);

    $classes = 'popup-demo ' . esc_attr($atts['class']);
    
    return sprintf(
        '<a href="#" class="%s">%s</a>',
        $classes,
        esc_html($atts['text'])
    );
}
add_shortcode('demo_popup_button', 'plixer_demo_popup_button_shortcode');

/**
 * Helper function to output a popup trigger button
 * Usage in template: echo demo_popup_trigger_button('Get Started');
 */
function demo_popup_trigger_button($text = 'Get Demo', $class = '') {
    $classes = 'popup-demo ' . esc_attr($class);
    return sprintf(
        '<a href="#" class="%s">%s</a>',
        $classes,
        esc_html($text)
    );
}

/**
 * Customize the popup content via filter
 * Add to your functions.php or custom plugin:
 * 
 * add_filter('demo_popup_form_id', function() {
 *     return 5; // Your form ID
 * });
 */
