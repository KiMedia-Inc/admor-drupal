<?php

declare(strict_types=1);

use Drupal\contact\Entity\ContactForm;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\node\Entity\Node;

function ilf_phase2_field_storage(string $entity_type, string $field_name, string $type, array $settings = [], int $cardinality = 1): void {
  if (!FieldStorageConfig::loadByName($entity_type, $field_name)) {
    FieldStorageConfig::create([
      'entity_type' => $entity_type,
      'field_name' => $field_name,
      'type' => $type,
      'settings' => $settings,
      'cardinality' => $cardinality,
    ])->save();
  }
}

function ilf_phase2_field(string $entity_type, string $bundle, string $field_name, string $label, string $type, array $storage_settings = [], array $field_settings = [], string $description = ''): void {
  ilf_phase2_field_storage($entity_type, $field_name, $type, $storage_settings);
  $field = FieldConfig::loadByName($entity_type, $bundle, $field_name) ?: FieldConfig::create([
    'entity_type' => $entity_type,
    'bundle' => $bundle,
    'field_name' => $field_name,
  ]);
  $field->setLabel($label);
  $field->setDescription($description);
  $field->setSettings($field_settings + $field->getSettings());
  $field->save();
}

function ilf_phase2_contact_form(string $id, string $label, string $message): void {
  $form = ContactForm::load($id) ?: ContactForm::create(['id' => $id]);
  $site_mail = \Drupal::config('system.site')->get('mail') ?: 'info@ilovemyfujitsu.com';
  $form->set('label', $label);
  $form->set('recipients', [$site_mail]);
  $form->set('message', $message);
  $form->set('reply', '');
  $form->set('redirect', '');
  $form->save();

  ilf_phase2_field('contact_message', $id, 'field_phone', 'Phone', 'string', ['max_length' => 80], [], 'Best contact phone number.');
  ilf_phase2_field('contact_message', $id, 'field_island', 'Island', 'list_string', [
    'allowed_values' => [
      'oahu' => 'Oahu',
      'kauai' => 'Kauai',
      'big_island' => 'Big Island',
      'maui' => 'Maui',
    ],
  ], [], 'Choose the island this message is about.');

  $display = \Drupal::entityTypeManager()->getStorage('entity_form_display')->load("contact_message.$id.default")
    ?: \Drupal::entityTypeManager()->getStorage('entity_form_display')->create([
      'targetEntityType' => 'contact_message',
      'bundle' => $id,
      'mode' => 'default',
      'status' => TRUE,
    ]);
  $display->setComponent('name', ['type' => 'string_textfield', 'weight' => 0]);
  $display->setComponent('mail', ['type' => 'email_default', 'weight' => 1]);
  $display->setComponent('field_phone', ['type' => 'string_textfield', 'weight' => 2]);
  $display->setComponent('field_island', ['type' => 'options_select', 'weight' => 3]);
  $display->setComponent('subject', ['type' => 'string_textfield', 'weight' => 4]);
  $display->setComponent('message', ['type' => 'string_textarea', 'weight' => 5]);
  $display->save();
}

ilf_phase2_contact_form('admor_hvac', 'Contact Admor HVAC', 'Mahalo! We’ll be in touch soon.');
ilf_phase2_contact_form('athletics_application', 'I Love My Fujitsu Athletics Application', 'Mahalo! We’ll be in touch soon.');

if (\Drupal::moduleHandler()->moduleExists('honeypot')) {
  $settings = \Drupal::configFactory()->getEditable('honeypot.settings');
  $form_settings = $settings->get('form_settings') ?: [];
  $form_settings['admor_hvac_contact_message_form'] = TRUE;
  $form_settings['athletics_application_contact_message_form'] = TRUE;
  $settings->set('form_settings', $form_settings)->set('protect_all_forms', FALSE)->set('time_limit', 5)->save();
}

function ilf_phase2_node_by_title(string $bundle, string $title): ?Node {
  $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => $bundle, 'title' => $title]);
  return $nodes ? reset($nodes) : NULL;
}

// Conversion-focused page cleanup.
$updates = [
  'Fujitsu Products' => [
    'alias' => '/products-overview',
    'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Fujitsu product library</p><h2>Find the Fujitsu system documents buyers and contractors ask for most.</h2><p>All working product PDFs from the live Products page are now managed as Drupal resources. Use the product catalog view to filter by catalog type, technical guide, rebate, or system family.</p></section><div class="ilf-card-grid ilf-card-grid--three"><article><h3>Residential comfort</h3><p>Consumer brochures, mini-split overviews, multi-zone brochures, and product sell sheets for Hawaii homes and condos.</p><a class="btn-main" href="/products">Browse products</a></article><article><h3>Commercial systems</h3><p>AIRSTAGE catalogs and commercial product documents for offices, hospitality, retail, and developer projects.</p><a class="btn-main" href="/resources/2021-fujitsu-airstage-full-line-catalog">AIRSTAGE catalog</a></article><article><h3>Technical support</h3><p>Troubleshooting and service PDFs are preserved locally for contractor and service team access.</p><a class="btn-main" href="/tech-tips">Tech tips</a></article></div>',
  ],
  'I Love My Fujitsu Athletics Application' => [
    'alias' => '/i-love-my-fujitsu-athletics-application',
    'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Community application</p><h2>I Love My Fujitsu Athletics Application</h2><p>Use the Drupal-managed application form to contact the Fujitsu Hawaii team about athletics, school, and community opportunities.</p><a class="btn-main" href="/contact/athletics_application">Open application form</a></section>',
  ],
  'Locate a Fujitsu Contractor' => [
    'alias' => '/locate-a-fujitsu-contractor',
    'body' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Contractor locator</p><h2>Find a Fujitsu Contractor Near You</h2><p>Choose Fujitsu before the estimate is written. A Fujitsu-focused contractor can help match the right ductless, multi-zone, or commercial system to your Hawaii property.</p><a class="btn-main" href="/find-a-dealer">Find by island</a></section>',
  ],
];
foreach ($updates as $title => $data) {
  if ($node = ilf_phase2_node_by_title('page', $title)) {
    $node->set('body', ['value' => $data['body'], 'format' => 'full_html']);
    $node->set('path', ['alias' => $data['alias']]);
    $node->save();
  }
}

// Dedicated Contact Admor page.
$contact = ilf_phase2_node_by_title('page', 'Contact Admor HVAC') ?: Node::create(['type' => 'page']);
$contact->setTitle('Contact Admor HVAC');
$contact->set('status', 1);
$contact->set('body', [
  'value' => '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Contact</p><h2>Contact Admor HVAC</h2><p>Questions about Fujitsu distribution, local support, product availability, or contractor resources? Send a message and the team will follow up.</p><a class="btn-main" href="/contact/admor_hvac">Open contact form</a></section>',
  'format' => 'full_html',
]);
$contact->set('path', ['alias' => '/contact-admor-hvac']);
$contact->save();

// Better dealer region copy.
$dealer_copy = [
  'Oahu Dealers' => 'Find Fujitsu contractor support across Honolulu, Windward Oahu, Central Oahu, Leeward Oahu, and the North Shore. Ask your installer to quote Fujitsu first so comfort, warranty, efficiency, and local support are part of the conversation from the start.',
  'Kauai Dealers' => 'Connect with Fujitsu-focused support for Kauai homes, vacation properties, small businesses, and replacement projects. Ductless and multi-zone Fujitsu systems are a strong fit for quiet island comfort.',
  'Big Island Dealers' => 'Find Fujitsu contractor support for Kona, Hilo, Waimea, Puna, and surrounding Hawaii Island communities. Local product access and branch support help contractors keep Fujitsu projects moving.',
  'Maui Dealers' => 'Find Maui Fujitsu support for homes, condos, hospitality spaces, offices, and light commercial projects. Ask for Fujitsu by name before comparing other AC brands.',
];
foreach ($dealer_copy as $title => $copy) {
  if ($node = ilf_phase2_node_by_title('dealer_region', $title)) {
    $node->set('body', ['value' => '<p>' . $copy . '</p>', 'format' => 'full_html']);
    $node->save();
  }
}

// Fix source typos and normalize titles.
$title_fixes = [
  "Fujitsu General's ProCore High Corrosion-Resistant Techonology" => "Fujitsu General's ProCore High Corrosion-Resistant Technology",
  'Fujitsu 410A Mni Split Troubleshooting Guide' => 'Fujitsu 410A Mini-Split Troubleshooting Guide',
];
foreach ($title_fixes as $old => $new) {
  foreach (['news_update', 'resource_brochure'] as $bundle) {
    if ($node = ilf_phase2_node_by_title($bundle, $old)) {
      $node->setTitle($new);
      if ($node->hasField('field_summary') && !$node->get('field_summary')->isEmpty()) {
        $node->set('field_summary', str_replace(['Techonology', 'Mni Split'], ['Technology', 'Mini-Split'], $node->get('field_summary')->value));
      }
      $node->set('body', ['value' => str_replace(['Techonology', 'Mni Split'], ['Technology', 'Mini-Split'], $node->body->value ?? ''), 'format' => 'full_html']);
      $node->save();
    }
  }
}

// Product Resources exposed filters/search.
if ($view = \Drupal\views\Entity\View::load('product_resources')) {
  $display = $view->get('display');
  $filters = $display['default']['display_options']['filters'] ?? [];
  $filters['title'] = [
    'id' => 'title',
    'table' => 'node_field_data',
    'field' => 'title',
    'relationship' => 'none',
    'group_type' => 'group',
    'admin_label' => '',
    'entity_type' => 'node',
    'entity_field' => 'title',
    'plugin_id' => 'string',
    'operator' => 'contains',
    'value' => '',
    'group' => 1,
    'exposed' => TRUE,
    'expose' => [
      'operator_id' => 'title_op',
      'label' => 'Search resources',
      'description' => '',
      'use_operator' => FALSE,
      'operator' => 'title_op',
      'identifier' => 'search',
      'required' => FALSE,
      'remember' => FALSE,
      'multiple' => FALSE,
    ],
  ];
  $display['default']['display_options']['filters'] = $filters;
  $display['default']['display_options']['exposed_form'] = ['type' => 'basic', 'options' => ['submit_button' => 'Apply', 'reset_button' => TRUE, 'reset_button_label' => 'Reset']];
  $display['default']['display_options']['sorts'] = [
    'field_resource_category_target_id' => ['id' => 'field_resource_category_target_id', 'table' => 'node__field_resource_category', 'field' => 'field_resource_category_target_id', 'order' => 'ASC', 'plugin_id' => 'standard'],
    'field_sort_order_value' => ['id' => 'field_sort_order_value', 'table' => 'node__field_sort_order', 'field' => 'field_sort_order_value', 'order' => 'ASC'],
    'title' => ['id' => 'title', 'table' => 'node_field_data', 'field' => 'title', 'order' => 'ASC'],
  ];
  $view->set('display', $display);
  $view->save();
}

// SEO and Open Graph defaults.
if (\Drupal::moduleHandler()->moduleExists('metatag')) {
  $front = \Drupal::configFactory()->getEditable('metatag.metatag_defaults.front');
  if (!$front->isNew()) {
    $front
      ->set('tags.title', 'I Love My Fujitsu | Fujitsu Air Conditioning Hawaii')
      ->set('tags.description', 'Discover Fujitsu air conditioning systems, rebates, local dealers, product brochures, commercials, and Hawaii contractor resources from I Love My Fujitsu.')
      ->set('tags.og_site_name', 'I Love My Fujitsu')
      ->set('tags.og_title', 'I Love My Fujitsu | Fujitsu Air Conditioning Hawaii')
      ->set('tags.og_description', 'Fujitsu air conditioning systems, rebates, local dealers, product brochures, commercials, and Hawaii contractor resources.')
      ->set('tags.og_type', 'website')
      ->save();
  }
  $global = \Drupal::configFactory()->getEditable('metatag.metatag_defaults.global');
  if (!$global->isNew()) {
    $global
      ->set('tags.og_site_name', 'I Love My Fujitsu')
      ->set('tags.og_type', 'website')
      ->set('tags.description', '[node:summary]')
      ->save();
  }
}

echo "Phase 2 polish and functionality script complete.\n";
