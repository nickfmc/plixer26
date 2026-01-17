# Landing Page Template - Quick Start Guide

## 🚀 Quick Setup (5 Minutes)

### Step 1: Create Page
1. WordPress Admin → **Pages** → **Add New**
2. Title: "Free Demo - Network Monitoring"
3. **Template**: Select "Landing Page (Paid Ads)"

### Step 2: Fill Custom Fields
After selecting template, scroll down to see fields:

**Landing Page Headline:**
```
Stop Network Outages Before They Happen
```

**Subheadline:**
```
Join 5,000+ companies using Plixer for real-time network visibility and threat detection
```

**Form Headline:**
```
Get Your Free Demo
```

**Form Subtext:**
```
See Plixer in action. No credit card required. Setup in minutes.
```

**Salesforce Form Embed:**
```html
<!-- Paste your Salesforce form code here -->
```

**Privacy Text:**
```
We respect your privacy. By submitting this form, you agree to our Privacy Policy. We'll never share your information.
```

### Step 3: Add Page Content
Click in the main editor and add these blocks:

#### Intro Paragraph
```
Plixer's network monitoring platform gives you complete visibility into your network traffic, 
helping you detect threats, troubleshoot issues, and optimize performance—all in real-time.
```

#### Benefits List (use bullets)
```
✓ Real-time threat detection powered by AI
✓ Reduce mean time to resolution by 60%
✓ Complete NetFlow, sFlow, and IPFIX support
✓ Deploy in minutes, not months
✓ 24/7 expert support included
```

#### Why Choose Plixer Heading
```
## Why 5,000+ Companies Trust Plixer
```

#### Features (use bullets)
```
• Instant Visibility: See every device, user, and application on your network
• Smart Alerts: AI-powered anomaly detection catches issues before they escalate
• Easy Integration: Works with your existing network infrastructure
• Proven Results: Average ROI of 327% in first year (Forrester TEI Study)
```

#### Social Proof Section
Add a Quote block:
```
"Plixer helped us identify and resolve a critical security threat within minutes. 
It would have taken hours with our old tools."

— Sarah Johnson, IT Director at Global Finance Corp
```

#### Trust Badges
In the **Trust Badges** custom field (or here), add logos:
- SOC 2 Certified badge
- ISO 27001 badge
- AWS Partner badge
- Client company logos (if allowed)

### Step 4: Compile & Preview
1. If using SCSS: Run `npm run build` in terminal
2. Click **Preview** to see your landing page
3. Test the form submission
4. Check on mobile device

---

## 📋 Pre-Launch Checklist

### Content
- [ ] Headline clearly states main benefit
- [ ] Subheadline adds credibility or urgency
- [ ] Benefits are specific and measurable
- [ ] At least one testimonial or trust indicator
- [ ] Form has clear CTA button text

### Technical
- [ ] Form submits successfully
- [ ] Thank you page redirects correctly
- [ ] Google Analytics tracking code present
- [ ] Google Ads conversion tracking setup
- [ ] Mobile responsive (test on phone)
- [ ] Page loads in < 3 seconds

### Legal
- [ ] Privacy policy linked
- [ ] Terms of use linked
- [ ] Cookie consent banner working
- [ ] GDPR compliant (if applicable)

### Testing
- [ ] Test form with real email
- [ ] Check confirmation email arrives
- [ ] Verify lead appears in Salesforce
- [ ] Test all links
- [ ] Spell check all content

---

## 🎨 Color Customization

Want to match your brand colors? Edit these variables in `_landing-page.scss`:

```scss
// Brand Colors
$brand-primary: #0066cc;    // Change to your primary color
$brand-success: #28a745;    // CTA button color
$brand-dark: #003865;       // Headings color

// Then update in the file:
// Line ~85: color: $brand-dark; (for headlines)
// Line ~240: background: $brand-primary; (for form input focus)
// Line ~275: background: $brand-primary; (for submit button)
```

---

## 📱 Mobile Optimization

The template is fully responsive. Key breakpoints:

- **Desktop** (1200px+): Side-by-side layout
- **Tablet** (992px-1199px): Slightly narrower columns
- **Mobile** (< 992px): Stacked layout (content above form)

Test on actual devices, not just browser resize!

---

## 🔄 A/B Testing Templates

### Variation A: Short Form
**Fields:** Name, Email, Company
**Hypothesis:** Fewer fields = higher conversion

### Variation B: Urgency Badge
Add at top of page:
```html
<span class="landing-page-badge">🔥 Limited Spots Available</span>
```

### Variation C: Video
Replace first paragraph with:
```html
<div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
  <iframe src="https://www.youtube.com/embed/YOUR_VIDEO_ID" 
          style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
          frameborder="0" allowfullscreen></iframe>
</div>
```

---

## 🎯 Conversion Rate Benchmarks

**Industry Average (B2B SaaS):** 2-5%
**Good Landing Page:** 5-10%
**Great Landing Page:** 10-20%

### If conversion rate is low:
1. **Simplify headline** - Is benefit immediately clear?
2. **Reduce form fields** - Ask for minimum information
3. **Add trust signals** - Security badges, testimonials, client logos
4. **Create urgency** - Limited time offer, scarcity
5. **Improve CTA** - "Start Free Trial" beats "Submit"

### If conversion rate is high:
1. **Add qualification fields** - Ensure lead quality
2. **Test higher value offers** - Demo vs. Trial vs. Consultation
3. **Increase traffic** - Scale what's working

---

## 📞 Support

Need help? Common issues:

**Fields not showing?**
- Check ACF Pro plugin is active
- Go to Custom Fields → Sync available

**Styles not loading?**
- Run: `npm install` then `npm run build`
- Clear browser cache

**Form not submitting?**
- Check Salesforce org ID is correct
- Verify return URL exists
- Check browser console for errors

---

## 🚀 Next Steps

1. **Set up tracking:** Google Analytics goals + conversion tracking
2. **Create thank you page:** Clear next steps after form submission
3. **Email follow-up:** Automated email sequence
4. **Lead scoring:** Prioritize hot leads in Salesforce
5. **Test & iterate:** A/B test headline, form, CTA every 2 weeks

---

**Need the full documentation?** See `LANDING-PAGE-TEMPLATE-README.md`
