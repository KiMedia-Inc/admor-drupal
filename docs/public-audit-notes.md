# Public Audit Notes

Initial public search audit performed without logging into WordPress or changing the live site.

## High-Value Source Content Found

- Homepage messaging includes Fujitsu commercials, updates, contractor finder, warranty, Hawaii Energy rebates, Cooling Cancer donation content, Admor/Kona branch contact info, and a large Faces of Fujitsu section.
- Commercials page lists a deep archive of Fujitsu ads, including "Fujitsu Girl Growing Up", "Fujitsu 12 Year and Gecko Warranty", "Gym Dog", "Alexa", "The Coach", "The Quarterback", "Grandpa Jack", and "I Love My Fujitsu - The Original".
- News/category pages include contractor VIP reception posts, KHON2 coverage, warranty/rebate posts, Cooling Cancer, and older campaign posts.
- Resource content includes at least one Hawaii Energy rebate PDF under WordPress uploads.
- Faces of Fujitsu includes local profiles such as Kanoa Leahey, Greg Salas, Stephanie Wang, Dave Shoji, Chelsea Hardin, Ashlee Kozuma, Ashley Jardine, Benny Agbayani, Rich Miano, Jack Ito, Kaui Kauhi, Drew Santos, Riley Graves-Lock, and Keli Santos.
- Oahu dealer page is indexed publicly and should be migrated into Dealer / Contractor content.
- Products page currently behaves like a brochure/catalog link hub, with multiple full-line, consumer, Airstage, Halcyon, mini-split, and product PDF/resource links.
- Locate a Fujitsu Contractor appears to depend on an iframe/plugin-style locator and should be rebuilt as a Drupal-native contractor locator or redirected to the new contractor flow.
- Friends & Family includes customer/install photo content and asks users to submit photos, names, and installing contractor information by email.

## Drupal Migration Implications

- Faces of Fujitsu should be migrated as `Face / Profile` nodes, not as one long page.
- Commercials should be migrated as `Commercial / Video` nodes so homepage, commercials page, and resource pages can reuse them.
- Rebate PDFs should be migrated as `Resource / Brochure` nodes and checked for current validity before launch.
- News posts should preserve dates and old slugs where possible.
- Existing category URLs may need redirects to the new Updates, Videos, Profiles, or Resources sections.

## Priority Audit Targets

1. Dealer pages for all islands.
2. Commercials page and video URLs/embeds.
3. Products/resource catalog links and PDFs.
4. Faces of Fujitsu profile posts and images.
5. Friends & Family customer/install photos and submission instructions.
6. News/update posts from 2019-2024.
7. Footer contact info, donation links, and social links.
