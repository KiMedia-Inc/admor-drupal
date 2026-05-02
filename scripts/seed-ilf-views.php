<?php

declare(strict_types=1);

use Drupal\views\Entity\View;
use Drupal\node\Entity\Node;

/**
 * Creates repeatable listing Views for the Fujitsu rebuild.
 */

function ilf_status_filter(): array {
  return [
    'id' => 'status',
    'table' => 'node_field_data',
    'field' => 'status',
    'relationship' => 'none',
    'group_type' => 'group',
    'admin_label' => '',
    'entity_type' => 'node',
    'entity_field' => 'status',
    'plugin_id' => 'boolean',
    'operator' => '=',
    'value' => '1',
    'group' => 1,
    'exposed' => FALSE,
  ];
}

function ilf_type_filter(string $bundle): array {
  return [
    'id' => 'type',
    'table' => 'node_field_data',
    'field' => 'type',
    'relationship' => 'none',
    'group_type' => 'group',
    'admin_label' => '',
    'entity_type' => 'node',
    'entity_field' => 'type',
    'plugin_id' => 'bundle',
    'operator' => 'in',
    'value' => [$bundle => $bundle],
    'group' => 1,
    'exposed' => FALSE,
  ];
}

function ilf_island_filter(string $island): array {
  return [
    'id' => 'field_island_value',
    'table' => 'node__field_island',
    'field' => 'field_island_value',
    'relationship' => 'none',
    'group_type' => 'group',
    'admin_label' => '',
    'plugin_id' => 'list_field',
    'operator' => 'or',
    'value' => [$island => $island],
    'group' => 1,
    'exposed' => FALSE,
    'field_name' => 'field_island',
    'entity_type' => 'node',
  ];
}

function ilf_sort_created_desc(): array {
  return [
    'created' => [
      'id' => 'created',
      'table' => 'node_field_data',
      'field' => 'created',
      'relationship' => 'none',
      'group_type' => 'group',
      'admin_label' => '',
      'entity_type' => 'node',
      'entity_field' => 'created',
      'plugin_id' => 'date',
      'order' => 'DESC',
      'exposed' => FALSE,
      'granularity' => 'second',
    ],
  ];
}

function ilf_sort_title_asc(): array {
  return [
    'title' => [
      'id' => 'title',
      'table' => 'node_field_data',
      'field' => 'title',
      'relationship' => 'none',
      'group_type' => 'group',
      'admin_label' => '',
      'entity_type' => 'node',
      'entity_field' => 'title',
      'plugin_id' => 'standard',
      'order' => 'ASC',
      'exposed' => FALSE,
    ],
  ];
}

function ilf_view(string $id, string $label, string $bundle, array $pages, array $sorts): array {
  $filters = [
    'status' => ilf_status_filter(),
    'type' => ilf_type_filter($bundle),
  ];

  $display = [
    'default' => [
      'id' => 'default',
      'display_title' => 'Default',
      'display_plugin' => 'default',
      'position' => 0,
      'display_options' => [
        'title' => $label,
        'fields' => [],
        'pager' => [
          'type' => 'full',
          'options' => [
            'offset' => 0,
            'items_per_page' => 12,
            'total_pages' => 0,
            'id' => 0,
            'tags' => [
              'next' => 'Next',
              'previous' => 'Previous',
              'first' => 'First',
              'last' => 'Last',
            ],
            'quantity' => 9,
          ],
        ],
        'exposed_form' => [
          'type' => 'basic',
          'options' => [
            'submit_button' => 'Apply',
            'reset_button' => FALSE,
            'reset_button_label' => 'Reset',
            'exposed_sorts_label' => 'Sort by',
            'expose_sort_order' => TRUE,
            'sort_asc_label' => 'Asc',
            'sort_desc_label' => 'Desc',
          ],
        ],
        'access' => [
          'type' => 'perm',
          'options' => ['perm' => 'access content'],
        ],
        'cache' => [
          'type' => 'tag',
          'options' => [],
        ],
        'empty' => [
          'area_text_custom' => [
            'id' => 'area_text_custom',
            'table' => 'views',
            'field' => 'area_text_custom',
            'relationship' => 'none',
            'group_type' => 'group',
            'admin_label' => '',
            'plugin_id' => 'text_custom',
            'label' => '',
            'empty' => TRUE,
            'content' => 'Migration content has not been imported yet.',
            'tokenize' => FALSE,
          ],
        ],
        'sorts' => $sorts,
        'arguments' => [],
        'filters' => $filters,
        'filter_groups' => [
          'operator' => 'AND',
          'groups' => [1 => 'AND'],
        ],
        'style' => [
          'type' => 'default',
          'options' => [
            'grouping' => [],
            'row_class' => 'ilf-listing__item',
            'default_row_class' => TRUE,
            'uses_fields' => FALSE,
          ],
        ],
        'row' => [
          'type' => 'entity:node',
          'options' => [
            'view_mode' => 'teaser',
          ],
        ],
        'query' => [
          'type' => 'views_query',
          'options' => [
            'query_comment' => '',
            'disable_sql_rewrite' => FALSE,
            'distinct' => FALSE,
            'replica' => FALSE,
            'query_tags' => [],
          ],
        ],
        'relationships' => [],
        'header' => [],
        'footer' => [],
        'display_extenders' => [],
      ],
    ],
  ];

  foreach ($pages as $machine_name => $page) {
    $display[$machine_name] = [
      'id' => $machine_name,
      'display_title' => $page['title'],
      'display_plugin' => 'page',
      'position' => $page['position'] ?? 1,
      'display_options' => [
        'title' => $page['title'],
        'defaults' => [
          'title' => FALSE,
          'filters' => empty($page['filters']),
          'filter_groups' => empty($page['filters']),
        ],
        'path' => $page['path'],
        'display_extenders' => [],
      ],
    ];

    if (!empty($page['filters'])) {
      $page_filters = $filters + $page['filters'];
      $display[$machine_name]['display_options']['filters'] = $page_filters;
      $display[$machine_name]['display_options']['filter_groups'] = [
        'operator' => 'AND',
        'groups' => [1 => 'AND'],
      ];
    }
  }

  return [
    'id' => $id,
    'label' => $label,
    'module' => 'views',
    'description' => 'Fujitsu buyer-facing listing.',
    'tag' => 'I Love My Fujitsu',
    'base_table' => 'node_field_data',
    'base_field' => 'nid',
    'display' => $display,
    'status' => TRUE,
  ];
}

$views = [
  ilf_view('ilf_news_updates', 'Updates / News', 'news_update', [
    'page_1' => ['title' => 'Updates / News', 'path' => 'updates'],
  ], ilf_sort_created_desc()),
  ilf_view('ilf_commercials', 'Commercials', 'commercial_video', [
    'page_1' => ['title' => 'Commercials', 'path' => 'commercials'],
  ], ilf_sort_created_desc()),
  ilf_view('ilf_resources', 'Resources', 'resource_brochure', [
    'page_1' => ['title' => 'Resources', 'path' => 'resources'],
  ], ilf_sort_title_asc()),
  ilf_view('ilf_faces', 'Friends & Family', 'face_profile', [
    'page_1' => ['title' => 'Friends & Family', 'path' => 'friends-family'],
  ], ilf_sort_title_asc()),
  ilf_view('ilf_dealers', 'Find a Dealer', 'dealer_contractor', [
    'page_all' => ['title' => 'Find a Dealer', 'path' => 'find-a-dealer'],
    'page_oahu' => [
      'title' => 'Oahu Dealers',
      'path' => 'find-a-dealer/oahu-dealers',
      'position' => 2,
      'filters' => ['field_island_value' => ilf_island_filter('oahu')],
    ],
    'page_maui' => [
      'title' => 'Maui Dealers',
      'path' => 'find-a-dealer/maui-dealers',
      'position' => 3,
      'filters' => ['field_island_value' => ilf_island_filter('maui')],
    ],
    'page_kauai' => [
      'title' => 'Kauai Dealers',
      'path' => 'find-a-dealer/kauai-dealers',
      'position' => 4,
      'filters' => ['field_island_value' => ilf_island_filter('kauai')],
    ],
    'page_big_island' => [
      'title' => 'Big Island Dealers',
      'path' => 'find-a-dealer/big-island-dealers',
      'position' => 5,
      'filters' => ['field_island_value' => ilf_island_filter('big_island')],
    ],
  ], ilf_sort_title_asc()),
];

foreach ($views as $definition) {
  if ($existing = View::load($definition['id'])) {
    $existing->delete();
  }
  View::create($definition)->save();
}

// Move earlier starter Basic Pages away from paths now owned by Views.
$reserved_page_titles = [
  'Find a Dealer' => '/seeded-page/find-a-dealer',
  'Oahu Dealers' => '/seeded-page/oahu-dealers',
  'Maui Dealers' => '/seeded-page/maui-dealers',
  'Kauai Dealers' => '/seeded-page/kauai-dealers',
  'Big Island Dealers' => '/seeded-page/big-island-dealers',
  'Commercials' => '/seeded-page/commercials',
  'Resources' => '/seeded-page/resources',
  'Updates' => '/seeded-page/updates',
  'Friends & Family' => '/seeded-page/friends-family',
];

$node_storage = \Drupal::entityTypeManager()->getStorage('node');
foreach ($reserved_page_titles as $title => $alias) {
  $matches = $node_storage->loadByProperties([
    'type' => 'page',
    'title' => $title,
  ]);
  foreach ($matches as $node) {
    assert($node instanceof Node);
    $node->set('path', ['alias' => $alias]);
    $node->save();
  }
}

$alias_storage = \Drupal::entityTypeManager()->getStorage('path_alias');
foreach ([
  '/updates',
  '/commercials',
  '/resources',
  '/friends-family',
  '/find-a-dealer',
  '/find-a-dealer/oahu-dealers',
  '/find-a-dealer/maui-dealers',
  '/find-a-dealer/kauai-dealers',
  '/find-a-dealer/big-island-dealers',
] as $view_path) {
  foreach ($alias_storage->loadByProperties(['alias' => $view_path]) as $alias) {
    $alias->delete();
  }
}

echo "Seeded Fujitsu listing views.\n";
