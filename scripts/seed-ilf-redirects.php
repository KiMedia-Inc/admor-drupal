<?php

declare(strict_types=1);

use Drupal\redirect\Entity\Redirect;

$redirects = [
  'category/home' => 'internal:/',
  'category/updates' => 'internal:/updates',
  'category/featured' => 'internal:/updates',
  'category/fujitsu-faces' => 'internal:/friends-family',
  'oahu-fujitsu-dealers' => 'internal:/find-a-dealer/oahu-dealers',
  'find-a-fujitsu-contractor' => 'internal:/find-a-contractor',
  'locate-a-fujitsu-contractor' => 'internal:/find-a-contractor',
  'i-love-my-fujitsu-athlete-application' => 'internal:/i-love-my-fujitsu-athletics-application',
  'mason2021_2022' => 'internal:/friends-family',
];

$storage = \Drupal::entityTypeManager()->getStorage('redirect');

foreach ($redirects as $source => $destination) {
  $existing = $storage->loadByProperties([
    'redirect_source.path' => $source,
  ]);

  $redirect = $existing ? reset($existing) : Redirect::create();
  $redirect->setSource($source);
  $redirect->set('redirect_redirect', ['uri' => $destination]);
  $redirect->setStatusCode(301);
  $redirect->save();
}

echo "Seeded initial Fujitsu redirects.\n";
