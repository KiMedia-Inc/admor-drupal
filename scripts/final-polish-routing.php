<?php

declare(strict_types=1);

use Drupal\redirect\Entity\Redirect;

$storage = \Drupal::entityTypeManager()->getStorage('node');

$unpublish_titles = [
  'news_update' => [
    'Fujitsu General ProCore High Corrosion Resistant Technology',
    'Cooling Cancer Donates 70k',
    'Elementor 805',
  ],
  'commercial_video' => [
    'Commercials',
    'Fujitsu Gym Dog',
  ],
  'page' => [
    'Full Line Brochure',
    'Consumer Brochure',
    'Troubleshooting Guide',
  ],
];

foreach ($unpublish_titles as $bundle => $titles) {
  foreach ($titles as $title) {
    $nodes = $storage->loadByProperties(['type' => $bundle, 'title' => $title]);
    foreach ($nodes as $node) {
      if ($bundle === 'commercial_video' && $title === 'Fujitsu Gym Dog' && $node->toUrl()->toString() === '/commercials/fujitsu-gym-dog') {
        continue;
      }
      if ($bundle === 'news_update' && $title === 'Cooling Cancer Donates 70k' && $node->toUrl()->toString() === '/updates/coolingcancer-donates-70k') {
        continue;
      }
      if ($node->isPublished()) {
        $node->setUnpublished();
        $node->save();
        echo "Unpublished artifact: {$title} (#{$node->id()})\n";
      }
    }
  }
}

$alias_updates = [
  'resource_brochure' => [
    'Full Line Brochure' => '/resources/full-line-brochure',
    'Consumer Brochure' => '/resources/consumer-brochure',
    'Troubleshooting Guide' => '/resources/troubleshooting-guide',
    'Fujitsu 410a Mini-Split Troubleshooting Guide' => '/resources/fujitsu-410a-mini-split-troubleshooting-guide',
  ],
  'commercial_video' => [
    'Wangs World Of Fujitsu' => '/commercials/wangs-world-of-fujitsu',
  ],
  'news_update' => [
    'Fujitsu Generals Procore High Corrosion Resistant Technology' => '/updates/fujitsu-procore-corrosion-resistant-technology',
    'Fujitsu Hawaii On KHON2' => '/updates/fujitsu-hawaii-on-khon2',
    'Fujitsu Infinite Comfort App' => '/updates/fujitsu-infinite-comfort-app',
  ],
];

foreach ($alias_updates as $bundle => $items) {
  foreach ($items as $title => $alias) {
    $nodes = $storage->loadByProperties(['type' => $bundle, 'title' => $title]);
    foreach ($nodes as $node) {
      if (!$node->isPublished()) {
        continue;
      }
      $node->set('path', ['alias' => $alias]);
      $node->save();
      echo "Updated alias: {$title} -> {$alias}\n";
      break;
    }
  }
}

$redirects = [
  'find-a-dealer/oahu-fujitsu-contractor-placeholder' => 'internal:/find-a-dealer/oahu-fujitsu-dealer-network',
  'find-a-dealer/maui-fujitsu-contractor-placeholder' => 'internal:/find-a-dealer/maui-fujitsu-dealer-network',
  'find-a-dealer/kauai-fujitsu-contractor-placeholder' => 'internal:/find-a-dealer/kauai-fujitsu-dealer-network',
  'find-a-dealer/big-island-fujitsu-contractor-placeholder' => 'internal:/find-a-dealer/hawaii-island-fujitsu-dealer-network',
  'resources/full-line-brochure-0' => 'internal:/resources/full-line-brochure-download',
  'resources/consumer-brochure-0' => 'internal:/resources/consumer-brochure-download',
  'resources/troubleshooting-guide-0' => 'internal:/resources/troubleshooting-guide-support',
  'resources/full-line-brochure-download' => 'internal:/resources/full-line-brochure',
  'resources/consumer-brochure-download' => 'internal:/resources/consumer-brochure',
  'resources/troubleshooting-guide-support' => 'internal:/resources/troubleshooting-guide',
  'updates/fujitsus-infinite-comfort-app' => 'internal:/updates/fujitsu-infinite-comfort-app',
  'updates/fujitsu-generals-procore-high-corrosion-resistant-techonology' => 'internal:/updates/fujitsu-procore-corrosion-resistant-technology',
  'mason2021_2022' => 'internal:/updates/mason-kekoa-nava-macloves-memorial-scholarships',
  '2019/04/23/kaui-kauhi' => 'internal:/friends-family/kaui-kauhi',
  '2019/04/23/drew-santos' => 'internal:/friends-family/drew-santos',
  '2019/04/23/keli-santos' => 'internal:/friends-family/keli-santos',
  '2020/08/07/kanoa-leahey' => 'internal:/friends-family/kanoa-leahey',
  '2019/04/23/chelsea-hardin' => 'internal:/friends-family/chelsea-hardin',
  '2019/04/23/ashley-jardine' => 'internal:/friends-family/ashley-jardine',
  '2019/04/23/jack-ito' => 'internal:/friends-family/jack-ito',
  '2019/04/21/fujitsus-infinite-comfort-app' => 'internal:/updates/fujitsu-infinite-comfort-app',
  '2019/04/21/airstage-on-broadway' => 'internal:/updates/airstage-on-broadway',
];

$redirect_storage = \Drupal::entityTypeManager()->getStorage('redirect');
foreach ($redirects as $from => $to) {
  $existing = $redirect_storage->loadByProperties([
    'redirect_source__path' => $from,
  ]);
  if ($existing) {
    $redirect = reset($existing);
    $redirect->set('redirect_redirect', ['uri' => $to]);
    $redirect->setStatusCode(301);
    $redirect->save();
    continue;
  }
  Redirect::create([
    'redirect_source' => ['path' => $from],
    'redirect_redirect' => ['uri' => $to],
    'status_code' => 301,
    'language' => 'und',
  ])->save();
}

$resource_pairs = [
  31 => [
    'canonical' => 'resources/full-line-brochure',
    'redirects' => ['resources/full-line-brochure-0', 'resources/full-line-brochure-download'],
  ],
  32 => [
    'canonical' => 'resources/consumer-brochure',
    'redirects' => ['resources/consumer-brochure-0', 'resources/consumer-brochure-download'],
  ],
  33 => [
    'canonical' => 'resources/troubleshooting-guide',
    'redirects' => ['resources/troubleshooting-guide-0', 'resources/troubleshooting-guide-support'],
  ],
];

$alias_storage = \Drupal::entityTypeManager()->getStorage('path_alias');
foreach ($resource_pairs as $nid => $pair) {
  $aliases = array_merge(['/' . $pair['canonical']], array_map(static fn (string $path): string => '/' . $path, $pair['redirects']));
  foreach ($aliases as $alias) {
    foreach ($alias_storage->loadByProperties(['alias' => $alias]) as $path_alias) {
      $path_alias->delete();
    }
  }
  foreach ($alias_storage->loadByProperties(['path' => '/node/' . $nid]) as $path_alias) {
    $path_alias->delete();
  }
  foreach (array_merge([$pair['canonical']], $pair['redirects']) as $source) {
    foreach ($redirect_storage->loadByProperties(['redirect_source__path' => $source]) as $redirect) {
      $redirect->delete();
    }
  }
  $alias_storage->create([
    'path' => '/node/' . $nid,
    'alias' => '/' . $pair['canonical'],
    'langcode' => 'en',
  ])->save();
  foreach ($pair['redirects'] as $redirect_path) {
    Redirect::create([
      'redirect_source' => ['path' => $redirect_path],
      'redirect_redirect' => ['uri' => 'internal:/' . $pair['canonical']],
      'status_code' => 301,
      'language' => 'und',
    ])->save();
  }
}

echo "Final routing polish complete.\n";
