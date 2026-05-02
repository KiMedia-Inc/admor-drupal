<?php

declare(strict_types=1);

use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;

$source = 'https://ilovemyfujitsu.com/commercials/';
$cache = '/tmp/ilf-commercials.html';
$html = is_readable($cache) ? file_get_contents($cache) : '';

if ($html === FALSE || $html === '' || !str_contains($html, 'TotalSoft_GV_HLG_793_')) {
  $html = shell_exec('curl -sSL -A ' . escapeshellarg('Mozilla/5.0') . ' ' . escapeshellarg($source));
}

if ($html === NULL || $html === '') {
  throw new RuntimeException('Unable to fetch live commercials page.');
}

preg_match_all(
  '~<div id="TotalSoft_GV_HLG_793_(\d+)"[^>]*href="([^"]+)"[^>]*data-poster="([^"]*)"[\s\S]*?<span[^>]*>([\s\S]*?)</span>~',
  $html,
  $matches,
  PREG_SET_ORDER
);

if (count($matches) < 20) {
  throw new RuntimeException('Commercial gallery scrape found fewer items than expected.');
}

$known_titles = [];
$body_format = 'full_html';
$file_repository = \Drupal::service('file.repository');
$commercials_directory = 'public://commercials';
\Drupal::service('file_system')->prepareDirectory($commercials_directory, \Drupal\Core\File\FileSystemInterface::CREATE_DIRECTORY);

function ilf_commercial_slug(string $title): string {
  $slug = strtolower($title);
  $slug = str_replace(['&', '+'], ' and ', $slug);
  $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?? $slug;
  return trim($slug, '-');
}

function ilf_commercial_summary(string $title): string {
  $lower = strtolower($title);
  if (str_contains($lower, 'warranty') || str_contains($lower, 'gecko')) {
    return 'A warranty-focused Fujitsu Hawaii commercial that gives buyers a strong reason to ask for Fujitsu over competing AC brands.';
  }
  if (str_contains($lower, 'radio ad')) {
    return 'A Fujitsu Hawaii radio spot that keeps the brand memorable and reinforces the ask-for-Fujitsu message.';
  }
  if (str_contains($lower, 'behind the scenes') || str_contains($lower, 'outtakes')) {
    return 'A behind-the-scenes Fujitsu Hawaii video that adds personality, familiarity, and local brand recall.';
  }
  if (str_contains($lower, 'breast cancer') || str_contains($lower, 'cool kid')) {
    return 'A community-focused Fujitsu Hawaii video that connects the brand with local causes, schools, and families.';
  }
  if (str_contains($lower, 'halcyon') || str_contains($lower, 'mini-split')) {
    return 'A product-focused Fujitsu video that helps buyers understand ductless comfort and efficient mini-split options.';
  }
  return 'A local Fujitsu Hawaii commercial that builds brand recognition and helps buyers remember to ask their contractor for Fujitsu by name.';
}

function ilf_download_commercial_image(string $url, string $title, object $file_repository): ?File {
  if ($url === '') {
    return NULL;
  }
  $extension = pathinfo(parse_url($url, PHP_URL_PATH) ?: '', PATHINFO_EXTENSION) ?: 'jpg';
  if (!preg_match('/^(jpg|jpeg|png|webp)$/i', $extension)) {
    $extension = 'jpg';
  }
  $destination = 'public://commercials/' . ilf_commercial_slug($title) . '.' . strtolower($extension);
  $data = @file_get_contents($url, FALSE, stream_context_create([
    'http' => [
      'header' => "User-Agent: Mozilla/5.0\r\n",
      'timeout' => 20,
    ],
  ]));
  if ($data === FALSE || $data === '') {
    return NULL;
  }
  $file = $file_repository->writeData($data, $destination, \Drupal\Core\File\FileExists::Replace);
  $file->setPermanent();
  $file->save();
  return $file;
}

$storage = \Drupal::entityTypeManager()->getStorage('node');
$created = 0;
$updated = 0;
$position = 0;
$base_time = \Drupal::time()->getRequestTime();

foreach ($matches as $match) {
  $position++;
  $video_url = html_entity_decode($match[2]);
  $poster_url = html_entity_decode($match[3]);
  $title = trim(html_entity_decode(strip_tags($match[4])));
  $title = preg_replace('/\s+/', ' ', $title) ?: ('Fujitsu Commercial ' . str_pad((string) $position, 2, '0', STR_PAD_LEFT));
  $title = str_replace('Fujitsu 12 Year and Gecko Warranty', 'Fujitsu 12-Year and Gecko Warranty', $title);
  $known_titles[$title] = TRUE;

  $existing = $storage->loadByProperties(['type' => 'commercial_video', 'title' => $title]);
  if (!$existing && $title === 'Gym Dog') {
    $existing = $storage->loadByProperties(['type' => 'commercial_video', 'title' => 'Fujitsu Gym Dog']);
  }
  if (!$existing && $title === 'Fujitsu 12-Year and Gecko Warranty') {
    $existing = $storage->loadByProperties(['type' => 'commercial_video', 'title' => 'Fujitsu 12 Year and Gecko Warranty']);
  }
  if (!$existing) {
    $existing = $storage->loadByProperties(['type' => 'commercial_video', 'field_video_url.uri' => $video_url]);
  }

  /** @var \Drupal\node\Entity\Node $node */
  $node = $existing ? reset($existing) : Node::create(['type' => 'commercial_video']);
  $node->setTitle($title);
  $node->set('status', 1);
  $node->set('created', $base_time - $position);
  $node->set('changed', $base_time);
  $node->set('field_summary', ilf_commercial_summary($title));
  $node->set('field_video_url', [
    'uri' => $video_url,
    'title' => str_ends_with(strtolower($video_url), '.mp4') ? 'Watch hosted commercial' : 'Watch on YouTube',
  ]);
  $node->set('body', [
    'value' => '<p>' . ilf_commercial_summary($title) . '</p><p>This archive helps keep Fujitsu familiar across Hawaii so homeowners, businesses, and builders remember the brand before the estimate is written.</p><p><a class="btn-main" href="/find-a-contractor">Find Fujitsu contractor support</a></p>',
    'format' => $body_format,
  ]);
  $node->set('path', ['alias' => '/commercials/' . ilf_commercial_slug($title)]);

  if ($file = ilf_download_commercial_image($poster_url, $title, $file_repository)) {
    $node->set('field_thumbnail', [
      'target_id' => $file->id(),
      'alt' => $title . ' commercial thumbnail',
    ]);
  }

  $node->save();
  $existing ? $updated++ : $created++;
}

// Keep the commercials archive faithful to the live WordPress gallery.
$ids = \Drupal::entityQuery('node')
  ->condition('type', 'commercial_video')
  ->accessCheck(FALSE)
  ->execute();
foreach (Node::loadMultiple($ids) as $node) {
  if ($node->isPublished() && !isset($known_titles[$node->label()])) {
    $node->setUnpublished();
    $node->save();
    echo "Unpublished non-gallery commercial: {$node->label()}\n";
  }
}

echo "Commercial gallery import complete. Created: {$created}; Updated: {$updated}; Total scraped: " . count($matches) . "\n";
