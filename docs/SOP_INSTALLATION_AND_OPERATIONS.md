# Standard Operating Procedures (SOP): Installation, Operations & Maintenance

## Document Details
- **Document ID:** SOP-WP-THEME-001
- **Product:** Ross Portfolio Theme (`ross-portfolio-theme`)
- **Target Audience:** DevOps Engineers, Web Administrators, Technical Project Managers, Security Auditors
- **Revision:** 1.0.0
- **Status:** Approved for Production Deployment

---

## 1. Prerequisites & Server Environment Requirements

### 1.1 Server Infrastructure Minimums
- **Web Server:** Nginx 1.20+ or Apache 2.4+ (with `mod_rewrite` enabled).
- **PHP Version:** PHP 7.4, 8.0, 8.1, 8.2, or 8.3.
- **PHP Memory Limit:** 128MB minimum (256MB recommended for high-traffic or media processing).
- **PHP Extensions Required:** `curl`, `mbstring`, `openssl`, `json`, `dom`, `gd` (or `imagick`), `mysqli`.
- **Database Engine:** MySQL 5.7+ or MariaDB 10.3+.
- **WordPress Version:** WordPress 6.0 or higher.
- **SSL / TLS:** Active SSL certificate (HTTPS enforced).

---

## 2. Standard Installation Procedures

### Procedure A: Installation via WordPress Admin Dashboard (ZIP Upload)
1. Log in to the target WordPress administration panel as an Administrator (`https://yourdomain.com/wp-admin`).
2. Navigate to **Appearance > Themes**.
3. Click the **Add New** button at the top of the screen, then click **Upload Theme**.
4. Click **Choose File** and select `ross-portfolio-theme.zip`.
5. Click **Install Now**.
6. Once WordPress unpacks and validates the theme package, click **Activate**.

### Procedure B: Manual Deployment via SFTP / SSH
1. Connect to the production server via SSH or SFTP.
2. Navigate to the WordPress themes directory:
   ```bash
   cd /var/www/html/wp-content/themes/
   ```
3. Extract or clone the theme directory into `ross-portfolio-theme`:
   ```bash
   # If copying the folder
   cp -r /path/to/source/ross-portfolio-theme ./

   # Or if extracting a zip archive
   unzip ross-portfolio-theme.zip -d ./
   ```
4. Set standard WordPress ownership and directory permissions:
   ```bash
   chown -R www-data:www-data ross-portfolio-theme/
   find ross-portfolio-theme/ -type d -exec chmod 755 {} \;
   find ross-portfolio-theme/ -type f -exec chmod 644 {} \;
   ```
5. Log into WordPress admin dashboard and activate **Ross Portfolio Theme** under **Appearance > Themes**, or activate via WP-CLI:
   ```bash
   wp theme activate ross-portfolio-theme --path=/var/www/html
   ```

---

## 3. Post-Activation Initial Setup & Content Seeding

### 3.1 Automated Demo Seeding
The theme contains a non-destructive seeder (`inc/seeder.php`) that runs once upon initial theme activation:
- Automatically creates essential baseline pages if missing: **Home**, **Blog**, **Contact**, **Projects**, and **About**.
- Automatically configures **Settings > Reading** to use static front page mode (`page_on_front` = Home, `page_for_posts` = Blog).
- Generates a sample high-performance architecture post to verify typography and code highlighting.
- Builds a primary navigation menu (`Primary Navigation`) with links to Home, About, Projects, Blog, and Contact, and assigns it to the `primary` theme location.

### 3.2 Manual Navigation Verification
If a custom menu already exists:
1. Navigate to **Appearance > Menus**.
2. Under **Menu Settings > Display location**, ensure **Primary Navigation** is checked.
3. Save changes.

---

## 4. Customizer Configuration Standard Operating Procedure

All profile information and page sections are managed natively through **Appearance > Customize**.

### 4.1 Step-by-Step Customization Workflow
1. Navigate to **Appearance > Customize > Portfolio & Profile Settings**.
2. **Profile Details:**
   - Input your full professional name into `Display Name`.
   - Set `Job Title / Role` (e.g., `Principal Architect & Performance Lead`).
   - Fill in `Location`, `Email Address`, `Phone Number`, and short `Bio`.
   - Upload a square high-resolution profile headshot in `Profile Avatar Photo` (optimal dimensions: 512x512px WebP/PNG).
   - Enter your public profile URLs for `GitHub`, `LinkedIn`, and `Twitter / X`.
3. **Hero Section:**
   - Update `Hero Status Badge` (e.g., `Available for Architecture Advisory`).
   - Define high-impact `Hero Main Headline` and `Hero Sub-headline`.
   - Configure Call to Action buttons: Primary Button Label/URL and Secondary Button Label/URL.
4. **Hero Key Metrics:**
   - Configure Metric 1-3 labels and values (e.g., `12+ Years Experience`, `99.99% Uptime`, `10M+ Monthly Users`).
5. **Skills & Capabilities (Grid of 6):**
   - Fill in Title, Description, and select an SVG icon for each skill card (Terminal, Bolt, Target, Shield, Search, Layers).
6. **Technical FAQs:**
   - Set up Questions and detailed Answers for items 1 through 4.
7. **Color Theme Presets:**
   - Select one of 6 presets (`Obsidian Cyber`, `Midnight Violet`, `Emerald Matrix`, `Sunset Ember`, `Royal Indigo`, `Minimal Titanium`).
8. Click **Publish** to commit changes.

---

## 5. Contact Page & Email Configuration

### 5.1 Setting Up the Contact Page
1. Navigate to **Pages > Add New** (or edit the seeded **Contact** page).
2. In the right settings panel under **Page Attributes > Template**, choose **Contact Page Template**.
3. Publish or update the page.

### 5.2 SMTP & Email Delivery Best Practices
Because `template-contact.php` uses WordPress core's `wp_mail()` function, server-level `sendmail` or an authenticated SMTP relay is required for reliable email delivery:
1. Install an authenticated SMTP plugin (e.g., WP Mail SMTP or Post SMTP) or configure an MTA like Postfix/msmtp on your host.
2. Authenticate with transactional email providers (SendGrid, Amazon SES, Postmark, or Mailgun).
3. Test submission through the contact form to confirm delivery and verify that DKIM and SPF pass.

---

## 6. Security & Audit Operations

### 6.1 Routine Security Checks
- **User Enumeration Verification:** Run `curl -i -X GET "https://yourdomain.com/?author=1"`; verify the server returns an HTTP 301 redirecting to `/`.
- **REST User Endpoint Check:** Run `curl -i -X GET "https://yourdomain.com/wp-json/wp/v2/users"`; unauthenticated requests should return `401 Unauthorized` or empty forbidden responses.
- **Security Headers Verification:** Run `curl -I https://yourdomain.com/`; inspect headers for:
  - `X-Frame-Options: SAMEORIGIN`
  - `X-Content-Type-Options: nosniff`
  - `X-Permitted-Cross-Domain-Policies: none`
  - `Cross-Origin-Opener-Policy: same-origin`
  - `Cross-Origin-Resource-Policy: same-origin`
  - `Referrer-Policy: strict-origin-when-cross-origin`

### 6.2 Rate Limit Transient Maintenance
The contact form stores rate limit attempts in WordPress transients (`_transient_contact_ip_*`).
- Transients automatically expire after 600 seconds (10 minutes).
- In high-traffic environments using Redis or Memcached Object Cache, transient operations are in-memory with zero database lock overhead.

---

## 7. Performance & Caching Configuration

1. **Page Caching:** Compatible with FastCGI Cache, Nginx Microcaching, LiteSpeed Cache, Varnish, Redis Cache, and Cloudflare Edge Cache.
2. **Asset Optimization:** Do **not** concatenate or defer `assets/js/navigation.js` if it compromises the mobile keyboard focus trap execution. The file is small (<3KB) and executes non-blocking.
3. **Core Web Vitals:** Because system fonts and native SVGs are used, Largest Contentful Paint (LCP) and Cumulative Layout Shift (CLS) scores typically achieve 98-100 on Google PageSpeed Insights out of the box.

---

## 8. Rollback & Disaster Recovery Procedures
1. In the event of a theme update issue or rollback requirement:
   ```bash
   wp theme activate twentytwentyfour --path=/var/www/html
   ```
2. Restore previous theme version folder from backup into `wp-content/themes/ross-portfolio-theme`.
3. Re-activate theme:
   ```bash
   wp theme activate ross-portfolio-theme --path=/var/www/html
   ```
4. Verify Customizer theme mods persist in the `wp_options` table under `theme_mods_ross-portfolio-theme`.
