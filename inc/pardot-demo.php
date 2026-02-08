<?php
// Check cookie to see if form was recently submitted
$form_submitted = isset($_COOKIE['pardot_demo_submitted']) && $_COOKIE['pardot_demo_submitted'] === 'true';

// Don't render iframe on thank-you pages OR if recently submitted (to prevent auto-redirect)
if (is_page('thank-you') || 
    strpos($_SERVER['REQUEST_URI'], 'thank-you') !== false || 
    isset($_GET['thank-you']) || 
    isset($_GET['submission'])) {
    echo '<div style="padding: 20px; text-align: center;">';
    echo '<p style="font-size: 18px; color: #333;"><strong>Thank you for your submission!</strong></p>';
    echo '<p>We\'ll be in touch soon.</p>';
    echo '</div>';
    return;
}
?>
<div style="padding: 20px; border-radius:10px;">
    <!-- Pardot iframe will be loaded via JavaScript to prevent auto-redirect loops -->
    <div id="pardot-form-container">
        <noscript>
            <iframe src="https://secure.plixer.com/l/1088472/2025-12-10/2wvfkv" width="100%" height="1000" type="text/html" frameborder="0" allowTransparency="true" style="border: 0"></iframe>
        </noscript>
    </div>
    <script>
    (function() {
        // Check if form was recently submitted (prevents Pardot auto-redirect)
        var isSubmitted = false;
        
        // Check sessionStorage with expiration (prevents extended thank-you display)
        var submittedData = sessionStorage.getItem('pardot_demo_submitted');
        if (submittedData) {
            try {
                var data = JSON.parse(submittedData);
                if (data.expiresAt && Date.now() < data.expiresAt) {
                    isSubmitted = true;
                } else {
                    // Expired - remove it
                    sessionStorage.removeItem('pardot_demo_submitted');
                }
            } catch(e) {
                // Old format or invalid - just check if it's 'true'
                if (submittedData === 'true') {
                    isSubmitted = true;
                }
            }
        }
        
        // Fallback: also check cookie
        if (!isSubmitted && document.cookie.indexOf('pardot_demo_submitted=true') > -1) {
            isSubmitted = true;
        }
        
        if (isSubmitted) {
            // Show thank you message instead of loading iframe
            document.getElementById('pardot-form-container').innerHTML = 
                '<div style="padding: 40px; text-align: center;">' +
                '<p style="font-size: 18px; color: #333; margin-bottom: 10px;"><strong>Thank you for your submission!</strong></p>' +
                '<p style="color: #666;">We\'ll be in touch soon.</p>' +
                '</div>';
        } else {
            // Safe to load iframe - no recent submission detected
            var iframe = document.createElement('iframe');
            iframe.src = 'https://secure.plixer.com/l/1088472/2025-12-10/2wvfkv';
            iframe.width = '100%';
            iframe.height = '1000';
            iframe.frameBorder = '0';
            iframe.allowTransparency = true;
            iframe.style.border = '0';
            document.getElementById('pardot-form-container').appendChild(iframe);
            
            // Listen for Pardot form submission (Pardot sends messages on submit)
            window.addEventListener('message', function(event) {
                // Pardot form submitted - set flag to prevent reload redirects
                if (event.origin.indexOf('plixer.com') > -1 || event.origin.indexOf('pardot.com') > -1) {
                    var expirationTime = Date.now() + 24 * 60 * 60 * 1000; // 24 hours
                    
                    // Set sessionStorage with expiration timestamp
                    sessionStorage.setItem('pardot_demo_submitted', JSON.stringify({
                        submitted: true,
                        expiresAt: expirationTime
                    }));
                    
                    // Set cookie that expires in 30 minutes
                    var expires = new Date(expirationTime).toUTCString();
                    document.cookie = 'pardot_demo_submitted=true; expires=' + expires + '; path=/';
                }
            });
        }
    })();
    </script>
</div>