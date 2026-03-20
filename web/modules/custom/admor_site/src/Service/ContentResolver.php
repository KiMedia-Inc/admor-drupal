<?php

declare(strict_types=1);

namespace Drupal\admor_site\Service;

use Drupal\Core\Datetime\DateFormatterInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\Menu\MenuTreeParameters;
use Drupal\Core\Menu\MenuLinkTreeInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Component\Utility\Html;
use Drupal\node\NodeInterface;
use Drupal\taxonomy\TermInterface;

/**
 * Builds homepage content from the existing site model.
 */
final class ContentResolver {

  use StringTranslationTrait;

  /**
   * Cached homepage payload.
   *
   * @var array<string, mixed>|null
   */
  private ?array $homepageCache = NULL;

  /**
   * Constructs the resolver.
   */
  public function __construct(
    private readonly EntityTypeManagerInterface $entityTypeManager,
    private readonly EntityFieldManagerInterface $entityFieldManager,
    private readonly FileUrlGeneratorInterface $fileUrlGenerator,
    private readonly DateFormatterInterface $dateFormatter,
    private readonly MenuLinkTreeInterface $menuLinkTree,
  ) {}

  /**
   * Builds the rendered main menu tree.
   */
  public function buildMainMenu(): array {
    $parameters = (new MenuTreeParameters())
      ->setMaxDepth(2)
      ->onlyEnabledLinks();

    $tree = $this->menuLinkTree->load('main', $parameters);
    $tree = $this->menuLinkTree->transform($tree, [
      ['callable' => 'menu.default_tree_manipulators:checkAccess'],
      ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
    ]);

    return $this->menuLinkTree->build($tree);
  }

  /**
   * Builds the homepage payload.
   */
  public function buildHomepage(): array {
    return $this->homepageCache ??= [
      'hero_products' => $this->buildProductCarousel(),
      'categories' => $this->buildCategoryCards(),
      'news' => $this->buildTeasers('Article', 3),
      'specials' => $this->buildTeasers('Specials & Rebates', 3, ['Expires'], FALSE),
      'training' => $this->buildTeasers('Training & Events', 3, ['Event start'], TRUE),
      'staff_groups' => $this->buildStaffGroups(),
      'testimonials' => $this->buildTestimonials(),
      'videos' => $this->buildVideos(),
    ];
  }

  /**
   * Returns a single homepage section.
   */
  public function getHomepageSection(string $section): mixed {
    $homepage = $this->buildHomepage();
    return $homepage[$section] ?? [];
  }

  /**
   * Builds the top-bar and footer contact payload.
   */
  public function buildContact(): array {
    $config = \Drupal::config('admor_site.settings')->getRawData();
    $phone = (string) ($config['phone'] ?? '');
    $config['phone_clean'] = preg_replace('/\D+/', '', $phone) ?: '8088417400';
    return $config;
  }

  /**
   * Builds the product logo carousel.
   */
  private function buildProductCarousel(): array {
    $products = $this->loadNodesByBundleLabel('Products', 9);
    $items = [];

    foreach ($products as $node) {
      $items[] = [
        'title' => $node->label(),
        'summary' => $this->extractSummary($node, ['Description', 'Body']),
        'image' => $this->extractImageUrl($node, ['Logo image', 'Logo', 'Image']),
        'url' => $this->extractLinkUrl($node, ['Web link']) ?? $node->toUrl()->toString(),
      ];
    }

    return $items;
  }

  /**
   * Builds product category cards.
   */
  private function buildCategoryCards(): array {
    $vocabulary = $this->findVocabularyIdByLabel('Product Categories');
    if (!$vocabulary) {
      return [];
    }

    $term_ids = $this->entityTypeManager->getStorage('taxonomy_term')->getQuery()
      ->accessCheck(TRUE)
      ->condition('vid', $vocabulary)
      ->sort('weight')
      ->sort('name')
      ->execute();

    if (!$term_ids) {
      return [];
    }

    $terms = $this->entityTypeManager->getStorage('taxonomy_term')->loadMultiple($term_ids);
    $items = [];

    foreach ($terms as $term) {
      if (!$term instanceof TermInterface) {
        continue;
      }

      $items[] = [
        'title' => $term->label(),
        'url' => $term->toUrl()->toString(),
      ];
    }

    return $items;
  }

  /**
   * Builds card-based teasers from a node bundle label.
   */
  private function buildTeasers(string $bundle_label, int $limit, array $date_labels = [], bool $ascending = FALSE): array {
    $nodes = $this->loadNodesByBundleLabel($bundle_label, $limit, $date_labels, $ascending);
    $items = [];

    foreach ($nodes as $node) {
      $meta = NULL;
      if ($date_labels) {
        $meta = $this->extractFormattedDate($node, $date_labels);
      }

      if (!$meta) {
        $meta = $this->extractReferencedLabel($node, ['Locations', 'Location', 'News Categories', 'Tags']);
      }

      $items[] = [
        'title' => $node->label(),
        'summary' => $this->extractSummary($node, ['Description', 'Body', 'Quote']),
        'eyebrow' => $bundle_label,
        'meta' => $meta,
        'image' => $this->extractImageUrl($node, ['Photo', 'Image', 'Logo image']),
        'fallback_image' => $this->fallbackImageForBundle($bundle_label),
        'media_fit' => $bundle_label === 'Products' ? 'contain' : 'cover',
        'url' => $node->toUrl()->toString(),
      ];
    }

    return $items;
  }

  /**
   * Builds grouped staff cards.
   */
  private function buildStaffGroups(): array {
    $staff = $this->loadNodesByBundleLabel('Staff', 40);
    $groups = [];

    foreach ($staff as $node) {
      $department = $this->extractReferencedLabel($node, ['Department', 'Departments']) ?: (string) $this->t('Team');
      $groups[$department]['department'] = $department;
      $groups[$department]['people'][] = [
        'title' => $node->label(),
        'position' => $this->extractPlainText($node, ['Position']),
        'phone' => $this->extractPlainText($node, ['Phone']),
        'email' => $this->extractPlainText($node, ['Email']),
        'image' => $this->extractImageUrl($node, ['Photo', 'Image']),
        'url' => $node->toUrl()->toString(),
      ];
    }

    return array_values($groups);
  }

  /**
   * Builds testimonial cards.
   */
  private function buildTestimonials(): array {
    $nodes = $this->loadNodesByBundleLabel('Testimonials', 8);
    $items = [];

    foreach ($nodes as $node) {
      $items[] = [
        'title' => $node->label(),
        'company' => $this->extractPlainText($node, ['Company']),
        'quote' => $this->extractSummary($node, ['Quote', 'Body']) ?: (string) $this->t('Add a quote to this testimonial to display it on the homepage.'),
      ];
    }

    return $items;
  }

  /**
   * Builds video cards.
   */
  private function buildVideos(): array {
    $nodes = $this->loadNodesByBundleLabel('Videos', 3);
    $items = [];

    foreach ($nodes as $node) {
      $video_url = $this->extractLinkUrl($node, ['Video URL']) ?? $this->extractPlainText($node, ['Video URL']);
      if (!$video_url) {
        continue;
      }

      $items[] = [
        'title' => $node->label(),
        'summary' => $this->extractSummary($node, ['Body']),
        'embed_url' => $this->toEmbedUrl($video_url),
        'url' => $node->toUrl()->toString(),
      ];
    }

    return $items;
  }

  /**
   * Loads nodes using the bundle label.
   *
   * @return \Drupal\node\NodeInterface[]
   *   Loaded published nodes.
   */
  private function loadNodesByBundleLabel(string $bundle_label, int $limit, array $sort_field_labels = [], bool $ascending = FALSE): array {
    $bundle = $this->findBundleIdByLabel('node', $bundle_label);
    if (!$bundle) {
      return [];
    }

    $storage = $this->entityTypeManager->getStorage('node');
    $query = $storage->getQuery()
      ->accessCheck(TRUE)
      ->condition('type', $bundle)
      ->condition('status', 1)
      ->range(0, $limit);

    $sorted = FALSE;
    foreach ($sort_field_labels as $label) {
      $field_name = $this->findFieldNameByLabel('node', $bundle, [$label]);
      if ($field_name) {
        $query->sort($field_name, $ascending ? 'ASC' : 'DESC');
        $sorted = TRUE;
        break;
      }
    }

    if (!$sorted) {
      $query->sort('created', $ascending ? 'ASC' : 'DESC');
    }

    $ids = $query->execute();
    if (!$ids) {
      return [];
    }

    $nodes = $storage->loadMultiple($ids);
    return array_values(array_filter($nodes, static fn ($node): bool => $node instanceof NodeInterface));
  }

  /**
   * Finds a bundle id using a label.
   */
  private function findBundleIdByLabel(string $entity_type, string $label): ?string {
    $config_entity_type = match ($entity_type) {
      'node' => 'node_type',
      'taxonomy_term' => 'taxonomy_vocabulary',
      default => NULL,
    };

    if (!$config_entity_type) {
      return NULL;
    }

    $entities = $this->entityTypeManager->getStorage($config_entity_type)->loadMultiple();
    $preferred = $this->preferredBundleMachineNames($entity_type, $label);
    foreach ($preferred as $candidate) {
      if (isset($entities[$candidate])) {
        return $candidate;
      }
    }

    foreach ($entities as $entity) {
      if (mb_strtolower((string) $entity->label()) === mb_strtolower($label)) {
        return $entity->id();
      }
    }

    return NULL;
  }

  /**
   * Finds a taxonomy vocabulary machine name by label.
   */
  private function findVocabularyIdByLabel(string $label): ?string {
    return $this->findBundleIdByLabel('taxonomy_term', $label);
  }

  /**
   * Finds a field name by label.
   */
  private function findFieldNameByLabel(string $entity_type, string $bundle, array $labels): ?string {
    $definitions = $this->entityFieldManager->getFieldDefinitions($entity_type, $bundle);
    foreach ($this->preferredFieldMachineNames($bundle, $labels) as $candidate) {
      if (isset($definitions[$candidate])) {
        return $candidate;
      }
    }

    $lookup = array_map('mb_strtolower', $labels);

    foreach ($definitions as $field_name => $definition) {
      if (in_array(mb_strtolower((string) $definition->getLabel()), $lookup, TRUE)) {
        return $field_name;
      }
    }

    return NULL;
  }

  /**
   * Returns preferred bundle machine names for known site bundles.
   */
  private function preferredBundleMachineNames(string $entity_type, string $label): array {
    $map = [
      'node' => [
        'Basic page' => ['page', 'basic_page'],
        'Article' => ['article'],
        'Careers' => ['careers', 'career'],
        'Products' => ['products', 'product'],
        'Specials & Rebates' => ['specials_rebates', 'specials_and_rebates', 'specials'],
        'Staff' => ['staff'],
        'Testimonials' => ['testimonials', 'testimonial'],
        'Training & Events' => ['training_events', 'training_and_events', 'training'],
        'Videos' => ['videos', 'video'],
      ],
      'taxonomy_term' => [
        'Departments' => ['departments', 'department'],
        'Job Types' => ['job_types', 'job_type'],
        'Locations' => ['locations', 'location'],
        'News Categories' => ['news_categories', 'news_category'],
        'Product Categories' => ['product_categories', 'product_category'],
        'Tags' => ['tags'],
      ],
    ];

    return $map[$entity_type][$label] ?? [];
  }

  /**
   * Returns preferred field machine names for known labels.
   */
  private function preferredFieldMachineNames(string $bundle, array $labels): array {
    $label_map = [
      'Description' => ['field_description', 'body'],
      'Body' => ['body', 'field_body'],
      'Logo image' => ['field_logo_image', 'field_logo', 'field_image'],
      'Logo' => ['field_logo', 'field_logo_image'],
      'Image' => ['field_image', 'field_photo', 'field_media_image'],
      'Web link' => ['field_web_link', 'field_link', 'field_cta_link'],
      'Expires' => ['field_expires', 'field_expiration_date'],
      'Event start' => ['field_event_start', 'field_start', 'field_start_date'],
      'Department' => ['field_department', 'field_departments'],
      'Departments' => ['field_departments', 'field_department'],
      'Position' => ['field_position'],
      'Phone' => ['field_phone'],
      'Email' => ['field_email'],
      'Photo' => ['field_photo', 'field_image'],
      'Company' => ['field_company'],
      'Quote' => ['field_quote', 'body'],
      'Video URL' => ['field_video_url', 'field_video', 'field_link'],
      'Locations' => ['field_locations', 'field_location'],
      'Location' => ['field_location', 'field_locations'],
      'News Categories' => ['field_news_categories', 'field_category'],
      'Tags' => ['field_tags'],
    ];

    $bundle_specific = [
      'products' => [
        'Description' => ['field_description', 'body'],
        'Logo image' => ['field_logo_image', 'field_logo', 'field_image'],
        'Web link' => ['field_web_link', 'field_link'],
      ],
      'staff' => [
        'Department' => ['field_department', 'field_departments'],
        'Photo' => ['field_photo', 'field_image'],
      ],
      'testimonials' => [
        'Quote' => ['field_quote', 'body'],
      ],
      'videos' => [
        'Video URL' => ['field_video_url', 'field_video', 'field_link'],
      ],
      'training_events' => [
        'Event start' => ['field_event_start', 'field_start', 'field_start_date'],
      ],
    ];

    $candidates = [];
    foreach ($labels as $label) {
      $candidates = array_merge($candidates, $bundle_specific[$bundle][$label] ?? [], $label_map[$label] ?? []);
    }

    return array_values(array_unique($candidates));
  }

  /**
   * Extracts the first matching field list by label.
   */
  private function extractField(NodeInterface $node, array $labels) {
    $field_name = $this->findFieldNameByLabel('node', $node->bundle(), $labels);
    return $field_name && $node->hasField($field_name) ? $node->get($field_name) : NULL;
  }

  /**
   * Extracts plain text from a node field.
   */
  private function extractPlainText(NodeInterface $node, array $labels): ?string {
    $field = $this->extractField($node, $labels);
    if (!$field || $field->isEmpty()) {
      return NULL;
    }

    $item = $field->first();
    $value = $item?->getValue();
    if (isset($value['value'])) {
      return trim(strip_tags((string) $value['value']));
    }
    if (isset($value['uri'])) {
      return trim((string) $value['uri']);
    }
    if (isset($value['title']) && $value['title'] !== '') {
      return trim((string) $value['title']);
    }
    if (isset($value['value'])) {
      return trim((string) $value['value']);
    }
    if (isset($value['target_id']) && $item?->entity) {
      return trim((string) $item->entity->label());
    }

    return isset($item->value) ? trim((string) $item->value) : NULL;
  }

  /**
   * Extracts a short summary.
   */
  private function extractSummary(NodeInterface $node, array $labels): ?string {
    $text = $this->extractPlainText($node, $labels);
    if (!$text) {
      return NULL;
    }

    return Html::decodeEntities(mb_strimwidth($text, 0, 180, '...'));
  }

  /**
   * Extracts a referenced label from a node field.
   */
  private function extractReferencedLabel(NodeInterface $node, array $labels): ?string {
    $field = $this->extractField($node, $labels);
    if (!$field || $field->isEmpty()) {
      return NULL;
    }

    foreach ($field->referencedEntities() as $entity) {
      if ($entity->label()) {
        return (string) $entity->label();
      }
    }

    return NULL;
  }

  /**
   * Extracts a formatted date from a node field.
   */
  private function extractFormattedDate(NodeInterface $node, array $labels): ?string {
    $field = $this->extractField($node, $labels);
    if (!$field || $field->isEmpty()) {
      return NULL;
    }

    $item = $field->first();
    $value = $item?->getValue();
    $raw = $value['value'] ?? NULL;
    if (!$raw) {
      return NULL;
    }

    try {
      return $this->dateFormatter->format(strtotime($raw), 'custom', 'M j, Y g:ia');
    }
    catch (\Throwable) {
      return NULL;
    }
  }

  /**
   * Extracts a link URL from a link field.
   */
  private function extractLinkUrl(NodeInterface $node, array $labels): ?string {
    $field = $this->extractField($node, $labels);
    if (!$field || $field->isEmpty()) {
      return NULL;
    }

    $item = $field->first();
    if (method_exists($item, 'getUrl')) {
      return $item->getUrl()->toString();
    }

    $value = $item?->getValue();
    return $value['uri'] ?? NULL;
  }

  /**
   * Extracts an image URL from an image or media field.
   */
  private function extractImageUrl(NodeInterface $node, array $labels): ?string {
    $field = $this->extractField($node, $labels);
    if (!$field || $field->isEmpty()) {
      return NULL;
    }

    $entity = $field->entity ?? $field->first()?->entity;
    if ($entity && method_exists($entity, 'getFileUri') && $entity->getFileUri()) {
      return $this->fileUrlGenerator->generateString($entity->getFileUri());
    }

    if ($entity && $entity->getEntityTypeId() === 'media') {
      $definitions = $this->entityFieldManager->getFieldDefinitions('media', $entity->bundle());
      foreach ($definitions as $definition_name => $definition) {
        if (in_array(mb_strtolower((string) $definition->getLabel()), ['image', 'photo', 'logo image', 'logo'], TRUE) && !$entity->get($definition_name)->isEmpty()) {
          $file = $entity->get($definition_name)->entity;
          if ($file && method_exists($file, 'getFileUri')) {
            return $this->fileUrlGenerator->generateString($file->getFileUri());
          }
        }
      }
    }

    return NULL;
  }

  /**
   * Converts a video URL to an embeddable URL.
   */
  private function toEmbedUrl(string $url): string {
    if (str_contains($url, 'youtube.com/watch')) {
      parse_str((string) parse_url($url, PHP_URL_QUERY), $query);
      return !empty($query['v']) ? 'https://www.youtube.com/embed/' . $query['v'] : $url;
    }

    if (str_contains($url, 'youtu.be/')) {
      $id = trim((string) parse_url($url, PHP_URL_PATH), '/');
      return $id ? 'https://www.youtube.com/embed/' . $id : $url;
    }

    if (str_contains($url, 'vimeo.com/')) {
      $id = trim((string) parse_url($url, PHP_URL_PATH), '/');
      return $id ? 'https://player.vimeo.com/video/' . $id : $url;
    }

    return $url;
  }

  /**
   * Returns a fallback theme asset by bundle.
   */
  private function fallbackImageForBundle(string $bundle_label): string {
    $base = base_path();
    return match ($bundle_label) {
      'Article' => $base . 'themes/custom/admor/vendor/coolair/images/background/9.webp',
      'Specials & Rebates' => $base . 'themes/custom/admor/vendor/coolair/images/background/16.webp',
      'Training & Events' => $base . 'themes/custom/admor/vendor/coolair/images/misc/1.webp',
      default => $base . 'themes/custom/admor/vendor/coolair/images/background/3.webp',
    };
  }

}
