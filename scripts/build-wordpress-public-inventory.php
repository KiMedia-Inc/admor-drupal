<?php

declare(strict_types=1);

$base = 'https://ilovemyfujitsu.com';
$output_dir = __DIR__ . '/../data/migration';
$csv_path = $output_dir . '/wordpress-public-inventory.csv';
$json_path = $output_dir . '/wordpress-public-inventory.json';

if (!is_dir($output_dir)) {
  mkdir($output_dir, 0775, TRUE);
}

function ilf_fetch(string $url): string {
  $context = stream_context_create([
    'http' => [
      'header' => "User-Agent: Mozilla/5.0\r\n",
      'timeout' => 20,
    ],
  ]);
  $body = @file_get_contents($url, FALSE, $context);
  return is_string($body) ? $body : '';
}

function ilf_sitemap_locs(string $xml): array {
  if ($xml === '') {
    return [];
  }
  $doc = @simplexml_load_string($xml);
  if (!$doc) {
    return [];
  }
  $doc->registerXPathNamespace('sm', 'http://www.sitemaps.org/schemas/sitemap/0.9');
  $locs = [];
  foreach ($doc->xpath('//sm:loc') ?: [] as $loc) {
    $locs[] = trim((string) $loc);
  }
  return $locs;
}

function ilf_title_from_slug(string $slug): string {
  $slug = trim($slug, '/');
  $parts = explode('/', $slug);
  $last = end($parts) ?: $slug;
  $last = str_replace(['-', '_'], ' ', $last);
  $last = preg_replace('/\s+/', ' ', $last);
  return ucwords($last ?: 'Untitled');
}

function ilf_suggest_type(string $url, string $source_type): string {
  $path = parse_url($url, PHP_URL_PATH) ?: '';
  if ($source_type === 'category') {
    return 'redirect_only';
  }
  $faces = [
    'kanoa-leahey', 'greg-salas', 'stephanie-wang', 'dave-shoji', 'chelsea-hardin',
    'ashlee-kozuma', 'ashley-jardine', 'benny-agbani', 'rich-miano', 'jack-ito',
    'kaui-kauhi', 'drew-santos', 'riley-graves-lock', 'keli-santos',
  ];
  foreach ($faces as $face) {
    if (str_contains($path, $face)) {
      return 'face_profile';
    }
  }
  if (str_contains($path, 'commercial') || str_contains($path, 'gym-dog') || str_contains($path, 'wangs-world')) {
    return 'commercial_video';
  }
  if (str_contains($path, 'rebate') || str_contains($path, 'brochure') || str_contains($path, 'troubleshooting')) {
    return 'resource_brochure';
  }
  if ($source_type === 'page') {
    return 'page';
  }
  return 'news_update';
}

function ilf_target_alias(string $url, string $drupal_type): string {
  $path = trim((string) parse_url($url, PHP_URL_PATH), '/');
  if ($path === '' || $path === 'home') {
    return '/';
  }
  $map = [
    'category/updates' => '/updates',
    'category/featured' => '/updates',
    'category/fujitsu-faces' => '/friends-family',
    'find-a-fujitsu-contractor' => '/find-a-contractor',
    'oahu-fujitsu-dealers' => '/find-a-dealer/oahu-dealers',
    'i-love-my-fujitsu-athlete-application' => '/i-love-my-fujitsu-athletics-application',
  ];
  if (isset($map[$path])) {
    return $map[$path];
  }
  if ($drupal_type === 'face_profile') {
    return '/friends-family/' . basename($path);
  }
  if ($drupal_type === 'commercial_video') {
    return '/commercials/' . basename($path);
  }
  if ($drupal_type === 'resource_brochure') {
    return '/resources/' . basename($path);
  }
  if ($drupal_type === 'news_update') {
    return '/updates/' . basename($path);
  }
  return '/' . $path;
}

$index = ilf_fetch($base . '/wp-sitemap.xml');
$sitemaps = ilf_sitemap_locs($index);
$rows = [];

foreach ($sitemaps as $sitemap) {
  if (str_contains($sitemap, 'wp-sitemap-users')) {
    continue;
  }

  $source_type = 'other';
  if (str_contains($sitemap, 'posts-post')) {
    $source_type = 'post';
  }
  elseif (str_contains($sitemap, 'posts-page')) {
    $source_type = 'page';
  }
  elseif (str_contains($sitemap, 'taxonomies-category')) {
    $source_type = 'category';
  }

  foreach (ilf_sitemap_locs(ilf_fetch($sitemap)) as $url) {
    if (str_contains($url, '/wp-sitemap-users-')) {
      continue;
    }
    $path = trim((string) parse_url($url, PHP_URL_PATH), '/');
    $drupal_type = ilf_suggest_type($url, $source_type);
    $notes = $source_type === 'category' ? 'Category archive: keep for redirect/SEO mapping, do not import as content.' : '';
    $rows[] = [
      'source_url' => $url,
      'source_type' => $source_type,
      'source_path' => '/' . $path,
      'title' => ilf_title_from_slug($path),
      'suggested_drupal_type' => $drupal_type,
      'target_alias' => ilf_target_alias($url, $drupal_type),
      'migration_status' => 'inventory',
      'notes' => $notes,
    ];
  }
}

usort($rows, static fn(array $a, array $b): int => [$a['source_type'], $a['source_url']] <=> [$b['source_type'], $b['source_url']]);

$csv = fopen($csv_path, 'w');
fputcsv($csv, ['source_url', 'source_type', 'source_path', 'title', 'suggested_drupal_type', 'target_alias', 'migration_status', 'notes'], ',', '"', '\\');
foreach ($rows as $row) {
  fputcsv($csv, $row, ',', '"', '\\');
}
fclose($csv);

file_put_contents($json_path, json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "Wrote " . count($rows) . " public WordPress inventory rows.\n";
echo $csv_path . "\n";
echo $json_path . "\n";
