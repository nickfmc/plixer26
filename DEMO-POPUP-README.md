# Demo Popup System - Installation Guide

A complete, portable popup system for WordPress with Gravity Forms integration. Features a two-column layout with marketing details on the left and a form on the right.

## 📁 Files Included

```
inc/demo-popup.php                      - PHP functions and hooks
src/js/demo-popup.js                    - JavaScript functionality  
src/scss/components/_demo-popup.scss    - Styles (SCSS)
```

## 🚀 Installation Instructions

### Step 1: Copy Files to New Theme

Copy these files to your new WordPress theme:

1. **PHP File**: `inc/demo-popup.php` → `your-theme/inc/`
2. **JavaScript**: `src/js/demo-popup.js` → `your-theme/js/` (or assets/js/)
3. **Styles**: `src/scss/components/_demo-popup.scss` → `your-theme/scss/components/`

### Step 2: Include PHP File

Add to your theme's `functions.php`:

```php
require_once('inc/demo-popup.php');
```

### Step 3: Import SCSS

Add to your main SCSS file (usually `style.scss` or `site.scss`):

```scss
@import "./scss/components/demo-popup";
```

### Step 4: Enqueue JavaScript

The JavaScript is automatically enqueued by `demo-popup.php`. If you need to manually enqueue it, add to your theme's enqueue function:

```php
wp_enqueue_script(
    'demo-popup',
    get_template_directory_uri() . '/js/demo-popup.js',
    array('jquery'),
    '1.0.0',
    true
);
```

### Step 5: Configure Gravity Form

1. Install and activate **Gravity Forms** plugin
2. Create a new form in WordPress admin (Forms → New Form)
3. Note the Form ID (shown in the forms list)
4. Update the form ID in `inc/demo-popup.php` (line 46):
   ```php
   $form_id = 1; // Change to your form ID
   ```

## 🎯 Usage

### Method 1: Add Class to Any Element

Add the class `popup-demo` to any link or button:

```html
<a href="#" class="popup-demo">Get Free Demo</a>
<button class="popup-demo">Request Quote</button>
```

### Method 2: Use Shortcode

Use in page/post editor or templates:

```
[demo_popup_button text="Get Started" class="btn-primary"]
```

### Method 3: Use PHP Function

Use in template files:

```php
<?php echo demo_popup_trigger_button('Get Started', 'custom-class'); ?>
```

## 🎨 Customization

### Change Popup Content

Edit the HTML in `inc/demo-popup.php` in the `plixer_demo_popup_html()` function:

- **Badge text**: Line 57
- **Title**: Line 58
- **Benefits list**: Lines 60-85

### Customize Colors

The popup uses SCSS variables. Update these in your theme's `_variables.scss`:

```scss
$color-purple-dark: #371b5e;
$color-purple-one: #7B5CA1;
$color-green: #94D33F;
$color-orange: #F36B39;
```

Or override directly in `_demo-popup.scss`.

### Adjust Popup Size

In `_demo-popup.scss`, modify:

```scss
.demo-popup-container {
    max-width: 1200px; // Change popup width
    max-height: 85vh;  // Change popup height
}
```

### Change Column Widths

In `_demo-popup.scss`, adjust the flex values:

```scss
.demo-popup-details {
    flex: 0 0 45%; // Left side width (45%)
}

.demo-popup-form {
    flex: 0 0 55%; // Right side width (55%)
}
```

## 🔧 Advanced Configuration

### Use Different Forms on Different Pages

Add this to your theme's `functions.php`:

```php
add_filter('demo_popup_form_id', function() {
    if (is_page('contact')) {
        return 5; // Form ID for contact page
    } elseif (is_page('demo')) {
        return 3; // Form ID for demo page
    }
    return 1; // Default form ID
});
```

### Add ACF Integration for Form ID

```php
add_filter('demo_popup_form_id', function() {
    if (function_exists('get_field')) {
        $form_id = get_field('popup_form_id', 'option');
        if ($form_id) return $form_id;
    }
    return 1; // Fallback
});
```

### Disable Popup on Specific Pages

Add to `demo-popup.php`:

```php
function plixer_demo_popup_html() {
    // Don't show on thank you page
    if (is_page('thank-you')) {
        return;
    }
    
    // Rest of the function...
}
```

## 🎬 Features

- ✅ Fully responsive design
- ✅ Smooth animations and transitions
- ✅ Keyboard accessible (ESC to close)
- ✅ Click outside to close
- ✅ Prevents body scroll when open
- ✅ AJAX form submission ready
- ✅ Custom validation styling
- ✅ Easy to customize colors and content
- ✅ Portable - works with any WordPress theme

## 📱 Responsive Behavior

- **Desktop (980px+)**: Two-column layout
- **Tablet (768px-979px)**: Stacked layout
- **Mobile (<768px)**: Stacked layout, optimized padding

## 🐛 Troubleshooting

### Popup Not Appearing

1. Check browser console for JavaScript errors
2. Verify jQuery is loaded: `jQuery` in console should return function
3. Confirm popup HTML is in page footer (view source)
4. Check CSS is compiled and loaded

### Form Not Showing

1. Verify Gravity Forms plugin is active
2. Check form ID is correct
3. Test form shortcode directly on a page first
4. Check for PHP errors in debug.log

### Styling Issues

1. Compile SCSS to CSS: `npm run build` or your build command
2. Check CSS is enqueued: View source, search for "demo-popup"
3. Clear browser and server cache
4. Check for CSS conflicts with `!important` rules

## 📚 Dependencies

- **WordPress**: 5.0+
- **jQuery**: Included with WordPress
- **Gravity Forms**: 2.0+ (required for form functionality)
- **SCSS Compiler**: For development (Sass, PostCSS, etc.)

## 🔄 Version History

- **1.0.0** - Initial release

## 📄 License

This component is part of your theme and follows your theme's license.

## 💡 Tips

1. **Test Form First**: Create and test your Gravity Form independently before adding to popup
2. **Backup**: Always backup before adding to production
3. **Mobile Testing**: Test on real devices for best results
4. **Performance**: Popup loads on all pages - consider conditional loading for large sites
5. **Analytics**: Add tracking to popup triggers for conversion data

## 🆘 Support

For issues specific to:
- **Gravity Forms**: Check Gravity Forms documentation
- **WordPress**: Check WordPress Codex
- **Theme Integration**: Refer to your theme's documentation

---

**Ready to use!** Just add the class `popup-demo` to any element and you're set! 🎉
