<?php

declare(strict_types=1);

use Drupal\node\Entity\Node;

$csv_path = __DIR__ . '/../data/migration/wordpress-public-inventory.csv';
if (!is_file($csv_path)) {
  throw new RuntimeException('Missing inventory CSV. Run php scripts/build-wordpress-public-inventory.php first.');
}

$handle = fopen($csv_path, 'r');
$header = fgetcsv($handle);
if (!$header) {
  throw new RuntimeException('Inventory CSV is empty.');
}

$created = 0;
$updated = 0;
$skipped = 0;
$body_format = 'full_html';
$reserved_listing_aliases = [
  '/',
  '/updates',
  '/commercials',
  '/resources',
  '/friends-family',
  '/find-a-dealer',
  '/find-a-dealer/oahu-dealers',
  '/find-a-dealer/maui-dealers',
  '/find-a-dealer/kauai-dealers',
  '/find-a-dealer/big-island-dealers',
];

while (($values = fgetcsv($handle)) !== FALSE) {
  $row = array_combine($header, $values);
  if (!$row) {
    continue;
  }

  if (($row['source_type'] ?? '') === 'category') {
    $skipped++;
    continue;
  }

  if (in_array($row['target_alias'], $reserved_listing_aliases, TRUE)) {
    $skipped++;
    continue;
  }

  $source_slug = basename(trim($row['source_path'], '/'));
  if (in_array($source_slug, ['updates'], TRUE)) {
    $skipped++;
    continue;
  }

  $type = $row['suggested_drupal_type'];
  if (!in_array($type, ['news_update', 'commercial_video', 'resource_brochure', 'face_profile'], TRUE)) {
    $skipped++;
    continue;
  }

  $title = $row['title'] ?: basename(trim($row['source_path'], '/'));
  $storage = \Drupal::entityTypeManager()->getStorage('node');
  $existing = $storage->loadByProperties([
    'type' => $type,
    'title' => $title,
  ]);
  $node = $existing ? reset($existing) : Node::create(['type' => $type]);

  $node->setTitle($title);
  $node->set('status', 1);
  $node->set('body', [
    'value' => '<p>This Fujitsu Hawaii content supports the buyer journey by helping homeowners, businesses, and contractors understand why Fujitsu should be requested by name.</p><p><a class="btn-main" href="/find-a-contractor">Find local Fujitsu support</a></p>',
    'format' => $body_format,
  ]);
  $node->set('path', ['alias' => $row['target_alias']]);

  if ($type === 'news_update') {
    $node->set('field_summary', 'Fujitsu Hawaii news and education designed to build confidence before a customer speaks with their AC contractor.');
  }
  elseif ($type === 'commercial_video') {
    $node->set('field_summary', 'Local Fujitsu video content that builds brand recognition and reinforces the ask-for-Fujitsu message.');
  }
  elseif ($type === 'resource_brochure') {
    $node->set('field_resource_type', 'external');
  }
  elseif ($type === 'face_profile') {
    $node->set('field_role', 'Fujitsu Hawaii community profile');
    $node->set('field_summary', 'A local Fujitsu story that helps the brand feel familiar, trusted, and connected to Hawaii.');
  }

  $node->save();
  $existing ? $updated++ : $created++;
}
fclose($handle);

echo "Created: $created\nUpdated: $updated\nSkipped: $skipped\n";
