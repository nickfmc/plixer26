<?php
/**
 * Template Name: Popup Test Page
 * 
 * Use this template to test the demo popup
 * Create a new page in WordPress and select this template
 */

get_header(); ?>

<style>
    .popup-test-container {
        max-width: 1200px;
        margin: 100px auto;
        padding: 40px;
        text-align: center;
    }
    .popup-test-container h1 {
        color: #fff;
        margin-bottom: 40px;
    }
    .test-button {
        display: inline-block;
        background: linear-gradient(135deg, #F36B39 0%, #e85a2a 100%);
        color: #fff;
        padding: 16px 32px;
        border-radius: 8px;
        font-size: 18px;
        font-weight: 700;
        text-decoration: none;
        margin: 10px;
        transition: all 0.3s ease;
    }
    .test-button:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(243, 107, 57, 0.4);
        color: #fff;
    }
    .test-section {
        background: rgba(255,255,255,0.05);
        padding: 40px;
        border-radius: 10px;
        margin-bottom: 30px;
    }
    .test-section h2 {
        color: #94D33F;
        margin-bottom: 20px;
    }
    .test-section p {
        color: rgba(255,255,255,0.8);
        margin-bottom: 20px;
    }
    .code-example {
        background: #1a0d2d;
        padding: 20px;
        border-radius: 5px;
        margin: 20px 0;
        text-align: left;
        font-family: monospace;
        color: #94D33F;
        overflow-x: auto;
    }
</style>

<div class="popup-test-container">
    <h1>🎉 Demo Popup Test Page</h1>
    
    <!-- Test Section 1: Basic Link -->
    <div class="test-section">
        <h2>Test 1: Basic Link</h2>
        <p>Click this link to open the popup:</p>
        <a href="#" class="popup-demo test-button">Open Demo Popup</a>
        <div class="code-example">
            &lt;a href="#" class="popup-demo"&gt;Open Demo Popup&lt;/a&gt;
        </div>
    </div>

    <!-- Test Section 2: Button -->
    <div class="test-section">
        <h2>Test 2: HTML Button</h2>
        <p>Click this button to open the popup:</p>
        <button class="popup-demo test-button">Get Free Consultation</button>
        <div class="code-example">
            &lt;button class="popup-demo"&gt;Get Free Consultation&lt;/button&gt;
        </div>
    </div>

    <!-- Test Section 3: Shortcode -->
    <div class="test-section">
        <h2>Test 3: Shortcode</h2>
        <p>Using the shortcode:</p>
        <?php echo do_shortcode('[demo_popup_button text="Request Quote" class="test-button"]'); ?>
        <div class="code-example">
            [demo_popup_button text="Request Quote" class="test-button"]
        </div>
    </div>

    <!-- Test Section 4: PHP Function -->
    <div class="test-section">
        <h2>Test 4: PHP Function</h2>
        <p>Using the helper function:</p>
        <?php echo demo_popup_trigger_button('Schedule Appointment', 'test-button'); ?>
        <div class="code-example">
            &lt;?php echo demo_popup_trigger_button('Schedule Appointment', 'test-button'); ?&gt;
        </div>
    </div>

    <!-- Test Section 5: Multiple Triggers -->
    <div class="test-section">
        <h2>Test 5: Multiple Triggers</h2>
        <p>All of these open the same popup:</p>
        <a href="#" class="popup-demo test-button">Link 1</a>
        <a href="#" class="popup-demo test-button">Link 2</a>
        <a href="#" class="popup-demo test-button">Link 3</a>
    </div>

    <!-- Instructions -->
    <div class="test-section">
        <h2>📝 Checklist</h2>
        <div style="text-align: left; max-width: 600px; margin: 0 auto;">
            <p style="color: #fff;">✅ Popup appears when clicking buttons</p>
            <p style="color: #fff;">✅ Popup closes with X button</p>
            <p style="color: #fff;">✅ Popup closes when clicking outside</p>
            <p style="color: #fff;">✅ Popup closes with ESC key</p>
            <p style="color: #fff;">✅ Gravity Form displays correctly</p>
            <p style="color: #fff;">✅ Form fields are styled</p>
            <p style="color: #fff;">✅ Submit button works</p>
            <p style="color: #fff;">✅ Popup looks good on mobile</p>
        </div>
    </div>

    <!-- Setup Info -->
    <div class="test-section">
        <h2>⚙️ Configuration</h2>
        <p style="color: #fff;">Current Form ID: <strong style="color: #94D33F;">
            <?php 
            $form_id = apply_filters('demo_popup_form_id', 1);
            echo $form_id; 
            ?>
        </strong></p>
        <p style="color: rgba(255,255,255,0.7); font-size: 14px;">
            To change the form, edit line 46 in <code>inc/demo-popup.php</code>
        </p>
        
        <?php if (!class_exists('GFForms')): ?>
            <p style="color: #F36B39; font-weight: bold;">
                ⚠️ Gravity Forms plugin is not active!
            </p>
        <?php endif; ?>
    </div>

</div>

<?php get_footer(); ?>
