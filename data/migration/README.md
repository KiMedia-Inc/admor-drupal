# Migration Data Workspace

This folder stores public WordPress inventory files and prepared import data.

Recommended flow:

1. Run `php scripts/build-wordpress-public-inventory.php`
2. Review `data/migration/wordpress-public-inventory.csv`
3. Fill or correct missing titles, content type mappings, asset URLs, and migration notes
4. Run `vendor/bin/drush scr scripts/import-wordpress-public-content.php`

The import script creates polished starter Drupal entries from public URL inventory. Final body copy, images, PDFs, and embeds should still be reviewed against the client-approved source material before launch.

WordPress category archive URLs stay in the inventory for redirects and SEO mapping only. They should not be imported as Drupal content cards.
