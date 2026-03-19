# Admor Theme Notes

## Colors

Update the brand palette in [theme.css](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/web/themes/custom/admor/assets/css/theme.css) under the `:root` CSS variables:

- `--admor-blue`
- `--admor-red`
- `--admor-dark`
- `--admor-surface`
- `--admor-text`

## Single-Command Setup

Prerequisite: Drupal is already installed locally and `drush` can target this site.

From the repo root:

```bash
composer install && composer run drush:admor-setup
```

That sequence:

1. installs PHP dependencies
2. enables the `admor` theme
3. enables the `admor_site` module
4. sets `admor` as the default theme
5. sets the front page path to `/home`
6. imports committed homepage block/menu config from `config/default`
7. clears caches

Available composer scripts:

- `composer run lint:php`
- `composer run drush:theme-enable`
- `composer run drush:module-enable`
- `composer run drush:admor-setup`

## Homepage Build

The front page layout lives in [page--front.html.twig](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/web/themes/custom/admor/templates/layout/page--front.html.twig).

This repo did not include the site's exported field/content-model config, so the homepage sections are assembled by Drupal block plugins backed by the companion module service. The resolver now prefers known machine names first and only falls back to label matching when needed.

Homepage data source service:

- [ContentResolver.php](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/web/modules/custom/admor_site/src/Service/ContentResolver.php)

Homepage route:

- `/home` via [HomepageController.php](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/web/modules/custom/admor_site/src/Controller/HomepageController.php)

Homepage sections:

- Hero product logo carousel: newest published `Products` nodes using `Logo image` and `Web link`
- Discover products CTA: hard-coded front-page CTA block in Twig
- Product categories grid: `Product Categories` taxonomy terms
- News section: published `Article` nodes
- Specials section: published `Specials & Rebates` nodes
- Training section: published `Training & Events` nodes, ordered by `Event start` when available
- Staff section: published `Staff` nodes grouped by `Department`
- Testimonials section: published `Testimonials` nodes
- Videos section: published `Videos` nodes using `Video URL`

Block plugins:

- `admor_site_homepage_hero`
- `admor_site_homepage_cta`
- `admor_site_homepage_categories`
- `admor_site_homepage_news`
- `admor_site_homepage_specials`
- `admor_site_homepage_training`
- `admor_site_homepage_staff`
- `admor_site_homepage_testimonials`
- `admor_site_homepage_videos`

Committed block placement config:

- [config/default/block.block.admor_hero.yml](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/config/default/block.block.admor_hero.yml)
- [config/default/block.block.admor_homepage_cta.yml](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/config/default/block.block.admor_homepage_cta.yml)
- [config/default/block.block.admor_homepage_categories.yml](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/config/default/block.block.admor_homepage_categories.yml)
- [config/default/block.block.admor_homepage_news.yml](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/config/default/block.block.admor_homepage_news.yml)
- [config/default/block.block.admor_homepage_specials.yml](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/config/default/block.block.admor_homepage_specials.yml)
- [config/default/block.block.admor_homepage_training.yml](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/config/default/block.block.admor_homepage_training.yml)
- [config/default/block.block.admor_homepage_staff.yml](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/config/default/block.block.admor_homepage_staff.yml)
- [config/default/block.block.admor_homepage_testimonials.yml](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/config/default/block.block.admor_homepage_testimonials.yml)
- [config/default/block.block.admor_homepage_videos.yml](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/config/default/block.block.admor_homepage_videos.yml)

## Menu

The module install hook seeds the Main Navigation with:

- Home
- Shop
- Products
- Specials & Rebates
- Training & Events
- Careers
- Blog
- About
- Contact

The external Shop link is created with `target="_blank"` via `menu_link_attributes`.

Committed menu manifest:

- [config/default/admor_site.menu.yml](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/config/default/admor_site.menu.yml)

## Site Contact Settings

Editable contact values are managed at:

- `/admin/config/system/admor-site-contact`

Those values feed the top bar and footer.

Config files:

- [admor_site.settings.yml](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/web/modules/custom/admor_site/config/install/admor_site.settings.yml)
- [SiteContactSettingsForm.php](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/web/modules/custom/admor_site/src/Form/SiteContactSettingsForm.php)

## Hero Slider Content

To change the hero logo carousel:

1. Edit or add published `Products` nodes.
2. Upload/update the `Logo image` field.
3. Set the `Web link` field for the click target.

The hero carousel currently uses the newest published Products items because that is the simplest reliable rule with no extra field additions.

## Remaining Assumptions

- The Admor logo is included as [logo.svg](/Volumes/docker/Ikaika Kimura Dropbox/Web Projects/Codex/web/themes/custom/admor/logo.svg) and can be swapped later if you have a final production vector asset.
- Because the repository did not include a committed export of the actual field machine names for the existing content model, I did not add speculative `views.view.*.yml` files that could import cleanly but silently break at runtime. The stable footprint is block placement plus module-backed section rendering, with machine-name-first field lookup and label fallback.
- If a real config export is added later, the homepage block plugins can be swapped for true Views block displays without changing the page regions or theme structure.
