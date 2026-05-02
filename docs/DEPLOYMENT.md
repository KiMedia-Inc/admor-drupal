# I Love My Fujitsu Drupal Deployment

## Requirements

- PHP compatible with Drupal 11
- Composer 2
- Drush via `vendor/bin/drush`
- MySQL/MariaDB or another Drupal-supported production database
- Public web root pointed at `web/`

## Code Setup

```bash
composer install --no-dev --optimize-autoloader
cp web/sites/default/default.settings.php web/sites/default/settings.php
```

Configure production database credentials in `web/sites/default/settings.php` or a host-managed settings include.

The config sync directory is:

```php
$settings['config_sync_directory'] = '../config/sync';
```

Trusted hosts are set for:

- `ilovemyfujitsu.com`
- `www.ilovemyfujitsu.com`
- `127.0.0.1`
- `localhost`

Adjust this list for staging domains before launch.

## Database and Files

Export the current local database:

```bash
scripts/export-db.sh
```

Import on the destination host using the host's database import tooling, then copy the public files package into:

```bash
web/sites/default/files
```

Required public file folders include:

- `commercials`
- `faces`
- `fujitsu-pdfs`
- `fujitsu-tech-tips`
- `wordpress-featured`

Do not deploy the local SQLite database file from `web/sites/default/files/.ht.sqlite`.

## Drupal Launch Commands

Run after code, database, and files are in place:

```bash
vendor/bin/drush updb -y
vendor/bin/drush cim -y
vendor/bin/drush php:script scripts/seed-launch-redirects.php
vendor/bin/drush simple-sitemap:generate
vendor/bin/drush cr
```

Run the local smoke check:

```bash
scripts/launch-check.sh https://ilovemyfujitsu.com
```

## Email

The Drupal Contact module forms are built and protected by Honeypot:

- `/contact/admor_hvac`
- `/contact/athletics_application`

Production still needs a real outbound mail service configured by the host or via a transactional provider such as Postmark, Mailgun, or SendGrid. Test both forms after DNS and mail delivery are configured.

## SEO

Implemented:

- Metatag defaults
- Canonical URL token defaults
- Open Graph defaults
- XML sitemap generation
- Redirect module redirects for known WordPress URLs
- Homepage Organization, LocalBusiness, and WebSite JSON-LD

Post-launch:

- Submit `/sitemap.xml` in Google Search Console.
- Validate redirects from old indexed WordPress URLs.
- Add GA4 / Google Tag Manager if the client provides IDs.

## Known Client-Dependent Items

- Confirm final Kauai branch/support wording.
- Replace missing/dead source PDFs listed in `data/migration/*missing-pdfs.json`.
- Confirm final dealer locator URLs.
- Configure production email delivery.
- Provide final GA4/GTM/Search Console ownership.
