# Demo Popup System - Installation Complete! ✅

## What Was Created

I've successfully created a complete, portable popup system for your WordPress theme with Gravity Forms integration. Here's what's been added:

### 📁 New Files Created

1. **`inc/demo-popup.php`** - Main PHP functionality
   - Handles popup rendering
   - Enqueues scripts
   - Provides shortcodes and helper functions
   - Gravity Forms integration

2. **`src/js/demo-popup.js`** - JavaScript functionality
   - Opens/closes popup
   - Handles click events
   - Keyboard navigation (ESC to close)
   - Click outside to close

3. **`src/scss/components/_demo-popup.scss`** - Complete styling
   - Two-column responsive layout
   - Purple gradient background (matching your brand)
   - Smooth animations
   - Mobile-optimized
   - Gravity Forms styling

### 📝 Documentation Files

4. **`DEMO-POPUP-README.md`** - Complete installation guide
5. **`DEMO-POPUP-EXAMPLES.html`** - Usage examples
6. **`DEMO-POPUP-PACKAGE-README.md`** - Portability guide

### 🔧 Files Modified

7. **`functions.php`** - Added require for demo-popup.php
8. **`src/site.scss`** - Imported _demo-popup.scss
9. **`src/site.js`** - Required demo-popup.js

## 🚀 Next Steps

### 1. Build Your Assets

Since your theme uses Prepros, you need to compile the SCSS and JS:

**Option A: Using Prepros (Recommended)**
- Open Prepros
- The project should auto-compile when you save files
- Wait for compilation to complete

**Option B: Manual Check**
- Check if `dist/site.bundle.js` was updated
- Check if `dist/main.bundle.css` was updated

### 2. Create Your Gravity Form

1. Go to WordPress Admin → Forms → New Form
2. Create your form with these fields (recommended):
   - Full Name
   - Email
   - Phone Number
   - Message/Comments
3. Note the Form ID (you'll see it in the forms list)

### 3. Configure the Form ID

Edit `inc/demo-popup.php` and change line 46:

```php
$form_id = 1; // Change to your actual Gravity Form ID
```

### 4. Test the Popup

Add this code anywhere to test:

```html
<a href="#" class="popup-demo">Click to Test Popup</a>
```

Or use the shortcode in a page:
```
[demo_popup_button text="Get Demo"]
```

## 🎨 Customization

### Change Popup Content

Edit `inc/demo-popup.php` starting at line 56:
- Badge text: "EXCLUSIVE"
- Title: "Get a Free Case Evaluation"
- Benefits list items

### Adjust Colors

The popup uses your existing theme colors:
- `$color-purple-dark` (#371b5e) - Background
- `$color-purple-one` (#7B5CA1) - Accents
- `$color-orange` (#F36B39) - CTA button
- `$color-green` (#94D33F) - Checkmarks

These are already defined in your `_variables.scss`.

### Change Popup Size

In `_demo-popup.scss`:
```scss
.demo-popup-container {
    max-width: 1200px; // Adjust width
}
```

## 📱 How It Works

1. **User clicks** any element with class `popup-demo`
2. **Popup appears** with smooth animation
3. **User fills** out the Gravity Form
4. **Form submits** via AJAX (Gravity Forms handles this)
5. **User can close** by clicking X, clicking outside, or pressing ESC

## ✨ Features Included

- ✅ Fully responsive (desktop, tablet, mobile)
- ✅ Smooth animations and transitions
- ✅ Keyboard accessible
- ✅ Click outside to close
- ✅ Body scroll prevention when open
- ✅ AJAX form submission ready
- ✅ Custom validation styling
- ✅ Easy to customize
- ✅ **Portable** - easy to move to other themes!

## 🎯 Usage Examples

### Basic Link
```html
<a href="#" class="popup-demo">Get Free Demo</a>
```

### Button with Your Existing Classes
```html
<button class="btn btn-primary popup-demo">Request Quote</button>
```

### Shortcode in Page Editor
```
[demo_popup_button text="Schedule Consultation" class="custom-class"]
```

### PHP in Template Files
```php
<?php echo demo_popup_trigger_button('Contact Us', 'header-btn'); ?>
```

## 🔄 Porting to Another Theme

Everything is organized for easy portability:

1. Copy these 3 files to new theme:
   - `inc/demo-popup.php`
   - `js/demo-popup.js` (or wherever your theme keeps JS)
   - `scss/components/_demo-popup.scss`

2. Include in new theme:
   - Add `require_once('inc/demo-popup.php');` to functions.php
   - Import SCSS in your main stylesheet
   - Require JS in your main JS file (or let PHP enqueue it)

3. Done! Everything will work the same way.

## 🐛 Troubleshooting

### Popup Not Appearing
- Check browser console for errors
- Verify assets are compiled (check Network tab)
- Confirm jQuery is loaded

### Form Not Showing
- Install Gravity Forms plugin
- Verify form ID is correct
- Make sure form is published

### Styles Look Wrong
- Run Prepros to compile SCSS
- Clear browser cache
- Check for CSS conflicts

## 📞 Need Help?

All the documentation is in these files:
- `DEMO-POPUP-README.md` - Full setup guide
- `DEMO-POPUP-EXAMPLES.html` - Code examples
- `DEMO-POPUP-PACKAGE-README.md` - Portability guide

## 🎉 You're All Set!

The popup system is fully integrated and ready to use. Just:

1. Compile your assets (Prepros)
2. Set your Gravity Form ID
3. Add `class="popup-demo"` to any element

**Test it now:**
```html
<a href="#" class="popup-demo">Test Popup</a>
```

Happy coding! 🚀
