<?php

declare(strict_types=1);

use Drupal\block_content\Entity\BlockContent;
use Drupal\block_content\Entity\BlockContentType;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;
use Drupal\taxonomy\Entity\Term;
use Drupal\taxonomy\Entity\Vocabulary;
use Drupal\views\Entity\View;

$entity_type_manager = \Drupal::entityTypeManager();

function ilf_cms_slug(string $value): string {
  $value = strtolower($value);
  $value = str_replace(['&', '+', '/'], [' and ', ' and ', ' '], $value);
  $value = preg_replace('/[^a-z0-9]+/', '-', $value) ?? $value;
  return trim($value, '-');
}

function ilf_cms_node_type(string $id, string $label, string $description = ''): void {
  $type = NodeType::load($id) ?: NodeType::create(['type' => $id]);
  $type->set('name', $label);
  $type->set('description', $description);
  $type->set('new_revision', TRUE);
  $type->save();
}

function ilf_cms_vocab(string $id, string $label, array $terms): void {
  $vocab = Vocabulary::load($id) ?: Vocabulary::create(['vid' => $id]);
  $vocab->set('name', $label);
  $vocab->save();

  foreach ($terms as $weight => $name) {
    $existing = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties([
      'vid' => $id,
      'name' => $name,
    ]);
    $term = $existing ? reset($existing) : Term::create(['vid' => $id, 'name' => $name]);
    $term->setWeight($weight);
    $term->save();
  }
}

function ilf_cms_field_storage(string $entity_type, string $field_name, string $type, array $settings = [], int $cardinality = 1): void {
  if (FieldStorageConfig::loadByName($entity_type, $field_name)) {
    return;
  }
  FieldStorageConfig::create([
    'entity_type' => $entity_type,
    'field_name' => $field_name,
    'type' => $type,
    'settings' => $settings,
    'cardinality' => $cardinality,
  ])->save();
}

function ilf_cms_field(string $entity_type, string $bundle, string $field_name, string $label, string $type, array $storage_settings = [], array $field_settings = [], int $cardinality = 1, bool $required = FALSE, string $description = ''): void {
  ilf_cms_field_storage($entity_type, $field_name, $type, $storage_settings, $cardinality);
  if ($field = FieldConfig::loadByName($entity_type, $bundle, $field_name)) {
    $field->setLabel($label);
    $field->setDescription($description);
    $field->setRequired($required);
    $field->setSettings($field_settings + $field->getSettings());
    $field->save();
    return;
  }
  FieldConfig::create([
    'entity_type' => $entity_type,
    'bundle' => $bundle,
    'field_name' => $field_name,
    'label' => $label,
    'description' => $description,
    'required' => $required,
    'settings' => $field_settings,
  ])->save();
}

function ilf_cms_term_target(string $vocabulary): array {
  return ['target_type' => 'taxonomy_term'];
}

function ilf_cms_term_field_settings(string $vocabulary): array {
  return [
    'handler' => 'default:taxonomy_term',
    'handler_settings' => ['target_bundles' => [$vocabulary => $vocabulary]],
  ];
}

function ilf_cms_configure_displays(string $bundle, array $fields): void {
  $form = \Drupal::entityTypeManager()->getStorage('entity_form_display')->load("node.$bundle.default")
    ?: \Drupal::entityTypeManager()->getStorage('entity_form_display')->create([
      'targetEntityType' => 'node',
      'bundle' => $bundle,
      'mode' => 'default',
      'status' => TRUE,
    ]);
  $view = \Drupal::entityTypeManager()->getStorage('entity_view_display')->load("node.$bundle.default")
    ?: \Drupal::entityTypeManager()->getStorage('entity_view_display')->create([
      'targetEntityType' => 'node',
      'bundle' => $bundle,
      'mode' => 'default',
      'status' => TRUE,
    ]);

  $weight = 0;
  foreach ($fields as $field_name => $component) {
    $form->setComponent($field_name, ['type' => $component['form'] ?? 'string_textfield', 'weight' => $weight] + ($component['form_settings'] ?? []));
    $view->setComponent($field_name, ['type' => $component['view'] ?? 'string', 'label' => 'above', 'weight' => $weight] + ($component['view_settings'] ?? []));
    $weight++;
  }
  $form->save();
  $view->save();
}

function ilf_cms_public_file_from_path(string $source, string $directory, string $filename): ?File {
  if (!is_file($source)) {
    return NULL;
  }
  \Drupal::service('file_system')->prepareDirectory($directory, \Drupal\Core\File\FileSystemInterface::CREATE_DIRECTORY);
  $destination = $directory . '/' . $filename;
  $real_destination = \Drupal::service('file_system')->realpath($directory) . '/' . $filename;
  copy($source, $real_destination);
  $existing = \Drupal::entityTypeManager()->getStorage('file')->loadByProperties(['uri' => $destination]);
  $file = $existing ? reset($existing) : File::create(['uri' => $destination]);
  $file->setFilename($filename);
  $file->setPermanent();
  $file->save();
  return $file;
}

function ilf_cms_file_by_uri(string $uri): ?File {
  $existing = \Drupal::entityTypeManager()->getStorage('file')->loadByProperties(['uri' => $uri]);
  return $existing ? reset($existing) : NULL;
}

function ilf_cms_term_id(string $vid, string $name): ?int {
  $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['vid' => $vid, 'name' => $name]);
  $term = $terms ? reset($terms) : NULL;
  return $term ? (int) $term->id() : NULL;
}

function ilf_cms_node_by_title(string $bundle, string $title): ?Node {
  $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => $bundle, 'title' => $title]);
  return $nodes ? reset($nodes) : NULL;
}

function ilf_cms_save_node(string $bundle, string $title, array $values): Node {
  $node = ilf_cms_node_by_title($bundle, $title) ?: Node::create(['type' => $bundle]);
  $node->setTitle($title);
  $node->set('status', $values['status'] ?? 1);
  unset($values['status']);
  foreach ($values as $field => $value) {
    if ($node->hasField($field)) {
      $node->set($field, $value);
    }
  }
  $node->save();
  return $node;
}

// Taxonomy.
ilf_cms_vocab('resource_type', 'Resource Type', [
  'Full Line Catalogs',
  'Consumer Brochures',
  'Mini-Split Systems',
  'Multi-Zone Systems',
  'Airstage / Commercial',
  'Technical Guides',
  'Rebates',
  'Warranty',
]);
ilf_cms_vocab('news_category', 'News Category', [
  'Updates',
  'Community',
  'Rebates',
  'Warranty',
  'Contractor Support',
  'Commercial',
  'Technical Tips',
]);
ilf_cms_vocab('island_region', 'Island / Region', ['Oahu', 'Kauai', 'Big Island', 'Maui']);
ilf_cms_vocab('audience', 'Audience', ['Homeowners', 'Contractors', 'Commercial', 'Residential']);

// Content types.
ilf_cms_node_type('homepage_slide', 'Homepage Slide', 'Drupal-managed homepage hero slides.');
ilf_cms_node_type('resource_brochure', 'Product / Brochure Resource', 'PDFs, brochures, product sheets, rebates, and external Fujitsu resources.');
ilf_cms_node_type('news_update', 'Update / News Article', 'News, local updates, rebates, community stories, and announcements.');
ilf_cms_node_type('commercial_video', 'Commercial / Video', 'Fujitsu commercials and video assets.');
ilf_cms_node_type('face_profile', 'Fujitsu Face / Ambassador', 'Faces of Fujitsu profiles and local ambassadors.');
ilf_cms_node_type('dealer_region', 'Dealer / Contractor Region', 'Island or region landing cards for contractor/dealer lookup.');
ilf_cms_node_type('branch_location', 'Branch / Location', 'Admor/Fujitsu branch and location information.');
ilf_cms_node_type('donation_cause', 'Donation / Cause', 'Donation and community-cause CTA cards.');

// Body/description fields for custom editorial bundles. Drupal only adds these
// automatically during UI creation, so the script creates them explicitly.
foreach ([
  'homepage_slide' => 'Administrative notes',
  'dealer_region' => 'Description',
  'branch_location' => 'Description',
  'donation_cause' => 'Description',
] as $bundle => $label) {
  ilf_cms_field('node', $bundle, 'body', $label, 'text_with_summary', [], [], 1, FALSE, 'Main editable text for this content item.');
}

$image_settings = [
  'file_extensions' => 'png jpg jpeg webp',
  'alt_field' => TRUE,
  'alt_field_required' => FALSE,
  'title_field' => FALSE,
];
$pdf_settings = ['file_extensions' => 'pdf', 'description_field' => TRUE];

// Fields: Homepage Slide.
ilf_cms_field('node', 'homepage_slide', 'field_subtitle', 'Subtitle / caption', 'text_long', [], [], 1, FALSE, 'Short slide caption displayed below the title.');
ilf_cms_field('node', 'homepage_slide', 'field_slide_image', 'Slide image', 'image', [], $image_settings, 1, TRUE, 'Upload the main hero image for this slide.');
ilf_cms_field('node', 'homepage_slide', 'field_link', 'Link URL', 'link', [], ['link_type' => 17, 'title' => 0], 1, FALSE, 'Where this slide should send visitors.');
ilf_cms_field('node', 'homepage_slide', 'field_link_text', 'Link text', 'string', ['max_length' => 120], [], 1, FALSE, 'Button label, for example Watch now or Learn more.');
ilf_cms_field('node', 'homepage_slide', 'field_sort_order', 'Sort order', 'integer', [], [], 1, FALSE, 'Lower numbers appear first.');

// Fields: Product / Brochure Resource.
ilf_cms_field('node', 'resource_brochure', 'field_resource_category', 'Resource type', 'entity_reference', ilf_cms_term_target('resource_type'), ilf_cms_term_field_settings('resource_type'), 1, FALSE, 'Choose the admin-managed resource category.');
ilf_cms_field('node', 'resource_brochure', 'field_thumbnail', 'Thumbnail image', 'image', [], $image_settings, 1, FALSE, 'Optional preview image for cards.');
ilf_cms_field('node', 'resource_brochure', 'field_year', 'Year', 'integer', [], [], 1, FALSE, 'Publication or catalog year.');
ilf_cms_field('node', 'resource_brochure', 'field_featured', 'Featured', 'boolean', [], ['on_label' => 'Featured', 'off_label' => 'Not featured'], 1, FALSE, 'Use for homepage or priority placement.');
ilf_cms_field('node', 'resource_brochure', 'field_sort_order', 'Sort order', 'integer', [], [], 1, FALSE, 'Lower numbers appear first.');

// Fields: News.
ilf_cms_field('node', 'news_update', 'field_date', 'Date', 'datetime', ['datetime_type' => 'date'], [], 1, FALSE, 'Displayed article date.');
ilf_cms_field('node', 'news_update', 'field_category', 'Category', 'entity_reference', ilf_cms_term_target('news_category'), ilf_cms_term_field_settings('news_category'), 1, FALSE, 'Editorial category.');
ilf_cms_field('node', 'news_update', 'field_related_files', 'Related files', 'file', [], $pdf_settings, -1, FALSE, 'Optional PDFs or documents attached to the article.');

// Fields: Commercial.
ilf_cms_field('node', 'commercial_video', 'field_year', 'Year', 'integer', [], [], 1, FALSE, 'Video year when known.');
ilf_cms_field('node', 'commercial_video', 'field_featured', 'Featured', 'boolean', [], ['on_label' => 'Featured', 'off_label' => 'Not featured'], 1, FALSE, 'Use for homepage promotion.');
ilf_cms_field('node', 'commercial_video', 'field_sort_order', 'Sort order', 'integer', [], [], 1, FALSE, 'Lower numbers appear first.');

// Fields: Face.
ilf_cms_field('node', 'face_profile', 'field_related_video_url', 'Related video URL', 'link', [], ['link_type' => 17, 'title' => 0], 1, FALSE, 'Optional commercial or interview URL.');
ilf_cms_field('node', 'face_profile', 'field_sort_order', 'Sort order', 'integer', [], [], 1, FALSE, 'Lower numbers appear first.');
ilf_cms_field('node', 'face_profile', 'field_featured', 'Featured', 'boolean', [], ['on_label' => 'Featured', 'off_label' => 'Not featured'], 1, FALSE, 'Use for homepage Faces section.');

// Fields: Dealer Region.
ilf_cms_field('node', 'dealer_region', 'field_island_region', 'Island', 'entity_reference', ilf_cms_term_target('island_region'), ilf_cms_term_field_settings('island_region'), 1, FALSE, 'Choose the island this dealer locator region belongs to.');
ilf_cms_field('node', 'dealer_region', 'field_dealer_locator_url', 'Dealer locator URL', 'link', [], ['link_type' => 17, 'title' => 0], 1, FALSE, 'Fujitsu locator or region-specific destination.');
ilf_cms_field('node', 'dealer_region', 'field_cta_text', 'CTA text', 'string', ['max_length' => 160], [], 1, FALSE, 'Button label for this region.');
ilf_cms_field('node', 'dealer_region', 'field_sort_order', 'Sort order', 'integer', [], [], 1, FALSE, 'Lower numbers appear first.');

// Fields: Branch Location.
ilf_cms_field('node', 'branch_location', 'field_island_region', 'Island', 'entity_reference', ilf_cms_term_target('island_region'), ilf_cms_term_field_settings('island_region'), 1, FALSE, 'Choose the island this branch serves.');
ilf_cms_field('node', 'branch_location', 'field_address', 'Address', 'text_long', [], [], 1, FALSE, 'Street address and mailing details.');
ilf_cms_field('node', 'branch_location', 'field_phone', 'Phone', 'string', ['max_length' => 80], [], 1, FALSE, 'Primary phone number.');
ilf_cms_field('node', 'branch_location', 'field_fax', 'Fax', 'string', ['max_length' => 80], [], 1, FALSE, 'Fax number.');
ilf_cms_field('node', 'branch_location', 'field_email', 'Email', 'email', [], [], 1, FALSE, 'Branch email if available.');
ilf_cms_field('node', 'branch_location', 'field_image', 'Image', 'image', [], $image_settings, 1, FALSE, 'Branch or showroom image.');
ilf_cms_field('node', 'branch_location', 'field_google_maps_url', 'Google Maps URL', 'link', [], ['link_type' => 17, 'title' => 0], 1, FALSE, 'Map destination.');
ilf_cms_field('node', 'branch_location', 'field_sort_order', 'Sort order', 'integer', [], [], 1, FALSE, 'Lower numbers appear first.');

// Fields: Donation Cause.
ilf_cms_field('node', 'donation_cause', 'field_logo_image', 'Logo/button image', 'image', [], $image_settings, 1, FALSE, 'Logo or donation button image.');
ilf_cms_field('node', 'donation_cause', 'field_donation_url', 'Donation URL', 'link', [], ['link_type' => 17, 'title' => 0], 1, FALSE, 'Donation or cause website.');
ilf_cms_field('node', 'donation_cause', 'field_sort_order', 'Sort order', 'integer', [], [], 1, FALSE, 'Lower numbers appear first.');

// Admin/form display order.
ilf_cms_configure_displays('homepage_slide', [
  'title' => ['form' => 'string_textfield'],
  'field_subtitle' => ['form' => 'text_textarea'],
  'field_slide_image' => ['form' => 'image_image'],
  'field_link' => ['form' => 'link_default'],
  'field_link_text' => ['form' => 'string_textfield'],
  'field_sort_order' => ['form' => 'number'],
]);
ilf_cms_configure_displays('resource_brochure', [
  'title' => ['form' => 'string_textfield'],
  'field_resource_category' => ['form' => 'options_select'],
  'field_thumbnail' => ['form' => 'image_image'],
  'field_resource_file' => ['form' => 'file_generic'],
  'field_resource_link' => ['form' => 'link_default'],
  'body' => ['form' => 'text_textarea_with_summary'],
  'field_year' => ['form' => 'number'],
  'field_featured' => ['form' => 'boolean_checkbox'],
  'field_sort_order' => ['form' => 'number'],
]);
ilf_cms_configure_displays('news_update', [
  'title' => ['form' => 'string_textfield'],
  'field_featured_image' => ['form' => 'image_image'],
  'field_date' => ['form' => 'datetime_default'],
  'field_summary' => ['form' => 'text_textarea'],
  'body' => ['form' => 'text_textarea_with_summary'],
  'field_category' => ['form' => 'options_select'],
  'field_related_files' => ['form' => 'file_generic'],
  'field_external_link' => ['form' => 'link_default'],
]);
ilf_cms_configure_displays('commercial_video', [
  'title' => ['form' => 'string_textfield'],
  'field_thumbnail' => ['form' => 'image_image'],
  'field_video_url' => ['form' => 'link_default'],
  'field_summary' => ['form' => 'text_textarea'],
  'body' => ['form' => 'text_textarea_with_summary'],
  'field_year' => ['form' => 'number'],
  'field_featured' => ['form' => 'boolean_checkbox'],
  'field_sort_order' => ['form' => 'number'],
]);
ilf_cms_configure_displays('face_profile', [
  'title' => ['form' => 'string_textfield'],
  'field_profile_image' => ['form' => 'image_image'],
  'field_summary' => ['form' => 'text_textarea'],
  'body' => ['form' => 'text_textarea_with_summary'],
  'field_role' => ['form' => 'string_textfield'],
  'field_related_video_url' => ['form' => 'link_default'],
  'field_sort_order' => ['form' => 'number'],
  'field_featured' => ['form' => 'boolean_checkbox'],
]);
ilf_cms_configure_displays('dealer_region', [
  'title' => ['form' => 'string_textfield'],
  'field_island_region' => ['form' => 'options_select'],
  'field_dealer_locator_url' => ['form' => 'link_default'],
  'body' => ['form' => 'text_textarea_with_summary'],
  'field_cta_text' => ['form' => 'string_textfield'],
  'field_sort_order' => ['form' => 'number'],
]);
ilf_cms_configure_displays('branch_location', [
  'title' => ['form' => 'string_textfield'],
  'field_island_region' => ['form' => 'options_select'],
  'field_address' => ['form' => 'text_textarea'],
  'field_phone' => ['form' => 'string_textfield'],
  'field_fax' => ['form' => 'string_textfield'],
  'field_email' => ['form' => 'email_default'],
  'field_image' => ['form' => 'image_image'],
  'field_google_maps_url' => ['form' => 'link_default'],
  'body' => ['form' => 'text_textarea_with_summary'],
  'field_sort_order' => ['form' => 'number'],
]);
ilf_cms_configure_displays('donation_cause', [
  'title' => ['form' => 'string_textfield'],
  'field_logo_image' => ['form' => 'image_image'],
  'field_donation_url' => ['form' => 'link_default'],
  'body' => ['form' => 'text_textarea_with_summary'],
  'field_sort_order' => ['form' => 'number'],
]);

// Custom reusable CTA block content type.
$block_type = BlockContentType::load('fujitsu_cta') ?: BlockContentType::create([
  'id' => 'fujitsu_cta',
  'label' => 'Fujitsu CTA Block',
  'revision' => TRUE,
]);
$block_type->save();
ilf_cms_field('block_content', 'fujitsu_cta', 'field_cta_link', 'CTA link', 'link', [], ['link_type' => 17, 'title' => 0], 1, FALSE, 'Button destination.');
ilf_cms_field('block_content', 'fujitsu_cta', 'field_cta_link_text', 'CTA link text', 'string', ['max_length' => 120], [], 1, FALSE, 'Button text.');
ilf_cms_field('block_content', 'fujitsu_cta', 'field_cta_image', 'CTA image', 'image', [], $image_settings, 1, FALSE, 'Optional image or badge.');
ilf_cms_field('block_content', 'fujitsu_cta', 'field_cta_variant', 'CTA variant', 'list_string', [
  'allowed_values' => [
    'red' => 'Red',
    'light' => 'Light',
    'dark' => 'Dark',
    'footer' => 'Footer',
  ],
], [], 1, FALSE, 'Visual treatment for theme templates.');
ilf_cms_field('block_content', 'fujitsu_cta', 'field_sort_order', 'Sort order', 'integer', [], [], 1, FALSE, 'Lower numbers appear first.');
ilf_cms_field('block_content', 'fujitsu_cta', 'body', 'Body', 'text_with_summary', [], [], 1, FALSE, 'CTA heading and supporting copy.');

// Seed homepage slide images from already imported featured media when possible.
$slides = [
  ['Fujitsu Growing Up Commercial', 'A long-running Fujitsu Hawaii commercial story that keeps the brand familiar across generations.', 'public://commercials/fujitsu-girl-growing-up.jpg', 'internal:/commercials/fujitsu-girl-growing', 'Watch commercial', 10],
  ['KHON2 Business Matters', 'Fujitsu Hawaii and local contractor support featured in KHON2 Business Matters.', 'public://wordpress-featured/fujitsu-hawaii-on-khon2.jpg', 'https://www.khon2.com/news/business-matters/business-matters-admor-hvac-inc-keeps-hawaii-customers-cool-smiling/', 'Watch KHON2 feature', 20],
  ['Mason Kekoa Donation', 'Support the Mason Kekoa Nava Macloves Memorial Scholarship and local student recipients.', 'public://wordpress-featured/mason-kekoa-nava-macloves-memorial-scholarships.jpg', 'https://www.masonkekoa.com/', 'Learn about the scholarship', 30],
  ['12 Year & Gecko Warranty', 'Strong warranty confidence helps Fujitsu stand apart from competing AC brands in Hawaii.', 'public://wordpress-featured/fujitsu-12-year-and-gecko-warranty.png', 'internal:/commercials/fujitsu-12-year-and-gecko-warranty', 'See warranty message', 40],
  ['Hawaii Energy Rebates', 'Rebates can make efficient Fujitsu comfort even easier to choose.', 'public://wordpress-featured/hawaii-energy-rebates.png', 'internal:/resources/hawaii-energy-rebates', 'Review rebates', 50],
  ['Cooling Cancer Donation', 'Fujitsu and CoolingCancer continue to connect local comfort with meaningful community support.', 'public://wordpress-featured/cooling-cancer-donates-70k.png', 'internal:/updates/cooling-cancer-donates-70k', 'Read the update', 60],
  ['Wang’s World of Fujitsu', 'A local Fujitsu video series that keeps the brand memorable and easy to request by name.', 'public://wordpress-featured/wangs-world-of-fujitsu.png', 'internal:/commercials', 'Watch videos', 70],
];

foreach ($slides as [$title, $subtitle, $image_uri, $link, $link_text, $sort]) {
  $file = ilf_cms_file_by_uri($image_uri);
  $values = [
    'field_subtitle' => $subtitle,
    'field_link' => ['uri' => $link, 'title' => $link_text],
    'field_link_text' => $link_text,
    'field_sort_order' => $sort,
    'path' => ['alias' => '/homepage-slides/' . ilf_cms_slug($title)],
  ];
  if ($file) {
    $values['field_slide_image'] = ['target_id' => $file->id(), 'alt' => $title];
  }
  ilf_cms_save_node('homepage_slide', $title, $values);
}

// Seed dealer regions.
$dealer_regions = [
  ['Oahu Dealers', 'Oahu', 'https://contractors.fujitsugeneral.com/locator/HI/Honolulu', 'Find certified Fujitsu contractor support across Honolulu, Windward, Central, Leeward, and North Shore communities.', 'Find Oahu dealers', 10],
  ['Kauai Dealers', 'Kauai', 'https://contractors.fujitsugeneral.com/locator/HI/Kauai', 'Connect with Fujitsu-focused support for Kauai homes, condos, vacation properties, and light commercial needs.', 'Find Kauai dealers', 20],
  ['Big Island Dealers', 'Big Island', 'https://contractors.fujitsugeneral.com/locator/HI/Kailua%20Kona', 'Find Fujitsu contractor support for Hilo, Kona, Waimea, Puna, and surrounding Hawaii Island communities.', 'Find Big Island dealers', 30],
  ['Maui Dealers', 'Maui', 'https://contractors.fujitsugeneral.com/locator/HI/Maui', 'Find Maui Fujitsu contractor support for homes, hospitality, offices, and replacement projects.', 'Find Maui dealers', 40],
];
foreach ($dealer_regions as [$title, $island, $url, $body, $cta, $sort]) {
  ilf_cms_save_node('dealer_region', $title, [
    'field_island_region' => ilf_cms_term_id('island_region', $island),
    'field_dealer_locator_url' => ['uri' => $url, 'title' => $cta],
    'field_cta_text' => $cta,
    'field_sort_order' => $sort,
    'body' => ['value' => '<p>' . htmlspecialchars($body, ENT_QUOTES | ENT_HTML5) . '</p>', 'format' => 'full_html'],
    'path' => ['alias' => '/find-a-dealer/' . ilf_cms_slug($title)],
  ]);
}

// Seed Admor branch / island support cards.
$branches = [
  ['Admor HVAC Oahu Headquarters', 'Oahu', "2928 Kaihikapu Street\nHonolulu, HI 96819", '(808) 570-0300', '', 'https://www.google.com/maps/search/?api=1&query=2928+Kaihikapu+Street+Honolulu+HI+96819', 'The Oahu headquarters supports Fujitsu contractors with local inventory, training, will-call access, and Hawaii-based product support.', 10, '/locations/admor-hvac-oahu-headquarters'],
  ['Admor HVAC Maui Branch', 'Maui', "150 Hana Highway\nKahului, HI 96732", '(808) 446-8900', '(808) 446-8977', 'https://www.google.com/maps/search/?api=1&query=150+Hana+Highway+Kahului+HI+96732', 'The Maui branch gives Valley Isle contractors a local Fujitsu resource for equipment availability, parts, and project support.', 20, '/locations/admor-hvac-maui-branch'],
  ['Admor HVAC Big Island Kona Branch', 'Big Island', "73-4818 Kanalani Street\nKailua Kona, HI 96740", '(808) 731-3778', '(808) 731-3788', 'https://www.google.com/maps/search/?api=1&query=73-4818+Kanalani+Street+Kailua+Kona+HI+96740', 'The Kona branch supports Fujitsu equipment availability, parts, and local contractor needs on Hawaii Island.', 30, '/locations/admor-hvac-big-island-kona-branch'],
  ['Admor HVAC Kauai Contractor Support', 'Kauai', "Kauai contractor support served through Admor Hawaii distribution", '(808) 841-7400', '', 'https://admorhvac.com/contact-us/', 'Kauai contractors and property owners are supported through Admor Hawaii distribution, contractor locator resources, and interisland product support.', 40, '/locations/admor-hvac-kauai-contractor-support'],
];
foreach ($branches as [$title, $island, $address, $phone, $fax, $map, $body, $sort, $alias]) {
  ilf_cms_save_node('branch_location', $title, [
    'field_island_region' => ilf_cms_term_id('island_region', $island),
    'field_address' => $address,
    'field_phone' => $phone,
    'field_fax' => $fax,
    'field_google_maps_url' => ['uri' => $map, 'title' => 'Open map'],
    'field_sort_order' => $sort,
    'body' => ['value' => '<p>' . htmlspecialchars($body, ENT_QUOTES | ENT_HTML5) . '</p>', 'format' => 'full_html'],
    'path' => ['alias' => $alias],
  ]);
}

// Seed donation causes.
$logo = ilf_cms_file_by_uri('public://wordpress-featured/mason-kekoa-nava-macloves-memorial-scholarships.jpg');
ilf_cms_save_node('donation_cause', 'CoolingCancer', [
  'field_donation_url' => ['uri' => 'https://coolingcancer.org/', 'title' => 'Donate to CoolingCancer'],
  'field_sort_order' => 10,
  'body' => ['value' => '<p>CoolingCancer supports cancer research and community giving through Hawaii HVAC industry fundraising.</p>', 'format' => 'full_html'],
  'path' => ['alias' => '/causes/coolingcancer'],
]);
ilf_cms_save_node('donation_cause', 'Mason Kekoa Scholarship', [
  'field_donation_url' => ['uri' => 'https://www.masonkekoa.com/', 'title' => 'Support Mason Kekoa Scholarship'],
  'field_logo_image' => $logo ? ['target_id' => $logo->id(), 'alt' => 'Mason Kekoa Scholarship'] : NULL,
  'field_sort_order' => 20,
  'body' => ['value' => '<p>The Mason Kekoa Nava Macloves Memorial Scholarship supports Hawaii students and keeps Mason’s memory connected to local opportunity.</p>', 'format' => 'full_html'],
  'path' => ['alias' => '/causes/mason-kekoa-scholarship'],
]);

// Assign taxonomy and featured/sort values to migrated content.
$resource_map = [
  'Full Line Brochure' => ['Full Line Catalogs', 2021, TRUE, 10],
  'Consumer Brochure' => ['Consumer Brochures', 2020, TRUE, 20],
  'Consumer Brochure Condensed' => ['Consumer Brochures', 2020, FALSE, 30],
  'Fujitsu 410A Mini-Split Troubleshooting Guide' => ['Technical Guides', 2021, TRUE, 40],
  'Hawaii Energy Rebates' => ['Rebates', 2020, TRUE, 50],
  '2021 Fujitsu Airstage Full Line Catalog' => ['Airstage / Commercial', 2021, TRUE, 60],
];
$ids = \Drupal::entityQuery('node')->condition('type', 'resource_brochure')->accessCheck(FALSE)->execute();
foreach (Node::loadMultiple($ids) as $node) {
  $title = $node->label();
  $category = 'Mini-Split Systems';
  if (str_contains($title, 'Airstage') || str_contains($title, 'AIRSTAGE')) {
    $category = 'Airstage / Commercial';
  }
  elseif (str_contains($title, 'Multi')) {
    $category = 'Multi-Zone Systems';
  }
  elseif (str_contains($title, 'Troubleshooting') || str_contains($title, 'Tech Tip')) {
    $category = 'Technical Guides';
  }
  elseif (str_contains($title, 'Rebate')) {
    $category = 'Rebates';
  }
  elseif (str_contains($title, 'Consumer')) {
    $category = 'Consumer Brochures';
  }
  elseif (str_contains($title, 'Catalog') || str_contains($title, 'Full Line')) {
    $category = 'Full Line Catalogs';
  }
  $year = (int) (preg_match('/20\d{2}/', $title, $match) ? $match[0] : 0);
  $featured = FALSE;
  $sort = 100;
  if (isset($resource_map[$title])) {
    [$category, $year, $featured, $sort] = $resource_map[$title];
  }
  if ($term_id = ilf_cms_term_id('resource_type', $category)) {
    $node->set('field_resource_category', $term_id);
  }
  if ($year) {
    $node->set('field_year', $year);
  }
  $node->set('field_featured', $featured);
  $node->set('field_sort_order', $sort);
  $node->save();
}

$featured_faces = ['Kanoa Leahey', 'Dave Shoji', 'Benny Agbayani', 'Keli Santos'];
$ids = \Drupal::entityQuery('node')->condition('type', 'face_profile')->accessCheck(FALSE)->execute();
$face_weight = 10;
foreach (Node::loadMultiple($ids) as $node) {
  $node->set('field_featured', in_array($node->label(), $featured_faces, TRUE));
  $node->set('field_sort_order', $face_weight);
  $node->save();
  $face_weight += 10;
}

$ids = \Drupal::entityQuery('node')->condition('type', 'commercial_video')->accessCheck(FALSE)->execute();
$video_weight = 10;
foreach (Node::loadMultiple($ids) as $node) {
  $node->set('field_featured', in_array($node->label(), ['Fujitsu Girl Growing Up', 'Fujitsu 12-Year and Gecko Warranty', 'Gym Dog'], TRUE));
  $node->set('field_sort_order', $video_weight);
  $node->save();
  $video_weight += 10;
}

$ids = \Drupal::entityQuery('node')->condition('type', 'news_update')->accessCheck(FALSE)->execute();
foreach (Node::loadMultiple($ids) as $node) {
  if ($node->hasField('field_date') && $node->get('field_date')->isEmpty()) {
    $node->set('field_date', DrupalDateTime::createFromTimestamp((int) $node->getCreatedTime())->format('Y-m-d'));
  }
  $category = str_contains(strtolower($node->label()), 'rebate') ? 'Rebates' : (str_contains(strtolower($node->label()), 'cancer') || str_contains(strtolower($node->label()), 'scholarship') ? 'Community' : 'Updates');
  if ($term_id = ilf_cms_term_id('news_category', $category)) {
    $node->set('field_category', $term_id);
  }
  $node->save();
}

// Reusable CTA blocks.
$blocks = [
  ['Homepage main CTA', 'Fujitsu Air Conditioning Systems for Hawaii Homes & Businesses', 'Ask your contractor for Fujitsu by name, then use the resources on this site to compare options with confidence.', 'internal:/find-a-contractor', 'Find a Fujitsu Contractor', 'red', 10],
  ['Find a Fujitsu Dealer CTA', 'Find a Fujitsu dealer by island', 'Choose your island and connect with certified Fujitsu support.', 'internal:/find-a-dealer', 'Find a dealer', 'light', 20],
  ['Need Help Choosing a System CTA', 'Need help choosing a Fujitsu system?', 'Review brochures, rebates, and product sheets before your contractor conversation.', 'internal:/products', 'Compare products', 'light', 30],
  ['Call Admor HVAC CTA', 'Call Admor HVAC', 'For local Fujitsu distribution support in Hawaii, call (808) 841-7400.', 'tel:8088417400', 'Call (808) 841-7400', 'red', 40],
  ['Footer Contact Info', 'I Love My Fujitsu', 'Helping Hawaii ask for Fujitsu air conditioning by name.', 'internal:/find-a-contractor', 'Find Fujitsu support', 'footer', 50],
  ['Footer Donation Buttons', 'Support local causes', 'CoolingCancer and Mason Kekoa Scholarship keep Fujitsu connected to community impact.', 'internal:/causes/coolingcancer', 'View causes', 'footer', 60],
  ['Instagram Follow CTA', 'Follow Fujitsu Hawaii', 'See local installations, updates, community stories, and Fujitsu comfort across the islands.', 'https://www.instagram.com/ilovemyfujitsu/', 'Follow on Instagram', 'light', 70],
  ['Best of Hawaii Award Trust Badge', 'Best of Hawaii trusted comfort', 'Use trust signals, local recognition, and familiar Fujitsu stories to build confidence before the estimate.', 'internal:/why-fujitsu', 'Why Fujitsu wins', 'light', 80],
  ['Fujitsu Warranty / Rebate Promo Block', 'Warranty and rebate confidence', 'Strong warranty messaging and Hawaii Energy rebate opportunities make Fujitsu easier to choose.', 'internal:/resources/rebates', 'Review rebates', 'red', 90],
];
foreach ($blocks as [$info, $title, $body, $link, $link_text, $variant, $sort]) {
  $existing = \Drupal::entityTypeManager()->getStorage('block_content')->loadByProperties(['info' => $info]);
  $block = $existing ? reset($existing) : BlockContent::create(['type' => 'fujitsu_cta']);
  $block->setInfo($info);
  $block->set('body', ['value' => '<h2>' . htmlspecialchars($title, ENT_QUOTES | ENT_HTML5) . '</h2><p>' . htmlspecialchars($body, ENT_QUOTES | ENT_HTML5) . '</p>', 'format' => 'full_html']);
  $block->set('field_cta_link', ['uri' => $link, 'title' => $link_text]);
  $block->set('field_cta_link_text', $link_text);
  $block->set('field_cta_variant', $variant);
  $block->set('field_sort_order', $sort);
  $block->save();
}

// Move legacy static product overview away from /products so the Product
// Resources View owns the canonical products route.
if ($product_page = ilf_cms_node_by_title('page', 'Fujitsu Products')) {
  $product_page->set('path', ['alias' => '/products-overview']);
  $product_page->save();
  $old_aliases = \Drupal::entityTypeManager()->getStorage('path_alias')->loadByProperties([
    'alias' => '/products',
    'path' => '/node/' . $product_page->id(),
  ]);
  foreach ($old_aliases as $old_alias) {
    $old_alias->delete();
  }
}

// Menus.
function ilf_cms_menu_link(string $menu, string $title, string $uri, int $weight = 0, ?string $parent_title = NULL): void {
  $storage = \Drupal::entityTypeManager()->getStorage('menu_link_content');
  $existing = $storage->loadByProperties(['menu_name' => $menu, 'title' => $title]);
  $link = $existing ? reset($existing) : $storage->create(['bundle' => 'menu_link_content']);
  $parent = '';
  if ($parent_title) {
    $parents = $storage->loadByProperties(['menu_name' => $menu, 'title' => $parent_title]);
    if ($parents) {
      $parent_link = reset($parents);
      $parent = 'menu_link_content:' . $parent_link->uuid();
    }
  }
  $link->set('title', $title);
  $link->set('menu_name', $menu);
  $link->set('link', ['uri' => $uri]);
  $link->set('weight', $weight);
  $link->set('parent', $parent);
  $link->set('enabled', TRUE);
  $link->save();
}

foreach (['main', 'footer'] as $menu_name) {
  $links = \Drupal::entityTypeManager()->getStorage('menu_link_content')->loadByProperties(['menu_name' => $menu_name]);
  foreach ($links as $link) {
    $link->delete();
  }
}
\Drupal::service('menu_link.static.overrides')->saveOverride('standard.front_page', ['enabled' => FALSE]);

$main_links = [
  ['Home', 'internal:/', 0, NULL],
  ['Products', 'internal:/products', 20, NULL],
  ['Commercials', 'internal:/commercials', 30, NULL],
  ['Updates', 'internal:/updates', 40, NULL],
  ['Friends & Family', 'internal:/friends-family', 50, NULL],
  ['Resources', 'internal:/resources', 60, NULL],
  ['Fujitsu Brochures', 'internal:/resources/fujitsu-brochures', 61, 'Resources'],
  ['Full Line Brochure', 'internal:/resources/full-line-brochure', 62, 'Resources'],
  ['Consumer Brochure', 'internal:/resources/consumer-brochure', 63, 'Resources'],
  ['Consumer Brochure Condensed', 'internal:/resources/consumer-brochure-condensed', 64, 'Resources'],
  ['Troubleshooting Guide', 'internal:/resources/troubleshooting-guide', 65, 'Resources'],
  ['Fujitsu General', 'internal:/resources/fujitsu-general', 66, 'Resources'],
  ['Rebates', 'internal:/resources/rebates', 67, 'Resources'],
  ['Fujitsu Videos', 'internal:/resources/fujitsu-videos', 68, 'Resources'],
];
foreach ($main_links as $link) {
  ilf_cms_menu_link('main', ...$link);
}

$footer_links = [
  ['Commercials', 'internal:/commercials', 0, NULL],
  ['Find a Fujitsu Contractor', 'internal:/find-a-contractor', 10, NULL],
  ['Friends & Family', 'internal:/friends-family', 20, NULL],
  ['Athlete Application', 'internal:/i-love-my-fujitsu-athletics-application', 30, NULL],
  ['Locate a Fujitsu Contractor', 'internal:/locate-a-fujitsu-contractor', 40, NULL],
  ['Maintenance Tips', 'internal:/maintenance-tips', 50, NULL],
  ['Oahu Fujitsu Dealers', 'internal:/find-a-dealer/oahu-dealers', 60, NULL],
  ['Products', 'internal:/products', 70, NULL],
  ['Rebates', 'internal:/resources/rebates', 80, NULL],
  ['Resources', 'internal:/resources', 90, NULL],
  ['Tech Tips', 'internal:/tech-tips', 100, NULL],
];
foreach ($footer_links as $link) {
  ilf_cms_menu_link('footer', ...$link);
}

// Views used by the homepage and listing pages.
\Drupal::service('entity_type.bundle.info')->clearCachedBundles();

function ilf_cms_view(string $id, string $label, string $bundle, string $path, string $title, array $sorts = ['field_sort_order_value' => ['id' => 'field_sort_order_value', 'table' => 'node__field_sort_order', 'field' => 'field_sort_order_value', 'order' => 'ASC']]): void {
  $view = View::load($id) ?: View::create(['id' => $id]);
  $view->set('label', $label);
  $view->set('base_table', 'node_field_data');
  $view->set('core', '11.x');
  $display = [
    'default' => [
      'display_plugin' => 'default',
      'id' => 'default',
      'display_title' => 'Default',
      'position' => 0,
      'display_options' => [
        'title' => $title,
        'access' => ['type' => 'perm', 'options' => ['perm' => 'access content']],
        'cache' => ['type' => 'tag'],
        'query' => ['type' => 'views_query'],
        'pager' => ['type' => 'mini', 'options' => ['items_per_page' => 12]],
        'style' => ['type' => 'default'],
        'row' => ['type' => 'entity:node', 'options' => ['view_mode' => 'teaser']],
        'fields' => [],
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
            'value' => [$bundle => $bundle],
            'group' => 1,
            'exposed' => FALSE,
          ],
        ],
        'filter_groups' => [
          'operator' => 'AND',
          'groups' => [1 => 'AND'],
        ],
        'sorts' => $sorts,
      ],
    ],
    'page_1' => [
      'display_plugin' => 'page',
      'id' => 'page_1',
      'display_title' => 'Page',
      'position' => 1,
      'display_options' => [
        'path' => $path,
        'menu' => ['type' => 'none'],
      ],
    ],
    'block_1' => [
      'display_plugin' => 'block',
      'id' => 'block_1',
      'display_title' => 'Block',
      'position' => 2,
      'display_options' => ['block_description' => $label],
    ],
  ];
  $view->set('display', $display);
  $view->save();
}

ilf_cms_view('homepage_slideshow', 'Homepage Slideshow', 'homepage_slide', 'admin/content/homepage-slides-preview', 'Homepage Slideshow');
ilf_cms_view('product_resources', 'Product Resources', 'resource_brochure', 'products', 'Fujitsu Product Catalogs & Brochures');
ilf_cms_view('latest_news', 'Latest News', 'news_update', 'updates', 'Updates / News', [
  'field_date_value' => ['id' => 'field_date_value', 'table' => 'node__field_date', 'field' => 'field_date_value', 'order' => 'DESC'],
  'created' => ['id' => 'created', 'table' => 'node_field_data', 'field' => 'created', 'order' => 'DESC'],
]);
ilf_cms_view('commercials', 'Commercials', 'commercial_video', 'commercials', 'Commercials');
ilf_cms_view('faces_of_fujitsu', 'Faces of Fujitsu', 'face_profile', 'friends-family', 'Friends & Family');
ilf_cms_view('dealer_region_view', 'Dealer Region', 'dealer_region', 'find-a-dealer', 'Find a Dealer');
ilf_cms_view('branch_locations', 'Branch Locations', 'branch_location', 'locations', 'Branch Locations');

// SEO metatags for homepage and products.
if (\Drupal::moduleHandler()->moduleExists('metatag')) {
  $front = \Drupal::configFactory()->getEditable('metatag.metatag_defaults.front');
  if (!$front->isNew()) {
    $front->set('tags.title', 'I Love My Fujitsu | Fujitsu Air Conditioning Hawaii');
    $front->set('tags.description', 'Discover Fujitsu air conditioning systems, rebates, local dealers, product brochures, commercials, and Hawaii contractor resources from I Love My Fujitsu.');
    $front->save();
  }
}

echo "Fujitsu Drupal CMS architecture build complete.\n";
