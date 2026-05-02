# Initial Redirect Plan

This list should be expanded during the full WordPress crawl. Keep old URLs when practical; redirect only when the new Drupal information architecture is cleaner.

| Old WordPress path | Drupal target | Status |
| --- | --- | --- |
| `/` | `/` | Preserve |
| `/home/` | `/` | Redirect |
| `/products/` | `/products` | Preserve without trailing slash |
| `/commercials/` | `/commercials` | Preserve without trailing slash |
| `/resources/` | `/resources` | Preserve without trailing slash |
| `/friends-family/` | `/friends-family` | Preserve without trailing slash |
| `/locate-a-fujitsu-contractor/` | `/locate-a-fujitsu-contractor` | Preserve as contractor locator landing page |
| `/oahu-fujitsu-dealers/` | `/find-a-dealer/oahu-dealers` | Redirect |
| `/category/updates/` | `/updates` | Redirect |
| `/category/featured/` | `/updates` | Redirect |
| `/category/home/` | `/` | Redirect |
| `/category/fujitsu-faces/` | `/friends-family` | Redirect |
| `/find-a-fujitsu-contractor/` | `/find-a-contractor` | Redirect |
| `/i-love-my-fujitsu-athlete-application/` | `/i-love-my-fujitsu-athletics-application` | Redirect typo/singular path to rebuilt page |
| `/mason2021_2022/` | `/updates/mason-kekoa-nava-macloves-memorial-scholarships` | Redirect to scholarship/community update |
| `/2019/04/23/kaui-kauhi/` | `/friends-family/kaui-kauhi` | Redirect |
| `/2019/04/23/drew-santos/` | `/friends-family/drew-santos` | Redirect |
| `/2019/04/23/keli-santos/` | `/friends-family/keli-santos` | Redirect |
| `/2020/08/07/kanoa-leahey/` | `/friends-family/kanoa-leahey` | Redirect |
| `/2019/04/23/chelsea-hardin/` | `/friends-family/chelsea-hardin` | Redirect |
| `/2019/04/23/ashley-jardine/` | `/friends-family/ashley-jardine` | Redirect |
| `/2019/04/23/jack-ito/` | `/friends-family/jack-ito` | Redirect |
| `/2019/04/21/fujitsus-infinite-comfort-app/` | `/updates/fujitsu-infinite-comfort-app` | Redirect |
| `/2019/04/21/airstage-on-broadway/` | `/updates/airstage-on-broadway` | Redirect |
| `/wp-content/uploads/*` | Drupal public files or preserved source file URL | Preserve file if migrated; redirect if path changes |

## Redirect Rules

- Preserve slugs exactly when the new page is the same topic and user intent.
- Use redirects for category archive URLs that become curated landing pages.
- Keep profile/news post date slugs only if SEO value is stronger than a cleaner alias; otherwise create redirects.
- Do not redirect active PDFs until the file is downloaded, checked, and hosted in Drupal or intentionally left external.
