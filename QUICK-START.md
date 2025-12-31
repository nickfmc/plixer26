# 🚀 QUICK START - Demo Popup

## Immediate Next Steps

### ⚡ Step 1: Compile Assets (Required!)

Your theme uses **Prepros** for compiling. Open Prepros and let it compile the new files.

Or check that these files exist and are recent:
- `dist/site.bundle.js`
- `dist/main.bundle.css`

### 📝 Step 2: Create Gravity Form

1. WordPress Admin → **Forms** → **New Form**
2. Add fields:
   - First Name
   - Last Name  
   - Email
   - Phone
   - Message
3. Save and note the **Form ID** (shows in forms list)

### 🎯 Step 3: Set Form ID

Open: `inc/demo-popup.php`

Find line 46 and change:
```php
$form_id = 1; // ← Change this to your actual Form ID
```

### ✅ Step 4: Test It!

Add this HTML anywhere on your site:
```html
<a href="#" class="popup-demo">TEST POPUP</a>
```

Refresh page and click the link. Popup should appear!

---

## Quick Reference

### Trigger Popup from HTML
```html
<a href="#" class="popup-demo">Text Here</a>
```

### Trigger Popup with Shortcode
```
[demo_popup_button text="Get Demo"]
```

### Trigger Popup from PHP
```php
<?php echo demo_popup_trigger_button('Button Text'); ?>
```

---

## What Gets Triggered?

Any element with the class `popup-demo` will open the popup when clicked.

Examples:
- `<a href="#" class="popup-demo">Link</a>`
- `<button class="popup-demo">Button</button>`
- `<div class="popup-demo">Div</div>`
- `<span class="btn popup-demo">Span</span>`

---

## Customize Content

Edit `inc/demo-popup.php` starting at line 56:

```php
<div class="demo-popup-badge">EXCLUSIVE</div> // Badge text
<h2 class="demo-popup-title">Get a Free<br>Case Evaluation</h2> // Title
```

Change the 3 benefit items in lines 60-85.

---

## Files Created

✅ `inc/demo-popup.php` - Backend functionality  
✅ `src/js/demo-popup.js` - Frontend JavaScript  
✅ `src/scss/components/_demo-popup.scss` - Styles  
✅ Documentation files (4 markdown files)

## Files Modified

✅ `functions.php` - Added require statement  
✅ `src/site.scss` - Imported popup styles  
✅ `src/site.js` - Required popup JavaScript

---

## Color Scheme Used

The popup matches your existing brand colors:

- **Purple Dark** (#371b5e) - Background gradient
- **Purple One** (#7B5CA1) - Accents, borders
- **Orange** (#F36B39) - CTA button, badge
- **Green** (#94D33F) - Checkmarks, success states

---

## Need More Info?

📖 **INSTALLATION-COMPLETE.md** - Overview of everything  
📖 **DEMO-POPUP-README.md** - Detailed setup guide  
📖 **DEMO-POPUP-EXAMPLES.html** - Code examples  
📖 **DEMO-POPUP-PACKAGE-README.md** - How to port to other themes

---

## Troubleshooting

**Popup doesn't appear?**
1. Compile assets in Prepros
2. Hard refresh browser (Ctrl+F5)
3. Check console for errors

**Form not showing?**
1. Install Gravity Forms plugin
2. Check form ID is correct
3. Make sure form is published

**Styles look broken?**
1. Run Prepros compile
2. Clear all caches
3. Check CSS loaded in Network tab

---

## 🎉 You're Ready!

Just compile with Prepros, set your form ID, and start using `class="popup-demo"` on any element!

```html
<a href="#" class="popup-demo">Click Me!</a>
```
