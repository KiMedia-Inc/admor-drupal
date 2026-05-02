# WordPress To Drupal Migration Map

Use this as the working checklist when auditing `ilovemyfujitsu.com` / `fujitsu.ikaikakimura.com`.

| Existing section | Drupal target | Notes |
| --- | --- | --- |
| Home | Front page template | Preserve brand/content intent, but use the new Fujitsu-first pull-through strategy. |
| Why Fujitsu / brand proof | Basic Page | Expand into buyer-facing comparison and Hawaii climate positioning. |
| Find a Dealer | Basic Page + Dealer / Contractor nodes | Island landing page plus structured contractor listings. |
| Oahu Dealers | Basic Page + Dealer / Contractor nodes | Migrate each visible dealer with island, phone, address, website. |
| Kauai Dealers | Basic Page + Dealer / Contractor nodes | Migrate each visible dealer with island, phone, address, website. |
| Big Island Dealers | Basic Page + Dealer / Contractor nodes | Migrate each visible dealer with island, phone, address, website. |
| Maui Dealers | Basic Page + Dealer / Contractor nodes | Migrate each visible dealer with island, phone, address, website. |
| Products | Basic Page | Organize by buyer outcome first, product category second. |
| Commercials | Commercial / Video nodes | Capture title, thumbnail, URL/embed, summary, date if visible. |
| Updates / News | News / Update nodes | Preserve title, publish date, body, featured image, excerpt, category. |
| Friends & Family | Face / Profile nodes | Rebuild Faces of Fujitsu as reusable profile content. |
| Resources | Basic Page + Resource / Brochure nodes | Use resource cards instead of a loose file/link dump. |
| Fujitsu Brochures | Resource / Brochure nodes | Preserve PDFs and public file URLs. |
| Full Line Brochure | Resource / Brochure node | Preserve PDF, title, meta, and alias. |
| Consumer Brochure | Resource / Brochure node | Preserve PDF, title, meta, and alias. |
| Troubleshooting Guide | Resource / Brochure node or Basic Page | Preserve PDF/support content and link from resources. |
| Fujitsu General | Resource / Brochure node | External manufacturer links should open cleanly and be labeled. |
| Rebates | Resource / Brochure nodes + Basic Page | Confirm active rebate dates before launch. |
| Fujitsu Videos | Commercial / Video nodes | Reuse video content type, optionally category/tag as video resource. |
| Maintenance Tips | News / Update nodes or Basic Page | If multiple posts exist, keep as News / Update category. |
| Tech Tips | News / Update nodes | Contractor-facing secondary content. |
| Locate a Fujitsu Contractor | Redirect or Basic Page | Preserve URL for SEO; likely route to Find a Contractor. |
| Athletics Application | Basic Page or Webform | Rebuild as a Drupal webform if the original form is active. |
| Footer navigation | Drupal menus + footer template | Preserve phone, address, donation/social links, and important legal/contact info. |

## Audit Fields To Capture

- Source URL
- Page title and H1
- Meta title and description if available
- Body copy
- Images and alt text
- PDF/file links
- Internal links
- External links
- Publish date for posts
- Author only if publicly meaningful
- Categories/tags
- Redirect needed
- Drupal destination content type
- Migration status

WordPress category archive URLs should remain redirect-only migration records. Do not import them as News, Face, or Resource nodes.

## Broken Plugin Replacement Rules

- Do not rebuild broken WordPress plugin behavior as-is.
- Instagram/social feeds should become static curated sections unless a reliable Drupal/social integration is approved.
- Forms should be rebuilt with Drupal-native forms/webforms.
- Video embeds should use clean URLs or embed fields, not legacy shortcode output.
