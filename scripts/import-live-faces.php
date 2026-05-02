<?php

declare(strict_types=1);

use Drupal\Core\File\FileExists;
use Drupal\Core\File\FileSystemInterface;
use Drupal\node\Entity\Node;

$source = 'https://ilovemyfujitsu.com/';
$cache = '/tmp/ilf-home.html';
$html = is_readable($cache) ? file_get_contents($cache) : '';

if ($html === FALSE || $html === '' || !str_contains($html, 'THE FACES OF FUJITSU')) {
  $html = shell_exec('curl -sSL -A ' . escapeshellarg('Mozilla/5.0') . ' ' . escapeshellarg($source));
}

if ($html === NULL || $html === '' || !str_contains($html, 'THE FACES OF FUJITSU')) {
  throw new RuntimeException('Unable to fetch the live homepage Faces of Fujitsu section.');
}

preg_match_all(
  '~<div class="single-post-wrapper mt-column-4">([\s\S]*?)</div><!-- \.single-post-wrapper -->~',
  $html,
  $blocks
);

if (count($blocks[1]) < 10) {
  throw new RuntimeException('Faces scrape found fewer entries than expected.');
}

$file_repository = \Drupal::service('file.repository');
$faces_directory = 'public://faces';
\Drupal::service('file_system')->prepareDirectory($faces_directory, FileSystemInterface::CREATE_DIRECTORY);
$storage = \Drupal::entityTypeManager()->getStorage('node');

function ilf_title_case_name(string $name): string {
  $name = strtolower(trim(preg_replace('/\s+/', ' ', $name) ?? $name));
  $name = str_replace('-', ' ', $name);
  $name = ucwords($name);
  return str_replace('Graves Lock', 'Graves Lock', $name);
}

function ilf_face_slug(string $title): string {
  $slug = strtolower($title);
  $slug = str_replace(['&', '+'], ' and ', $slug);
  $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?? $slug;
  return trim($slug, '-');
}

function ilf_clean_face_summary(string $summary): string {
  $summary = html_entity_decode(strip_tags($summary), ENT_QUOTES | ENT_HTML5);
  $summary = str_replace(['[...]', '[…]', '[&hellip;]', ' […]'], '', $summary);
  $summary = preg_replace('/\s+/', ' ', $summary) ?? $summary;
  return trim($summary);
}

function ilf_download_face_image(string $url, string $title, object $file_repository): ?\Drupal\file\FileInterface {
  $path = parse_url($url, PHP_URL_PATH) ?: '';
  $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION) ?: 'png');
  if (!preg_match('/^(jpg|jpeg|png|webp)$/', $extension)) {
    $extension = 'png';
  }

  $data = @file_get_contents($url, FALSE, stream_context_create([
    'http' => [
      'header' => "User-Agent: Mozilla/5.0\r\n",
      'timeout' => 20,
    ],
  ]));

  if ($data === FALSE || $data === '') {
    return NULL;
  }

  $destination = 'public://faces/' . ilf_face_slug($title) . '.' . $extension;
  $file = $file_repository->writeData($data, $destination, FileExists::Replace);
  $file->setPermanent();
  $file->save();
  return $file;
}

$legacy_paths = [];
$created = 0;
$updated = 0;

foreach ($blocks[1] as $block) {
  if (
    !preg_match('~<img[^>]+src="([^"]+)"~', $block, $image_match) ||
    !preg_match('~<p>([\s\S]*?)</p>~', $block, $summary_match) ||
    !preg_match('~<h3 class="post-title"><a href="([^"]+)">([\s\S]*?)</a></h3>~', $block, $title_match)
  ) {
    continue;
  }

  $source_title = html_entity_decode(strip_tags($title_match[2]), ENT_QUOTES | ENT_HTML5);
  $source_title = trim(preg_replace('/\s+/', ' ', $source_title) ?? $source_title);
  $title = ilf_title_case_name($source_title);
  $summary = ilf_clean_face_summary($summary_match[1]);
  $image_url = html_entity_decode($image_match[1], ENT_QUOTES | ENT_HTML5);
  $legacy_path = trim(parse_url(html_entity_decode($title_match[1], ENT_QUOTES | ENT_HTML5), PHP_URL_PATH) ?: '', '/');

  // Preserve the original WordPress typo while presenting the cleaner display name.
  if ($title === 'Benny Agbayani') {
    $lookup_titles = ['Benny Agbani', 'Benny Agbayani'];
    $display_title = 'Benny Agbayani';
    $alias_slug = 'benny-agbani';
  }
  elseif ($title === 'Riley Graves Lock') {
    $lookup_titles = ['Riley Graves Lock', 'Riley Graves-Lock'];
    $display_title = 'Riley Graves Lock';
    $alias_slug = 'riley-graves-lock';
  }
  else {
    $lookup_titles = [$title];
    $display_title = $title;
    $alias_slug = ilf_face_slug($title);
  }

  $existing = [];
  foreach ($lookup_titles as $lookup_title) {
    $existing = $storage->loadByProperties(['type' => 'face_profile', 'title' => $lookup_title]);
    if ($existing) {
      break;
    }
  }

  /** @var \Drupal\node\Entity\Node $node */
  $node = $existing ? reset($existing) : Node::create(['type' => 'face_profile']);
  $node->setTitle($display_title);
  $node->set('status', 1);
  $node->set('field_role', 'Faces of Fujitsu');
  $node->set('field_summary', $summary);
  $node->set('body', [
    'value' => '<p>' . htmlspecialchars($summary, ENT_QUOTES | ENT_HTML5) . '</p><p>These local voices help make Fujitsu familiar across Hawaii and keep the brand top-of-mind before homeowners and businesses talk with an AC contractor.</p><p><a class="btn-main" href="/find-a-contractor">Find a Fujitsu contractor</a></p>',
    'format' => 'full_html',
  ]);
  $node->set('path', ['alias' => '/friends-family/' . $alias_slug]);

  if ($file = ilf_download_face_image($image_url, $display_title, $file_repository)) {
    $node->set('field_profile_image', [
      'target_id' => $file->id(),
      'alt' => $display_title . ' - Faces of Fujitsu',
    ]);
  }

  $node->save();
  $existing ? $updated++ : $created++;

  if ($legacy_path !== '') {
    $legacy_paths[$legacy_path] = 'internal:/friends-family/' . $alias_slug;
  }
}

if (\Drupal::moduleHandler()->moduleExists('redirect')) {
  $redirect_storage = \Drupal::entityTypeManager()->getStorage('redirect');
  foreach ($legacy_paths as $from => $to) {
    $matches = $redirect_storage->loadByProperties(['redirect_source.path' => $from]);
    $redirect = $matches ? reset($matches) : $redirect_storage->create([]);
    $redirect->set('redirect_source', ['path' => $from]);
    $redirect->set('redirect_redirect', ['uri' => $to]);
    $redirect->set('status_code', 301);
    $redirect->save();
  }
}

echo "Faces import complete. Created: {$created}; Updated: {$updated}; Total scraped: " . count($blocks[1]) . "\n";
