<?php

declare(strict_types=1);

use Drupal\Core\Entity\Entity\EntityFormDisplay;
use Drupal\Core\Entity\Entity\EntityViewDisplay;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\menu_link_content\Entity\MenuLinkContent;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;
use Drupal\redirect\Entity\Redirect;
use Drupal\views\Entity\View;

// Remove the legacy redirect so /find-a-fujitsu-contractor can be a real
// conversion page.
$redirects = \Drupal::entityTypeManager()->getStorage('redirect')->loadByProperties(['redirect_source__path' => 'find-a-fujitsu-contractor']);
foreach ($redirects as $redirect) {
  $redirect->delete();
}

// Customer testimonial content model.
$type = NodeType::load('customer_testimonial') ?: NodeType::create(['type' => 'customer_testimonial']);
$type->set('name', 'Customer Testimonial');
$type->set('description', 'Customer quotes used as trust proof on Fujitsu authority, comparison, and dealer pages.');
$type->set('new_revision', TRUE);
$type->save();
if (!FieldConfig::loadByName('node', 'customer_testimonial', 'body')) {
  node_add_body_field($type, 'Internal notes');
}
ilf_p5_field('node', 'customer_testimonial', 'field_testimonial_quote', 'Quote', 'text_long', [], [], 1, TRUE, 'Paste the approved testimonial quote.');
ilf_p5_field('node', 'customer_testimonial', 'field_island', 'Island', 'string', [], [], 1, FALSE, 'Example: Oahu, Maui, Kauai, Big Island.');
ilf_p5_field('node', 'customer_testimonial', 'field_system_installed', 'System installed', 'string', [], [], 1, FALSE, 'Optional Fujitsu system, model family, or installation type.');
ilf_p5_field('node', 'customer_testimonial', 'field_customer_image', 'Image', 'image', [], [
  'file_extensions' => 'png jpg jpeg webp',
  'alt_field' => TRUE,
  'alt_field_required' => FALSE,
], 1, FALSE, 'Optional customer, home, or installed-system image approved for use.');
ilf_p5_field('node', 'customer_testimonial', 'field_sort_order', 'Sort order', 'integer', [], [], 1, FALSE, 'Lower numbers appear first.');

$form = EntityFormDisplay::load('node.customer_testimonial.default') ?: EntityFormDisplay::create([
  'targetEntityType' => 'node',
  'bundle' => 'customer_testimonial',
  'mode' => 'default',
  'status' => TRUE,
]);
$form
  ->setComponent('title', ['type' => 'string_textfield', 'weight' => 0])
  ->setComponent('field_testimonial_quote', ['type' => 'text_textarea', 'weight' => 1])
  ->setComponent('field_island', ['type' => 'string_textfield', 'weight' => 2])
  ->setComponent('field_system_installed', ['type' => 'string_textfield', 'weight' => 3])
  ->setComponent('field_customer_image', ['type' => 'image_image', 'weight' => 4])
  ->setComponent('field_sort_order', ['type' => 'number', 'weight' => 5])
  ->setComponent('body', ['type' => 'text_textarea_with_summary', 'weight' => 20])
  ->setComponent('path', ['type' => 'path', 'weight' => 30])
  ->save();

$display = EntityViewDisplay::load('node.customer_testimonial.default') ?: EntityViewDisplay::create([
  'targetEntityType' => 'node',
  'bundle' => 'customer_testimonial',
  'mode' => 'default',
  'status' => TRUE,
]);
$display
  ->setComponent('field_testimonial_quote', ['type' => 'text_default', 'label' => 'hidden', 'weight' => 0])
  ->setComponent('field_island', ['type' => 'string', 'label' => 'above', 'weight' => 1])
  ->setComponent('field_system_installed', ['type' => 'string', 'label' => 'above', 'weight' => 2])
  ->save();

ilf_p5_view_testimonials();

$why_body = <<<'HTML'
<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Fujitsu for Hawaii</p><h2>Why Fujitsu Air Conditioning is the Best Choice for Hawaii</h2><p>Hawaii air conditioning is different. Systems face year-round use, coastal salt air, humidity, limited service windows, and homes that often need room-by-room comfort. Fujitsu stands out because it combines ductless comfort, corrosion-aware technology, warranty confidence, and local Admor-backed support.</p></section>
<div class="ilf-card-grid ilf-card-grid--three"><article><h3>Salt air corrosion resistance</h3><p>Coastal installations need more than standard efficiency claims. Fujitsu gives buyers corrosion-aware talking points such as ProCore and blue-fin technology to discuss with their contractor.</p><a class="btn-main" href="/manufacturer/fujitsu-technology">Review technology</a></article><article><h3>Humidity and constant use</h3><p>Fujitsu ductless and multi-zone systems are built around quiet, efficient, room-by-room comfort for spaces that cool often and need consistent performance.</p><a class="btn-main" href="/products">Explore Fujitsu Products</a></article><article><h3>Local support through Admor</h3><p>Fujitsu is backed by Hawaii distribution support, inventory, parts access, contractor relationships, and local product knowledge through Admor HVAC Products.</p><a class="btn-main" href="/find-a-fujitsu-contractor">Find a Fujitsu Dealer</a></article></div>
<section class="ilf-content-band"><h2>What makes Fujitsu different in Hawaii?</h2><p><strong>Coastal durability:</strong> Hawaii homes near ocean air need corrosion-aware product selection and maintenance planning.</p><p><strong>Energy efficiency:</strong> Mini-splits can cool the rooms people actually use, which helps reduce waste compared with one-size-fits-all cooling.</p><p><strong>Warranty confidence:</strong> Fujitsu warranty messaging, including 12-year and Gecko warranty positioning, gives buyers a stronger reason to request Fujitsu before the estimate is written.</p><p><strong>Certified contractor path:</strong> A qualified Fujitsu contractor can help match the right system, register warranty requirements, and support long-term service needs.</p></section>
<section class="ilf-comparison-advantage"><h2>Quick comparison highlights</h2><ul><li><strong>Vs Mitsubishi:</strong> Fujitsu competes in the premium mini-split category while adding a clear Hawaii distributor support story.</li><li><strong>Vs Daikin:</strong> Fujitsu keeps residential and light-commercial buyers focused on ductless comfort, local support, and practical ownership.</li><li><strong>Vs LG:</strong> Fujitsu positions the decision around HVAC-first comfort and serviceability, not electronics-brand familiarity.</li></ul><p><a class="btn-main" href="/compare">Compare Fujitsu to Other Brands</a></p></section>
<section class="ilf-callout"><h2>Ready to ask for Fujitsu?</h2><p>Choose the brand before the estimate is written. Tell your contractor you want Fujitsu quoted by name.</p><p><a class="btn-main" href="/find-a-fujitsu-contractor">Find a Fujitsu Dealer Near You</a> <a class="btn-main btn-outline" href="/products">Explore Fujitsu Products</a></p></section>
HTML;

$best_body = <<<'HTML'
<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Best AC Hawaii</p><h2>Best Air Conditioning for Hawaii Homes and Businesses</h2><p>The best AC system in Hawaii should handle humidity, salt air, year-round cooling, quiet comfort, energy use, and long-term support. For many homes, condos, additions, offices, and small commercial spaces, ductless mini-splits are the best starting point.</p></section>
<div class="ilf-card-grid ilf-card-grid--three"><article><h3>Window and portable AC</h3><p>Useful for short-term cooling, but usually weaker for whole-home comfort, quiet operation, and long-term efficiency.</p></article><article><h3>Central ducted systems</h3><p>Appropriate for some homes and larger buildings, but ductwork, zoning, and retrofit cost can make them less flexible.</p></article><article><h3>Ductless mini-splits</h3><p>Often the best Hawaii fit because they deliver room-by-room comfort without major ductwork and can be scaled from one room to multiple zones.</p></article></div>
<section class="ilf-content-band"><h2>Why mini splits dominate in Hawaii</h2><p>Mini-splits work well for Hawaii because homes often need targeted cooling, quiet bedrooms, condo-friendly installation, efficient daily operation, and flexible comfort for rooms that are used at different times. They also support additions, rental units, small offices, and businesses where ductwork may not be practical.</p></section>
<section class="ilf-comparison-advantage"><h2>Which mini-split brand should you ask for?</h2><ul><li><strong>Fujitsu:</strong> best fit when you want ductless comfort, warranty confidence, corrosion-aware messaging, and Admor-backed Hawaii support.</li><li><strong>Mitsubishi and Daikin:</strong> serious competitors, especially in premium and commercial conversations, but should be compared against Fujitsu’s local support path.</li><li><strong>LG, Gree, Panasonic:</strong> worth comparing when price, brand familiarity, or availability enters the quote, but Fujitsu gives a stronger Hawaii authority story.</li></ul><p><a class="btn-main" href="/compare">Compare Fujitsu to Other Brands</a></p></section>
<section class="ilf-callout"><h2>Best next step: ask for Fujitsu by name.</h2><p>Before accepting any AC quote, ask your contractor to include Fujitsu and explain the right system for your island, room layout, humidity needs, and long-term service expectations.</p><p><a class="btn-main" href="/find-a-fujitsu-contractor">Find a Fujitsu Dealer</a> <a class="btn-main btn-outline" href="/manufacturer/tax-credits-rebates">View Rebates</a></p></section>
HTML;

$funnel_body = <<<'HTML'
<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Dealer funnel</p><h2>Find a Fujitsu Dealer Near You</h2><p>Certified Fujitsu contractors matter because product selection, sizing, installation quality, warranty registration, and service support all affect long-term comfort. Start by choosing your island, then ask each contractor to quote Fujitsu specifically.</p></section>
<div class="ilf-island-grid"><a data-ilf-contractor-link href="/find-a-dealer/oahu-dealers"><strong>Oahu Fujitsu Dealers</strong><span>Honolulu, Windward, Central, Leeward, and North Shore support.</span></a><a data-ilf-contractor-link href="/find-a-dealer/maui-dealers"><strong>Maui Fujitsu Dealers</strong><span>Residential, resort, office, and commercial comfort support.</span></a><a data-ilf-contractor-link href="/find-a-dealer/kauai-dealers"><strong>Kauai Fujitsu Dealers</strong><span>Islandwide Fujitsu contractor pathways and Admor-backed support.</span></a><a data-ilf-contractor-link href="/find-a-dealer/big-island-dealers"><strong>Big Island Fujitsu Dealers</strong><span>Kona, Hilo, Waimea, Puna, and surrounding communities.</span></a></div>
<section class="ilf-callout"><h2>What to ask your contractor</h2><p>“Can you quote Fujitsu, confirm the right system size, explain warranty registration, and show why this setup fits Hawaii salt air, humidity, and year-round use?”</p><p><a class="btn-main" href="/why-fujitsu-hawaii">Why Fujitsu for Hawaii</a> <a class="btn-main btn-outline" href="/products">Explore Fujitsu Products</a></p></section>
HTML;

ilf_p5_page('Why Fujitsu Hawaii', '/why-fujitsu-hawaii', $why_body);
ilf_p5_page('Best Air Conditioning Hawaii', '/best-air-conditioning-hawaii', $best_body);
ilf_p5_page('Find a Fujitsu Dealer Near You', '/find-a-fujitsu-contractor', $funnel_body);

// Keep the older path useful and canonical-ish for existing internal links.
if ($old = ilf_p5_node_by_title('page', 'Find a Fujitsu Contractor')) {
  $old->set('body', ['value' => $funnel_body, 'format' => 'full_html']);
  $old->save();
}

ilf_p5_menu_link('main', 'Why Fujitsu', 'internal:/why-fujitsu-hawaii', 15);
ilf_p5_menu_link('main', 'Best AC Hawaii', 'internal:/best-air-conditioning-hawaii', 16);
ilf_p5_menu_link('main', 'Find a Fujitsu Dealer', 'internal:/find-a-fujitsu-contractor', 18);
ilf_p5_menu_link('footer', 'Why Fujitsu Hawaii', 'internal:/why-fujitsu-hawaii', 12);
ilf_p5_menu_link('footer', 'Best AC Hawaii', 'internal:/best-air-conditioning-hawaii', 14);
ilf_p5_standardize_ctas();

// Seed unpublished testimonial examples so the admin has the model ready without
// inventing public customer quotes.
$examples = [
  ['Pending Oahu Homeowner Testimonial', 'Oahu', 'Residential mini-split', 'Client-approved quote needed before publishing.'],
  ['Pending Maui Business Testimonial', 'Maui', 'Commercial ductless system', 'Client-approved quote needed before publishing.'],
  ['Pending Big Island Contractor Testimonial', 'Big Island', 'Multi-zone Fujitsu system', 'Client-approved quote needed before publishing.'],
];
foreach ($examples as $index => [$title, $island, $system, $quote]) {
  $node = ilf_p5_node_by_title('customer_testimonial', $title) ?: Node::create(['type' => 'customer_testimonial']);
  $node->setTitle($title);
  $node->setUnpublished();
  $node->set('field_island', $island);
  $node->set('field_system_installed', $system);
  $node->set('field_testimonial_quote', $quote);
  $node->set('field_sort_order', ($index + 1) * 10);
  $node->save();
}

echo "Phase 5 authority and funnel content created.\n";

function ilf_p5_page(string $title, string $alias, string $body): void {
  $node = ilf_p5_node_by_title('page', $title) ?: Node::create(['type' => 'page']);
  $node->setTitle($title);
  $node->setPublished(TRUE);
  $node->set('body', ['value' => $body, 'format' => 'full_html']);
  $node->set('path', ['alias' => $alias, 'pathauto' => 0]);
  $node->save();
}

function ilf_p5_node_by_title(string $bundle, string $title): ?Node {
  $ids = \Drupal::entityQuery('node')
    ->accessCheck(FALSE)
    ->condition('type', $bundle)
    ->condition('title', $title)
    ->range(0, 1)
    ->execute();
  return $ids ? Node::load(reset($ids)) : NULL;
}

function ilf_p5_standardize_ctas(): void {
  $replacements = [
    '/find-a-contractor' => '/find-a-fujitsu-contractor',
    'Find a Fujitsu Contractor' => 'Find a Fujitsu Dealer',
    'Find Fujitsu contractor support' => 'Find a Fujitsu Dealer',
    'Find Fujitsu support' => 'Find a Fujitsu Dealer',
    'Find local Fujitsu support' => 'Find a Fujitsu Dealer',
    'Find a contractor' => 'Find a Fujitsu Dealer',
    'Find a Contractor' => 'Find a Fujitsu Dealer',
    'Compare Fujitsu Products' => 'Explore Fujitsu Products',
    'Compare Fujitsu products' => 'Explore Fujitsu Products',
    'View Product PDFs' => 'Explore Fujitsu Products',
    'Browse Fujitsu PDFs' => 'Explore Fujitsu Products',
  ];
  $ids = \Drupal::entityQuery('node')
    ->accessCheck(FALSE)
    ->exists('body.value')
    ->execute();
  foreach ($ids as $id) {
    $node = Node::load($id);
    if (!$node || !$node->hasField('body') || $node->body->isEmpty()) {
      continue;
    }
    $body = $node->body->value;
    $updated = strtr($body, $replacements);
    if ($updated !== $body) {
      $node->set('body', ['value' => $updated, 'format' => $node->body->format ?: 'full_html']);
      $node->save();
    }
  }
}

function ilf_p5_field(string $entity_type, string $bundle, string $field_name, string $label, string $type, array $storage_settings = [], array $field_settings = [], int $cardinality = 1, bool $required = FALSE, string $description = ''): void {
  if (!FieldStorageConfig::loadByName($entity_type, $field_name)) {
    FieldStorageConfig::create([
      'entity_type' => $entity_type,
      'field_name' => $field_name,
      'type' => $type,
      'settings' => $storage_settings,
      'cardinality' => $cardinality,
    ])->save();
  }
  $field = FieldConfig::loadByName($entity_type, $bundle, $field_name) ?: FieldConfig::create([
    'entity_type' => $entity_type,
    'bundle' => $bundle,
    'field_name' => $field_name,
  ]);
  $field->setLabel($label);
  $field->setDescription($description);
  $field->setRequired($required);
  $field->setSettings($field_settings + $field->getSettings());
  $field->save();
}

function ilf_p5_menu_link(string $menu, string $title, string $uri, int $weight): void {
  $ids = \Drupal::entityQuery('menu_link_content')
    ->accessCheck(FALSE)
    ->condition('menu_name', $menu)
    ->condition('title', $title)
    ->range(0, 1)
    ->execute();
  $link = $ids ? MenuLinkContent::load(reset($ids)) : MenuLinkContent::create(['menu_name' => $menu]);
  $link->set('title', $title);
  $link->set('link', ['uri' => $uri]);
  $link->set('weight', $weight);
  $link->set('enabled', TRUE);
  $link->save();
}

function ilf_p5_view_testimonials(): void {
  $view = View::load('customer_testimonials') ?: View::create(['id' => 'customer_testimonials']);
  $view->set('label', 'Customer Testimonials');
  $view->set('base_table', 'node_field_data');
  $view->set('base_field', 'nid');
  $view->set('core', '10.x');
  $view->set('dependencies', [
    'config' => [
      'core.entity_view_mode.node.teaser',
      'node.type.customer_testimonial',
    ],
    'module' => [
      'node',
      'user',
    ],
  ]);
  $view->set('display', [
    'default' => [
      'display_plugin' => 'default',
      'id' => 'default',
      'display_title' => 'Default',
      'position' => 0,
      'display_options' => [
        'title' => 'Customer Testimonials',
        'fields' => [],
        'style' => ['type' => 'default'],
        'row' => ['type' => 'entity:node', 'options' => ['view_mode' => 'teaser']],
        'pager' => ['type' => 'some', 'options' => ['items_per_page' => 6, 'offset' => 0]],
        'access' => ['type' => 'perm', 'options' => ['perm' => 'access content']],
        'cache' => ['type' => 'tag'],
        'filters' => [
          'status' => [
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
          ],
          'type' => [
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
            'value' => ['customer_testimonial' => 'customer_testimonial'],
            'group' => 1,
            'exposed' => FALSE,
          ],
        ],
        'filter_groups' => ['operator' => 'AND', 'groups' => [1 => 'AND']],
        'sorts' => [
          'field_sort_order_value' => ['id' => 'field_sort_order_value', 'table' => 'node__field_sort_order', 'field' => 'field_sort_order_value', 'order' => 'ASC'],
          'created' => ['id' => 'created', 'table' => 'node_field_data', 'field' => 'created', 'order' => 'DESC'],
        ],
        'query' => ['type' => 'views_query'],
        'display_extenders' => [],
      ],
    ],
    'block_1' => [
      'display_plugin' => 'block',
      'id' => 'block_1',
      'display_title' => 'Block',
      'position' => 1,
      'display_options' => ['block_description' => 'Customer Testimonials'],
    ],
  ]);
  $view->save();
}
