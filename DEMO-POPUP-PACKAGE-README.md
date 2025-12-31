# Demo Popup - Portable Package

This folder contains everything needed to add the demo popup to any WordPress theme.

## 📦 Package Contents

```
demo-popup-package/
├── README.md                          (This file)
├── INSTALLATION.md                    (Step-by-step guide)
├── EXAMPLES.html                      (Usage examples)
├── php/
│   └── demo-popup.php                (Main PHP functions)
├── js/
│   └── demo-popup.js                 (JavaScript functionality)
└── scss/
    └── _demo-popup.scss              (Styles)
```

## ⚡ Quick Start (3 Steps)

1. **Copy files to your theme**
   ```
   php/demo-popup.php       → your-theme/inc/
   js/demo-popup.js         → your-theme/js/
   scss/_demo-popup.scss    → your-theme/scss/components/
   ```

2. **Include in functions.php**
   ```php
   require_once('inc/demo-popup.php');
   ```

3. **Import SCSS in your main stylesheet**
   ```scss
   @import "components/demo-popup";
   ```

4. **Add to any element**
   ```html
   <a href="#" class="popup-demo">Get Demo</a>
   ```

## 📋 Requirements

- WordPress 5.0+
- Gravity Forms plugin
- jQuery (included with WordPress)
- SCSS compiler (for development)

## 🎯 What You Get

- ✅ Beautiful two-column popup design
- ✅ Responsive mobile layout
- ✅ Gravity Forms integration
- ✅ Smooth animations
- ✅ Keyboard accessible
- ✅ Easy to customize
- ✅ Works with any theme

## 📝 Configuration

### Set Your Form ID

In `demo-popup.php`, line 46:
```php
$form_id = 1; // Change to your Gravity Form ID
```

### Customize Content

Edit the popup text in `demo-popup.php`:
- Badge text (line 57)
- Title (line 58)  
- Benefits list (lines 60-85)

### Adjust Colors

The popup uses these SCSS variables (from your theme):
- `$color-purple-dark` - Background gradients
- `$color-purple-one` - Accents
- `$color-orange` - CTA buttons and badge
- `$color-green` - Check marks

Override in `_demo-popup.scss` or your theme's variables.

## 🔧 Integration Methods

### Method 1: Webpack/Bundler Themes

If your theme uses webpack or similar:

```javascript
// In your main JS file (site.js, app.js, etc.)
require('./js/demo-popup.js');
```

### Method 2: Direct Enqueue (Traditional Themes)

The PHP file handles enqueuing automatically. No extra steps needed!

### Method 3: Manual Enqueue

If needed, add to your theme's functions:

```php
function my_theme_scripts() {
    wp_enqueue_script(
        'demo-popup',
        get_template_directory_uri() . '/js/demo-popup.js',
        array('jquery'),
        '1.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'my_theme_scripts');
```

## 🎨 Customization Tips

### Change Popup Width
```scss
.demo-popup-container {
    max-width: 1000px; // Default is 1200px
}
```

### Change Column Split
```scss
.demo-popup-details {
    flex: 0 0 40%; // Left side (was 45%)
}
.demo-popup-form {
    flex: 0 0 60%; // Right side (was 55%)
}
```

### Add Your Logo
```php
// In demo-popup.php, add after line 58:
<img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Logo">
```

### Change Animation Speed
```scss
.demo-popup-overlay {
    transition: opacity 0.5s ease; // Default is 0.3s
}
```

## 🐛 Troubleshooting

**Popup doesn't appear?**
- Check console for JS errors
- Verify jQuery is loaded
- Confirm files are enqueued (view page source)

**Form not showing?**
- Install Gravity Forms plugin
- Verify form ID is correct
- Check form is published (not in trash)

**Styles look wrong?**
- Compile SCSS to CSS
- Clear cache (browser + server)
- Check for CSS conflicts

## 📱 Mobile Responsive

The popup automatically adapts:
- **Desktop**: Side-by-side layout
- **Tablet/Mobile**: Stacked layout
- Touch-friendly close button
- Optimized font sizes

## ♿ Accessibility

- Keyboard navigation (Tab, Enter, Esc)
- Screen reader friendly
- ARIA labels on buttons
- Focus management
- High contrast support

## 🔒 Security

- All inputs sanitized
- Gravity Forms handles validation
- XSS protection
- CSRF protection via WordPress nonces

## 📊 Analytics Tracking

Add tracking to popup opens:

```javascript
// In demo-popup.js, in openPopup function:
openPopup: function() {
    $('#demo-popup-overlay').addClass('active');
    $('body').addClass('demo-popup-open');
    
    // Add your tracking here
    if (typeof gtag !== 'undefined') {
        gtag('event', 'popup_open', {
            'event_category': 'engagement',
            'event_label': 'demo_popup'
        });
    }
}
```

## 🔄 Updates & Maintenance

This is a standalone component with no external dependencies (except WordPress and Gravity Forms). 

To update:
1. Backup your customizations
2. Replace files with new versions
3. Re-apply customizations
4. Test thoroughly

## 📞 Support Resources

- **Gravity Forms Docs**: https://docs.gravityforms.com/
- **WordPress Codex**: https://codex.wordpress.org/
- **CSS-Tricks**: https://css-tricks.com/

## 🎉 You're Ready!

The popup system is fully portable and ready to use. Just add the class `popup-demo` to any element and you're set!

**Example:**
```html
<a href="#" class="popup-demo">Click Me!</a>
```

Happy coding! 🚀
