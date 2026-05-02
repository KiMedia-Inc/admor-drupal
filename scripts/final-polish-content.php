<?php

declare(strict_types=1);

use Drupal\node\Entity\Node;

$storage = \Drupal::entityTypeManager()->getStorage('node');
$body_format = 'full_html';

function ilf_polish_title(string $title): string {
  $title = str_replace(['Fujitsus', 'Techonology', 'Mni Split', 'Coolingcancer', 'Khon2'], ['Fujitsu', 'Technology', 'Mini-Split', 'Cooling Cancer', 'KHON2'], $title);
  $title = preg_replace('/\s+2$/', '', $title) ?? $title;
  return trim($title);
}

function ilf_polish_summary(string $title, string $type): string {
  $lower = strtolower($title);
  if (str_contains($lower, 'rebate')) {
    return 'Current rebate guidance and buyer education to help Hawaii homeowners understand available incentives before selecting a Fujitsu system.';
  }
  if (str_contains($lower, 'warranty') || str_contains($lower, 'gecko')) {
    return 'Warranty-focused messaging that reinforces long-term confidence and gives buyers another reason to ask their contractor for Fujitsu.';
  }
  if (str_contains($lower, 'contractor') || str_contains($lower, 'elite')) {
    return 'Contractor-focused support content showing how Fujitsu is backed locally by trained professionals and island-based product knowledge.';
  }
  if (str_contains($lower, 'school') || str_contains($lower, 'scholarship') || str_contains($lower, 'donat') || str_contains($lower, 'charity') || str_contains($lower, 'cancer')) {
    return 'Community news highlighting Fujitsu Hawaii involvement, local partnerships, and the brand presence that keeps Fujitsu familiar across the islands.';
  }
  if ($type === 'commercial_video') {
    return 'A local Fujitsu Hawaii video asset that builds brand familiarity and helps customers remember to request Fujitsu by name.';
  }
  if ($type === 'face_profile') {
    return 'A familiar local Fujitsu story that adds Hawaii-based trust and personality to the brand.';
  }
  return 'Fujitsu Hawaii news and education designed to help buyers choose quiet, efficient comfort with confidence.';
}

function ilf_polish_body(string $title, string $type): string {
  $summary = ilf_polish_summary($title, $type);
  if ($type === 'commercial_video') {
    return '<p>' . $summary . '</p><p>Use this video as part of the decision journey: learn the message, compare comfort options, and ask your AC contractor for Fujitsu when it is time to quote a system.</p><p><a class="btn-main" href="/find-a-contractor">Find a Fujitsu contractor</a></p>';
  }
  if ($type === 'face_profile') {
    return '<p>' . $summary . '</p><p>Faces of Fujitsu content should help the brand feel local, credible, and connected to Hawaii. These profiles support the larger goal of making Fujitsu the air conditioning name people recognize and request.</p><p><a class="btn-main" href="/find-a-contractor">Ask for Fujitsu</a></p>';
  }
  if ($type === 'resource_brochure') {
    return '<p>This resource helps homeowners, property managers, builders, and contractors evaluate Fujitsu options with more confidence.</p><p>Use it to compare product choices, prepare better questions, and make the conversation with your installer more productive.</p><p><a class="btn-main" href="/find-a-contractor">Find local Fujitsu support</a></p>';
  }
  return '<p>' . $summary . '</p><p>Fujitsu is positioned for Hawaii homes and businesses that need quiet comfort, efficient operation, strong warranty support, and equipment backed by local inventory and contractor training.</p><p><a class="btn-main" href="/find-a-contractor">Find a Fujitsu contractor</a></p>';
}

function ilf_load_by_title(string $bundle, string $title): ?Node {
  $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties([
    'type' => $bundle,
    'title' => $title,
  ]);
  return $nodes ? reset($nodes) : NULL;
}

$dealer_updates = [
  'Oahu Fujitsu Contractor Placeholder' => [
    'title' => 'Oahu Fujitsu Dealer Network',
    'island' => 'oahu',
    'phone' => '(808) 841-7400',
    'address' => 'Honolulu, Windward Oahu, Central Oahu, Leeward Oahu, and North Shore service areas',
    'website' => ['uri' => 'https://contractors.fujitsugeneral.com/locator/HI/Honolulu', 'title' => 'Open Oahu Fujitsu contractor locator'],
    'body' => '<p>Connect with certified Fujitsu support on Oahu for residential homes, townhomes, condos, light commercial spaces, and replacement projects.</p><p>Ask your installer for Fujitsu by name and confirm that your system is matched to Hawaii humidity, salt air, and year-round cooling demands.</p><p><a class="btn-main" href="https://contractors.fujitsugeneral.com/locator/HI/Honolulu">Open Oahu Fujitsu contractor locator</a></p>',
    'alias' => '/find-a-dealer/oahu-fujitsu-dealer-network',
  ],
  'Maui Fujitsu Contractor Placeholder' => [
    'title' => 'Maui Fujitsu Dealer Network',
    'island' => 'maui',
    'phone' => '(808) 841-7400',
    'address' => 'Kahului, Wailuku, Kihei, Lahaina, Upcountry, and islandwide Maui service areas',
    'website' => ['uri' => 'https://contractors.fujitsugeneral.com/locator/HI/MAUI', 'title' => 'Open Maui Fujitsu contractor locator'],
    'body' => '<p>Find Fujitsu-focused contractor support for Maui homes, vacation properties, offices, and small commercial spaces.</p><p>Fujitsu systems are a strong fit when quiet comfort, efficient cooling, and dependable local product support matter.</p><p><a class="btn-main" href="https://contractors.fujitsugeneral.com/locator/HI/MAUI">Open Maui Fujitsu contractor locator</a></p>',
    'alias' => '/find-a-dealer/maui-fujitsu-dealer-network',
  ],
  'Kauai Fujitsu Contractor Placeholder' => [
    'title' => 'Kauai Fujitsu Dealer Network',
    'island' => 'kauai',
    'phone' => '(808) 841-7400',
    'address' => 'Lihue, Kapaa, Princeville, Poipu, Waimea, and islandwide Kauai service areas',
    'website' => ['uri' => 'https://contractors.fujitsugeneral.com/locator/HI/Kauai', 'title' => 'Open Kauai Fujitsu contractor locator'],
    'body' => '<p>Use this Kauai dealer pathway to connect with qualified Fujitsu installation and service support.</p><p>Ask for Fujitsu when comparing brands so your contractor understands that reliability, quiet operation, and local backing are priorities.</p><p><a class="btn-main" href="https://contractors.fujitsugeneral.com/locator/HI/Kauai">Open Kauai Fujitsu contractor locator</a></p>',
    'alias' => '/find-a-dealer/kauai-fujitsu-dealer-network',
  ],
  'Big Island Fujitsu Contractor Placeholder' => [
    'title' => 'Hawaii Island Fujitsu Dealer Network',
    'island' => 'big_island',
    'phone' => '(808) 841-7400',
    'address' => 'Hilo, Kona, Waimea, Puna, Hamakua, and islandwide Hawaii Island service areas',
    'website' => ['uri' => 'https://contractors.fujitsugeneral.com/locator/HI/Hawaii', 'title' => 'Open Hawaii Island Fujitsu contractor locator'],
    'body' => '<p>Find Fujitsu contractor support for Hawaii Island homes, businesses, and projects where durability and efficient year-round comfort matter.</p><p>Start the conversation by asking your contractor for Fujitsu and confirming the system is sized and selected for island conditions.</p><p><a class="btn-main" href="https://contractors.fujitsugeneral.com/locator/HI/Hawaii">Open Hawaii Island Fujitsu contractor locator</a></p>',
    'alias' => '/find-a-dealer/hawaii-island-fujitsu-dealer-network',
  ],
];

foreach ($dealer_updates as $old_title => $data) {
  $node = ilf_load_by_title('dealer_contractor', $old_title) ?: ilf_load_by_title('dealer_contractor', $data['title']);
  if (!$node) {
    $node = Node::create(['type' => 'dealer_contractor']);
  }
  $node->setTitle($data['title']);
  $node->set('status', 1);
  $node->set('field_island', $data['island']);
  $node->set('field_phone', $data['phone']);
  $node->set('field_address', $data['address']);
  $node->set('field_website', $data['website']);
  $node->set('body', ['value' => $data['body'], 'format' => $body_format]);
  $node->set('path', ['alias' => $data['alias']]);
  $node->save();
}

$resource_updates = [
  'Full Line Brochure' => [
    'type' => 'brochure',
    'link' => ['uri' => 'http://ilovemyfujitsu.com/wp-content/uploads/2021/04/2021_Full_Line_Brochure_FG2028.pdf', 'title' => 'Open Fujitsu full line brochure'],
    'summary' => 'A complete Fujitsu product overview for comparing ductless, multi-zone, and commercial comfort options before requesting a quote.',
    'body' => '<p>Use the Fujitsu full line brochure to understand the breadth of available systems before meeting with a contractor. It is especially useful for homeowners, builders, and property managers who want to compare comfort options and ask better questions during the estimate process.</p><p><a class="btn-main" href="http://ilovemyfujitsu.com/wp-content/uploads/2021/04/2021_Full_Line_Brochure_FG2028.pdf">Open the full line brochure</a></p>',
  ],
  'Consumer Brochure' => [
    'type' => 'brochure',
    'link' => ['uri' => 'http://admorhvac.com/wp-content/uploads/2020/08/2020_fujitsu_consumer_brochure.pdf', 'title' => 'Open Fujitsu consumer brochure'],
    'summary' => 'Buyer-friendly Fujitsu guidance for understanding comfort, efficiency, and indoor air quality benefits.',
    'body' => '<p>The consumer brochure gives homeowners a clearer picture of why Fujitsu is a strong fit for Hawaii living: quiet operation, efficient cooling, design flexibility, and comfort that can be tailored room by room.</p><p><a class="btn-main" href="http://admorhvac.com/wp-content/uploads/2020/08/2020_fujitsu_consumer_brochure.pdf">Open the consumer brochure</a></p>',
  ],
  'Troubleshooting Guide' => [
    'type' => 'guide',
    'link' => ['uri' => 'http://ilovemyfujitsu.com/wp-content/uploads/2021/05/fujitsu2019-Troubleshooting-Guide.pdf', 'title' => 'Open Fujitsu troubleshooting guide'],
    'summary' => 'Technical support reference for installers, service teams, and advanced owners troubleshooting Fujitsu mini-split systems.',
    'body' => '<p>This troubleshooting guide is intended for technical reference and contractor support. Homeowners should use it to understand the support path, then work with a qualified Fujitsu contractor for diagnosis and service.</p><p><a class="btn-main" href="http://ilovemyfujitsu.com/wp-content/uploads/2021/05/fujitsu2019-Troubleshooting-Guide.pdf">Open the troubleshooting guide</a></p>',
  ],
  'Hawaii Energy Rebates' => [
    'type' => 'rebate',
    'link' => ['uri' => 'http://ilovemyfujitsu.com/wp-content/uploads/2020/06/2020_hawaii_energy_1500_rebate.pdf', 'title' => 'Review Hawaii Energy rebate information'],
    'summary' => 'Rebate guidance for Hawaii buyers evaluating high-efficiency Fujitsu systems and available incentives.',
    'body' => '<p>Hawaii Energy rebates can make a high-efficiency Fujitsu system even more compelling. Confirm current incentive availability, eligibility, and installation requirements with your contractor before finalizing your system.</p><p><a class="btn-main" href="http://ilovemyfujitsu.com/wp-content/uploads/2020/06/2020_hawaii_energy_1500_rebate.pdf">Review rebate information</a></p>',
  ],
  'Fujitsu 410a Mini-Split Troubleshooting Guide' => [
    'type' => 'guide',
    'link' => ['uri' => 'http://ilovemyfujitsu.com/wp-content/uploads/2021/05/fujitsu2019-Troubleshooting-Guide.pdf', 'title' => 'Open Fujitsu troubleshooting guide'],
    'summary' => 'A support-focused technical guide for Fujitsu 410A mini-split troubleshooting.',
    'body' => '<p>Use this guide as a technical reference for Fujitsu 410A mini-split troubleshooting. For service work, confirm findings with a qualified Fujitsu contractor.</p><p><a class="btn-main" href="http://ilovemyfujitsu.com/wp-content/uploads/2021/05/fujitsu2019-Troubleshooting-Guide.pdf">Open the troubleshooting guide</a></p>',
  ],
  'Rebates' => [
    'type' => 'rebate',
    'link' => ['uri' => 'https://hawaiienergy.com/for-homes/rebates', 'title' => 'Check current Hawaii Energy rebates'],
    'summary' => 'A buyer pathway for checking current energy efficiency rebates before selecting a Fujitsu system.',
    'body' => '<p>Rebate programs change over time, so buyers should verify current offers before installation. Fujitsu remains the brand request; rebates can help make the right choice easier to move forward.</p><p><a class="btn-main" href="https://hawaiienergy.com/for-homes/rebates">Check current rebate programs</a></p>',
  ],
];

foreach ($resource_updates as $title => $data) {
  if ($node = ilf_load_by_title('resource_brochure', $title)) {
    $node->set('field_resource_type', $data['type']);
    $node->set('field_resource_link', $data['link']);
    if ($node->hasField('field_summary')) {
      $node->set('field_summary', $data['summary']);
    }
    $node->set('body', ['value' => $data['body'], 'format' => $body_format]);
    $node->save();
  }
}

$condensed = ilf_load_by_title('resource_brochure', 'Consumer Brochure Condensed');
if (!$condensed) {
  $condensed = Node::create(['type' => 'resource_brochure']);
}
$condensed->setTitle('Consumer Brochure Condensed');
$condensed->set('status', 1);
$condensed->set('field_resource_type', 'brochure');
$condensed->set('field_resource_link', [
  'uri' => 'http://admorhvac.com/wp-content/uploads/2020/08/2020_fujitsu_consumer_brochure_condensed.pdf',
  'title' => 'Open condensed Fujitsu consumer brochure',
]);
$condensed->set('body', [
  'value' => '<p>A shorter consumer brochure for quick Fujitsu education before a homeowner, property manager, or builder speaks with an AC contractor.</p><p><a class="btn-main" href="http://admorhvac.com/wp-content/uploads/2020/08/2020_fujitsu_consumer_brochure_condensed.pdf">Open the condensed brochure</a></p>',
  'format' => $body_format,
]);
$condensed->set('path', ['alias' => '/resources/consumer-brochure-condensed']);
$condensed->save();

$profile_updates = [
  'Kanoa Leahey' => [
    'role' => 'University of Hawaii sports voice and Fujitsu Hawaii profile',
    'summary' => 'A familiar Hawaii sportscaster whose profile reinforces Fujitsu as a local, recognizable comfort brand.',
    'body' => '<p>Kanoa Leahey is the voice of University of Hawaii sports, a KHON2 sports reporter, and an announcer for Spectrum Sports and ESPN Networks. A Hawaii Sportscaster of the Year honoree, Kanoa is part of a three-generation sportscasting family following his father Jim Leahey and grandfather Chuck Leahey.</p><p>His Faces of Fujitsu profile helps connect the brand with familiar Hawaii voices and the everyday local confidence buyers look for when choosing an AC system.</p>',
  ],
  'Greg Salas' => [
    'role' => 'Former UH and NFL football player',
    'summary' => 'A local athletics profile that connects Fujitsu Hawaii with performance, durability, and community recognition.',
    'body' => '<p>Greg Salas starred for the University of Hawaii before being drafted by the St. Louis Rams in 2011. His professional football career included time with the Rams, Patriots, Eagles, Jets, Lions, and Bills.</p><p>Today, his Fujitsu Hawaii profile supports a larger local message: choose a brand with proven performance, reliable support, and a name Hawaii recognizes.</p>',
  ],
  'Kaui Kauhi' => [
    'role' => 'Faces of Fujitsu local profile',
    'summary' => 'A local Fujitsu profile that adds familiar Hawaii personality and trust to the brand.',
    'body' => '<p>Kaui Kauhi is part of the Faces of Fujitsu campaign, helping the brand feel local, recognizable, and connected to Hawaii families.</p><p>These profiles support the site’s core conversion goal: when it is time to compare air conditioning brands, buyers remember to ask their contractor for Fujitsu.</p>',
  ],
];

foreach ($profile_updates as $title => $data) {
  if ($node = ilf_load_by_title('face_profile', $title)) {
    $node->set('field_role', $data['role']);
    $node->set('field_summary', $data['summary']);
    $node->set('body', ['value' => $data['body'], 'format' => $body_format]);
    $node->save();
  }
}

$news_updates = [
  'Maui Fujitsu Elite Contractors VIP Reception May 19th 2022' => [
    'alias' => '/updates/maui-fujitsu-elite-contractors-vip-reception-may-19th-2022',
    'summary' => 'A Maui contractor event reinforcing the local training, relationships, and dealer support behind Fujitsu Hawaii.',
    'body' => '<p>Team Fujitsu Hawaii and Fujitsu management hosted a VIP reception for Maui Elite Contractors at the Wailea Beach Resort. The event reflects a major advantage for Hawaii buyers: Fujitsu is supported by trained local contractors, island relationships, and distributor-backed product knowledge.</p><p>For homeowners and project teams, that local support matters long after installation day.</p><p><a class="btn-main" href="/find-a-contractor">Find Fujitsu contractor support</a></p>',
  ],
  'Oahu Fujitsu Elite Contractors Vip Reception May 20th 2022' => [
    'title' => 'Oahu Fujitsu Elite Contractors VIP Reception May 20th 2022',
    'alias' => '/updates/oahu-fujitsu-elite-contractors-vip-reception-may-20th-2022',
    'summary' => 'An Oahu contractor event showing the local professional network behind Fujitsu systems in Hawaii.',
    'body' => '<p>Team Fujitsu Hawaii and Fujitsu management hosted a VIP reception for Oahu Elite Contractors at The Kahala Resort. Events like this strengthen the local contractor network that helps homeowners, businesses, builders, and developers choose Fujitsu with confidence.</p><p>When a contractor recommends Fujitsu, that recommendation is backed by local inventory, training, and support.</p><p><a class="btn-main" href="/find-a-contractor">Find Fujitsu contractor support</a></p>',
  ],
  'Cooling Cancer Donates 70k' => [
    'title' => 'Cooling Cancer Donates $70K',
    'alias' => '/updates/cooling-cancer-donates-70k',
    'summary' => 'Fujitsu Hawaii community involvement through the CoolingCancer Golf Tournament and UH Cancer Center support.',
    'body' => '<p>Fujitsu served as a tournament sponsor for the 7th Annual CoolingCancer Golf Tournament, helping raise $70,000 for the University of Hawaii Cancer Center. The check presentation took place on October 29, 2019, following the August tournament at Hoakalei Country Club in Ewa Beach.</p><p>Community visibility like this keeps Fujitsu connected to Hawaii beyond equipment and installation. It reinforces the brand as local, present, and trusted.</p>',
  ],
  'Fujitsu 12 Year Gecko Warranty' => [
    'title' => 'Fujitsu 12-Year and Gecko Warranty',
    'alias' => '/updates/fujitsu-12-year-gecko-warranty',
    'summary' => 'Warranty confidence that helps Fujitsu stand apart when Hawaii buyers compare AC brands.',
    'body' => '<p>Fujitsu’s 12-year warranty and Gecko Warranty messaging give Hawaii buyers another reason to ask for Fujitsu by name. Strong warranty confidence matters in a climate where air conditioning runs often and equipment must stand up to humidity, heat, and island conditions.</p><p><a class="btn-main" href="/find-a-contractor">Ask a contractor about Fujitsu warranty coverage</a></p>',
  ],
];

foreach ($news_updates as $lookup_title => $data) {
  $node = ilf_load_by_title('news_update', $lookup_title) ?: ilf_load_by_title('news_update', $data['title'] ?? $lookup_title);
  if (!$node && $lookup_title === 'Fujitsu 12 Year Gecko Warranty') {
    $node = ilf_load_by_title('news_update', 'Fujitsu 12-Year and Gecko Warranty');
  }
  if (!$node) {
    $node = Node::create(['type' => 'news_update']);
  }
  $node->setTitle($data['title'] ?? $lookup_title);
  $node->set('status', 1);
  $node->set('field_summary', $data['summary']);
  $node->set('body', ['value' => $data['body'], 'format' => $body_format]);
  $node->set('path', ['alias' => $data['alias']]);
  $node->save();
}

$nids = \Drupal::entityQuery('node')
  ->accessCheck(FALSE)
  ->condition('status', 1)
  ->condition('type', ['news_update', 'commercial_video', 'resource_brochure', 'face_profile'], 'IN')
  ->execute();

foreach ($storage->loadMultiple($nids) as $node) {
  $type = $node->bundle();
  $title = ilf_polish_title($node->label());
  if ($title !== $node->label()) {
    $node->setTitle($title);
  }
  if ($node->hasField('field_summary')) {
    $node->set('field_summary', ilf_polish_summary($title, $type));
  }
  if ($node->hasField('field_role') && $type === 'face_profile') {
    $node->set('field_role', 'Fujitsu Hawaii community profile');
  }
  if ($node->hasField('body')) {
    $body = (string) ($node->get('body')->value ?? '');
    if ($body === '' || preg_match('/placeholder|migration|imported from|source url|replace with/i', $body)) {
      $node->set('body', [
        'value' => ilf_polish_body($title, $type),
        'format' => $body_format,
      ]);
    }
  }
  $node->save();
}

$page_updates = [
  'Find a Fujitsu Contractor' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Start here</p><h2>Tell your AC contractor you want Fujitsu.</h2><p>Most buyers do not need to become HVAC experts. They need enough clarity to request the right brand before the estimate is written. Fujitsu gives Hawaii homeowners, builders, and businesses quiet comfort, efficient operation, strong warranty confidence, and support from a local distributor network.</p></section><div class="ilf-island-grid"><a href="/find-a-dealer/oahu-dealers"><strong>Oahu Dealers</strong><span>Honolulu, Windward, Central, Leeward, and North Shore support.</span></a><a href="/find-a-dealer/maui-dealers"><strong>Maui Dealers</strong><span>Residential and commercial Fujitsu comfort support.</span></a><a href="/find-a-dealer/kauai-dealers"><strong>Kauai Dealers</strong><span>Islandwide ductless and mini-split support.</span></a><a href="/find-a-dealer/big-island-dealers"><strong>Hawaii Island Dealers</strong><span>Hilo, Kona, Waimea, Puna, and beyond.</span></a></div><section class="ilf-callout"><h2>Ask by brand name.</h2><p>When comparing systems, say: “I want Fujitsu. What Fujitsu options do you recommend for my space?”</p></section>',
  'Fujitsu Products' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Comfort systems</p><h2>Fujitsu systems fit the way Hawaii cools.</h2><p>From ductless single-room comfort to flexible multi-zone systems and commercial AIRSTAGE solutions, Fujitsu gives contractors a high-quality path for homes, condos, offices, restaurants, and developer projects.</p></section><div class="ilf-card-grid ilf-card-grid--three"><article><h3>Ductless comfort</h3><p>Quiet, efficient room-by-room cooling for bedrooms, living areas, additions, condos, and hard-to-condition spaces.</p></article><article><h3>Multi-zone flexibility</h3><p>Comfort for multiple rooms with fewer compromises, ideal for Hawaii homes that need targeted cooling without bulky ductwork.</p></article><article><h3>Commercial confidence</h3><p>Scalable Fujitsu options for offices, retail, hospitality, and light commercial applications that need dependable support.</p></article></div><section class="ilf-callout"><h2>Ready to compare options?</h2><p>Ask a certified Fujitsu contractor which system best fits your space, budget, and comfort goals.</p></section>',
  'Rebates' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Incentives</p><h2>Check rebate opportunities before you choose.</h2><p>Energy incentives can make high-efficiency Fujitsu comfort even more compelling. Confirm current rebate availability with your contractor and review eligibility before installation.</p></section><section class="ilf-callout"><h2>Use rebates as part of the decision, not the whole decision.</h2><p>Fujitsu is chosen for quiet comfort, efficiency, warranty confidence, and local support. Rebates can make that choice easier.</p></section>',
  'Locate a Fujitsu Contractor' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Local support</p><h2>Locate Fujitsu contractor support in Hawaii.</h2><p>Use the dealer locator pages to find island-based contractor pathways and start the conversation with a clear request: “I want Fujitsu.”</p></section><div class="ilf-island-grid"><a href="/find-a-dealer/oahu-dealers"><strong>Oahu</strong><span>View Oahu dealer pathways.</span></a><a href="/find-a-dealer/maui-dealers"><strong>Maui</strong><span>View Maui dealer pathways.</span></a><a href="/find-a-dealer/kauai-dealers"><strong>Kauai</strong><span>View Kauai dealer pathways.</span></a><a href="/find-a-dealer/big-island-dealers"><strong>Hawaii Island</strong><span>View Hawaii Island dealer pathways.</span></a></div>',
  'I Love My Fujitsu Athletics Application' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Community</p><h2>Fujitsu Hawaii community partnerships.</h2><p>Fujitsu Hawaii has long supported local athletics, schools, and community programs. Application details should be confirmed with the client before launch; this page is structured for a future Drupal form or downloadable application packet.</p></section><section class="ilf-callout"><h2>Community visibility builds brand trust.</h2><p>These programs help keep Fujitsu familiar, local, and easy for Hawaii families to remember when choosing air conditioning.</p></section>',
];

foreach ($page_updates as $title => $body) {
  if ($node = ilf_load_by_title('page', $title)) {
    $node->set('body', ['value' => $body, 'format' => $body_format]);
    $node->save();
  }
}

echo "Final content polish complete.\n";
