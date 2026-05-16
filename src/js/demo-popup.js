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
            // Form no longer redirects - simplified initialization
            this.bindEvents();
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
