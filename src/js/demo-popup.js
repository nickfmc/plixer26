/**
 * Demo Popup System
 * Portable popup component for Gravity Forms
 * 
 * Usage: Add class 'popup-demo' to any element to trigger the popup
 */

(function($) {
    'use strict';

    const DemoPopup = { 
        init: function() {
            // Check if we're on a thank-you page or have a submission parameter
            if (this.isThankYouPage()) {
                console.log('Thank you page detected - popup disabled');
                return;
            }
            
            // Popup HTML is added by PHP in footer - no need to create it here
            this.bindEvents();
            this.handlePardotRedirect();
        },
        
        isThankYouPage: function() {
            const url = window.location.href.toLowerCase();
            const params = new URLSearchParams(window.location.search);
            
            return url.includes('/thank-you') || 
                   url.includes('thank-you') ||
                   params.has('thank-you') ||
                   params.has('submission') ||
                   document.body.classList.contains('page-template-thank-you');
        },
        
        handlePardotRedirect: function() {
            // Detect if we're being redirected from a Pardot form submission
            // and handle it gracefully
            const self = this;
            
            // Listen for iframe message from Pardot form or detect URL changes in iframe
            window.addEventListener('message', function(event) {
                // Check if message is from Pardot
                if (event.origin.indexOf('plixer.com') > -1 || 
                    event.origin.indexOf('pardot.com') > -1 || 
                    event.origin.indexOf('salesforce.com') > -1) {
                    
                    // Mark form as submitted
                    sessionStorage.setItem('pardot_demo_submitted', 'true');
                    
                    // Set cookie that expires in 30 minutes to persist across page loads
                    var expires = new Date(Date.now() + 30 * 60 * 1000).toUTCString();
                    document.cookie = 'pardot_demo_submitted=true; expires=' + expires + '; path=/';
                    
                    // Close popup
                    self.closePopup();
                    
                    // Show brief confirmation message
                    if (!document.querySelector('.demo-submission-notice')) {
                        var notice = document.createElement('div');
                        notice.className = 'demo-submission-notice';
                        notice.style.cssText = 'position: fixed; top: 20px; right: 20px; background: #4CAF50; color: white; padding: 15px 20px; border-radius: 5px; z-index: 99999; box-shadow: 0 2px 10px rgba(0,0,0,0.2);';
                        notice.innerHTML = '<strong>Thank you!</strong> We\'ll be in touch soon.';
                        document.body.appendChild(notice);
                        
                        setTimeout(function() {
                            notice.remove();
                        }, 5000);
                    }
                }
            });
            
            // Check for recent submission on page load
            if (sessionStorage.getItem('pardot_demo_submitted') === 'true' ||
                document.cookie.indexOf('pardot_demo_submitted=true') > -1) {
                console.log('Previous form submission detected - iframe will show thank you message');
            }
        },

        bindEvents: function() {
            const self = this;

            // Open popup
            $(document).on('click', '.popup-demo', function(e) {
                e.preventDefault();
                self.openPopup();
            });

            // Close popup - close button
            $(document).on('click', '.demo-popup-close', function(e) {
                e.preventDefault();
                self.closePopup();
            });

            // Close popup - overlay (only when clicking outside the content)
            $(document).on('click', '.demo-popup-overlay', function(e) {
                if (e.target === this) {
                    self.closePopup();
                }
            });

            // Close on ESC key
            $(document).on('keydown', function(e) {
                if (e.key === 'Escape' && $('#demo-popup-overlay').hasClass('active')) {
                    self.closePopup();
                }
            });

            // Prevent closing when clicking inside popup content
            $(document).on('click', '.demo-popup-container', function(e) {
                e.stopPropagation();
            });
        },

        openPopup: function() {
            // Don't open if on thank-you page or recently submitted
            if (this.isThankYouPage()) {
                return;
            }
            
            $('#demo-popup-overlay').addClass('active');
            $('body').addClass('demo-popup-open');
        },

        closePopup: function() {
            $('#demo-popup-overlay').removeClass('active');
            $('body').removeClass('demo-popup-open');
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        DemoPopup.init();
    });

})(jQuery);
