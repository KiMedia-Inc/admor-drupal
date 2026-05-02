<?php

declare(strict_types=1);

use Drupal\node\Entity\Node;
use Drupal\redirect\Entity\Redirect;

$node_storage = \Drupal::entityTypeManager()->getStorage('node');
$alias_storage = \Drupal::entityTypeManager()->getStorage('path_alias');
$redirect_storage = \Drupal::entityTypeManager()->getStorage('redirect');
$format = 'full_html';

function ilf_node_by_title(string $bundle, string $title): ?Node {
  $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties([
    'type' => $bundle,
    'title' => $title,
  ]);
  return $nodes ? reset($nodes) : NULL;
}

function ilf_set_page_body(string $title, string $body): void {
  if ($node = ilf_node_by_title('page', $title)) {
    $node->set('body', ['value' => $body, 'format' => 'full_html']);
    $node->save();
  }
}

function ilf_unpublish_node(int $nid): void {
  if ($node = Node::load($nid)) {
    if ($node->isPublished()) {
      $node->setUnpublished();
      $node->save();
      echo "Unpublished duplicate/artifact #{$nid}: {$node->label()}\n";
    }
  }
}

function ilf_canonical_alias(int $nid, string $alias, array $redirects = []): void {
  $alias_storage = \Drupal::entityTypeManager()->getStorage('path_alias');
  $redirect_storage = \Drupal::entityTypeManager()->getStorage('redirect');
  foreach (array_merge([$alias], $redirects) as $path) {
    foreach ($alias_storage->loadByProperties(['alias' => $path]) as $path_alias) {
      $path_alias->delete();
    }
    foreach ($redirect_storage->loadByProperties(['redirect_source__path' => ltrim($path, '/')]) as $redirect) {
      $redirect->delete();
    }
  }
  foreach ($alias_storage->loadByProperties(['path' => '/node/' . $nid]) as $path_alias) {
    $path_alias->delete();
  }
  $alias_storage->create([
    'path' => '/node/' . $nid,
    'alias' => $alias,
    'langcode' => 'en',
  ])->save();
  foreach ($redirects as $from) {
    Redirect::create([
      'redirect_source' => ['path' => ltrim($from, '/')],
      'redirect_redirect' => ['uri' => 'internal:' . $alias],
      'status_code' => 301,
      'language' => 'und',
    ])->save();
  }
}

// Remove duplicate published content that shared identical final aliases.
ilf_unpublish_node(80);
ilf_unpublish_node(79);
ilf_unpublish_node(19);
ilf_canonical_alias(26, '/updates/fujitsu-12-year-gecko-warranty', ['/2019/04/23/fujitsu-12-year-and-gecko-warranty']);
ilf_canonical_alias(78, '/updates/cooling-cancer-donates-70k', ['/updates/coolingcancer-donates-70k']);
ilf_canonical_alias(51, '/resources/rebates', ['/resources/rebates-overview']);

$title_alias_updates = [
  52 => ['2014 Cooling Cancer Charity Golf Tournament', '/updates/2014-cooling-cancer-charity-golf-tournament', ['/updates/2014-coolingcancer-charity-golf-tournament']],
  55 => ['2015 Cooling Cancer Golf Tournament', '/updates/2015-cooling-cancer-golf-tournament', ['/updates/2015-coolingcancer-golf-tournament']],
  56 => ['2016 Cooling Cancer Golf Tournament', '/updates/2016-cooling-cancer-golf-tournament', ['/updates/2016-coolingcancer-golf-tournament']],
  57 => ['2017 Cooling Cancer Golf Tournament', '/updates/2017-cooling-cancer-golf-tournament', ['/updates/2017-coolingcancer-golf-tournament']],
  58 => ['AIRSTAGE on Broadway', '/updates/airstage-on-broadway', []],
  60 => ['Cooling Cancer Donates $45K', '/updates/cooling-cancer-donates-45k', ['/updates/coolingcancer-donates-45k']],
  61 => ['Cooling Cancer Donates $50K', '/updates/cooling-cancer-donates-50k', ['/updates/coolingcancer-donates-50k']],
  53 => ['Donations to Cool Schools', '/updates/donations-to-cool-schools', ['/updates/donations-cool-schools']],
  62 => ['Find a Fujitsu Contractor', '/updates/find-a-fujitsu-contractor', []],
  86 => ["Fujitsu General's ProCore High Corrosion-Resistant Technology", '/updates/fujitsu-procore-corrosion-resistant-technology', ['/updates/fujitsu-generals-procore-high-corrosion-resistant-technology']],
  27 => ['Hawaii Energy Rebates', '/updates/hawaii-energy-rebates', ['/2020/06/03/hawaii-energy-rebates']],
  64 => ['West Oahu Schools Receive Donation', '/updates/west-oahu-schools-receive-donation', ['/updates/w-oahu-schools-receive-donation']],
  81 => ['Fujitsu 410A Mini-Split Troubleshooting Guide', '/resources/fujitsu-410a-mini-split-troubleshooting-guide', ['/resources/fujitsu-410a-mini-split-troubleshooting-guide']],
];

foreach ($title_alias_updates as $nid => [$title, $alias, $redirects]) {
  if ($node = Node::load($nid)) {
    $node->setTitle($title);
    $node->save();
    ilf_canonical_alias($nid, $alias, $redirects);
  }
}

// Make thin support pages feel intentional and useful, not like migrated stubs.
ilf_set_page_body('Fujitsu Brochures', '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Brochures</p><h2>Compare Fujitsu comfort options before the estimate.</h2><p>Fujitsu brochures help buyers understand system types, efficiency, room-by-room comfort, and the questions to ask a contractor. Use these materials to make the brand request clear before equipment is quoted.</p></section><div class="ilf-card-grid ilf-card-grid--three"><article><h3>Full line brochure</h3><p>Best for homeowners, developers, and property managers comparing the complete Fujitsu product family.</p><a class="btn-main" href="/resources/full-line-brochure">Open full line brochure</a></article><article><h3>Consumer brochure</h3><p>Best for buyer-friendly education around quiet comfort, efficiency, and ductless flexibility.</p><a class="btn-main" href="/resources/consumer-brochure">Open consumer brochure</a></article><article><h3>Quick consumer guide</h3><p>A shorter brochure for fast pre-estimate review and simple Fujitsu talking points.</p><a class="btn-main" href="/resources/consumer-brochure-condensed">Open condensed guide</a></article></div>');

ilf_set_page_body('Fujitsu General', '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Manufacturer support</p><h2>Fujitsu General brings the product depth. Hawaii support makes it practical.</h2><p>Use Fujitsu General resources for product family information, technical background, and manufacturer-level context. For Hawaii buyers, the important next step is pairing that product strength with certified local installation support.</p></section><section class="ilf-callout"><h2>Research the brand, then ask locally.</h2><p>When you contact an AC contractor, ask directly for Fujitsu and confirm which Fujitsu system is right for your space.</p><p><a class="btn-main" href="https://www.fujitsugeneral.com/">Visit Fujitsu General</a></p></section>');

ilf_set_page_body('Fujitsu Videos', '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Video library</p><h2>See the Fujitsu comfort story in motion.</h2><p>Videos and commercials help buyers remember the brand before they meet with a contractor. The goal is simple: when options are discussed, Fujitsu should already be the name they trust.</p></section><div class="ilf-card-grid ilf-card-grid--three"><article><h3>Commercials</h3><p>Local Fujitsu Hawaii commercials and buyer-facing video messages.</p><a class="btn-main" href="/commercials">Watch commercials</a></article><article><h3>Product education</h3><p>Manufacturer videos for learning about ductless comfort, controls, and system options.</p><a class="btn-main" href="https://www.youtube.com/user/FujitsuGeneralUSA/playlists">Open Fujitsu video playlists</a></article><article><h3>Next step</h3><p>Bring what you learn to a certified Fujitsu contractor and ask for Fujitsu by name.</p><a class="btn-main" href="/find-a-contractor">Find a contractor</a></article></div>');

ilf_set_page_body('Maintenance Tips', '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Care and performance</p><h2>Protect comfort with routine Fujitsu maintenance.</h2><p>Hawaii air conditioners work hard through humidity, salt air, dust, and year-round use. Regular care helps preserve efficiency, quiet operation, and long-term reliability.</p></section><div class="ilf-card-grid ilf-card-grid--three"><article><h3>Clean filters regularly</h3><p>Check filters often, especially in homes with pets, heavy use, or open windows. Clean airflow helps comfort and efficiency.</p></article><article><h3>Keep outdoor units clear</h3><p>Maintain clearance around the outdoor unit and keep leaves, salt residue, and debris from restricting airflow.</p></article><article><h3>Schedule qualified service</h3><p>Use trained Fujitsu support for deeper cleaning, diagnostics, and performance checks before small issues become expensive repairs.</p></article></div><section class="ilf-callout"><h2>Not sure what your system needs?</h2><p>Ask a Fujitsu contractor to inspect, clean, and confirm your system is ready for Hawaii cooling demand.</p></section>');

ilf_set_page_body('Tech Tips', '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Technical guidance</p><h2>Better technical questions lead to better Fujitsu outcomes.</h2><p>Fujitsu performance depends on proper sizing, placement, installation quality, and service support. These tips help homeowners and project teams have more productive conversations with contractors.</p></section><div class="ilf-card-grid ilf-card-grid--three"><article><h3>Confirm sizing</h3><p>Ask how the system was sized for room load, sun exposure, insulation, ceiling height, and occupancy.</p></article><article><h3>Discuss placement</h3><p>Indoor and outdoor unit placement affects comfort, service access, noise, drainage, and long-term performance.</p></article><article><h3>Protect warranty confidence</h3><p>Use certified installation support, keep documentation, and confirm warranty coverage before work begins.</p></article></div><section class="ilf-callout"><h2>Need technical documentation?</h2><p>Use the Fujitsu troubleshooting guide as a reference, then work with a qualified contractor for service.</p><p><a class="btn-main" href="/resources/troubleshooting-guide">Open troubleshooting guide</a></p></section>');

ilf_set_page_body('I Love My Fujitsu Athletics Application', '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Community partnerships</p><h2>Fujitsu Hawaii supports the local programs people remember.</h2><p>Community visibility is part of how Fujitsu stays familiar across Hawaii. Athletics, schools, charity events, and local profiles all support the same brand goal: make Fujitsu the name people request when comfort matters.</p></section><div class="ilf-card-grid ilf-card-grid--three"><article><h3>Local recognition</h3><p>Partnerships connect Fujitsu with the people, schools, and events that Hawaii families already know.</p></article><article><h3>Brand trust</h3><p>Community involvement reinforces that Fujitsu is present locally, not just another mainland product line.</p></article><article><h3>Client-ready structure</h3><p>This page is ready for a future Drupal form or downloadable application packet once final program details are approved.</p></article></div>');

// Update commercials with clearer buyer intent and known video links where verified.
$commercial_updates = [
  'Fujitsu 12 Year and Gecko Warranty' => [
    'title' => 'Fujitsu 12-Year and Gecko Warranty',
    'video' => ['uri' => 'https://youtu.be/-hIhb3GqsFg', 'title' => 'Watch the Fujitsu warranty commercial'],
    'summary' => 'A warranty-focused Fujitsu Hawaii commercial that gives buyers a strong reason to ask for Fujitsu over competing AC brands.',
  ],
  'Fujitsu Girl Growing Up' => [
    'summary' => 'A local lifestyle commercial built around comfort, family, and the long-term decision to choose Fujitsu for Hawaii homes.',
  ],
  'Fujitsu Gym Dog' => [
    'summary' => 'A memorable Fujitsu Hawaii commercial that keeps the brand familiar and easy to request by name.',
  ],
  'Wang’s World of Fujitsu: Local Comfort' => [
    'summary' => 'A Fujitsu Hawaii video message focused on local comfort, local trust, and confident brand recall.',
  ],
  'Wang’s World of Fujitsu: Brand Story' => [
    'summary' => 'A Fujitsu Hawaii brand video that reinforces why buyers should request Fujitsu before their AC estimate is written.',
  ],
];

foreach ($commercial_updates as $lookup => $data) {
  $node = ilf_node_by_title('commercial_video', $lookup) ?: ilf_node_by_title('commercial_video', $data['title'] ?? $lookup);
  if (!$node) {
    continue;
  }
  if (isset($data['title'])) {
    $node->setTitle($data['title']);
  }
  $node->set('field_summary', $data['summary']);
  if (isset($data['video'])) {
    $node->set('field_video_url', $data['video']);
  }
  $node->set('body', [
    'value' => '<p>' . $data['summary'] . '</p><p>Use this message as part of the buyer journey: remember the Fujitsu name, compare comfort options, and ask your contractor for Fujitsu when it is time to quote a system.</p><p><a class="btn-main" href="/find-a-contractor">Find Fujitsu contractor support</a></p>',
    'format' => $format,
  ]);
  $node->save();
}

// Add final, visible summaries to resource cards through the body and link fields.
$resource_summaries = [
  'Consumer Brochure Condensed' => 'A shorter buyer guide for quick Fujitsu education before speaking with a contractor.',
  'Full Line Brochure' => 'A complete Fujitsu product overview for comparing ductless, multi-zone, and commercial comfort systems.',
  'Consumer Brochure' => 'A buyer-friendly brochure explaining comfort, efficiency, and ductless flexibility.',
  'Troubleshooting Guide' => 'A technical support reference for Fujitsu mini-split troubleshooting and contractor service conversations.',
  'Fujitsu 410a Mini-Split Troubleshooting Guide' => 'A support-focused guide for Fujitsu 410A mini-split troubleshooting.',
  'Hawaii Energy Rebates' => 'Rebate guidance for Hawaii buyers evaluating high-efficiency Fujitsu systems.',
  'Rebates' => 'A current incentive pathway for checking available Hawaii efficiency rebate programs.',
];

foreach ($resource_summaries as $title => $summary) {
  if ($node = ilf_node_by_title('resource_brochure', $title)) {
    $body = (string) ($node->body->value ?? '');
    $body = preg_replace('#<p><a class="btn-main"[^>]*>.*?</a></p>#s', '', $body) ?? $body;
    if (!str_contains($body, 'Ask your contractor for Fujitsu')) {
      $body .= '<p><strong>Ask your contractor for Fujitsu by name.</strong> Use this resource to make the conversation clearer before the estimate is written.</p>';
    }
    $node->set('body', ['value' => $body, 'format' => $format]);
    $node->save();
  }
}

echo "Final completion content pass complete.\n";
