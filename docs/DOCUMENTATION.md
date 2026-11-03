# Technical Architecture Documentation

## Ross Portfolio Theme (`ross-portfolio-theme`)
**Author:** Ross — Principal Theme Architect & Front-End Performance Lead
**Version:** 1.0.0
**License:** GNU General Public License v2 or later
**Requires PHP:** 7.4+ (Tested up to PHP 8.3)
**Requires WordPress:** 6.0+

---

## 1. Executive Summary & Design Philosophy
`ross-portfolio-theme` is an ultra-performant, standalone classic WordPress theme engineered for technical founders, principal engineers, architects, and high-growth advisory consultancies.

### Core Architectural Pillars
1. **Zero External Dependencies:**
   - No Google Fonts HTTP/DNS handshakes (uses native `system-ui, -apple-system, sans-serif`).
   - No jQuery or third-party JS runtime engines.
   - Pure ES6+ vanilla JavaScript with event delegation and strict ARIA state management.
   - Native SVG icons rendered via `wp_kses()` with an explicit whitelist.
2. **Modern Glassmorphism UI & Tokenized Design System:**
   - Page background: `#070A0E` with ambient layered radial gradients.
   - Elevated glass surfaces: `rgba(18, 25, 35, 0.65)` with `backdrop-filter: blur(16px)` and high-contrast borders `rgba(255, 255, 255, 0.08)`.
   - Accent colors: Electric Blue (`#60A5FA`) and Success Emerald (`#34D399`).
   - 6 curated color presets switchable dynamically via WordPress Customizer.
3. **WCAG 2.2 AA Accessibility Compliance:**
   - Dedicated keyboard focus trapping in mobile navigation drawer.
   - Screen reader `.skip-link` pointing directly to `#main-content`.
   - High-contrast `:focus-visible` styling (`outline: 2px solid var(--accent-blue)` with offset).
   - Dynamic `aria-expanded`, `aria-hidden`, and `aria-live` state attributes.
4. **Defense-in-Depth WordPress Hardening:**
   - ABSPATH execution guards (`if ( ! defined( 'ABSPATH' ) ) exit;`) on every PHP file.
   - REST API `/wp/v2/users` enumeration restrictions for unauthenticated requests.
   - Query string user enumeration redirection (`?author=N` -> `301 /`).
   - Login credential obfuscation preventing username harvesting via `wp-login.php`.
   - Disabling XML-RPC pingback methods and discovery header tags (`rsd_link`, `wlwmanifest_link`).
   - Removal of WordPress generator meta tags from `<head>` and RSS feeds.
   - HTTP Security Headers: `X-Content-Type-Options: nosniff`, `X-Frame-Options: SAMEORIGIN`, `X-XSS-Protection: 1; mode=block`, `Referrer-Policy: strict-origin-when-cross-origin`, `Permissions-Policy: camera=(), microphone=(), geolocation=()`, `X-Permitted-Cross-Domain-Policies: none`, `Cross-Origin-Opener-Policy: same-origin`, `Cross-Origin-Resource-Policy: same-origin`, and `Strict-Transport-Security` when on SSL.
   - Server-side contact form with IP transient rate limiting (max 5 submissions per 10 minutes), honeypot trap, CRLF SMTP injection sanitization, and nonce validation.

---

## 2. Directory & File Structure

```text
ross-portfolio-theme/
├── 404.php                     # Accessible 404 error page with quick navigation back home
├── archive.php                 # Standard WordPress archive fallback (categories, tags, dates)
├── assets/
│   └── js/
│       └── navigation.js       # Vanilla JS mobile menu drawer with keyboard focus trap & ARIA toggle
├── comments.php                # Hardened comment list, reply form, and count badges
├── footer.php                  # Global footer with copyright, back-to-top button, and wp_footer()
├── front-page.php              # Modern homepage (Hero card, Skills, Projects, Standout CTA, FAQs, Contact)
├── functions.php               # Theme bootstrapper; includes modular inc/*.php files
├── header.php                  # Global header, skiplink, brand logo, desktop & mobile drawer nav
├── home.php                    # Default blog post index layout with hero header and grid cards
├── inc/
│   ├── customizer.php          # 100% Native Customizer controls (No JSON textareas)
│   ├── enqueue.php             # Enqueues style.css & assets/js/navigation.js without jQuery
│   ├── helpers.php             # Presets, profile getters, SVG whitelisting, and icon helpers
│   ├── seeder.php              # Automated content seeder creating demo posts, pages, and menus
│   ├── seo-aeo.php             # JSON-LD Schema (Person, WebSite, FAQPage, Article) for Search & AI Engines
│   └── setup.php               # Theme supports, sidebars, HTTP headers, security & REST hardening
├── index.php                   # Mandatory classic WordPress fallback template
├── page.php                    # Standard single page template with Gutenberg container
├── search.php                  # Search results template with contextual query terms
├── sidebar.php                 # Dynamic sidebar container invoking registered widget areas
├── single.php                  # Single blog post template with meta, featured media, and comments
├── style.css                   # Primary stylesheet: CSS variables, glassmorphic UI, responsive grids
├── template-blog.php           # Dedicated 2-column blog layout with right sidebar and widgets
├── template-contact.php        # Dedicated contact page template with native zero-dependency form handling
└── theme.json                  # Gutenberg block editor theme tokens (palette, spacing, typography)
```

---

## 3. Template Hierarchy & Rendering Workflows

### 3.1 Homepage (`front-page.php`)
- **Status:** Automatically takes precedence when a static front page is assigned or when `is_front_page()` is true.
- **Sections:**
  1. **Hero Section:** Features profile badge, main headline, lead text, CTA buttons, and the interactive `.hero-profile-card` (emerald status ping, avatar with glow ring, verified badge, quick metadata, and social icons).
  2. **Skills / Architectural Specialties:** Dynamic grid of up to 6 customizer-configured cards with custom SVGs.
  3. **Featured Projects:** Showcases portfolio projects query with tech tags, live preview links, and GitHub links.
  4. **Standout CTA Card:** High-impact callout box directing clients to book architectural advisory.
  5. **Technical FAQ Accordion:** Pure CSS `<details>` / `<summary>` accordions (zero JS) with Schema.org `FAQPage` integration.
  6. **Direct Inquiries Footer:** Direct contact channel summary with phone, email, location, and consultation button.

### 3.2 Blog Engine (`home.php` & `template-blog.php`)
- `home.php`: Displays latest blog posts in a modern 3-column glassmorphic grid with pagination.
- `template-blog.php`: Custom Page Template (`Template Name: Blog with Right Sidebar Template`) allowing any page to function as a publication portal with a dynamic widgetized right sidebar.

### 3.3 Contact Engine (`template-contact.php`)
- Custom Page Template (`Template Name: Contact Page Template`).
- Zero external plugins (Gravity Forms, Contact Form 7, or WPForms not required).
- Built-in honeypot spam bot trapping.
- Transient IP rate limiting (5 submissions per 10 minutes).
- CRLF sanitization preventing email header hijacking.
- Delivers clean plain-text inquiries via native `wp_mail()`.

---

## 4. Customizer Architecture (Native Individual Controls)
All content is managed through `inc/customizer.php` without bloated JSON payloads:
- **Profile Details:** Display Name, Job Title, Location, Email, Phone, Bio, Avatar Upload, GitHub, LinkedIn, Twitter/X.
- **Hero & CTA Content:** Badge text, Main Headline, Sub-headline, Primary Button Text & URL, Secondary Button Text & URL.
- **Metrics:** Metric 1-3 numerical values and descriptive labels.
- **Skills 1 to 6:** Title, description, SVG icon selector (terminal, bolt, target, shield, search, layers), optional image upload.
- **FAQ Items 1 to 4:** Question text and comprehensive answer text.
- **Contact Settings:** Response time commitment guarantee, contact intro copy.
- **Design System Color Preset:** Switchable select dropdown offering Obsidian Cyber, Midnight Violet, Emerald Matrix, Sunset Ember, Royal Indigo, and Minimal Titanium.

---

## 5. Security Architecture Matrix

| Attack Vector | Vulnerability Type | Theme Mitigation Strategy | File Location |
| :--- | :--- | :--- | :--- |
| Direct Script Execution | Remote Code Execution | `if (!defined('ABSPATH')) exit;` in all PHP files | All `.php` files |
| Cross-Site Scripting (XSS) | Client-side injection | `esc_html`, `esc_attr`, `esc_url`, `wp_kses` | All templates & helpers |
| SVG Script Injection | Malicious XML | Explicit SVG tag and attribute whitelisting in `ross_portfolio_get_allowed_svg_tags()` | `inc/helpers.php` |
| REST API User Scraping | User Enumeration | Filtering `rest_endpoints` to unset `/wp/v2/users` for unauthenticated requests | `inc/setup.php` |
| Query User Harvesting | User Enumeration | Redirecting `?author=N` requests with 301 to home | `inc/setup.php` |
| Login Error Harvesting | Account Discovery | Obfuscating `login_errors` into a generic failure notice | `inc/setup.php` |
| XML Sitemap Scraping | Author Enumeration | Unsetting `users` provider in `wp_sitemaps_add_provider` | `inc/setup.php` |
| DDoS & Pingback Attacks | Network Amplification | Unsetting XML-RPC pingback methods and headers | `inc/setup.php` |
| Clickjacking & MIME Sniffing | Protocol Exploits | `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff` | `inc/setup.php` |
| SMTP Header Hijacking | CRLF Injection | Stripping `[\r\n\t]+` from contact form sender names, emails, and subjects | `template-contact.php` |
| Contact Email Flooding | Mailbox DoS | Transient-based IP rate limiting (max 5 per 10 mins) | `template-contact.php` |
| Comment Spam & Payloads | Buffer/DB Abuse | 4,000 character limit and enforced `rel="nofollow noopener noreferrer"` | `inc/setup.php` |

---

## 6. AEO (Answer Engine Optimization) & SEO
`inc/seo-aeo.php` injects structured JSON-LD into `wp_head`:
1. **Person Schema:** Represents the portfolio owner, job title, social profiles, and primary topics of expertise.
2. **WebSite Schema:** Outlines site search actions and institutional ownership.
3. **FAQPage Schema:** Converts Customizer FAQ items into native search result accordions and training data for AI answer engines (Perplexity, ChatGPT, Claude).
4. **Article Schema:** Injected on single blog posts including author, published time, and featured images.
