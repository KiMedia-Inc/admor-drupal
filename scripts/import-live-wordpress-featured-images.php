<?php

declare(strict_types=1);

use Drupal\Core\File\FileExists;
use Drupal\Core\File\FileSystemInterface;

$source = 'https://ilovemyfujitsu.com/wp-json/wp/v2/posts?per_page=100&_embed=1';
$cache = '/tmp/ilf-posts.json';
$json = is_readable($cache) ? file_get_contents($cache) : '';

if ($json === FALSE || $json === '' || !str_starts_with(trim($json), '[')) {
  $json = shell_exec('curl -sSL -A ' . escapeshellarg('Mozilla/5.0') . ' ' . escapeshellarg($source));
}

$posts = json_decode((string) $json, TRUE);
if (!is_array($posts)) {
  throw new RuntimeException('Unable to load WordPress posts JSON.');
}

$directory = 'public://wordpress-featured';
\Drupal::service('file_system')->prepareDirectory($directory, FileSystemInterface::CREATE_DIRECTORY);
$file_repository = \Drupal::service('file.repository');
$node_storage = \Drupal::entityTypeManager()->getStorage('node');
$alias_manager = \Drupal::service('path_alias.manager');

function ilf_featured_clean_title(string $title): string {
  $title = html_entity_decode(strip_tags($title), ENT_QUOTES | ENT_HTML5);
  $title = str_replace(['“', '”', '’', '&#038;'], ['"', '"', "'", '&'], $title);
  $title = preg_replace('/\s+/', ' ', $title) ?? $title;
  return trim($title);
}

function ilf_featured_key(string $value): string {
  $value = strtolower(ilf_featured_clean_title($value));
  $value = str_replace(['coolingcancer', 'w.oahu', 'techonology', '&'], ['cooling cancer', 'west oahu', 'technology', 'and'], $value);
  $value = preg_replace('/[^a-z0-9]+/', '', $value) ?? $value;
  return $value;
}

function ilf_featured_slug(string $title): string {
  $slug = strtolower(ilf_featured_clean_title($title));
  $slug = str_replace(['&', '+'], ' and ', $slug);
  $slug = preg_replace('/[^a-z0-9]+/', '-', $slug) ?? $slug;
  return trim($slug, '-');
}

function ilf_featured_bundle(string $slug, array $post): string {
  $face_slugs = [
    'kanoa-leahey', 'greg-salas', 'stephanie-wang', 'dave-shoji', 'chelsea-hardin',
    'ashlee-kozuma', 'ashley-jardine', 'benny-agbani', 'rich-miano', 'jack-ito',
    'kaui-kauhi', 'drew-santos', 'riley-graves-lock', 'keli-santos',
  ];
  if (in_array($slug, $face_slugs, TRUE)) {
    return 'face_profile';
  }
  $title = strtolower(ilf_featured_clean_title($post['title']['rendered'] ?? ''));
  if (str_contains($slug, 'commercial') || str_contains($slug, 'gym-dog') || str_contains($slug, 'wangs-world')) {
    return 'commercial_video';
  }
  if (str_contains($slug, 'brochure') || str_contains($slug, 'troubleshooting')) {
    return 'resource_brochure';
  }
  return 'news_update';
}

function ilf_featured_target_alias(string $bundle, string $slug): string {
  $overrides = [
    'donations-cool-schools' => '/updates/donations-to-cool-schools',
    'elementor-805' => '/updates/maui-fujitsu-elite-contractors-vip-reception-may-19th-2022',
    'fujitsus-infinite-comfort-app' => '/updates/fujitsu-infinite-comfort-app',
    'maui-fujitsu-elite-contractors-vip-reception-may-19-2022' => '/updates/maui-fujitsu-elite-contractors-vip-reception-may-19th-2022',
  ];
  if (isset($overrides[$slug])) {
    return $overrides[$slug];
  }
  if ($bundle === 'face_profile') {
    return '/friends-family/' . $slug;
  }
  if ($bundle === 'commercial_video') {
    return '/commercials/' . $slug;
  }
  if ($bundle === 'resource_brochure') {
    return '/resources/' . $slug;
  }
  return '/updates/' . str_replace(['coolingcancer', 'w-oahu'], ['cooling-cancer', 'west-oahu'], $slug);
}

function ilf_featured_download(string $url, string $title, string $directory, object $file_repository): ?\Drupal\file\FileInterface {
  if ($url === '') {
    return NULL;
  }
  $path = parse_url($url, PHP_URL_PATH) ?: '';
  $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION) ?: 'jpg');
  if (!preg_match('/^(jpg|jpeg|png|webp)$/', $extension)) {
    $extension = 'jpg';
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
  $file = $file_repository->writeData($data, $directory . '/' . ilf_featured_slug($title) . '.' . $extension, FileExists::Replace);
  $file->setPermanent();
  $file->save();
  return $file;
}

$nodes_by_key = [];
foreach (['news_update', 'commercial_video', 'face_profile'] as $bundle) {
  $ids = \Drupal::entityQuery('node')->condition('type', $bundle)->accessCheck(FALSE)->execute();
  foreach ($node_storage->loadMultiple($ids) as $node) {
    $nodes_by_key[$bundle][ilf_featured_key($node->label())] = $node;
  }
}

$updated = 0;
$skipped = 0;

foreach ($posts as $post) {
  $media = $post['_embedded']['wp:featuredmedia'][0]['source_url'] ?? '';
  if ($media === '') {
    $skipped++;
    continue;
  }

  $slug = (string) ($post['slug'] ?? '');
  $title = ilf_featured_clean_title((string) ($post['title']['rendered'] ?? $slug));
  $bundle = ilf_featured_bundle($slug, $post);
  $field = match ($bundle) {
    'face_profile' => 'field_profile_image',
    'commercial_video' => 'field_thumbnail',
    default => 'field_featured_image',
  };

  $node = NULL;
  $alias = ilf_featured_target_alias($bundle, $slug);
  $system_path = $alias_manager->getPathByAlias($alias);
  if (preg_match('~^/node/(\d+)$~', $system_path, $match)) {
    $candidate = $node_storage->load((int) $match[1]);
    if ($candidate && $candidate->bundle() === $bundle) {
      $node = $candidate;
    }
  }

  if (!$node) {
    $node = $nodes_by_key[$bundle][ilf_featured_key($title)] ?? NULL;
  }

  if (!$node || !$node->hasField($field)) {
    $skipped++;
    continue;
  }

  $file = ilf_featured_download($media, $node->label(), $directory, $file_repository);
  if (!$file) {
    $skipped++;
    continue;
  }

  $node->set($field, [
    'target_id' => $file->id(),
    'alt' => $node->label() . ' image',
  ]);
  $node->save();
  $updated++;
}

echo "Featured image import complete. Updated: {$updated}; Skipped: {$skipped}; Posts checked: " . count($posts) . "\n";
