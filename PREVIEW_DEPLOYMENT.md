# I Love My Fujitsu Drupal Preview Deployment

This package is prepared for a client preview subdomain, not final production launch.

## Preview target

- Expected preview host: `fujitsu.ikaikakimura.com`
- Drupal root: `web`
- Active theme: `ilovemyfujitsu`
- Config sync directory: `config/sync`

## Deployment steps

1. Upload the codebase to the preview server.
2. Point the subdomain document root to the `web` directory.
3. Upload public files into `web/sites/default/files`.
4. Import the included database dump, or use the included SQLite database file for a quick preview deployment.
5. Confirm `web/sites/default/settings.php` has the correct database connection for the preview environment.
6. Run:

   ```bash
   vendor/bin/drush updb -y
   vendor/bin/drush cim -y
   vendor/bin/drush cr
   vendor/bin/drush simple-sitemap:generate
   ```

7. Test:

   ```bash
   scripts/launch-check.sh https://fujitsu.ikaikakimura.com
   ```

## Current preview notes

- Email delivery is intentionally not finalized for the preview.
- Contact forms currently use placeholder recipient configuration and can be updated before final launch.
- Fujitsu contractor locator URLs use Fujitsu General's external site and may show bot/human verification when tested by automated crawlers.
- Customer testimonials are modeled in Drupal but remain unpublished until client-approved quotes are available.

## Final launch items after client approval

- Replace preview database credentials with final production credentials.
- Confirm GA4/Search Console tracking if requested.
- Confirm final contact form recipients.
- Submit the XML sitemap after DNS is pointed live.
- Run a final broken-link crawl against the live hostname.
