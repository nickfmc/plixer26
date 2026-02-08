/**
 * Timeline Block - Scroll Animation
 * Adds 'is-active' class to timeline items as they enter viewport
 */

(function() {
    'use strict';
    
    // Check if IntersectionObserver is supported
    if (!('IntersectionObserver' in window)) {
        // Fallback: show all items if IntersectionObserver not supported
        document.addEventListener('DOMContentLoaded', function() {
            var items = document.querySelectorAll('.c-timeline__item');
            items.forEach(function(item) {
                item.classList.add('is-active');
            });
        });
        return;
    }
    
    function initTimeline() {
        var timelineItems = document.querySelectorAll('.c-timeline__item');
        
        if (timelineItems.length === 0) return;
        
        console.log('Timeline initialized with ' + timelineItems.length + ' items');
        
        // Create observer options - trigger when item is more centered in viewport
        var observerOptions = {
            root: null,
            rootMargin: '0px 0px -35% 0px', // Trigger when item is 35% from bottom
            threshold: [0, 0.2, 0.4] // Must be at least 20% visible
        };
        
        // Callback function when items intersect
        var observerCallback = function(entries, observer) {
            entries.forEach(function(entry) {
                // Only activate when at least 20% is visible
                if (entry.isIntersecting && entry.intersectionRatio >= 0.2) {
                    entry.target.classList.add('is-active');
                    console.log('Timeline item activated at ratio: ' + entry.intersectionRatio);
                }
            });
        };
        
        // Create the observer
        var observer = new IntersectionObserver(observerCallback, observerOptions);
        
        // Observe each timeline item (don't activate first one immediately)
        timelineItems.forEach(function(item) {
            observer.observe(item);
        });
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initTimeline);
    } else {
        initTimeline();
    }
    
})();
