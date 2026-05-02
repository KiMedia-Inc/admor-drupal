<?php

declare(strict_types=1);

use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\node\Entity\Node;

$pages = [
  '/why-fujitsu' => [
    'title' => 'Why Fujitsu',
    'body' => <<<'HTML'
<section class="ilf-content-band ilf-content-band--intro">
  <p class="ilf-kicker">Fujitsu over the alternatives</p>
  <h2>The air conditioning choice that makes sense for Hawaii.</h2>
  <p>Homeowners, builders, property managers, and business owners have a lot of AC brands placed in front of them. This page should make the decision feel simple: Fujitsu is quiet, efficient, reliable, warranty-backed, and supported locally.</p>
</section>
<section class="ilf-card-grid ilf-card-grid--four">
  <article><h3>Built for island conditions</h3><p>Hawaii air conditioning works hard year-round. Fujitsu messaging should connect directly to humidity, salt air, constant use, and long-term comfort.</p></article>
  <article><h3>Quiet comfort</h3><p>Ductless systems should feel invisible in daily life: quiet rooms, even temperatures, and comfort without bulky ductwork.</p></article>
  <article><h3>Efficiency advantage</h3><p>Energy savings matter in Hawaii. Fujitsu should be positioned as a smart investment, not only an equipment purchase.</p></article>
  <article><h3>Local support</h3><p>Admor supports Fujitsu from the background with local inventory, parts, training, and contractor support across the islands.</p></article>
</section>
<section class="ilf-comparison">
  <h2>Why ask for Fujitsu by name?</h2>
  <div class="ilf-comparison__grid">
    <div><strong>Instead of:</strong><span>accepting whichever brand gets quoted first</span></div>
    <div><strong>Ask for:</strong><span>Fujitsu, installed by a certified contractor</span></div>
    <div><strong>Instead of:</strong><span>buying on lowest upfront price alone</span></div>
    <div><strong>Ask for:</strong><span>quiet operation, efficiency, warranty, and long-term support</span></div>
  </div>
</section>
HTML,
  ],
  '/find-a-contractor' => [
    'title' => 'Find a Fujitsu Contractor',
    'body' => <<<'HTML'
<section class="ilf-content-band ilf-content-band--intro">
  <p class="ilf-kicker">Start with the right installer</p>
  <h2>Tell your contractor you want Fujitsu.</h2>
  <p>Admor does not need this page to sell direct. The goal is to help people find and speak with qualified Fujitsu contractors, then ask for Fujitsu before the estimate is finalized.</p>
</section>
<section class="ilf-island-grid">
  <a href="/find-a-dealer/oahu-dealers"><strong>Oahu Dealers</strong><span>Find certified Fujitsu support on Oahu.</span></a>
  <a href="/find-a-dealer/maui-dealers"><strong>Maui Dealers</strong><span>Find certified Fujitsu support on Maui.</span></a>
  <a href="/find-a-dealer/kauai-dealers"><strong>Kauai Dealers</strong><span>Find certified Fujitsu support on Kauai.</span></a>
  <a href="/find-a-dealer/big-island-dealers"><strong>Big Island Dealers</strong><span>Find certified Fujitsu support on Hawaii Island.</span></a>
</section>
<section class="ilf-callout">
  <h2>What to say when you call</h2>
  <p>“I’m interested in a Fujitsu system. Can you quote Fujitsu and explain the warranty, efficiency, and installation options for my space?”</p>
</section>
HTML,
  ],
  '/find-a-dealer' => [
    'title' => 'Find a Dealer',
    'body' => <<<'HTML'
<section class="ilf-content-band ilf-content-band--intro">
  <p class="ilf-kicker">Fujitsu across Hawaii</p>
  <h2>Find local Fujitsu dealers by island.</h2>
  <p>This page will become the master dealer locator, with each island page listing certified contractors and useful contact details.</p>
</section>
<section class="ilf-island-grid">
  <a href="/find-a-dealer/oahu-dealers"><strong>Oahu Dealers</strong><span>Honolulu, Windward, Central, Leeward, North Shore.</span></a>
  <a href="/find-a-dealer/maui-dealers"><strong>Maui Dealers</strong><span>Residential and commercial Fujitsu support.</span></a>
  <a href="/find-a-dealer/kauai-dealers"><strong>Kauai Dealers</strong><span>Islandwide comfort specialists.</span></a>
  <a href="/find-a-dealer/big-island-dealers"><strong>Big Island Dealers</strong><span>Hilo, Kona, Waimea, and beyond.</span></a>
</section>
HTML,
  ],
  '/find-a-dealer/oahu-dealers' => ['title' => 'Oahu Dealers', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Oahu Fujitsu contractors</p><h2>Ask an Oahu contractor for Fujitsu.</h2><p>Dealer listings will be migrated here from the WordPress site or entered as Dealer / Contractor content.</p></section>'],
  '/find-a-dealer/kauai-dealers' => ['title' => 'Kauai Dealers', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Kauai Fujitsu contractors</p><h2>Ask a Kauai contractor for Fujitsu.</h2><p>Dealer listings will be migrated here from the WordPress site or entered as Dealer / Contractor content.</p></section>'],
  '/find-a-dealer/big-island-dealers' => ['title' => 'Big Island Dealers', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Hawaii Island Fujitsu contractors</p><h2>Ask a Big Island contractor for Fujitsu.</h2><p>Dealer listings will be migrated here from the WordPress site or entered as Dealer / Contractor content.</p></section>'],
  '/find-a-dealer/maui-dealers' => ['title' => 'Maui Dealers', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Maui Fujitsu contractors</p><h2>Ask a Maui contractor for Fujitsu.</h2><p>Dealer listings will be migrated here from the WordPress site or entered as Dealer / Contractor content.</p></section>'],
  '/products' => [
    'title' => 'Fujitsu Products',
    'body' => <<<'HTML'
<section class="ilf-content-band ilf-content-band--intro">
  <p class="ilf-kicker">Residential and commercial comfort</p>
  <h2>Fujitsu systems for Hawaii homes, condos, offices, and projects.</h2>
  <p>The product pages should translate technical equipment into buyer benefits: quiet rooms, cleaner comfort, flexible installation, efficiency, warranties, and local contractor support.</p>
</section>
<section class="ilf-card-grid ilf-card-grid--three">
  <article><h3>Ductless mini-splits</h3><p>Room-by-room comfort without traditional ductwork.</p></article>
  <article><h3>Multi-zone systems</h3><p>Efficient comfort for multiple spaces with one outdoor unit.</p></article>
  <article><h3>Commercial solutions</h3><p>Scalable Fujitsu systems for businesses, developers, and property managers.</p></article>
</section>
HTML,
  ],
  '/commercials' => [
    'title' => 'Commercials',
    'body' => <<<'HTML'
<section class="ilf-content-band ilf-content-band--intro">
  <p class="ilf-kicker">Local proof</p>
  <h2>Fujitsu is a familiar Hawaii name.</h2>
  <p>Commercials and videos should reinforce brand familiarity, trust, and the simple action we want from buyers: ask your contractor for Fujitsu.</p>
</section>
<section class="ilf-callout"><h2>Migration note</h2><p>Video cards will be rebuilt as Commercial / Video content, with titles, thumbnails, dates, and embedded video URLs.</p></section>
HTML,
  ],
  '/resources' => [
    'title' => 'Resources',
    'body' => <<<'HTML'
<section class="ilf-content-band ilf-content-band--intro">
  <p class="ilf-kicker">Decision confidence</p>
  <h2>Everything a buyer needs to feel good asking for Fujitsu.</h2>
  <p>Resources should be organized around decision-making, not file storage. Brochures, rebates, guides, and videos should all support choosing Fujitsu over another brand.</p>
</section>
<section class="ilf-resource-list">
  <a href="/resources/fujitsu-brochures">Fujitsu Brochures</a>
  <a href="/resources/full-line-brochure">Full Line Brochure</a>
  <a href="/resources/consumer-brochure">Consumer Brochure</a>
  <a href="/resources/troubleshooting-guide">Troubleshooting Guide</a>
  <a href="/resources/fujitsu-general">Fujitsu General</a>
  <a href="/resources/rebates">Rebates</a>
  <a href="/resources/fujitsu-videos">Fujitsu Videos</a>
</section>
HTML,
  ],
  '/resources/fujitsu-brochures' => ['title' => 'Fujitsu Brochures', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Fujitsu resources</p><h2>Product brochures and buyer resources.</h2><p>PDFs and resource cards will be migrated as Resource / Brochure content.</p></section>'],
  '/resources/full-line-brochure' => ['title' => 'Full Line Brochure', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Full product line</p><h2>Fujitsu full line brochure.</h2><p>This page will preserve the original brochure link or hosted PDF.</p></section>'],
  '/resources/consumer-brochure' => ['title' => 'Consumer Brochure', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Homeowner resource</p><h2>Fujitsu consumer brochure.</h2><p>This page will preserve the original brochure link or hosted PDF.</p></section>'],
  '/resources/troubleshooting-guide' => ['title' => 'Troubleshooting Guide', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Support</p><h2>Fujitsu troubleshooting guide.</h2><p>Useful support content should help owners while reinforcing the value of certified Fujitsu contractors.</p></section>'],
  '/resources/fujitsu-general' => ['title' => 'Fujitsu General', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Manufacturer information</p><h2>Fujitsu General resources.</h2><p>External Fujitsu links and manufacturer resources will be preserved here.</p></section>'],
  '/resources/rebates' => ['title' => 'Rebates', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Save with Fujitsu</p><h2>Rebates and incentives make Fujitsu even easier to choose.</h2><p>Rebate content should focus on reducing friction and encouraging the buyer to ask for Fujitsu.</p></section>'],
  '/resources/fujitsu-videos' => ['title' => 'Fujitsu Videos', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Watch and learn</p><h2>Fujitsu videos and product explainers.</h2><p>Videos will be migrated as structured Commercial / Video content where useful.</p></section>'],
  '/maintenance-tips' => ['title' => 'Maintenance Tips', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Owner education</p><h2>Help Fujitsu systems perform beautifully for years.</h2><p>Maintenance tips should be practical, simple, and focused on protecting comfort and efficiency.</p></section>'],
  '/tech-tips' => ['title' => 'Tech Tips', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Contractor support</p><h2>Technical tips for Fujitsu contractors.</h2><p>This is a secondary contractor-facing area, but it reinforces that Fujitsu is locally supported and professionally installed.</p></section>'],
  '/locate-a-fujitsu-contractor' => ['title' => 'Locate a Fujitsu Contractor', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Find qualified support</p><h2>Locate a Fujitsu contractor in Hawaii.</h2><p>This path is preserved for SEO and can redirect or merge into Find a Contractor after URL review.</p></section>'],
  '/i-love-my-fujitsu-athletics-application' => ['title' => 'I Love My Fujitsu Athletics Application', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Community</p><h2>Athletics application.</h2><p>This application content will be migrated from WordPress and rebuilt as a clean Drupal page or webform.</p></section>'],
  '/updates' => ['title' => 'Updates', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">News and education</p><h2>Fujitsu updates for Hawaii.</h2><p>News, rebates, maintenance tips, technical tips, and announcements will be migrated as News / Update content.</p></section>'],
  '/friends-family' => ['title' => 'Friends & Family', 'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Faces of Fujitsu</p><h2>Local people make Fujitsu feel trusted.</h2><p>Faces of Fujitsu content will be rebuilt as structured profiles so it can be reused across homepage, landing pages, and story sections.</p></section>'],
];

foreach ($pages as $alias => $page) {
  $existing = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties([
    'type' => 'page',
    'title' => $page['title'],
  ]);
  $node = $existing ? reset($existing) : Node::create(['type' => 'page']);
  $node->setTitle($page['title']);
  $node->set('body', [
    'value' => $page['body'],
    'format' => 'full_html',
  ]);
  $node->set('status', 1);
  $node->set('path', ['alias' => $alias]);
  $node->save();
}

$menu_links = [
  ['title' => 'Why Fujitsu', 'uri' => 'internal:/why-fujitsu'],
  ['title' => 'Find a Contractor', 'uri' => 'internal:/find-a-contractor'],
  ['title' => 'Products', 'uri' => 'internal:/products'],
  ['title' => 'Commercials', 'uri' => 'internal:/commercials'],
  ['title' => 'Resources', 'uri' => 'internal:/resources'],
  ['title' => 'Updates', 'uri' => 'internal:/updates'],
  ['title' => 'Friends & Family', 'uri' => 'internal:/friends-family'],
];

$parent_links = [];
foreach ($menu_links as $weight => $definition) {
  $existing = \Drupal::entityTypeManager()->getStorage('menu_link_content')->loadByProperties([
    'menu_name' => 'main',
    'title' => $definition['title'],
  ]);
  $link = $existing ? reset($existing) : MenuLinkContent::create(['menu_name' => 'main']);
  $link->set('title', $definition['title']);
  $link->set('link', ['uri' => $definition['uri']]);
  $link->set('weight', $weight);
  $link->set('expanded', in_array($definition['title'], ['Find a Contractor', 'Resources'], TRUE));
  $link->save();
  $parent_links[$definition['title']] = $link;
}

$child_links = [
  'Find a Contractor' => [
    ['title' => 'Find a Dealer', 'uri' => 'internal:/find-a-dealer'],
    ['title' => 'Oahu Dealers', 'uri' => 'internal:/find-a-dealer/oahu-dealers'],
    ['title' => 'Maui Dealers', 'uri' => 'internal:/find-a-dealer/maui-dealers'],
    ['title' => 'Kauai Dealers', 'uri' => 'internal:/find-a-dealer/kauai-dealers'],
    ['title' => 'Big Island Dealers', 'uri' => 'internal:/find-a-dealer/big-island-dealers'],
    ['title' => 'Locate a Fujitsu Contractor', 'uri' => 'internal:/locate-a-fujitsu-contractor'],
  ],
  'Resources' => [
    ['title' => 'Fujitsu Brochures', 'uri' => 'internal:/resources/fujitsu-brochures'],
    ['title' => 'Full Line Brochure', 'uri' => 'internal:/resources/full-line-brochure'],
    ['title' => 'Consumer Brochure', 'uri' => 'internal:/resources/consumer-brochure'],
    ['title' => 'Troubleshooting Guide', 'uri' => 'internal:/resources/troubleshooting-guide'],
    ['title' => 'Fujitsu General', 'uri' => 'internal:/resources/fujitsu-general'],
    ['title' => 'Rebates', 'uri' => 'internal:/resources/rebates'],
    ['title' => 'Fujitsu Videos', 'uri' => 'internal:/resources/fujitsu-videos'],
    ['title' => 'Maintenance Tips', 'uri' => 'internal:/maintenance-tips'],
    ['title' => 'Tech Tips', 'uri' => 'internal:/tech-tips'],
  ],
];

foreach ($child_links as $parent_title => $links) {
  if (empty($parent_links[$parent_title])) {
    continue;
  }

  $parent_plugin_id = 'menu_link_content:' . $parent_links[$parent_title]->uuid();

  foreach ($links as $weight => $definition) {
    $existing = \Drupal::entityTypeManager()->getStorage('menu_link_content')->loadByProperties([
      'menu_name' => 'main',
      'title' => $definition['title'],
    ]);
    $link = $existing ? reset($existing) : MenuLinkContent::create(['menu_name' => 'main']);
    $link->set('title', $definition['title']);
    $link->set('link', ['uri' => $definition['uri']]);
    $link->set('parent', $parent_plugin_id);
    $link->set('weight', $weight);
    $link->set('expanded', FALSE);
    $link->save();
  }
}

echo "Seeded Fujitsu strategic pages and menu links.\n";
