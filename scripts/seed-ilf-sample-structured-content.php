<?php

declare(strict_types=1);

use Drupal\node\Entity\Node;

function ilf_save_node(string $type, string $title, array $values): void {
  $storage = \Drupal::entityTypeManager()->getStorage('node');
  $existing = $storage->loadByProperties([
    'type' => $type,
    'title' => $title,
  ]);

  $node = $existing ? reset($existing) : Node::create(['type' => $type]);
  $node->setTitle($title);
  $node->set('status', 1);

  foreach ($values as $field => $value) {
    $node->set($field, $value);
  }

  $node->save();
}

$body_format = 'full_html';

$updates = [
  [
    'Fujitsu General ProCore High Corrosion Resistant Technology',
    'Fujitsu corrosion-resistant technology helps reinforce long-term confidence for Hawaii conditions.',
    '/2024/06/06/fujitsu-generals-procore-high-corrosion-resistant-techonology',
  ],
  [
    'Fujitsu 12-Year and Gecko Warranty',
    'Warranty messaging that helps buyers ask for Fujitsu by name with confidence.',
    '/2020/08/06/fujitsu-12-year-gecko-warranty',
  ],
  [
    'Hawaii Energy Rebates',
    'Rebate guidance that helps buyers evaluate efficient Fujitsu comfort before installation.',
    '/2020/06/03/hawaii-energy-rebates',
  ],
];

foreach ($updates as [$title, $summary, $alias]) {
  ilf_save_node('news_update', $title, [
    'field_summary' => $summary,
    'body' => [
      'value' => '<p>Fujitsu Hawaii news and education should help buyers understand comfort, efficiency, warranty support, and the value of asking their contractor for Fujitsu.</p>',
      'format' => $body_format,
    ],
    'path' => ['alias' => $alias],
  ]);
}

$videos = [
  ['Fujitsu 12 Year and Gecko Warranty', 'Warranty-focused commercial proof point for Hawaii buyers.'],
  ['Fujitsu Girl Growing Up', 'Long-running local commercial content to migrate into reusable video cards.'],
  ['Fujitsu Gym Dog', 'Memorable campaign creative that supports brand recall.'],
];

foreach ($videos as [$title, $summary]) {
  ilf_save_node('commercial_video', $title, [
    'field_summary' => $summary,
    'body' => [
      'value' => '<p>Local Fujitsu video content should build brand recognition and make it easier for customers to remember the Fujitsu name when requesting a quote.</p>',
      'format' => $body_format,
    ],
  ]);
}

$resources = [
  ['Full Line Brochure', 'brochure', 'Complete Fujitsu product-line reference for buyer and contractor education.'],
  ['Consumer Brochure', 'brochure', 'Homeowner-friendly Fujitsu buyer education.'],
  ['Troubleshooting Guide', 'guide', 'Support content for existing owners and certified contractors.'],
  ['Hawaii Energy Rebates', 'rebate', 'Rebate resource to verify and update before launch.'],
];

foreach ($resources as [$title, $type, $body]) {
  ilf_save_node('resource_brochure', $title, [
    'field_resource_type' => $type,
    'body' => [
      'value' => '<p>' . $body . '</p><p><a class="btn-main" href="/find-a-contractor">Find local Fujitsu support</a></p>',
      'format' => $body_format,
    ],
  ]);
}

$profiles = [
  ['Kanoa Leahey', 'Faces of Fujitsu profile', 'Local profile content from the WordPress Faces of Fujitsu archive.'],
  ['Greg Salas', 'Faces of Fujitsu profile', 'Local profile content from the WordPress Faces of Fujitsu archive.'],
  ['Dave Shoji', 'Faces of Fujitsu profile', 'Local profile content from the WordPress Faces of Fujitsu archive.'],
  ['Chelsea Hardin', 'Faces of Fujitsu profile', 'Local profile content from the WordPress Faces of Fujitsu archive.'],
];

foreach ($profiles as [$title, $role, $summary]) {
  ilf_save_node('face_profile', $title, [
    'field_role' => $role,
    'field_summary' => $summary,
    'body' => [
    'value' => '<p>Faces of Fujitsu content should make the brand feel local, credible, and connected to the Hawaii community.</p>',
      'format' => $body_format,
    ],
  ]);
}

$dealers = [
  ['Oahu Fujitsu Dealer Network', 'oahu', '(808) 841-7400', 'Honolulu, Windward Oahu, Central Oahu, Leeward Oahu, and North Shore service areas'],
  ['Maui Fujitsu Dealer Network', 'maui', '(808) 841-7400', 'Kahului, Wailuku, Kihei, Lahaina, Upcountry, and islandwide Maui service areas'],
  ['Kauai Fujitsu Dealer Network', 'kauai', '(808) 841-7400', 'Lihue, Kapaa, Princeville, Poipu, Waimea, and islandwide Kauai service areas'],
  ['Hawaii Island Fujitsu Dealer Network', 'big_island', '(808) 841-7400', 'Hilo, Kona, Waimea, Puna, Hamakua, and islandwide Hawaii Island service areas'],
];

foreach ($dealers as [$title, $island, $phone, $address]) {
  ilf_save_node('dealer_contractor', $title, [
    'field_island' => $island,
    'field_phone' => $phone,
    'field_address' => $address,
    'body' => [
      'value' => '<p>Connect with local Fujitsu support and ask your installer to quote Fujitsu for quiet, efficient comfort built for Hawaii conditions.</p>',
      'format' => $body_format,
    ],
  ]);
}

echo "Seeded sample structured Fujitsu content.\n";
