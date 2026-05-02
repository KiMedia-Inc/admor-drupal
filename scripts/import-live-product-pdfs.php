<?php

declare(strict_types=1);

use Drupal\Core\File\FileExists;
use Drupal\Core\File\FileSystemInterface;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;

$resources = [
  ['Full Line Brochure', 'http://ilovemyfujitsu.com/wp-content/uploads/2021/04/2021_Full_Line_Brochure_FG2028.pdf', 'brochure'],
  ['Consumer Brochure', 'http://admorhvac.com/wp-content/uploads/2020/08/2020_fujitsu_consumer_brochure.pdf', 'brochure'],
  ['Consumer Brochure Condensed', 'http://admorhvac.com/wp-content/uploads/2020/08/2020_fujitsu_consumer_brochure_condensed.pdf', 'brochure'],
  ['Fujitsu 410A Mini-Split Troubleshooting Guide', 'http://ilovemyfujitsu.com/wp-content/uploads/2021/05/fujitsu2019-Troubleshooting-Guide.pdf', 'guide'],
  ['2021 Fujitsu Airstage Full Line Catalog', 'https://www.admorhvac.com/admor-files/catalogs_linecards/2021%20Airstage%20Full%20Line%20Catalog%20lo-res.pdf', 'brochure'],
  ['2018 Fujitsu Full-Line Catalog', 'http://ilovemyfujitsu.com/files/products/fujitsu-2018-full-line-brochure.pdf', 'brochure'],
  ['Airstage J-IIS Series Sell Sheet', 'http://ilovemyfujitsu.com/files/products/J_IIS_Series_Sell_Sheet.pdf', 'brochure'],
  ['AOU45RLXFZ 5-Zone Sell Sheet', 'http://ilovemyfujitsu.com/files/products/aou45rlxfz-june-2016-ad.pdf', 'brochure'],
  ['2016 Multi Zone Brochure', 'http://ilovemyfujitsu.com/files/products/multi-zone-brochure-april-2016.pdf', 'brochure'],
  ['Halcyon Auto-Louver Grille Kit', 'http://ilovemyfujitsu.com/files/products/auto-louver-grille-kit-halcyon.pdf', 'brochure'],
  ['Hybrid Flex Inverter 48,000 BTU 8-Zone Sell Sheet', 'http://ilovemyfujitsu.com/files/products/hybrid-flex-inverter-48000.pdf', 'brochure'],
  ['Fujitsu 4RL2 and 9RL2 Sell Sheet', 'http://ilovemyfujitsu.com/files/products/fujitsu-9&4-rl2.pdf', 'brochure'],
  ['Fujitsu 18RULX, 24RULX, 36RSLX Sell Sheet', 'http://ilovemyfujitsu.com/files/products/fujitsu-18rulx-24rulx-36rslx.pdf', 'brochure'],
  ['Fujitsu 18RCLX, 24RCLX, 36RCLX, 42RCLX Sell Sheet', 'http://ilovemyfujitsu.com/files/products/fujitsu-454-18-24-36-42rclx.pdf', 'brochure'],
  ['Fujitsu Mini Split Flipbook', 'http://ilovemyfujitsu.com/files/products/fujitsi-mini-split-flipbook.pdf', 'brochure'],
  ['Fujitsu Advantages', 'http://ilovemyfujitsu.com/files/products/fujitsu-advantages.pdf', 'brochure'],
  ['Fujitsu Cooling Systems', 'http://ilovemyfujitsu.com/files/products/fujitsu-cooling-systems.pdf', 'brochure'],
  ['Heat Pump Savings Brochure', 'http://ilovemyfujitsu.com/files/products/heat-pump-savings-brochure.pdf', 'brochure'],
  ['Hawaii Energy Rebates', 'http://ilovemyfujitsu.com/wp-content/uploads/2020/06/2020_hawaii_energy_1500_rebate.pdf', 'rebate'],
];

$missing_from_live = [
  'Hybrid Flex Inverter Dual/Tri/Quad Zone Mix & Match' => 'The live Products page links to a PDF that is not present on the server.',
  'Fujitsu RLFC, RLFCC' => 'The live Products page links to a PDF, but only a PNG asset exists in the public product directory.',
  'Fujitsu Mini Split Heating & Cooling' => 'The live Products page links to a PDF that is not present on the server.',
];

$directory = 'public://fujitsu-pdfs';
\Drupal::service('file_system')->prepareDirectory($directory, FileSystemInterface::CREATE_DIRECTORY);
$file_repository = \Drupal::service('file.repository');
$file_url_generator = \Drupal::service('file_url_generator');
$storage = \Drupal::entityTypeManager()->getStorage('node');

function ilf_pdf_slug(string $title): string {
  $slug = strtolower($title);
  $slug = str_replace(['&', '+'], ' and ', $slug);
  $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?? $slug;
  return trim($slug, '-');
}

function ilf_pdf_download(string $url, string $title, string $directory): ?\Drupal\file\FileInterface {
  $destination = $directory . '/' . ilf_pdf_slug($title) . '.pdf';
  $real_destination = \Drupal::service('file_system')->realpath($directory) . '/' . ilf_pdf_slug($title) . '.pdf';
  $command = 'curl -fL --max-time 180 -A ' . escapeshellarg('Mozilla/5.0') . ' -o ' . escapeshellarg($real_destination) . ' ' . escapeshellarg($url);
  exec($command, $output, $status);

  if ($status !== 0 || !is_file($real_destination) || filesize($real_destination) < 1000) {
    @unlink($real_destination);
    return NULL;
  }

  $handle = fopen($real_destination, 'rb');
  $signature = $handle ? fread($handle, 4) : '';
  if ($handle) {
    fclose($handle);
  }
  if ($signature !== '%PDF') {
    @unlink($real_destination);
    return NULL;
  }

  $existing = \Drupal::entityTypeManager()->getStorage('file')->loadByProperties(['uri' => $destination]);
  $file = $existing ? reset($existing) : File::create(['uri' => $destination]);
  $file->setFilename(basename($destination));
  $file->setPermanent();
  $file->save();
  return $file;
}

function ilf_pdf_summary(string $title, string $type): string {
  $lower = strtolower($title);
  if (str_contains($lower, 'troubleshooting')) {
    return 'A technical Fujitsu troubleshooting guide for contractors and informed owners who need product support details.';
  }
  if (str_contains($lower, 'rebate') || $type === 'rebate') {
    return 'Rebate information that helps Hawaii buyers understand available incentives before choosing Fujitsu.';
  }
  if (str_contains($lower, 'airstage') || str_contains($lower, 'commercial')) {
    return 'A Fujitsu product catalog for commercial and light-commercial applications across Hawaii.';
  }
  if (str_contains($lower, 'sell sheet') || str_contains($lower, 'zone') || str_contains($lower, 'rl')) {
    return 'A Fujitsu product sheet for comparing system options before talking with a certified contractor.';
  }
  return 'A Fujitsu brochure for reviewing comfort options, efficiency benefits, and product choices before requesting Fujitsu by name.';
}

function ilf_pdf_existing_node(object $storage, string $title): ?Node {
  $lookups = [$title];
  if ($title === 'Consumer Brochure Condensed') {
    $lookups[] = 'Consumer Brochure (Condensed)';
  }
  if ($title === 'Fujitsu 410A Mini-Split Troubleshooting Guide') {
    $lookups[] = 'Troubleshooting Guide';
  }
  foreach ($lookups as $lookup) {
    $existing = $storage->loadByProperties(['type' => 'resource_brochure', 'title' => $lookup]);
    if ($existing) {
      return reset($existing);
    }
  }
  return NULL;
}

$created = 0;
$updated = 0;
$failed = [];

foreach ($resources as [$title, $url, $type]) {
  $file = ilf_pdf_download($url, $title, $directory);
  if (!$file) {
    $failed[] = $title . ' | ' . $url;
    continue;
  }

  $node = ilf_pdf_existing_node($storage, $title) ?: Node::create(['type' => 'resource_brochure']);
  $is_new = $node->isNew();
  $summary = ilf_pdf_summary($title, $type);
  $public_path = $file_url_generator->generateString($file->getFileUri());

  $node->setTitle($title);
  $node->set('status', 1);
  $node->set('field_resource_type', $type);
  $node->set('field_resource_file', [
    'target_id' => $file->id(),
    'display' => 1,
    'description' => $title . ' PDF',
  ]);
  $node->set('field_resource_link', [
    'uri' => 'internal:' . $public_path,
    'title' => 'Open PDF',
  ]);
  $node->set('body', [
    'value' => '<p>' . htmlspecialchars($summary, ENT_QUOTES | ENT_HTML5) . '</p><p>Keep this PDF handy when comparing Fujitsu equipment or preparing questions for a certified contractor.</p>',
    'format' => 'full_html',
  ]);
  $node->set('path', ['alias' => '/resources/' . ilf_pdf_slug($title)]);
  $node->save();

  $is_new ? $created++ : $updated++;
}

file_put_contents(
  __DIR__ . '/../data/migration/products-missing-pdfs.json',
  json_encode($missing_from_live + array_fill_keys($failed, 'Download failed during import.'), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
);

echo "Product PDF import complete. Created: {$created}; Updated: {$updated}; Failed downloads: " . count($failed) . "\n";
foreach ($failed as $failure) {
  echo "Failed: {$failure}\n";
}
