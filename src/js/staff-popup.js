/**
 * Staff Popup Block - Modal Functionality
 * Opens and closes staff member bio modals
 */

(function() {
    'use strict';
    
    function initStaffPopups() {
        var staffCards = document.querySelectorAll('.c-staff-card:not(.is-admin)');
        
        if (staffCards.length === 0) return;
        
        console.log('Staff popups initialized with ' + staffCards.length + ' cards');
        
        // Move all modals to body to escape stacking context
        var modals = document.querySelectorAll('.c-staff-modal');
        modals.forEach(function(modal) {
            if (modal.parentElement !== document.body) {
                document.body.appendChild(modal);
            }
        });
        
        // Open modal
        staffCards.forEach(function(card) {
            // Skip external link cards
            if (card.classList.contains('c-staff-card--external')) {
                return;
            }
            
            card.addEventListener('click', function(e) {
                e.preventDefault();
                var modalId = card.getAttribute('data-modal');
                var modal = document.getElementById(modalId);
                
                if (modal) {
                    // Ensure modal is in body
                    if (modal.parentElement !== document.body) {
                        document.body.appendChild(modal);
                    }
                    
                    modal.classList.add('is-active');
                    document.body.classList.add('modal-open');
                    
                    // Trap focus in modal
                    var closeBtn = modal.querySelector('.c-staff-modal__close');
                    if (closeBtn) {
                        setTimeout(function() {
                            closeBtn.focus();
                        }, 100);
                    }
                }
            });
            
            // Make keyboard accessible
            card.setAttribute('tabindex', '0');
            card.setAttribute('role', 'button');
            
            card.addEventListener('keydown', function(e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    card.click();
                }
            });
        });
        
        // Close modal functionality
        modals.forEach(function(modal) {
            var closeBtn = modal.querySelector('.c-staff-modal__close');
            var overlay = modal.querySelector('.c-staff-modal__overlay');
            
            // Close button
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    closeModal(modal);
                });
            }
            
            // Overlay click
            if (overlay) {
                overlay.addEventListener('click', function() {
                    closeModal(modal);
                });
            }
            
            // ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && modal.classList.contains('is-active')) {
                    closeModal(modal);
                }
            });
        });
        
        function closeModal(modal) {
            modal.classList.remove('is-active');
            document.body.classList.remove('modal-open');
            
            // Return focus to card that opened modal
            var modalId = modal.getAttribute('id');
            var card = document.querySelector('[data-modal="' + modalId + '"]');
            if (card) {
                card.focus();
            }
        }
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initStaffPopups);
    } else {
        initStaffPopups();
    }
    
    // Re-initialize for dynamically added blocks (AJAX/Gutenberg preview)
    if (window.acf) {
        window.acf.addAction('render_block_preview/type=staff-popup', initStaffPopups);
    }
    
})();
