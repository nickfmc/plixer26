<?php
/**
 * Table of Contents Module
 * Automatically generates TOC from H2 and H3 headings with proper schema markup
 * 
 * @package 2keller
 */

class TableOfContents {
    
    private $toc_items = [];
    private $content = '';
    private $include_h3 = true;
    
    /**
     * Constructor
     */
    public function __construct() {
        // Add custom meta box for TOC settings
        add_action('add_meta_boxes', array($this, 'add_toc_meta_box'));
        add_action('save_post', array($this, 'save_toc_meta'));
    }
    
    /**
     * Add meta box for TOC settings
     */
    public function add_toc_meta_box() {
        add_meta_box(
            'toc_settings',
            'Table of Contents Settings',
            array($this, 'toc_meta_box_callback'),
            'post',
            'side',
            'default'
        );
    }
    
    /**
     * Meta box callback
     */
    public function toc_meta_box_callback($post) {
        wp_nonce_field('toc_meta_box', 'toc_meta_box_nonce');
        
        $hide_h3 = get_post_meta($post->ID, '_toc_hide_h3', true);
        
        echo '<label for="toc_hide_h3">';
        echo '<input type="checkbox" id="toc_hide_h3" name="toc_hide_h3" value="1" ' . checked($hide_h3, '1', false) . ' />';
        echo ' Hide H3 headings from Table of Contents';
        echo '</label>';
    }
    
    /**
     * Save meta box data
     */
    public function save_toc_meta($post_id) {
        if (!isset($_POST['toc_meta_box_nonce'])) {
            return;
        }
        
        if (!wp_verify_nonce($_POST['toc_meta_box_nonce'], 'toc_meta_box')) {
            return;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        $hide_h3 = isset($_POST['toc_hide_h3']) ? '1' : '';
        update_post_meta($post_id, '_toc_hide_h3', $hide_h3);
    }
    
    /**
     * Generate TOC from content
     */
    public function generate_toc($content, $post_id = null) {
        if (!$post_id) {
            global $post;
            $post_id = $post->ID;
        }
        
        $this->content = $content;
        $this->include_h3 = get_post_meta($post_id, '_toc_hide_h3', true) !== '1';
        $this->toc_items = [];
        
        // Parse headings and add anchors
        $content = $this->parse_headings($content);
        
        return $content;
    }
    
    /**
     * Parse headings and create anchor links
     */
    private function parse_headings($content) {
        $pattern = '/<(h[23])([^>]*)>(.*?)<\/h[23]>/i';
        
        $content = preg_replace_callback($pattern, array($this, 'process_heading'), $content);
        
        return $content;
    }
    
    /**
     * Process individual heading
     */
    private function process_heading($matches) {
        $tag = strtolower($matches[1]);
        $attributes = $matches[2];
        $heading_text = strip_tags($matches[3]);
        $level = ($tag === 'h2') ? 2 : 3;
        
        // Skip H3 if disabled
        if ($level === 3 && !$this->include_h3) {
            return $matches[0]; // Return original heading without anchor
        }
        
        // Generate anchor ID
        $anchor_id = $this->generate_anchor_id($heading_text);
        
        // Check if ID already exists in attributes
        if (!preg_match('/id\s*=/', $attributes)) {
            $attributes .= ' id="' . $anchor_id . '"';
        }
        
        // Add to TOC items
        $this->toc_items[] = array(
            'level' => $level,
            'anchor' => $anchor_id,
            'text' => $heading_text,
            'tag' => $tag
        );
        
        // Return heading with anchor
        return '<' . $tag . $attributes . '>' . $matches[3] . '</' . $tag . '>';
    }
    
    /**
     * Generate anchor ID from heading text
     */
    private function generate_anchor_id($text) {
        // Remove HTML entities and convert to lowercase
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = strtolower($text);
        
        // Replace non-alphanumeric characters with hyphens
        $text = preg_replace('/[^a-z0-9]+/', '-', $text);
        
        // Remove leading/trailing hyphens
        $text = trim($text, '-');
        
        // Ensure uniqueness by adding counter if needed
        $original_text = $text;
        $counter = 1;
        $existing_anchors = wp_list_pluck($this->toc_items, 'anchor');
        
        while (in_array($text, $existing_anchors)) {
            $text = $original_text . '-' . $counter;
            $counter++;
        }
        
        return $text;
    }
    
    /**
     * Get TOC HTML
     */
    public function get_toc_html() {
        if (empty($this->toc_items)) {
            return '';
        }
        
        // Get current post title
        $post_title = get_the_title();
        
        $schema_items = array();
        $toc_html = '<div class="c-table-of-contents" itemscope itemtype="https://schema.org/Table">';
        $toc_html .= '<div class="c-toc-header">';
        $toc_html .= '<span class="c-toc-title" itemprop="name">' . esc_html($post_title) . '</span>';
        $toc_html .= '<button class="c-toc-toggle" aria-expanded="true" aria-controls="toc-list">';
        $toc_html .= '<svg class="c-toc-chevron" width="13" height="8" viewBox="0 0 13 8" fill="none">';
        $toc_html .= '<path d="M1 1L6.5 6.5L12 1" stroke="#1c5195" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>';
        $toc_html .= '</svg>';
        $toc_html .= '</button>';
        $toc_html .= '</div>';
        
        $toc_html .= '<nav class="c-toc-nav" id="toc-list" role="navigation" aria-label="Table of Contents">';
        $toc_html .= '<ul class="c-toc-list" itemprop="hasPart">';
        
        foreach ($this->toc_items as $index => $item) {
            $schema_items[] = array(
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['text'],
                'url' => '#' . $item['anchor']
            );
            
            $toc_html .= '<li class="c-toc-item c-toc-item--level-' . $item['level'] . '" itemscope itemtype="https://schema.org/ListItem">';
            $toc_html .= '<meta itemprop="position" content="' . ($index + 1) . '">';
            $toc_html .= '<a href="#' . $item['anchor'] . '" class="c-toc-link" itemprop="url">';
            $toc_html .= '<span itemprop="name">' . esc_html($item['text']) . '</span>';
            $toc_html .= '</a>';
            $toc_html .= '</li>';
        }
        
        $toc_html .= '</ul>';
        $toc_html .= '</nav>';
        $toc_html .= '</div>';
        
        // Add structured data
        $structured_data = array(
            '@context' => 'https://schema.org',
            '@type' => 'Table',
            'name' => 'Table of Contents',
            'mainEntity' => array(
                '@type' => 'ItemList',
                'itemListElement' => $schema_items
            )
        );
        
        $toc_html .= '<script type="application/ld+json">' . wp_json_encode($structured_data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>';
        
        return $toc_html;
    }
    
    /**
     * Get complete TOC sidebar with social sharing
     */
    public function get_toc_sidebar_html() {
        if (empty($this->toc_items)) {
            return '';
        }
        
        $sidebar_html = '<div class="c-toc-sidebar">';
        $sidebar_html .= $this->get_toc_html();
        $sidebar_html .= $this->get_social_share_html();
        $sidebar_html .= '</div>';
        
        return $sidebar_html;
    }
    
    /**
     * Get social share buttons HTML
     */
    public function get_social_share_html() {
        $share_html = '<div class="c-single-post__share-buttons">';
        $share_html .= '<h4 class="c-share-title">Share This Article</h4>';
        $share_html .= '<!-- AddToAny BEGIN -->';
        $share_html .= '<div class="a2a_kit a2a_kit_size_32 a2a_default_style">';
        $share_html .= '<a class="a2a_button_facebook"><svg xmlns="http://www.w3.org/2000/svg" width="7" height="14" viewBox="0 0 7 14" fill="none">';
        $share_html .= '<path fill-rule="evenodd" clip-rule="evenodd" d="M4.65425 14H1.5509V7.38906H0V4.84149H1.5509V3.31325C1.5509 1.23644 2.42648 0 4.91428 0H6.98525V2.54758H5.69128C4.72256 2.54758 4.65813 2.90318 4.65813 3.5677L4.65425 4.84149H7L6.72522 7.38906H4.65425V14Z" fill="#1C5195"/>';
        $share_html .= '</svg></a>';
        $share_html .= '<a class="a2a_button_x"><svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">';
        $share_html .= '<path d="M6.80827 8.14834L2.36633 13.296C2.24865 13.4309 2.08347 13.5 1.91734 13.5C1.77837 13.5 1.63885 13.4516 1.52601 13.3532C1.27817 13.1369 1.2526 12.7607 1.46891 12.5128L6.05219 7.20327L6.80827 8.14834ZM8.42412 6.29679L13.0074 0.987216C13.2237 0.739374 13.1981 0.363205 12.9503 0.146889C12.7025 -0.0694262 12.3261 -0.043856 12.11 0.203986L7.66805 5.35164L8.42412 6.29679Z" fill="#1C5195"/>';
        $share_html .= '<path d="M13.6307 13.4999H10.5337C10.3527 13.4999 10.1816 13.4176 10.0686 13.2763L0.380506 0.967623C0.237487 0.788868 0.209614 0.543886 0.308798 0.337576C0.407982 0.131266 0.616595 0 0.845536 0H3.94256C4.12354 0 4.29459 0.0822698 4.40759 0.223542L14.0957 12.5322C14.2387 12.711 14.2666 12.956 14.1674 13.1623C14.0683 13.3686 13.8596 13.4999 13.6307 13.4999ZM10.8199 12.3087H12.3915L3.65629 1.19116H2.08474L10.8199 12.3087Z" fill="#1C5195"/>';
        $share_html .= '</svg></a>';
        $share_html .= '<a class="a2a_button_linkedin"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none">';
        $share_html .= '<path d="M3.62988 14H0.726562V4.64844H3.62988V14ZM11.0186 4.4209C13.9545 4.4209 14.5 6.35618 14.5 8.875V14H11.6016V9.45312C11.6016 8.3667 11.5851 6.97266 10.0957 6.97266C8.585 6.97283 8.35845 8.15609 8.3584 9.37207V14H5.45996V4.64844H8.23438V5.92969H8.27148C8.66004 5.19462 9.60474 4.42104 11.0186 4.4209ZM2.18359 0C3.11189 0 3.86816 0.756794 3.86816 1.68652C3.86814 2.61624 3.11188 3.37305 2.18359 3.37305C1.25005 3.37289 0.50002 2.61614 0.5 1.68652C0.5 0.756891 1.25004 0.000157856 2.18359 0Z" fill="#1C5195"/>';
        $share_html .= '</svg></a>';
        $share_html .= '<a class="a2a_button_email">';
        $share_html .= '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 32 32"><path fill="#1C5195" d="M28 6H4a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h24a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2m-2.2 2L16 14.78L6.2 8ZM4 24V8.91l11.43 7.91a1 1 0 0 0 1.14 0L28 8.91V24Z"/></svg>';
        $share_html .= '</a>';
        $share_html .= '</div>';
        $share_html .= '<script defer src="https://static.addtoany.com/menu/page.js"></script>';
        $share_html .= '<!-- AddToAny END -->';
        $share_html .= '</div>';
        
        // Add subscribe button
        $share_html .= '<div class="c-toc-subscribe">';
        $share_html .= '<button class="c-toc-subscribe__button" aria-label="Subscribe to blog">';
        $share_html .= '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">';
        $share_html .= '<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>';
        $share_html .= '<polyline points="22,6 12,13 2,6"></polyline>';
        $share_html .= '</svg>';
        $share_html .= '<span>Subscribe to Blog</span>';
        $share_html .= '</button>';
        $share_html .= '</div>';
        
        return $share_html;
    }
    
    /**
     * Check if content has headings
     */
    public function has_headings($content = null) {
        if ($content === null) {
            $content = $this->content;
        }
        
        $pattern = '/<h[23][^>]*>.*?<\/h[23]>/i';
        return preg_match($pattern, $content);
    }
}

// Initialize the TOC class
global $table_of_contents;
$table_of_contents = new TableOfContents();

/**
 * Helper function to generate TOC
 */
function get_table_of_contents($content = null, $post_id = null) {
    global $table_of_contents;
    
    if ($content === null) {
        $content = get_the_content();
    }
    
    // Process content to add anchors
    $processed_content = $table_of_contents->generate_toc($content, $post_id);
    
    return array(
        'content' => $processed_content,
        'toc_html' => $table_of_contents->get_toc_html(),
        'has_toc' => $table_of_contents->has_headings($content)
    );
}

/**
 * Add smooth scrolling script
 */
function toc_smooth_scroll_script() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // TOC toggle functionality
        const tocToggle = document.querySelector('.c-toc-toggle');
        const tocList = document.querySelector('.c-toc-nav');
        const tocChevron = document.querySelector('.c-toc-chevron');
        
        if (tocToggle && tocList) {
            tocToggle.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                this.setAttribute('aria-expanded', !isExpanded);
                tocList.style.display = isExpanded ? 'none' : 'block';
                tocChevron.style.transform = isExpanded ? 'rotate(-90deg)' : 'rotate(0deg)';
            });
        }
        
        // Smooth scrolling for TOC links
        const tocLinks = document.querySelectorAll('.c-toc-link');
        tocLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                
                if (targetElement) {
                    const headerOffset = 100; // Adjust for sticky header
                    const elementPosition = targetElement.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                    
                    // Update active link
                    tocLinks.forEach(l => l.classList.remove('active'));
                    this.classList.add('active');
                }
            });
        });
        
        // Highlight current section on scroll
        function updateActiveLink() {
            const scrollPosition = window.scrollY + 150;
            const headings = document.querySelectorAll('h2[id], h3[id]');
            let currentId = '';
            
            headings.forEach(function(heading) {
                if (heading.offsetTop <= scrollPosition) {
                    currentId = heading.id;
                }
            });
            
            tocLinks.forEach(function(link) {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + currentId) {
                    link.classList.add('active');
                }
            });
        }
        
        // Throttled scroll listener
        let ticking = false;
        window.addEventListener('scroll', function() {
            if (!ticking) {
                requestAnimationFrame(function() {
                    updateActiveLink();
                    ticking = false;
                });
                ticking = true;
            }
        });
        
        // Initialize active link
        updateActiveLink();
    });
    </script>
    <?php
}
add_action('wp_footer', 'toc_smooth_scroll_script');