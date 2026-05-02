<?php

declare(strict_types=1);

use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\metatag\Entity\MetatagDefaults;
use Drupal\node\Entity\Node;

$compare_body = <<<'HTML'
<section class="ilf-content-band ilf-content-band--intro">
  <p class="ilf-kicker">Fujitsu comparison hub</p>
  <h2>Compare Fujitsu before you accept an AC quote.</h2>
  <p>If your contractor quoted Mitsubishi, Daikin, LG, Gree, or Panasonic, use these Hawaii-focused comparisons to understand why Fujitsu may be the stronger long-term choice for island homes, coastal conditions, warranty confidence, and local support.</p>
</section>
<div class="ilf-card-grid ilf-card-grid--five ilf-compare-hub-grid">
  <article><h3>Fujitsu vs Mitsubishi</h3><p>Premium vs premium: compare Hawaii support, coastal comfort, Airstage options, and the Admor-backed local path.</p><a class="btn-main" href="/fujitsu-vs-mitsubishi">Compare Mitsubishi</a></article>
  <article><h3>Fujitsu vs Daikin</h3><p>Compare Daikin's broad HVAC ecosystem against Fujitsu's clearer mini-split and local contractor-support story.</p><a class="btn-main" href="/fujitsu-vs-daikin">Compare Daikin</a></article>
  <article><h3>Fujitsu vs LG</h3><p>Look past electronics-brand familiarity and compare HVAC-first comfort, serviceability, and warranty confidence.</p><a class="btn-main" href="/fujitsu-vs-lg">Compare LG</a></article>
  <article><h3>Fujitsu vs Gree</h3><p>Weigh lower upfront cost against premium support, 12-year warranty options, and long-term Hawaii service confidence.</p><a class="btn-main" href="/fujitsu-vs-gree">Compare Gree</a></article>
  <article><h3>Fujitsu vs Panasonic</h3><p>Compare familiar household-brand recognition against Fujitsu's focused ductless AC resources and contractor pathway.</p><a class="btn-main" href="/fujitsu-vs-panasonic">Compare Panasonic</a></article>
</div>
<section class="ilf-callout ilf-callout--compare">
  <h2>Ask the question that changes the quote.</h2>
  <p>Do not only ask, "What AC can you install?" Ask, "Can you quote Fujitsu, and why is it the right fit for Hawaii?"</p>
  <p><a class="btn-main" href="/find-a-contractor">Find a Fujitsu Contractor</a> <a class="btn-main btn-outline" href="/products">View Product PDFs</a></p>
</section>
<section class="ilf-content-band ilf-content-band--intro">
  <p class="ilf-kicker">Local proof</p>
  <h2>Faces of Fujitsu keep the brand familiar before the estimate.</h2>
  <p>Commercials, local profiles, donations, and community stories all support the same goal: when Hawaii buyers compare AC brands, Fujitsu should already be the name they remember and request.</p>
  <p><a class="btn-main btn-outline" href="/friends-family">View Friends & Family</a></p>
</section>
HTML;

$compare = ilf_hvp_node_by_title('page', 'Compare Fujitsu to Other Mini-Split Brands') ?: Node::create(['type' => 'page']);
$compare->setTitle('Compare Fujitsu to Other Mini-Split Brands');
$compare->setPublished(TRUE);
$compare->set('body', ['value' => $compare_body, 'format' => 'full_html']);
$compare->set('path', ['alias' => '/compare', 'pathauto' => 0]);
$compare->save();

ilf_hvp_menu_link('main', 'Compare Brands', 'internal:/compare', 25);
ilf_hvp_menu_link('footer', 'Compare Fujitsu Brands', 'internal:/compare', 85);

if (\Drupal::moduleHandler()->moduleExists('metatag')) {
  ilf_hvp_metatag_default('node__brand_comparison', 'Brand Comparison', [
    'title' => '[node:title] | I Love My Fujitsu',
    'description' => '[node:field_comparison_summary]',
    'canonical_url' => '[node:url]',
    'robots' => 'index, follow',
    'og_site_name' => 'I Love My Fujitsu',
    'og_title' => '[node:title] | I Love My Fujitsu',
    'og_description' => '[node:field_comparison_summary]',
    'og_type' => 'article',
    'og_image' => 'https://ilovemyfujitsu.com/themes/custom/ilovemyfujitsu/assets/images/fujitsu-logo.png',
  ]);
  ilf_hvp_metatag_default('node__resource_brochure', 'Resource / Brochure', [
    'title' => '[node:title] | Fujitsu Hawaii Resources',
    'description' => 'Review [node:title] from I Love My Fujitsu, then ask a Hawaii contractor to quote Fujitsu by name.',
    'canonical_url' => '[node:url]',
    'robots' => 'index, follow',
    'og_site_name' => 'I Love My Fujitsu',
    'og_title' => '[node:title] | Fujitsu Hawaii Resources',
    'og_description' => 'Review Fujitsu brochures, PDFs, rebates, and technical resources before choosing an AC system in Hawaii.',
    'og_type' => 'article',
    'og_image' => 'https://ilovemyfujitsu.com/themes/custom/ilovemyfujitsu/assets/images/fujitsu-logo.png',
  ]);
  ilf_hvp_metatag_default('node__news_update', 'Update / News Article', [
    'title' => '[node:title] | Fujitsu Hawaii Updates',
    'description' => '[node:field_summary]',
    'canonical_url' => '[node:url]',
    'robots' => 'index, follow',
    'og_site_name' => 'I Love My Fujitsu',
    'og_title' => '[node:title] | Fujitsu Hawaii Updates',
    'og_description' => '[node:field_summary]',
    'og_type' => 'article',
    'og_image' => 'https://ilovemyfujitsu.com/themes/custom/ilovemyfujitsu/assets/images/fujitsu-logo.png',
  ]);
  ilf_hvp_metatag_default('node__dealer_region', 'Dealer Region', [
    'title' => '[node:title] | Find Fujitsu Contractors in Hawaii',
    'description' => 'Find Fujitsu contractor support for [node:title] and ask your AC installer to quote Fujitsu by name.',
    'canonical_url' => '[node:url]',
    'robots' => 'index, follow',
    'og_site_name' => 'I Love My Fujitsu',
    'og_title' => '[node:title] | Fujitsu Hawaii Contractor Support',
    'og_description' => 'Choose your island, compare Fujitsu, and find contractor support for Hawaii homes and businesses.',
    'og_type' => 'article',
    'og_image' => 'https://ilovemyfujitsu.com/themes/custom/ilovemyfujitsu/assets/images/fujitsu-logo.png',
  ]);
}

echo "High-value client polish applied.\n";

function ilf_hvp_node_by_title(string $bundle, string $title): ?Node {
  $ids = \Drupal::entityQuery('node')
    ->accessCheck(FALSE)
    ->condition('type', $bundle)
    ->condition('title', $title)
    ->range(0, 1)
    ->execute();
  return $ids ? Node::load(reset($ids)) : NULL;
}

function ilf_hvp_menu_link(string $menu, string $title, string $uri, int $weight): void {
  $ids = \Drupal::entityQuery('menu_link_content')
    ->accessCheck(FALSE)
    ->condition('menu_name', $menu)
    ->condition('title', $title)
    ->range(0, 1)
    ->execute();
  $link = $ids ? MenuLinkContent::load(reset($ids)) : MenuLinkContent::create(['menu_name' => $menu]);
  $link->set('title', $title);
  $link->set('link', ['uri' => $uri]);
  $link->set('weight', $weight);
  $link->set('enabled', TRUE);
  $link->save();
}

function ilf_hvp_metatag_default(string $id, string $label, array $tags): void {
  $default = MetatagDefaults::load($id) ?: MetatagDefaults::create(['id' => $id]);
  $default->set('label', $label);
  $default->set('tags', $tags);
  $default->save();
}
