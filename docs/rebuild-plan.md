# I Love My Fujitsu Drupal Rebuild Plan

## Strategic Goal

This rebuild is a pull-through demand site for Fujitsu HVAC systems in Hawaii. The site should make homeowners, property managers, builders, and developers ask their contractor for Fujitsu by name. Admor HVAC Products is the local distributor and support backbone, but the primary brand experience should be Fujitsu-first.

## Theme Structure

- Custom Drupal theme: `web/themes/custom/ilovemyfujitsu`
- Visual base: selected CoolAir assets copied into `vendor/coolair`
- Custom design layer: `assets/css/fujitsu.css`
- Custom behavior layer: `assets/js/fujitsu.js`
- Active design palette: Fujitsu red, deep red, charcoal, warm white, and neutral gray. Do not use blue or navy as theme colors.
- Drupal templates:
  - `templates/layout/page--front.html.twig` for the conversion-focused homepage
  - `templates/layout/page.html.twig` for global layout
  - `templates/content/node--page.html.twig` for standard strategic pages
  - `templates/includes/header.html.twig` and `footer.html.twig`
  - `templates/navigation/menu--main.html.twig`

## Content Types

- Basic Page: evergreen marketing and resource landing pages
- News / Update: announcements, rebates, maintenance tips, technical tips, and news
- Dealer / Contractor: contractor listings grouped by island
- Face / Profile: Faces of Fujitsu, local testimonials, friends, family, and ambassadors
- Resource / Brochure: PDFs, brochures, rebate links, troubleshooting guides, and manufacturer links
- Commercial / Video: TV commercials, YouTube videos, product explainers, and local proof videos

## Pages To Create

- Home
- Why Fujitsu
- Find a Contractor
- Find a Dealer
- Oahu Dealers
- Maui Dealers
- Kauai Dealers
- Big Island Dealers
- Products
- Commercials
- Resources
- Fujitsu Brochures
- Full Line Brochure
- Consumer Brochure
- Troubleshooting Guide
- Fujitsu General
- Rebates
- Fujitsu Videos
- Updates
- Friends & Family
- Maintenance Tips
- Tech Tips
- Locate a Fujitsu Contractor
- I Love My Fujitsu Athletics Application

## Migration Approach

No WordPress SQL dump or server files are available, so migration should combine three sources:

- Public crawl of visible pages, images, PDFs, titles, headings, and internal links
- WordPress admin exports where possible for posts, pages, and media references
- Manual review for plugin-driven sections, broken Instagram content, dealer listings, PDFs, and forms

Every migrated item should be assigned to a Drupal content type, given a URL alias, and checked for internal links and file references. Placeholder images are allowed only when originals cannot be recovered and must be marked for replacement.

## Homepage Plan

- Hero: Hawaii lifestyle comfort with direct message, "Ask your contractor for Fujitsu by name"
- Trust row: Hawaii climate, quiet comfort, efficiency, warranty, local support
- Pull-through proof section: why Fujitsu should be requested before brand quoting begins
- Contractor CTA: a simple island-based route to find certified support
- Comparison positioning: choose Fujitsu over whichever brand is quoted first
- Warranty/support band: 12-year and Gecko warranty messaging, backed by local parts and support
- Local proof: Faces of Fujitsu, commercials, installations, community
- Resource cards: brochures, rebates, videos, troubleshooting, product learning
- Footer CTA: ask for Fujitsu before you approve your AC quote

## SEO And Redirect Plan

- Preserve old WordPress slugs wherever they make sense as Drupal aliases
- Add redirects for changed paths, especially dealer/resource/application/news URLs
- Preserve page titles, H1s, important headings, PDF links, image alt text, and internal link destinations
- Use Metatag for titles/descriptions and Open Graph basics
- Use Simple XML Sitemap for crawlable public pages
- Use Pathauto for consistent future URL aliases
- Run a broken-link pass after visible content and PDFs are migrated

## First Implementation Steps

1. Finish clean Drupal scaffold and local preview server.
2. Convert CoolAir visual assets into a maintainable Drupal custom theme.
3. Seed the main menu, strategic pages, and page aliases.
4. Add structured content types and fields.
5. Build homepage with conversion-focused Fujitsu Hawaii messaging.
6. Crawl/audit WordPress content and map each page/post/resource to Drupal.
7. Migrate real dealer listings, PDFs, videos, posts, and images.
8. Configure redirects, metatags, sitemap, and QA checks.
