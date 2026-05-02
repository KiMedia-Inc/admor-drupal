<?php

declare(strict_types=1);

use Drupal\Core\File\FileSystemInterface;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;

$resources = [
  ['ACTPM Tech Tip', 'http://ilovemyfujitsu.com/images/techtips/actpm-tech-tip.pdf'],
  ['Condenser Evaporator Fan Motor Tech Tip', 'http://ilovemyfujitsu.com/images/techtips/condenser-evap-fan-motor.pdf'],
  ['DC Check HFI Tech Tip', 'http://ilovemyfujitsu.com/images/techtips/dc-check-hfi.pdf'],
  ['Diode Bridge Rectifier Test Tech Tip', 'http://ilovemyfujitsu.com/images/techtips/diode-bridge-rectifier-test.pdf'],
  ['EEV Check Tech Tip', 'http://ilovemyfujitsu.com/images/techtips/eev-check.pdf'],
  ['Fresh Air Intake Tech Tip', 'http://ilovemyfujitsu.com/images/techtips/fresh-air-intake.pdf'],
  ['Priority Mode 48RLXFZ1 Tech Tip', 'http://ilovemyfujitsu.com/images/techtips/priority-mode-48rlxfz1.pdf'],
  ['Serial Signal Troubleshooting Tech Tip', 'http://ilovemyfujitsu.com/images/techtips/serial-signal-troubleshooting.pdf'],
  ['Static Pressure Tech Tip', 'http://ilovemyfujitsu.com/images/techtips/static-pressure.pdf'],
  ['Temperature Correction HFI Tech Tip', 'http://ilovemyfujitsu.com/images/techtips/temp-correction-hfi.pdf'],
  ['Updated IPM Tech Tip', 'http://ilovemyfujitsu.com/images/techtips/updated-ipm.pdf'],
  ['Wireless Remote Fahrenheit/Celsius Modification Tech Tip', 'http://ilovemyfujitsu.com/images/techtips/wireless-remote-fahrenheit-celsius-mod.pdf'],
];

$directory = 'public://fujitsu-tech-tips';
\Drupal::service('file_system')->prepareDirectory($directory, FileSystemInterface::CREATE_DIRECTORY);
$storage = \Drupal::entityTypeManager()->getStorage('node');
$file_url_generator = \Drupal::service('file_url_generator');

function ilf_tech_pdf_slug(string $title): string {
  $slug = strtolower($title);
  $slug = str_replace(['&', '/', '+'], [' and ', ' ', ' and '], $slug);
  $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?? $slug;
  return trim($slug, '-');
}

function ilf_tech_download(string $title, string $url, string $directory): ?\Drupal\file\FileInterface {
  $destination = $directory . '/' . ilf_tech_pdf_slug($title) . '.pdf';
  $real_destination = \Drupal::service('file_system')->realpath($directory) . '/' . basename($destination);
  exec('curl -fL --max-time 90 -A ' . escapeshellarg('Mozilla/5.0') . ' -o ' . escapeshellarg($real_destination) . ' ' . escapeshellarg($url), $output, $status);
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

$created = 0;
$updated = 0;
$failed = [];

foreach ($resources as [$title, $url]) {
  $file = ilf_tech_download($title, $url, $directory);
  if (!$file) {
    $failed[] = $title;
    continue;
  }

  $existing = $storage->loadByProperties(['type' => 'resource_brochure', 'title' => $title]);
  $node = $existing ? reset($existing) : Node::create(['type' => 'resource_brochure']);
  $is_new = $node->isNew();
  $public_path = $file_url_generator->generateString($file->getFileUri());

  $node->setTitle($title);
  $node->set('status', 1);
  $node->set('field_resource_type', 'guide');
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
    'value' => '<p>A Fujitsu technical reference for contractors and service teams working with mini-split and AIRSTAGE systems.</p><p>Use this document to support accurate diagnosis, cleaner installation practices, and more confident Fujitsu ownership in Hawaii.</p>',
    'format' => 'full_html',
  ]);
  $node->set('path', ['alias' => '/resources/' . ilf_tech_pdf_slug($title)]);
  $node->save();

  $is_new ? $created++ : $updated++;
}

// Keep the older generic troubleshooting resource useful by attaching the current guide.
$guide = reset($storage->loadByProperties(['type' => 'resource_brochure', 'title' => 'Fujitsu 410A Mini-Split Troubleshooting Guide']));
$legacy = reset($storage->loadByProperties(['type' => 'resource_brochure', 'title' => 'Troubleshooting Guide']));
if ($guide && $legacy && $guide->hasField('field_resource_file') && !$guide->get('field_resource_file')->isEmpty()) {
  $legacy->set('field_resource_file', $guide->get('field_resource_file')->getValue());
  $legacy->set('field_resource_link', $guide->get('field_resource_link')->getValue());
  $legacy->set('field_resource_type', 'guide');
  $legacy->save();
}

file_put_contents(__DIR__ . '/../data/migration/tech-tips-missing-pdfs.json', json_encode([
  '2014 Troubleshooting Guide' => 'The live Tech Tips page links to this PDF, but the URL returns 404. The newer Fujitsu 410A Mini-Split Troubleshooting Guide has been preserved.',
  'failed_imports' => $failed,
], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "Tech tip PDF import complete. Created: {$created}; Updated: {$updated}; Failed: " . count($failed) . "\n";
