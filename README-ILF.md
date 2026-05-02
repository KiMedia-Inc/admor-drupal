# I Love My Fujitsu Drupal Build

Local Drupal rebuild for the Fujitsu Hawaii / Admor HVAC pull-through demand site.

## Current Local Preview

- Project path: `/private/tmp/ilovemyfujitsu-drupal`
- Local URL: `http://127.0.0.1:8097`
- Drupal admin: `http://127.0.0.1:8097/user/login`
- Local admin user: `admin`
- Local admin password: `admin`

## Build Status

- Drupal 11 clean build installed with SQLite for local development.
- Custom theme enabled: `ilovemyfujitsu`.
- CoolAir static assets copied into the custom Drupal theme as vendor assets.
- Fujitsu red/navy palette applied.
- Homepage rebuilt around the core conversion goal: get Hawaii buyers to ask contractors for Fujitsu by name.
- Main strategic pages seeded with Drupal URL aliases.
- Main menu and dropdown structure seeded.
- Drupal content types added for news, dealers, profiles, resources, and videos.
- Local development CSS/JS aggregation disabled to avoid stale generated asset issues.
- Drupal config exported to `config/sync`.

## Useful Commands

```bash
vendor/bin/drush status
vendor/bin/drush cr
vendor/bin/drush scr scripts/seed-ilf-content.php
php -S 127.0.0.1:8097 -t web
```

## Notes

- This build does not touch the live WordPress site.
- Real WordPress content, PDFs, dealer listings, images, and posts still need to be audited and migrated.
- Placeholder/migration-note content is intentionally marked on seeded pages until source content is recovered.
