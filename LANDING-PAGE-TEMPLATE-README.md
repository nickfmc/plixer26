# Landing Page Template for Paid Ads

## Overview
This high-converting landing page template is specifically designed for paid advertising campaigns. It follows industry best practices to maximize conversion rates with a clean, distraction-free design.

## Key Features

### ✅ Conversion-Optimized Design
- **No navigation distractions** - Header only shows the logo
- **Clean 2-column layout** - Content on left, form on right
- **Sticky form** - Form stays visible as users scroll
- **Mobile responsive** - Fully optimized for all devices
- **Fast loading** - Minimal dependencies

### ✅ Best Practices Implemented
1. **Clear Value Proposition** - Prominent headline and subheadline
2. **Single Call-to-Action** - Focus on form submission
3. **Trust Indicators** - Space for badges, certifications, testimonials
4. **Minimal Footer** - Only essential legal links
5. **Above-the-fold Form** - Form visible immediately on desktop
6. **Social Proof Ready** - Built-in sections for testimonials and logos

## How to Use

### 1. Create a New Page
1. Go to **Pages → Add New** in WordPress admin
2. Give your page a title (this can be overridden)
3. In the **Page Attributes** section, select **Template: Landing Page (Paid Ads)**
4. Publish or save as draft

### 2. Configure Custom Fields
After selecting the template, you'll see these custom fields:

#### **Landing Page Headline** (Optional)
- Main attention-grabbing headline
- If left empty, uses the page title
- Example: "Transform Your Network Visibility in 30 Days"
- Best practice: 5-10 words, benefit-focused

#### **Subheadline** (Optional)
- Supporting statement or value proposition
- Example: "Join 5,000+ companies who trust Plixer for network monitoring"
- Best practice: Build credibility or clarify the offer

#### **Trust Badges** (Optional)
- Add images of certifications, awards, or client logos
- Use the WYSIWYG editor to upload and arrange images
- Best practice: 3-6 recognizable logos/badges

#### **Form Headline** (Required)
- Text above the form
- Default: "Get Started Today"
- Example: "Schedule Your Free Demo"

#### **Form Subtext** (Optional)
- Brief text under form headline
- Default: "Fill out the form below..."
- Example: "No credit card required. Set up in 5 minutes."

#### **Salesforce Form Embed** (Required)
- Paste your complete Salesforce or Marketo form embed code
- Include the full `<script>` tags
- The form will be automatically styled to match the design

#### **Privacy Text** (Optional)
- Brief privacy statement below form
- Default: "We respect your privacy..."
- Link to full privacy policy if needed

### 3. Add Page Content
Use the WordPress block editor to add:
- **Benefits list** - Use bullet points (automatically gets checkmarks)
- **Feature descriptions** - Use headings and paragraphs
- **Social proof** - Add testimonials using quote blocks
- **Images/screenshots** - Add product images or screenshots

## Content Best Practices

### Writing Headlines
✅ **Good Examples:**
- "Get 40% More Network Visibility in 30 Days"
- "Stop Network Outages Before They Happen"
- "See Why 5,000+ Companies Trust Plixer"

❌ **Avoid:**
- Generic: "Welcome to Plixer"
- Vague: "We Offer Network Solutions"
- Too long: "Comprehensive Enterprise-Grade Network Monitoring and Analytics Platform"

### Benefits Over Features
✅ **Benefits-focused:**
- "Detect threats in real-time before they impact your business"
- "Reduce mean time to resolution by 60%"

❌ **Feature-focused:**
- "Includes NetFlow, sFlow, and IPFIX protocols"
- "Built on a scalable microservices architecture"

### Call-to-Action Tips
- Use action words: "Start," "Get," "Download," "Try"
- Create urgency: "Limited Time Offer"
- Remove risk: "Free Trial," "No Credit Card Required"
- Be specific: "Schedule Your Demo" vs. "Learn More"

## Styling Options

### Available CSS Classes
Add these classes to blocks in the editor for special styling:

#### `.landing-page-cta-button`
Creates a prominent green CTA button
```html
<a href="#form" class="landing-page-cta-button">Start Your Free Trial</a>
```

#### `.landing-page-badge`
Yellow badge for urgency/scarcity
```html
<span class="landing-page-badge">Limited Time Offer</span>
```

#### `.landing-page-highlight`
Highlighted box for key benefits
```html
<div class="landing-page-highlight">
  <p><strong>Money-Back Guarantee:</strong> Try Plixer risk-free for 30 days.</p>
</div>
```

#### `.landing-page-social-proof`
Styled testimonial box
```html
<div class="landing-page-social-proof">
  <p>"Plixer helped us reduce network incidents by 75% in the first quarter."</p>
  <cite>— John Smith, CTO at TechCorp</cite>
</div>
```

## Form Integration

### Salesforce Web-to-Lead
```html
<form action="https://webto.salesforce.com/servlet/servlet.WebToLead" method="POST">
  <input type="hidden" name="oid" value="YOUR_ORG_ID">
  <input type="hidden" name="retURL" value="https://yoursite.com/thank-you">
  
  <label for="first_name">First Name</label>
  <input id="first_name" name="first_name" type="text" required>
  
  <label for="last_name">Last Name</label>
  <input id="last_name" name="last_name" type="text" required>
  
  <label for="email">Email</label>
  <input id="email" name="email" type="email" required>
  
  <label for="company">Company</label>
  <input id="company" name="company" type="text" required>
  
  <button type="submit">Request Demo</button>
</form>
```

### Marketo Forms
```html
<script src="//app-abc123.marketo.com/js/forms2/js/forms2.min.js"></script>
<form id="mktoForm_1234"></form>
<script>
  MktoForms2.loadForm("//app-abc123.marketo.com", "123-ABC-456", 1234);
</script>
```

## Tracking & Analytics

### Google Tag Manager
The template includes GTM by default. Track form submissions:

```javascript
// Add to your form's onsubmit event
dataLayer.push({
  'event': 'formSubmission',
  'formType': 'landing-page',
  'formName': 'paid-ads-landing'
});
```

### Google Ads Conversion Tracking
Add conversion tracking in the Custom Fields or form success callback:

```html
<script>
  gtag('event', 'conversion', {
    'send_to': 'AW-1068318176/abc123'
  });
</script>
```

## Testing Checklist

Before launching your landing page:

- [ ] **Headline** - Clear, benefit-focused, attention-grabbing?
- [ ] **Value Proposition** - Does it answer "What's in it for me?"
- [ ] **Form** - All fields necessary? Can you remove any?
- [ ] **CTA** - Clear what happens after submission?
- [ ] **Trust Signals** - Logos, testimonials, guarantees present?
- [ ] **Mobile** - Test on actual mobile device
- [ ] **Load Speed** - Page loads in under 3 seconds?
- [ ] **Form Submission** - Tested end-to-end?
- [ ] **Thank You Page** - Working and with conversion tracking?
- [ ] **Legal** - Privacy policy and terms linked?
- [ ] **Tracking** - Google Analytics and Ads conversion tracking working?

## A/B Testing Ideas

Test these elements to improve conversion:
1. **Headline variations** - Different benefit statements
2. **Form length** - Fewer vs. more fields
3. **CTA text** - "Get Started" vs. "Request Demo" vs. "Start Free Trial"
4. **Social proof position** - Above vs. below fold
5. **Image vs. video** - Hero image vs. explainer video
6. **Form placement** - Right side vs. centered below content

## Technical Details

### Files Created
- `template-landing-page.php` - Main template file
- `src/scss/components/_landing-page.scss` - Styles
- `acf-json/group_landing_page_fields.json` - ACF fields configuration

### Browser Support
- Chrome, Firefox, Safari, Edge (latest 2 versions)
- IE11 supported with minor degradation

### Performance
- No additional JavaScript dependencies
- Minimal CSS (< 15KB)
- Lazy loading for images recommended

## Troubleshooting

### Form not submitting
- Check Salesforce/Marketo embed code is complete
- Verify form action URL is correct
- Check browser console for JavaScript errors

### Styles not applying
- Run `npm run build` or compile SCSS
- Clear browser cache
- Check if template is selected correctly

### ACF fields not showing
- Ensure ACF Pro plugin is active
- Check that `acf-json` folder has correct permissions
- Re-sync field groups in ACF settings

## Support & Resources

- **Landing Page Best Practices:** [Unbounce Blog](https://unbounce.com/landing-pages/)
- **Conversion Optimization:** [CXL Institute](https://cxl.com/)
- **Form Design:** [Baymard Institute](https://baymard.com/blog/form-design-best-practices)

---

**Version:** 1.0  
**Created:** January 2026  
**Last Updated:** January 5, 2026
