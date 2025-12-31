# Demo Popup - Visual Structure

## Layout Preview

```
┌────────────────────────────────────────────────────────────────┐
│  [X]                                                           │
│  ┌──────────────────┬─────────────────────────────────────┐   │
│  │                  │                                     │   │
│  │  LEFT COLUMN     │    RIGHT COLUMN                     │   │
│  │  (Details)       │    (Gravity Form)                   │   │
│  │                  │                                     │   │
│  │  ┌────────────┐  │    [Full Name Input]                │   │
│  │  │ EXCLUSIVE  │  │    [Email Input]                    │   │
│  │  └────────────┘  │    [Phone Input]                    │   │
│  │                  │    [Message Textarea]               │   │
│  │  Get a Free      │    [Submit Button]                  │   │
│  │  Case Evaluation │                                     │   │
│  │                  │                                     │   │
│  │  ✓ Benefit 1     │                                     │   │
│  │  ✓ Benefit 2     │                                     │   │
│  │  ✓ Benefit 3     │                                     │   │
│  │                  │                                     │   │
│  └──────────────────┴─────────────────────────────────────┘   │
└────────────────────────────────────────────────────────────────┘
```

## Color Scheme

```
┌─────────────────────────────────────────────────┐
│ Background: Purple Gradient                     │
│ #1a0d2d → #2d1a4d                              │
│                                                 │
│ ┌─────────────────────┐  ┌───────────────────┐ │
│ │ LEFT (Purple Tint)  │  │ RIGHT (White BG)  │ │
│ │                     │  │                   │ │
│ │ ┌──────┐            │  │ Form Fields       │ │
│ │ │Orange│ Badge      │  │ Border: #e0e0e0   │ │
│ │ └──────┘            │  │ Focus: #7B5CA1    │ │
│ │                     │  │                   │ │
│ │ White Text          │  │ ┌──────────────┐  │ │
│ │                     │  │ │ Orange Button│  │ │
│ │ ○ Green Checkmarks  │  │ └──────────────┘  │ │
│ │                     │  │                   │ │
│ └─────────────────────┘  └───────────────────┘ │
└─────────────────────────────────────────────────┘
```

## File Relationship Diagram

```
┌─────────────────────────────────────────────────┐
│              WORDPRESS THEME                    │
│                                                 │
│  ┌──────────────────────────────────────────┐  │
│  │ functions.php                            │  │
│  │ ├─ require inc/demo-popup.php            │  │
│  │ │                                        │  │
│  │ └──> ┌────────────────────────────────┐ │  │
│  │      │ inc/demo-popup.php             │ │  │
│  │      │ • Enqueues JS                  │ │  │
│  │      │ • Renders HTML                 │ │  │
│  │      │ • Gravity Forms integration    │ │  │
│  │      └────────────────────────────────┘ │  │
│  └──────────────────────────────────────────┘  │
│                                                 │
│  ┌──────────────────────────────────────────┐  │
│  │ src/site.js                              │  │
│  │ └─ require('./js/demo-popup.js')         │  │
│  │                                          │  │
│  │    ┌────────────────────────────────┐   │  │
│  │    │ src/js/demo-popup.js           │   │  │
│  │    │ • Click handlers               │   │  │
│  │    │ • Open/close logic             │   │  │
│  │    │ • Keyboard navigation          │   │  │
│  │    └────────────────────────────────┘   │  │
│  └──────────────────────────────────────────┘  │
│                                                 │
│  ┌──────────────────────────────────────────┐  │
│  │ src/site.scss                            │  │
│  │ └─ @import "components/demo-popup"       │  │
│  │                                          │  │
│  │    ┌────────────────────────────────┐   │  │
│  │    │ src/scss/components/           │   │  │
│  │    │ _demo-popup.scss               │   │  │
│  │    │ • Layout styles                │   │  │
│  │    │ • Colors & gradients           │   │  │
│  │    │ • Responsive design            │   │  │
│  │    │ • Form styling                 │   │  │
│  │    └────────────────────────────────┘   │  │
│  └──────────────────────────────────────────┘  │
│                                                 │
│  ┌──────────────────────────────────────────┐  │
│  │ PREPROS                                  │  │
│  │ Compiles ↓                               │  │
│  └──────────────────────────────────────────┘  │
│           │                                     │
│           ↓                                     │
│  ┌──────────────────────────────────────────┐  │
│  │ dist/                                    │  │
│  │ ├─ site.bundle.js                        │  │
│  │ └─ main.bundle.css                       │  │
│  └──────────────────────────────────────────┘  │
└─────────────────────────────────────────────────┘
```

## User Interaction Flow

```
┌───────────────────────────────────────────────────────┐
│ 1. USER CLICKS TRIGGER                                │
│    <a href="#" class="popup-demo">Get Demo</a>        │
└───────────────┬───────────────────────────────────────┘
                │
                ↓
┌───────────────────────────────────────────────────────┐
│ 2. JAVASCRIPT CATCHES EVENT                           │
│    demo-popup.js → openPopup()                        │
└───────────────┬───────────────────────────────────────┘
                │
                ↓
┌───────────────────────────────────────────────────────┐
│ 3. POPUP APPEARS                                      │
│    • Overlay fades in                                 │
│    • Popup scales up                                  │
│    • Body scroll locked                               │
└───────────────┬───────────────────────────────────────┘
                │
                ↓
┌───────────────────────────────────────────────────────┐
│ 4. USER FILLS FORM                                    │
│    Gravity Forms handles validation                   │
└───────────────┬───────────────────────────────────────┘
                │
                ↓
┌───────────────────────────────────────────────────────┐
│ 5. USER SUBMITS                                       │
│    Gravity Forms AJAX submission                      │
└───────────────┬───────────────────────────────────────┘
                │
                ↓
┌───────────────────────────────────────────────────────┐
│ 6. SUCCESS MESSAGE                                    │
│    Or validation errors displayed                     │
└───────────────────────────────────────────────────────┘

┌───────────────────────────────────────────────────────┐
│ CLOSE OPTIONS (anytime after step 3):                │
│ • Click [X] button                                    │
│ • Click outside popup                                 │
│ • Press ESC key                                       │
└───────────────────────────────────────────────────────┘
```

## Responsive Behavior

### Desktop (980px and up)
```
┌─────────────────────────────────────────────┐
│ ┌─────────────────┬─────────────────────┐   │
│ │     Details     │       Form          │   │
│ │                 │                     │   │
│ │      45%        │        55%          │   │
│ │                 │                     │   │
│ └─────────────────┴─────────────────────┘   │
└─────────────────────────────────────────────┘
```

### Tablet/Mobile (below 980px)
```
┌─────────────────────────────┐
│ ┌─────────────────────────┐ │
│ │       Details           │ │
│ │                         │ │
│ │        100%             │ │
│ │                         │ │
│ ├─────────────────────────┤ │
│ │        Form             │ │
│ │                         │ │
│ │        100%             │ │
│ │                         │ │
│ └─────────────────────────┘ │
└─────────────────────────────┘
```

## Class Structure

```
.demo-popup-overlay (Full screen overlay)
  │
  └── .demo-popup-container (Popup box)
        │
        ├── .demo-popup-close (X button)
        │
        └── .demo-popup-content (Content wrapper)
              │
              ├── .demo-popup-details (Left column)
              │     │
              │     ├── .demo-popup-badge
              │     ├── .demo-popup-title
              │     └── .demo-popup-benefits (UL)
              │           └── li (with checkmark SVG)
              │
              └── .demo-popup-form (Right column)
                    │
                    └── .demo-popup-form-inner
                          │
                          └── [Gravity Form]
```

## Trigger Patterns

```
METHOD 1: HTML Class
──────────────────────────────────────
<element class="popup-demo">Text</element>
                ↓
        Opens popup on click


METHOD 2: Shortcode
──────────────────────────────────────
[demo_popup_button text="Get Demo"]
                ↓
        Renders: <a class="popup-demo">Get Demo</a>
                ↓
        Opens popup on click


METHOD 3: PHP Function
──────────────────────────────────────
demo_popup_trigger_button('Text', 'class')
                ↓
        Outputs: <a class="popup-demo class">Text</a>
                ↓
        Opens popup on click
```

## State Management

```
POPUP STATES:
─────────────────────────────────────

┌─────────────┐
│  Hidden     │  opacity: 0, visibility: hidden
└──────┬──────┘
       │ .popup-demo clicked
       ↓
┌─────────────┐
│  Opening    │  Transition starts
└──────┬──────┘
       │ 0.3s animation
       ↓
┌─────────────┐
│  Visible    │  .active class added
│             │  opacity: 1, visibility: visible
│             │  Body scroll locked
└──────┬──────┘
       │ Close trigger
       ↓
┌─────────────┐
│  Closing    │  .active class removed
└──────┬──────┘
       │ 0.3s animation
       ↓
┌─────────────┐
│  Hidden     │  Back to start
└─────────────┘
```

## Integration Points

```
YOUR THEME
    │
    ├─→ functions.php
    │       └─→ require inc/demo-popup.php
    │               ├─→ Enqueues JS
    │               ├─→ Adds popup HTML to footer
    │               ├─→ Registers shortcodes
    │               └─→ Provides helper functions
    │
    ├─→ site.scss
    │       └─→ @import demo-popup styles
    │               ├─→ Uses theme variables
    │               ├─→ Responsive breakpoints
    │               └─→ Form styling
    │
    └─→ site.js
            └─→ require demo-popup.js
                    ├─→ Event listeners
                    ├─→ Open/close logic
                    └─→ Keyboard handling

GRAVITY FORMS PLUGIN
    │
    └─→ Provides form functionality
            ├─→ Form rendering
            ├─→ Validation
            ├─→ AJAX submission
            └─→ Email notifications
```

---

This visual guide should help understand the complete structure and flow of the popup system!
