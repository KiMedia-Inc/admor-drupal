<?php

declare(strict_types=1);

use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\node\Entity\Node;
use Drupal\taxonomy\Entity\Term;

$pages = [
  'Fujitsu General Manufacturer Resource Center' => [
    'alias' => '/manufacturer/fujitsu-general-resources',
    'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Official manufacturer resources</p><h2>Research Fujitsu from the manufacturer, then ask locally.</h2><p>Fujitsu General publishes product lineups, warranty statements, technology explainers, rebates, tax-credit documents, manuals, submittal sheets, videos, and case studies. This hub organizes the most useful manufacturer resources for Hawaii buyers and contractors, then connects each decision back to local Fujitsu support.</p></section><div class="ilf-card-grid ilf-card-grid--three"><article><h3>Product lineup</h3><p>Review AIRSTAGE mini-split families, indoor unit styles, model categories, capacities, and comfort applications.</p><a class="btn-main" href="/manufacturer/airstage-mini-split-lineup">View lineup</a></article><article><h3>Technology</h3><p>Understand ProCore corrosion-resistance messaging, inverter comfort, controls, and features that matter in Hawaii.</p><a class="btn-main" href="/manufacturer/fujitsu-technology">View technology</a></article><article><h3>Tax credits and rebates</h3><p>Use official IRA, 25C, and rebate documents as a starting point before confirming eligibility with a contractor or tax professional.</p><a class="btn-main" href="/manufacturer/tax-credits-rebates">View incentives</a></article></div><section class="ilf-callout"><h2>Manufacturer research is step one. A Fujitsu quote is the next step.</h2><p>After reviewing Fujitsu General documents, ask your local AC contractor to quote Fujitsu specifically and explain which system is right for your home or business.</p><p><a class="btn-main" href="/find-a-contractor">Find a Fujitsu Contractor</a> <a class="btn-main btn-outline" href="/products">Browse Fujitsu PDFs</a></p></section>',
  ],
  'Fujitsu AIRSTAGE Mini-Split Lineup' => [
    'alias' => '/manufacturer/airstage-mini-split-lineup',
    'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">AIRSTAGE mini-split lineup</p><h2>Fujitsu gives Hawaii buyers multiple paths to ductless comfort.</h2><p>Fujitsu General’s residential AIRSTAGE mini-split lineup includes single-room systems, multi-zone configurations, and a range of indoor unit styles. The manufacturer lineup includes wall mounted, floor mounted, ceiling suspended, compact cassette, circular flow cassette, medium static pressure duct, and multi-position air handling unit options.</p></section><div class="ilf-card-grid ilf-card-grid--three"><article><h3>Wall mounted comfort</h3><p>The familiar mini-split option for bedrooms, living rooms, offices, additions, and spaces where ductwork is not practical.</p></article><article><h3>Concealed and cassette options</h3><p>Ceiling cassette and ducted configurations support cleaner interior design when a visible wall unit is not the right fit.</p></article><article><h3>Multi-zone flexibility</h3><p>Multi-zone systems can connect multiple indoor units to one outdoor system, helping homeowners target comfort room by room.</p></article></div><section class="ilf-callout"><h2>Ask your contractor to match the system to the room.</h2><p>Model availability, capacity, refrigerant generation, and installation requirements change over time. Use the official lineup for research, then confirm the right Fujitsu configuration with a qualified contractor.</p><p><a class="btn-main" href="https://www.fujitsugeneral.com/us/products/split/index.html">Open official lineup</a> <a class="btn-main btn-outline" href="/find-a-contractor">Find a Contractor</a></p></section>',
  ],
  'Fujitsu General Technology for Hawaii Comfort' => [
    'alias' => '/manufacturer/fujitsu-technology',
    'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Technology proof points</p><h2>Use manufacturer technology pages to explain why Fujitsu belongs in Hawaii homes.</h2><p>Fujitsu General’s manufacturer resources give the site stronger proof points around corrosion resistance, inverter-driven comfort, user-friendly controls, humidity comfort, quiet operation, and product support. The copy on this site should translate those technical advantages into simple buyer language.</p></section><div class="ilf-card-grid ilf-card-grid--three"><article><h3>ProCore corrosion-resistance</h3><p>ProCore messaging helps explain why corrosion-aware product design matters for humid, coastal, salt-air environments.</p><a class="btn-main" href="https://www.fujitsu-general.com/us/residential/technology/procore-technology.html">Open ProCore</a></article><article><h3>Inverter comfort</h3><p>Inverter systems vary compressor speed to help improve comfort stability, efficiency, noise, and response compared with simple on/off operation.</p><a class="btn-main" href="https://www.fujitsugeneral.com/us/residential/technology/inverters-constant-comfort.html">Open inverter info</a></article><article><h3>Controls and daily use</h3><p>Control options, timers, dehumidification modes, and readable interfaces help make Fujitsu easier to live with after installation.</p><a class="btn-main" href="https://www.fujitsugeneral.com/us/residential/technology/user-friendly-controls.html">Open controls info</a></article></div><section class="ilf-callout"><h2>Turn technology into a better contractor conversation.</h2><p>Ask how the proposed Fujitsu system handles salt air, humidity, room-by-room comfort, drainage, maintenance, and long-term service access.</p><p><a class="btn-main" href="/compare">Compare Fujitsu</a> <a class="btn-main btn-outline" href="/find-a-contractor">Find a Contractor</a></p></section>',
  ],
  'Fujitsu Tax Credits, Rebates, and Warranty Resources' => [
    'alias' => '/manufacturer/tax-credits-rebates',
    'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Incentives and confidence</p><h2>Use official Fujitsu documents to verify rebates, IRA information, and warranty pathways.</h2><p>Manufacturer documents can help buyers understand possible incentives and warranty requirements. Eligibility depends on model, installation date, registration, location, program rules, and tax situation, so final confirmation should come from the contractor, program administrator, or tax professional.</p></section><div class="ilf-card-grid ilf-card-grid--three"><article><h3>IRA heat pump fact sheet</h3><p>Official Fujitsu General fact sheet summarizing Inflation Reduction Act incentive concepts for heat pump systems.</p><a class="btn-main" href="https://www.fujitsugeneral.com/us/resources/pdf/residential/benefits/pdf-fcus-ira-03.pdf">Open IRA PDF</a></article><article><h3>25C manufacturer statement</h3><p>Use the manufacturer certification statement as a reference when evaluating tax-credit eligibility.</p><a class="btn-main" href="https://www.fujitsugeneral.com/us/resources/pdf/support/downloads/pdf-fcus-manufacturer-cert-statement-minisplit-2025-02.pdf">Open 25C PDF</a></article><article><h3>AIRSTAGE warranty</h3><p>Fujitsu General’s warranty page explains standard coverage and extended warranty paths for qualifying installations.</p><a class="btn-main" href="https://www.fujitsugeneral.com/us/support/downloads/halcyon/warranty.html">Open warranty</a></article></div><section class="ilf-callout"><h2>Confirm incentives before installation.</h2><p>Rebate and tax-credit rules change. Before finalizing a system, ask your contractor to confirm model eligibility, documentation, and registration steps.</p><p><a class="btn-main" href="/resources/rebates">View rebate resources</a> <a class="btn-main btn-outline" href="/find-a-contractor">Find a Contractor</a></p></section>',
  ],
  'Fujitsu General Media Library and Case Studies' => [
    'alias' => '/manufacturer/media-library',
    'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Manufacturer media</p><h2>Fujitsu General’s media library adds proof beyond brochures.</h2><p>The official media library includes case studies, videos, advertising, press releases, news articles, and educational content. For this Hawaii site, the best use is to point buyers toward proof that ductless Fujitsu systems work in many real-world building types while keeping the local CTA focused on asking for Fujitsu by name.</p></section><div class="ilf-card-grid ilf-card-grid--three"><article><h3>Case studies</h3><p>Manufacturer case studies show how ductless systems are used in schools, churches, apartments, salons, historic buildings, custom homes, and unique spaces.</p></article><article><h3>Videos and advertising</h3><p>Videos help visitors understand product families, AIRSTAGE messaging, and comfort stories without overwhelming them with specs.</p></article><article><h3>News and education</h3><p>Manufacturer news and press items can support SEO topics such as heat pumps, mini-split service, efficiency, refrigerants, and VRF technology.</p></article></div><section class="ilf-callout"><h2>Use proof, then choose Fujitsu locally.</h2><p>Manufacturer case studies build confidence; local contractor support makes the system practical for Hawaii.</p><p><a class="btn-main" href="https://www.fujitsugeneral.com/us/media-library/index.html">Open media library</a> <a class="btn-main btn-outline" href="/find-a-contractor">Find a Contractor</a></p></section>',
  ],
];

foreach ($pages as $title => $data) {
  $node = ilf_fg_node_by_title('page', $title) ?: Node::create(['type' => 'page']);
  $node->setTitle($title);
  $node->setPublished(TRUE);
  $node->set('body', ['value' => $data['body'], 'format' => 'full_html']);
  $node->set('path', ['alias' => $data['alias'], 'pathauto' => 0]);
  $node->save();
}

$resources = [
  ['Fujitsu General Residential Products', 'Product Families', 'https://www.fujitsugeneral.com/us/products/index.html', 'Official manufacturer overview of residential heating and cooling product families.'],
  ['AIRSTAGE Single-Room Mini-Split Lineup', 'Mini-Split Systems', 'https://www.fujitsugeneral.com/us/products/split/index.html', 'Official Fujitsu General lineup for single-room AIRSTAGE mini-split systems, capacities, and indoor unit styles.'],
  ['AIRSTAGE Mini-Split Downloads Library', 'Technical Guides', 'https://www.fujitsugeneral.com/us/support/downloads/halcyon/index.html', 'Official downloads hub for AIRSTAGE mini-split catalogs, warranty documents, operation manuals, and submittal sheets.'],
  ['AIRSTAGE Warranty Information', 'Warranty', 'https://www.fujitsugeneral.com/us/support/downloads/halcyon/warranty.html', 'Official warranty page explaining standard and extended warranty paths for qualifying AIRSTAGE installations.'],
  ['AIRSTAGE H-Series Limited Warranty Statement R-32', 'Warranty', 'https://www.fujitsugeneral.com/us/resources/pdf/support/downloads/pdf-fcus-halcyon-warranty-202410.pdf', 'Current Fujitsu General limited warranty statement for AIRSTAGE H-Series systems.'],
  ['Fujitsu Inflation Reduction Act Heat Pump Fact Sheet', 'Rebates', 'https://www.fujitsugeneral.com/us/resources/pdf/residential/benefits/pdf-fcus-ira-03.pdf', 'Official Fujitsu General IRA heat pump fact sheet for incentive research.'],
  ['Fujitsu 25C Tax Credit Manufacturer Certification Statement', 'Rebates', 'https://www.fujitsugeneral.com/us/resources/pdf/support/downloads/pdf-fcus-manufacturer-cert-statement-minisplit-2025-02.pdf', 'Manufacturer certification statement for 25C tax-credit research.'],
  ['Fujitsu Rebates and Offers', 'Rebates', 'https://www.fujitsugeneral.com/us/residential/benefits/rebates-and-offers.html', 'Official manufacturer rebates and offers page for checking available incentives.'],
  ['Fujitsu ProCore Corrosion-Resistant Technology', 'Technical Guides', 'https://www.fujitsu-general.com/us/residential/technology/procore-technology.html', 'Manufacturer technology page explaining ProCore corrosion-resistant tubing.'],
  ['Fujitsu Inverter Constant Comfort Technology', 'Technical Guides', 'https://www.fujitsugeneral.com/us/residential/technology/inverters-constant-comfort.html', 'Manufacturer technology page explaining inverter-driven comfort and efficiency.'],
  ['Fujitsu User Friendly Controls', 'Technical Guides', 'https://www.fujitsugeneral.com/us/residential/technology/user-friendly-controls.html', 'Manufacturer technology page for remote controls, timers, dehumidification, and control options.'],
  ['Fujitsu General Media Library', 'Fujitsu Videos', 'https://www.fujitsugeneral.com/us/media-library/index.html', 'Official media library with case studies, videos, advertising, news, and press releases.'],
  ['AIRSTAGE Operation Manuals', 'Technical Guides', 'https://www.fujitsugeneral.com/us/support/downloads/halcyon/manual.html', 'Official operation manual library for current AIRSTAGE mini-split systems.'],
  ['Central Air Conditioners, Heat Pumps, and Furnaces', 'Airstage / Commercial', 'https://www.fujitsugeneral.com/us/products/central-air-conditioners/index.html', 'Official Fujitsu General overview for central air conditioners, heat pumps, furnaces, air handlers, coils, and packaged equipment.'],
];

foreach ($resources as [$title, $type, $url, $description]) {
  $node = ilf_fg_node_by_title('resource_brochure', $title) ?: Node::create(['type' => 'resource_brochure']);
  $node->setTitle($title);
  $node->setPublished(TRUE);
  $node->set('body', ['value' => '<p>' . htmlspecialchars($description, ENT_QUOTES | ENT_HTML5) . '</p><p>Use this official Fujitsu General resource for research, then confirm the right system and documentation path with a local Fujitsu contractor.</p><p><a class="btn-main" href="' . htmlspecialchars($url, ENT_QUOTES | ENT_HTML5) . '">Open official resource</a></p>', 'format' => 'full_html']);
  $node->set('field_resource_link', ['uri' => $url, 'title' => 'Open official resource']);
  if ($term = ilf_fg_term_by_name('resource_type', $type)) {
    $node->set('field_resource_category', $term->id());
  }
  $node->set('field_featured', str_contains($title, 'Warranty') || str_contains($title, 'Tax') || str_contains($title, 'IRA'));
  $node->set('field_sort_order', 300 + array_search([$title, $type, $url, $description], $resources, TRUE));
  $node->set('path', ['alias' => '/resources/' . ilf_fg_slug($title), 'pathauto' => 0]);
  $node->save();
}

ilf_fg_menu_link('main', 'Manufacturer Resources', 'internal:/manufacturer/fujitsu-general-resources', 69, 'Resources');
ilf_fg_menu_link('footer', 'Manufacturer Resources', 'internal:/manufacturer/fujitsu-general-resources', 95);

echo "Fujitsu General manufacturer content seeded.\n";

function ilf_fg_node_by_title(string $bundle, string $title): ?Node {
  $ids = \Drupal::entityQuery('node')
    ->accessCheck(FALSE)
    ->condition('type', $bundle)
    ->condition('title', $title)
    ->range(0, 1)
    ->execute();
  return $ids ? Node::load(reset($ids)) : NULL;
}

function ilf_fg_term_by_name(string $vid, string $name): ?Term {
  $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['vid' => $vid, 'name' => $name]);
  if ($terms) {
    return reset($terms);
  }
  $term = Term::create(['vid' => $vid, 'name' => $name]);
  $term->save();
  return $term;
}

function ilf_fg_menu_link(string $menu, string $title, string $uri, int $weight, ?string $parent_title = NULL): void {
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
  if ($parent_title) {
    $parent_ids = \Drupal::entityQuery('menu_link_content')
      ->accessCheck(FALSE)
      ->condition('menu_name', $menu)
      ->condition('title', $parent_title)
      ->range(0, 1)
      ->execute();
    if ($parent_ids) {
      $parent = MenuLinkContent::load(reset($parent_ids));
      $link->set('parent', 'menu_link_content:' . $parent->uuid());
    }
  }
  $link->set('enabled', TRUE);
  $link->save();
}

function ilf_fg_slug(string $title): string {
  $slug = strtolower($title);
  $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);
  return trim($slug, '-');
}
