<?php

declare(strict_types=1);

use Drupal\pathauto\Entity\PathautoPattern;

$config = \Drupal::configFactory();

$config->getEditable('metatag.metatag_defaults.global')
  ->set('tags', [
    'title' => '[current-page:title] | [site:name]',
    'description' => 'Fujitsu Hawaii air conditioning resources, contractor connections, rebates, commercials, and local support for homeowners and businesses.',
    'canonical_url' => '[current-page:url]',
    'robots' => 'index, follow',
  ])
  ->save();

$config->getEditable('metatag.metatag_defaults.front')
  ->set('tags', [
    'title' => 'Ask Your Contractor for Fujitsu | Fujitsu Hawaii',
    'description' => 'Quiet, efficient Fujitsu air conditioning built for Hawaii comfort. Learn why homeowners and businesses should ask contractors for Fujitsu by name.',
    'canonical_url' => '[site:url]',
    'robots' => 'index, follow',
  ])
  ->save();

$config->getEditable('metatag.metatag_defaults.node')
  ->set('tags', [
    'title' => '[node:title] | [site:name]',
    'description' => '[node:summary]',
    'canonical_url' => '[node:url]',
    'robots' => 'index, follow',
  ])
  ->save();

function ilf_pathauto_pattern(string $id, string $label, string $bundle, string $pattern, int $weight): void {
  if ($existing = PathautoPattern::load($id)) {
    $existing->delete();
  }

  $entity = PathautoPattern::create([
    'id' => $id,
    'label' => $label,
    'type' => 'canonical_entities:node',
    'pattern' => $pattern,
    'weight' => $weight,
  ]);
  $entity->addSelectionCondition([
    'id' => 'entity_bundle:node',
    'bundles' => [$bundle => $bundle],
    'negate' => FALSE,
    'context_mapping' => ['node' => 'node'],
  ]);
  $entity->save();
}

ilf_pathauto_pattern('ilf_news_updates', 'Fujitsu updates', 'news_update', '/updates/[node:title]', -10);
ilf_pathauto_pattern('ilf_commercials', 'Fujitsu commercials', 'commercial_video', '/commercials/[node:title]', -9);
ilf_pathauto_pattern('ilf_resources', 'Fujitsu resources', 'resource_brochure', '/resources/[node:title]', -8);
ilf_pathauto_pattern('ilf_faces', 'Faces of Fujitsu', 'face_profile', '/friends-family/[node:title]', -7);
ilf_pathauto_pattern('ilf_dealers', 'Fujitsu dealers', 'dealer_contractor', '/find-a-dealer/[node:title]', -6);
ilf_pathauto_pattern('ilf_pages', 'Basic pages', 'page', '/[node:title]', 0);

$config->getEditable('pathauto.settings')
  ->set('punctuation.ampersand', 1)
  ->set('punctuation.slash', 1)
  ->set('reduce_ascii', TRUE)
  ->set('case', TRUE)
  ->set('max_component_length', 100)
  ->save();

$sitemap_links = [
  ['path' => '/', 'priority' => '1.0', 'changefreq' => 'daily'],
  ['path' => '/why-fujitsu', 'priority' => '0.9', 'changefreq' => 'weekly'],
  ['path' => '/find-a-contractor', 'priority' => '0.9', 'changefreq' => 'weekly'],
  ['path' => '/find-a-dealer', 'priority' => '0.9', 'changefreq' => 'weekly'],
  ['path' => '/find-a-dealer/oahu-dealers', 'priority' => '0.8', 'changefreq' => 'weekly'],
  ['path' => '/find-a-dealer/maui-dealers', 'priority' => '0.8', 'changefreq' => 'weekly'],
  ['path' => '/find-a-dealer/kauai-dealers', 'priority' => '0.8', 'changefreq' => 'weekly'],
  ['path' => '/find-a-dealer/big-island-dealers', 'priority' => '0.8', 'changefreq' => 'weekly'],
  ['path' => '/products', 'priority' => '0.8', 'changefreq' => 'monthly'],
  ['path' => '/commercials', 'priority' => '0.7', 'changefreq' => 'monthly'],
  ['path' => '/resources', 'priority' => '0.8', 'changefreq' => 'monthly'],
  ['path' => '/updates', 'priority' => '0.7', 'changefreq' => 'weekly'],
  ['path' => '/friends-family', 'priority' => '0.7', 'changefreq' => 'monthly'],
];

$config->getEditable('simple_sitemap.custom_links.default')
  ->set('links', $sitemap_links)
  ->save();

$config->getEditable('simple_sitemap.settings')
  ->set('base_url', 'https://fujitsu.ikaikakimura.com')
  ->save();

echo "Seeded Fujitsu SEO defaults and Pathauto patterns.\n";
