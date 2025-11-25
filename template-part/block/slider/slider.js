(function($){
    var splide = new Splide( '.splide', {
        pagination : false,
        arrows     : false,
        type   : 'loop',
        drag   : 'free',
        focus  : 'center',
        perPage: 6,
        autoScroll: {
            speed: 0.5,
          },
        breakpoints: {
            1450: {
                perPage: 5,
            },
            1200: {
                perPage: 4,
            },
            900: {
                perPage: 3,
            },
            800: {
                perPage: 2,
            },
            600: {
                perPage: 1,
            },

        }

    } );
    
    
    splide.mount(window.splide.Extensions);
    /**
     * initializeBlock
     *
     * Adds custom JavaScript to the block HTML.
     *
     * @date    15/4/19
     * @since   1.0.0
     *
     * @param   object $block The block jQuery element.
     * @param   object attributes The block attributes (only available when editing).
     * @return  void
     */
    var initializeBlock = function( $block ) {
            //Custom Script goes here
            
    }

    // Initialize each block on page load (front end).
    $(document).ready(function(){
        $('.wp-block-acf-button-block').each(function(){
            initializeBlock( $(this) );
        });
      
    });

    // Initialize dynamic block preview (editor).
    if( window.acf ) {
        window.acf.addAction( 'render_block_preview/type=slider-block', initializeBlock );
        // Stop links from activating in the editor
    }

    

})(jQuery);