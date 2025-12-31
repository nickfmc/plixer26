/**
 * GutenDevTheme scripts (footer)
 * This file contains any js scripts you want added to the theme's footer. 
 */

// *********************** START CUSTOM JS *********************************

// // grab element for Headroom
// var headroomElement = document.querySelector("#c-page-header");
// console.log(headroomElement);

// // get height of element for Headroom
// var headerHeight = headroomElement.offsetHeight; 
// console.log(headerHeight);

// // construct an instance of Headroom, passing the element
// var headroom = new Headroom(headroomElement, {
//   "offset": headerHeight,
//   "tolerance": 5,
//   "classes": {
//     "initial": "animate__animated",
//     "pinned": "animate__slideInDown",
//     "unpinned": "animate__slideOutUp"
//   }
// });
// headroom.init();

// mobile footer menus
document.addEventListener('DOMContentLoaded', function() {
  var menus = document.querySelectorAll('.c-footer-nav'); 
  menus.forEach(function(menu) {
      var firstLinkText = menu.querySelector('li a').textContent;
      var title = document.createElement('a');
      title.innerHTML = firstLinkText + ' <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11.178 19.569a.998.998 0 0 0 1.644 0l9-13A.999.999 0 0 0 21 5H3a1.002 1.002 0 0 0-.822 1.569l9 13z"/></svg>';
      title.className = 'menu-title';
      menu.parentNode.insertBefore(title, menu);

      title.addEventListener('click', function() {
          if (menu.style.display === 'block') {
              menu.style.display = 'none';
              title.classList.remove('active');
          } else {
              menu.style.display = 'block';
              title.classList.add('active');
          }
      });
  });
});



document.addEventListener('DOMContentLoaded', function() {
    // Select all menu items that have mega menus and are click-triggered
    const megaMenuItems = document.querySelectorAll('.has-mega-menu[data-trigger-type="click"]');

    megaMenuItems.forEach(item => {
        const button = item.querySelector('button');
        const megaMenuContent = item.querySelector('.mega-menu__content');

        if (button && megaMenuContent) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                // Close other open mega menus
                document.querySelectorAll('.has-mega-menu.is-active').forEach(activeItem => {
                    if (activeItem !== item) {
                        activeItem.classList.remove('is-active');
                        const activeButton = activeItem.querySelector('button');
                        const activeContent = activeItem.querySelector('.mega-menu__content');
                        activeButton.setAttribute('aria-expanded', 'false');
                        activeContent.classList.remove('is-active');
                        activeContent.setAttribute('aria-hidden', 'true');
                    }
                });

                // Toggle current mega menu
                const isExpanded = button.getAttribute('aria-expanded') === 'true';
                button.setAttribute('aria-expanded', !isExpanded);
                megaMenuContent.setAttribute('aria-hidden', isExpanded);
                item.classList.toggle('is-active');
                megaMenuContent.classList.toggle('is-active'); // Add this line to toggle is-active on content

            });

            // Close mega menu when clicking outside
            document.addEventListener('click', function(e) {
                if (!item.contains(e.target)) {
                    item.classList.remove('is-active');
                    megaMenuContent.classList.remove('is-active'); // Add this line
                    button.setAttribute('aria-expanded', 'false');
                    megaMenuContent.setAttribute('aria-hidden', 'true');
                }
            });
        }
    });

    // Handle escape key
    document.addEventListener('keyup', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.has-mega-menu.is-active').forEach(item => {
                item.classList.remove('is-active');
                const button = item.querySelector('button');
                const content = item.querySelector('.mega-menu__content');
                button.setAttribute('aria-expanded', 'false');
                content.classList.remove('is-active'); // Add this line
                content.setAttribute('aria-hidden', 'true');
            });
        }
    });
});

// document.addEventListener('DOMContentLoaded', function() {
//     var menus = document.querySelectorAll('.c-footer-nav');

//     menus.forEach(function(menu) {
//         var title = document.createElement('li');
//         title.classList.add('menu-title');
//         title.innerText = 'Menu Title'; // Replace with your desired title

//         title.addEventListener('click', function() {
//             menu.classList.toggle('active');
//         });

//         menu.insertBefore(title, menu.firstChild);
//     });
// });

// sticky header
window.onscroll = function() {
  var header = document.getElementById('c-page-header');
  if (window.pageYOffset > 200) {
      header.classList.add('sticky');
  } else {
      header.classList.remove('sticky');
  }
};

// blog pagination
window.onload = function() {
  var navLinks = document.querySelectorAll('.c-post-nav a');
  navLinks.forEach(function(link) {
    link.href += '#c-main-posts';
  });
};

// number counter
document.addEventListener('DOMContentLoaded', function() {
  var observer = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
          if (entry.isIntersecting) {
              var number = entry.target;
              var toNumber = parseInt(number.innerHTML.replace(/\D/g, ''), 10);
              var suffix = number.innerHTML.replace(/[0-9]/g, '');
              var prefix = '', postfix = '';

              if (number.innerHTML.indexOf(suffix) === 0) {
                  prefix = suffix;
              } else {
                  postfix = suffix;
              }

              var currentNumber = 0;
              var interval = setInterval(function() {
                  if (currentNumber < toNumber) {
                      currentNumber++;
                      number.textContent = prefix + currentNumber + postfix;
                  } else {
                      clearInterval(interval);
                  }
              }, 10);

              observer.unobserve(number);
          }
      });
  });

  var counters = document.querySelectorAll('.number-counter');
  counters.forEach(function(counter) {
      observer.observe(counter);
  });
});


document.addEventListener('DOMContentLoaded', function() {
    const searchTrigger = document.getElementById('search-trigger');
    const searchPopup = document.getElementById('search-popup');
    const closeButton = document.querySelector('.close');
    const searchInput = searchPopup.querySelector('input[type="search"]');
    const submitButton = searchPopup.querySelector('input[type="submit"]');
    const documentationLink = searchPopup.querySelector('a[href*="docs.plixer.com"]');

    // Create array of focusable elements
    const getFocusableElements = () => {
        return [searchInput, submitButton, documentationLink, closeButton].filter(Boolean);
    };

    // Function to handle tab key navigation
    function handleTabKey(e) {
        if (!searchPopup.classList.contains('active')) return;

        const focusableElements = getFocusableElements();
        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];
        const activeElement = document.activeElement;

        // If Shift + Tab
        if (e.shiftKey) {
            if (activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            }
        } 
        // If just Tab
        else {
            if (activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        }
    }

    if (searchTrigger && searchPopup) {
        // Handle both click and keyboard events for search trigger
        searchTrigger.addEventListener('click', openSearch);
        searchTrigger.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                openSearch(event);
            }
        });

        // Handle keyboard navigation
        document.addEventListener('keydown', function(event) {
            if (searchPopup.classList.contains('active')) {
                if (event.key === 'Tab') {
                    handleTabKey(event);
                }
                if (event.key === 'Escape') {
                    closeSearch(event);
                }
            }
        });

        if (closeButton) {
            closeButton.addEventListener('click', closeSearch);
            closeButton.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    closeSearch(event);
                }
            });
        }

        // Add click outside functionality
        document.addEventListener('click', function(event) {
            if (searchPopup.classList.contains('active') && 
                !searchPopup.contains(event.target) && 
                !searchTrigger.contains(event.target)) {
                closeSearch(event);
            }
        });
    }

    function openSearch(event) {
        if (event) event.preventDefault();
        searchPopup.classList.add('active');
        
        // Set ARIA attributes
        searchPopup.setAttribute('aria-hidden', 'false');
        searchTrigger.setAttribute('aria-expanded', 'true');
        
        // Focus the search input after a brief delay
        setTimeout(() => {
            searchInput.focus();
        }, 100);
    }

    function closeSearch(event) {
        if (event) event.preventDefault();
        searchPopup.classList.remove('active');
        
        // Reset ARIA attributes
        searchPopup.setAttribute('aria-hidden', 'true');
        searchTrigger.setAttribute('aria-expanded', 'false');
        
        // Return focus to search trigger
        searchTrigger.focus();
    }
});



// Fixed Bar Functionality
document.addEventListener('DOMContentLoaded', function() {
  const fixedBar = document.querySelector('.c-fixed-bar');
  const closeBtn = document.querySelector('.c-fixed-bar-close');
  
  if (fixedBar && closeBtn) {
    closeBtn.addEventListener('click', function() {
      fixedBar.style.display = 'none';
      document.body.classList.add('fixed-bar-closed');
      

    });
    

  }
});




// Info popup script
document.addEventListener('DOMContentLoaded', function() {
    var popupTrigger = document.getElementById('info-popup-trigger');
    var popup = document.getElementById('info-popup');
    var closeButton = document.querySelector('.c-info-popup-close');

    // Only proceed if all required elements exist
    if (!popupTrigger || !popup || !closeButton) {
        // Exit early if any required elements are missing
        return;
    }

    // Function to get a cookie by name
    function getCookie(name) {
        var value = "; " + document.cookie;
        var parts = value.split("; " + name + "=");
        if (parts.length == 2) return parts.pop().split(";").shift();
    }

    // Function to set a cookie
    function setCookie(name, value, days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    }

    // Function to close the popup and set the cookie
    function closePopup() {
        popup.classList.add('is-closing');
        setTimeout(function() {
            popup.classList.remove('is-visible', 'is-closing');
            popup.setAttribute('aria-hidden', 'true');
            popupTrigger.setAttribute('aria-expanded', 'false');
            setCookie('infoPopupClosed', 'true', 0); // Session cookie
        }, 300); // Match the duration of the slideOut animation
    }

    // Check if the popup should be shown
    if (!getCookie('infoPopupClosed')) {
        setTimeout(function() {
            if (popup) { // Additional check before showing
                popup.classList.add('is-visible');
                popup.setAttribute('aria-hidden', 'false');
                popupTrigger.setAttribute('aria-expanded', 'true');
            }
        }, 2000);
    }

    // Event listener to close the popup with the close button
    closeButton.addEventListener('click', closePopup);

    // Event listener to toggle the popup with the trigger
    popupTrigger.addEventListener('click', function() {
        if (popup.classList.contains('is-visible')) {
            closePopup();
        } else {
            popup.classList.add('is-visible');
            popup.setAttribute('aria-hidden', 'false');
            popupTrigger.setAttribute('aria-expanded', 'true');
        }
    });
});

// end info popup script


// external link accessibility script
class AccessibilityEnhancer {
    constructor() {
        this.newTabText = '(Opens in a new tab)';
        this.externalLinkText = '(External link)';
        this.pdfText = '(PDF file)'; 
    }
  
    enhanceLinks() {
        const links = document.querySelectorAll('a');
        
        links.forEach(link => {
            this.enhanceSingleLink(link);
        });
    }
  
    enhanceSingleLink(link) {
      const isNewTab = link.target === '_blank' || link.target === 'blank';
      const isExternal = this.isExternalLink(link);
      const isPDF = this.isPDFLink(link); // Add this line
      const existingLabel = link.getAttribute('aria-label');
      const linkText = link.textContent || link.innerText;
      
      let newLabel = existingLabel || linkText;
  
      // Add appropriate notices
      if (isNewTab && !newLabel.includes(this.newTabText)) {
          newLabel += ` ${this.newTabText}`;
      }
      if (isExternal && !newLabel.includes(this.externalLinkText)) {
          newLabel += ` ${this.externalLinkText}`;
      }
      if (isPDF && !newLabel.includes(this.pdfText)) { // Add this block
          newLabel += ` ${this.pdfText}`;
      }
  
        // Set the enhanced label
        if (newLabel !== linkText) {
            link.setAttribute('aria-label', newLabel.trim());
        }
  
        // Add security attributes for external links
        if (isNewTab || isExternal) {
            const rel = 'noopener noreferrer';
            const currentRel = link.getAttribute('rel');
            if (!currentRel || !currentRel.includes(rel)) {
                link.setAttribute('rel', rel);
            }
        }
    }
  
    isExternalLink(link) {
        if (!link.href) return false;
        
        const currentDomain = window.location.hostname;
        try {
            const linkDomain = new URL(link.href).hostname;
            return linkDomain !== currentDomain;
        } catch (e) {
            return false;
        }
    }
  
    isPDFLink(link) {
        if (!link.href) return false;
        
        // Check if the URL ends with .pdf
        if (link.href.toLowerCase().endsWith('.pdf')) return true;
        
        // Check if the MIME type is available and is PDF
        if (link.type && link.type.toLowerCase() === 'application/pdf') return true;
        
        // Check if the download attribute exists and the file ends with .pdf
        if (link.hasAttribute('download')) {
            const downloadValue = link.getAttribute('download');
            if (downloadValue && downloadValue.toLowerCase().endsWith('.pdf')) return true;
        }
        
        return false;
    }
    
  
    // Method to handle dynamically added content
    observe() {
        const observer = new MutationObserver((mutations) => {
            mutations.forEach(mutation => {
                mutation.addedNodes.forEach(node => {
                    if (node.nodeType === 1) { // ELEMENT_NODE
                        // Check the added element itself
                        if (node.tagName === 'A') {
                            this.enhanceSingleLink(node);
                        }
                        // Check for links within the added element
                        const links = node.querySelectorAll('a');
                        links.forEach(link => this.enhanceSingleLink(link));
                    }
                });
            });
        });
  
        observer.observe(document.body, {
            childList: true,
            subtree: true
        });
    }
  }
  
  // Usage
  const accessibilityEnhancer = new AccessibilityEnhancer();
  
  document.addEventListener('DOMContentLoaded', () => {
    accessibilityEnhancer.enhanceLinks();
    accessibilityEnhancer.observe(); // Optional: observe for dynamic content
  });
  // END external link accessibility script


document.addEventListener('DOMContentLoaded', function() { 
    const dropdownButtons = document.querySelectorAll('.dropdown-toggle');
    
    function closeAllSubmenus() {
        dropdownButtons.forEach(button => {
            button.setAttribute('aria-expanded', 'false');
            const submenu = button.parentElement.querySelector('ul');
            if (submenu) {
                submenu.classList.remove('is-active');
            }
        });
    }
    
    dropdownButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const isExpanded = this.getAttribute('aria-expanded') === 'true';
            
            // If menu is already open, just close it
            if (isExpanded) {
                this.setAttribute('aria-expanded', false);
                const submenu = this.parentElement.querySelector('ul');
                if (submenu) {
                    submenu.classList.remove('is-active');
                }
                return;
            }
            
            // Close all submenus first
            closeAllSubmenus();
            
            // Then open the clicked submenu
            this.setAttribute('aria-expanded', true);
            const submenu = this.parentElement.querySelector('ul');
            if (submenu) {
                submenu.classList.add('is-active');
            }
        });
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.menu-item-has-children')) {
            closeAllSubmenus();
        }
    });
});



// Video source enhancement for page-id-64562
document.addEventListener('DOMContentLoaded', function() {
    // Check if we're on the specific page
    if (document.body.classList.contains('page-id-64562')) {
        const videoPlayerDiv = document.querySelector('.video_player72c2_64562');
        
        if (videoPlayerDiv) {
            const videoElement = videoPlayerDiv.querySelector('video');
            
            if (videoElement) {
                // Check if MOV source already exists
                const existingMovSource = videoElement.querySelector('source[src*=".mov"]');
                
                if (!existingMovSource) {
                    // Find the existing webm source
                    const webmSource = videoElement.querySelector('source[src*="Srutinizer-AI-prompt-copy-vp9-chrome.webm"]');
                    
                    if (webmSource) {
                        // Create MOV source element
                        const movSource = document.createElement('source');
                        movSource.src = webmSource.src.replace('.webm', '.mov');
                        movSource.type = 'video/quicktime';
                        
                        // Insert MOV source before the webm source (MOV as fallback)
                        videoElement.insertBefore(movSource, webmSource);
                    }
                }
            }
        }
    }
});

// *********************** END CUSTOM JS *********************************

// *********************** START CUSTOM JQUERY DOC READY SCRIPTS *******************************
jQuery( document ).ready(function( $ ) {

   // get Template URL
   var templateUrl = object_name.templateUrl;
   

$('#mobile-nav').hcOffcanvasNav({
    disableAt: 1165,
    width: 580,
    customToggle: $('.toggle'),
    pushContent: '.menu-slide',
    levelTitles: true,
    position: 'right',
    levelOpen: 'expand',
    navTitle: $('<div class="c-mobile-menu-header"><a href="/">' + 
        '<svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 360 85.61">' +
        '<path class="cls-1" d="M85.44,85.59c-7.33,0-12.47-3.06-12.47-12.84V.02h16.14v66.62c0,4.89,1.22,6.11,6.11,6.11h31.29v12.84h-41.07Z"/>' +
        '<path class="cls-1" d="M133.84,85.59V.02h16.14v85.57h-16.14Z"/>' +
        '<path class="cls-1" d="M206.86,85.59l-15.52-30.8-15.52,30.8h-19.19l24.33-43.39L157.6.02h19.19l14.55,29.58L205.89.02h19.19l-23.35,42.17,24.33,43.39h-19.19Z"/>' +
        '<path class="cls-1" d="M284.56,85.59h-41.44c-7.33,0-12.47-3.06-12.47-12.84V12.86C230.65,3.08,235.78.02,243.12.02h40.95v12.83h-31.17c-3.38,0-6.11,2.74-6.11,6.11v16.5h36.06v12.83h-36.06v18.34c0,3.38,2.74,6.11,6.11,6.11h31.66v12.84Z"/>' +
        '<path class="cls-1" d="M44.68,55.27h1.22c13.08,0,18.89-10.64,18.89-28.24S59.29.02,43.39.02H12.47C5.13.02,0,3.08,0,12.86v72.73h16.14V18.97c0-3.38,2.74-6.11,6.11-6.11h13.81c10.27,0,12.1,4.4,12.1,14.18s-1.34,15.77-10.27,15.77H7.03c-2.47,0-3.94,2.77-2.54,4.82l3.71,5.42c.96,1.4,2.54,2.23,4.23,2.23h32.24Z"/>' +
        '<path class="cls-1" d="M338.57,55.88v-.61h1.22c13.08,0,18.5-10.64,18.5-28.24S352.79.02,336.9.02h-30.93c-7.33,0-12.47,3.06-12.47,12.83v72.73h16.14V18.97c0-3.38,2.74-6.11,6.11-6.11h13.81c10.27,0,12.1,4.4,12.1,14.18s-1.34,15.77-10.27,15.77h-14.06c-2.47,0-3.94,2.77-2.54,4.82l7.18,9.24c.2.33.42.65.64.98l5.38,7.83,14.15,19.92h17.85l-21.43-29.7Z"/>' +
        '</svg></a></div>'),
    levelTitleAsBack: true
});







  

  // modal menu init ----------------------------------
  // var modal_menu = jQuery("#c-modal-nav-button").animatedModal({
  //   modalTarget: 'modal-navigation',
  //   animatedIn: 'slideInDown',
  //   animatedOut: 'slideOutUp',
  //   animationDuration: '0.40s',
  //   color: '#dedede',
  //   afterClose: function() {
  //     $( 'body, html' ).css({ 'overflow': '' });
  //   }
  // });

  // // get last and current hash + update on hash change
  // var currentHash = function() {
  //   return location.hash.replace(/^#/, '')
  // }
  // var last_hash
  // var hash = currentHash()
  // $(window).bind('hashchange', function(event) {
  //   last_hash = hash;
  //   hash = currentHash();
  // });

  // enable back/foward to close/open modal --------------------------
  // $("#c-modal-nav-button").on('click', function(){ window.location.href = ensureHash("#menu"); });
  // function ensureHash(newHash) {
  //   if (window.location.hash) {
  //     return window.location.href.substring(0, window.location.href.lastIndexOf(window.location.hash)) + newHash;
  //   }
  //   return window.location.hash + newHash;
  // }
  // // if back button is pressed, close the modal
  // $(window).on('hashchange', function (event) {
  //   if (last_hash == 'menu' && hash == '') {
  //     modal_menu.close();
  //     history.replaceState('', document.title, window.location.pathname);
  //   } // if forward button, open the modal
  //   else if (window.location.hash == "#menu"){
  //     modal_menu.open();
  //   }
  // });

  // // if close button is clicked, clear the #menu hash added above
  // $('.close-modal-navigation').on('click', function (e) {
  //   history.replaceState('', document.title, window.location.pathname);
  // });

  // // close modal menu if esc key is used ------------------------
  // $(document).keyup(function(ev){
  //   if(ev.keyCode == 27 && hash == 'menu') {
  //     window.history.back();
  //   }
  // });


  // Magnific as menu popup
  // MENU POPUP
  // $('#c-modal-nav-button').magnificPopup({
  //   type: 'inline',
  //   removalDelay: 700, //delay removal by X to allow out-animation
  //   showCloseBtn: false,
  //   closeOnBgClick: false,
  //   autoFocusLast: false,
  //   fixedContentPos: false, 
  //   fixedContentPos: true,
  //   callbacks: {
  //     beforeOpen: function() {
  //        this.st.mainClass = 'mfp-move-from-side menu-popup';
  //        $('body').addClass('mfp-active');
  //     },
  //     open: function() { 
  //       $('#close-modal, .close-modal-navigation').on('click',function(event){
  //         event.preventDefault();
  //         $.magnificPopup.close(); 
  //       }); 
  //   },
  //   beforeClose: function() {
  //   $('body').removeClass('mfp-active');
  // }
  //   },
  //   midClick: true // allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source.
  // });

  // *********************** SUBSCRIBE FLYOUT *********************************
  // Sticky subscribe button show/hide on scroll
  const subscribeBtn = document.querySelector('.c-subscribe-sticky');
  const subscribeFlyout = document.querySelector('.c-subscribe-flyout');
  
  if (subscribeBtn && subscribeFlyout) {
    let scrollTimeout;
    
    // Show button after scrolling down 300px
    window.addEventListener('scroll', function() {
      clearTimeout(scrollTimeout);
      scrollTimeout = setTimeout(function() {
        if (window.scrollY > 300) {
          subscribeBtn.classList.add('is-visible');
        } else {
          subscribeBtn.classList.remove('is-visible');
        }
      }, 100);
    });
    
    // Open flyout
    subscribeBtn.addEventListener('click', function() {
      subscribeFlyout.classList.add('is-open');
      subscribeFlyout.setAttribute('aria-hidden', 'false');
      document.body.classList.add('subscribe-flyout-open');
    });
    
    // Close flyout - close button
    const closeBtn = subscribeFlyout.querySelector('.c-subscribe-flyout__close');
    if (closeBtn) {
      closeBtn.addEventListener('click', function() {
        closeFlyout();
      });
    }
    
    // Close flyout - overlay click
    const overlay = subscribeFlyout.querySelector('.c-subscribe-flyout__overlay');
    if (overlay) {
      overlay.addEventListener('click', function() {
        closeFlyout();
      });
    }
    
    // Close flyout - Escape key
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape' && subscribeFlyout.classList.contains('is-open')) {
        closeFlyout();
      }
    });
    
    function closeFlyout() {
      subscribeFlyout.classList.remove('is-open');
      subscribeFlyout.setAttribute('aria-hidden', 'true');
      document.body.classList.remove('subscribe-flyout-open');
    }
  }
  // *********************** END SUBSCRIBE FLYOUT *********************************

});
// *********************** END CUSTOM JQUERY DOC READY SCRIPTS *********************************
