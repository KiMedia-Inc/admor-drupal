<?php

declare(strict_types=1);

use Drupal\node\Entity\Node;

$posts = json_decode((string) file_get_contents('/tmp/ilf-posts.json'), TRUE) ?: [];
$pages = json_decode((string) file_get_contents('/tmp/ilf-pages.json'), TRUE) ?: [];
$storage = \Drupal::entityTypeManager()->getStorage('node');
$alias_manager = \Drupal::service('path_alias.manager');

function ilf_text_from_html(string $html): string {
  $html = preg_replace('~<script[\s\S]*?</script>~i', ' ', $html) ?? $html;
  $html = preg_replace('~<style[\s\S]*?</style>~i', ' ', $html) ?? $html;
  $html = preg_replace('~<br\s*/?>~i', "\n", $html) ?? $html;
  $html = preg_replace('~</(p|div|h[1-6]|li|tr)>~i', "\n", $html) ?? $html;
  $text = html_entity_decode(strip_tags($html), ENT_QUOTES | ENT_HTML5);
  $text = str_replace(["\xc2\xa0", 'Read More', 'Watch Now', 'VIEW & DOWNLOAD PDF'], ' ', $text);
  $text = preg_replace('/[ \t]+/', ' ', $text) ?? $text;
  $text = preg_replace('/\n\s+/', "\n", $text) ?? $text;
  $text = preg_replace('/\n{3,}/', "\n\n", $text) ?? $text;
  return trim($text);
}

function ilf_paragraph_html(string $text, int $max_paragraphs = 8): string {
  $parts = preg_split('/\n+/', $text) ?: [];
  $paragraphs = [];
  foreach ($parts as $part) {
    $part = trim($part);
    if ($part === '' || strlen($part) < 18) {
      continue;
    }
    $paragraphs[] = '<p>' . htmlspecialchars($part, ENT_QUOTES | ENT_HTML5) . '</p>';
    if (count($paragraphs) >= $max_paragraphs) {
      break;
    }
  }
  return implode('', $paragraphs);
}

function ilf_key(string $value): string {
  $value = strtolower(html_entity_decode(strip_tags($value), ENT_QUOTES | ENT_HTML5));
  $value = str_replace(['coolingcancer', 'w.oahu', 'techonology', '&'], ['cooling cancer', 'west oahu', 'technology', 'and'], $value);
  $value = preg_replace('/[^a-z0-9]+/', '', $value) ?? $value;
  return $value;
}

function ilf_summary(string $text, string $fallback): string {
  $text = trim(preg_replace('/\s+/', ' ', $text) ?? $text);
  if ($text === '') {
    return $fallback;
  }
  return mb_substr($text, 0, 320);
}

function ilf_find_node_for_post(array $post, object $storage, object $alias_manager): ?Node {
  $slug = (string) ($post['slug'] ?? '');
  $title = html_entity_decode(strip_tags((string) ($post['title']['rendered'] ?? '')), ENT_QUOTES | ENT_HTML5);
  $aliases = [
    '/updates/' . $slug,
    '/friends-family/' . $slug,
    '/commercials/' . $slug,
    '/resources/' . $slug,
  ];
  $overrides = [
    'elementor-805' => '/updates/maui-fujitsu-elite-contractors-vip-reception-may-19th-2022',
    'w-oahu-schools-receive-donation' => '/updates/west-oahu-schools-receive-donation',
    'fujitsu-generals-procore-high-corrosion-resistant-techonology' => '/updates/fujitsu-procore-corrosion-resistant-technology',
    'benny-agbani' => '/friends-family/benny-agbani',
    'fujitsus-gym-dog' => '/commercials/gym-dog',
    'fujitsu-12-year-gecko-warranty' => '/commercials/fujitsu-12-year-and-gecko-warranty',
    'fujitsu-410a-mni-split-troubleshooting-guide' => '/resources/fujitsu-410a-mini-split-troubleshooting-guide',
  ];
  if (isset($overrides[$slug])) {
    array_unshift($aliases, $overrides[$slug]);
  }
  foreach ($aliases as $alias) {
    $path = $alias_manager->getPathByAlias($alias);
    if (preg_match('~^/node/(\d+)$~', $path, $match)) {
      $node = $storage->load((int) $match[1]);
      if ($node) {
        return $node;
      }
    }
  }
  foreach (['news_update', 'face_profile', 'commercial_video', 'resource_brochure'] as $bundle) {
    $ids = \Drupal::entityQuery('node')->condition('type', $bundle)->accessCheck(FALSE)->execute();
    foreach ($storage->loadMultiple($ids) as $node) {
      if (ilf_key($node->label()) === ilf_key($title)) {
        return $node;
      }
    }
  }
  return NULL;
}

$fallbacks = [
  'news_update' => 'Fujitsu Hawaii news and proof points that build confidence before homeowners, builders, businesses, and contractors compare AC brands.',
  'face_profile' => 'A local Faces of Fujitsu story that keeps the brand familiar, trusted, and connected to Hawaii.',
  'commercial_video' => 'A Fujitsu Hawaii video that builds brand recognition and helps buyers remember to ask for Fujitsu by name.',
  'resource_brochure' => 'A Fujitsu resource for comparing systems, support information, and next steps before requesting Fujitsu from a contractor.',
];

$updated_posts = 0;
foreach ($posts as $post) {
  $node = ilf_find_node_for_post($post, $storage, $alias_manager);
  if (!$node) {
    continue;
  }
  $bundle = $node->bundle();
  $text = ilf_text_from_html((string) ($post['content']['rendered'] ?? ''));
  if (mb_strlen($text) < 70) {
    $text = ilf_text_from_html((string) ($post['excerpt']['rendered'] ?? ''));
  }
  $fallback = $fallbacks[$bundle] ?? $fallbacks['news_update'];
  $body = ilf_paragraph_html($text, $bundle === 'news_update' ? 10 : 5);
  if ($body === '') {
    $body = '<p>' . htmlspecialchars($fallback, ENT_QUOTES | ENT_HTML5) . '</p>';
  }

  if ($bundle === 'news_update') {
    $body .= '<p>For buyers comparing air conditioning options in Hawaii, the takeaway is simple: Fujitsu combines quiet comfort, efficient operation, and local support that contractors can stand behind.</p>';
  }
  elseif ($bundle === 'face_profile') {
    $body .= '<p>These local voices help make Fujitsu familiar across Hawaii and keep the brand top-of-mind before homeowners and businesses talk with an AC contractor.</p>';
  }
  elseif ($bundle === 'commercial_video') {
    $body .= '<p>This video belongs to the long-running Fujitsu Hawaii brand story: memorable, local, and built to make people ask for Fujitsu by name.</p>';
  }

  if ($node->hasField('field_summary')) {
    $node->set('field_summary', ilf_summary($text, $fallback));
  }
  $node->set('body', ['value' => $body, 'format' => 'full_html']);
  $node->save();
  $updated_posts++;
}

function ilf_set_page(string $title, string $html): void {
  $nodes = \Drupal::entityTypeManager()->getStorage('node')->loadByProperties(['type' => 'page', 'title' => $title]);
  if (!$nodes) {
    return;
  }
  $node = reset($nodes);
  $node->set('body', ['value' => $html, 'format' => 'full_html']);
  $node->save();
}

$page_by_slug = [];
foreach ($pages as $page) {
  $page_by_slug[$page['slug']] = $page;
}

$maintenance_text = ilf_text_from_html((string) ($page_by_slug['maintenance-tips']['content']['rendered'] ?? ''));
ilf_set_page('Maintenance Tips',
  '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Protect the system</p><h2>Simple care helps Fujitsu systems last in Hawaii.</h2><p>Humidity, salt air, dust, and year-round cooling make regular maintenance especially important. These tips help owners keep airflow clean, spot issues early, and know when to call a certified Fujitsu contractor.</p></section>'
  . ilf_paragraph_html($maintenance_text, 14)
  . '<section class="ilf-callout"><h2>Need help with service?</h2><p>Ask a Fujitsu-focused contractor to inspect the system, clean components correctly, and confirm the installation is operating as designed.</p><a class="btn-main" href="/find-a-contractor">Find Fujitsu support</a></section>'
);

ilf_set_page('Tech Tips',
  '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Technical library</p><h2>Fujitsu technical PDFs are now organized as Drupal resources.</h2><p>The live WordPress Tech Tips page was mostly an image grid of PDF links. Those working PDFs have been imported locally so contractors and service teams can access them from the Resources library.</p></section><div class="ilf-card-grid ilf-card-grid--three"><article><h3>Service references</h3><p>Serial signal troubleshooting, EEV checks, IPM updates, fan motor guidance, and related technical PDFs.</p><a class="btn-main" href="/resources">Open resources</a></article><article><h3>Troubleshooting guide</h3><p>The current Fujitsu 410A mini-split troubleshooting guide is preserved as a local Drupal file.</p><a class="btn-main" href="/resources/fujitsu-410a-mini-split-troubleshooting-guide">Open guide</a></article><article><h3>Contractor support</h3><p>Use these materials alongside Fujitsu training, local distributor support, and proper diagnostic procedures.</p><a class="btn-main" href="/find-a-contractor">Find support</a></article></div>'
);

ilf_set_page('Fujitsu Products',
  '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Fujitsu product library</p><h2>Find the Fujitsu system documents buyers and contractors ask for most.</h2><p>The live Products page was a document grid. In Drupal, those PDFs are preserved as structured resources so they are easier to manage, search, update, and use during contractor conversations.</p></section><div class="ilf-card-grid ilf-card-grid--three"><article><h3>Residential comfort</h3><p>Consumer brochures, mini-split overviews, multi-zone brochures, and product sell sheets for Hawaii homes and condos.</p><a class="btn-main" href="/resources/consumer-brochure">Consumer brochure</a></article><article><h3>Commercial systems</h3><p>AIRSTAGE catalogs and commercial product documents for offices, hospitality, retail, and developer projects.</p><a class="btn-main" href="/resources/2021-fujitsu-airstage-full-line-catalog">AIRSTAGE catalog</a></article><article><h3>Full resource library</h3><p>All working PDFs from the live Products and Tech Tips pages have been imported into Drupal resources.</p><a class="btn-main" href="/resources">View all resources</a></article></div><section class="ilf-callout"><h2>Ask your contractor for Fujitsu by name.</h2><p>Use these documents to compare options, then ask which Fujitsu system best fits your space, budget, and comfort goals.</p><a class="btn-main" href="/find-a-contractor">Find Fujitsu support</a></section>'
);

ilf_set_page('Fujitsu Brochures',
  '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Brochures</p><h2>Fujitsu brochures are available as local Drupal PDFs.</h2><p>Full-line catalogs, consumer brochures, AIRSTAGE documents, product sell sheets, and support guides have been imported from the live site wherever the source files were available.</p></section><div class="ilf-card-grid ilf-card-grid--three"><article><h3>Full line brochure</h3><p>Review the complete Fujitsu product range before comparing system options.</p><a class="btn-main" href="/resources/full-line-brochure">Open brochure</a></article><article><h3>Consumer brochure</h3><p>Simple buyer-facing guidance for ductless and efficient comfort options.</p><a class="btn-main" href="/resources/consumer-brochure">Open brochure</a></article><article><h3>All resources</h3><p>Browse every imported product PDF, guide, rebate document, and technical resource.</p><a class="btn-main" href="/resources">Browse resources</a></article></div>'
);

ilf_set_page('Find a Fujitsu Contractor',
  '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Start here</p><h2>Tell your AC contractor you want Fujitsu.</h2><p>Fujitsu contractors specialize in different applications, certifications, and island service areas. The goal is to make your next estimate easier: ask for Fujitsu first, then work with a qualified contractor to match the right system to your space.</p></section><div class="ilf-island-grid"><a href="/find-a-dealer/oahu-dealers"><strong>Oahu Dealers</strong><span>Honolulu, Windward, Central, Leeward, and North Shore support.</span></a><a href="/find-a-dealer/maui-dealers"><strong>Maui Dealers</strong><span>Residential, condo, hospitality, and light commercial Fujitsu support.</span></a><a href="/find-a-dealer/kauai-dealers"><strong>Kauai Dealers</strong><span>Islandwide ductless and mini-split support.</span></a><a href="/find-a-dealer/big-island-dealers"><strong>Hawaii Island Dealers</strong><span>Hilo, Kona, Waimea, Puna, and beyond.</span></a></div><section class="ilf-callout"><h2>Use the exact phrase.</h2><p>When comparing estimates, say: “I want Fujitsu. What Fujitsu options do you recommend for my home or building?”</p><a class="btn-main" href="https://contractors.fujitsugeneral.com/locator/HI/Honolulu">Open Fujitsu contractor locator</a></section>'
);

ilf_set_page('I Love My Fujitsu Athletics Application',
  '<section class="ilf-content-band ilf-content-band--intro"><p class="ilf-kicker">Community</p><h2>I Love My Fujitsu Athletics Application</h2><p>The live WordPress page used a form plugin. In Drupal, this page is preserved as a clean program landing page until the final application form destination is confirmed.</p></section><div class="ilf-card-grid ilf-card-grid--three"><article><h3>Who it is for</h3><p>Hawaii student athletes, schools, and community programs connected to the I Love My Fujitsu athletics initiative.</p></article><article><h3>Information collected</h3><p>Name, school, sport, social handles, address, contact phone, and merchandise size.</p></article><article><h3>Next step</h3><p>Connect with the Fujitsu Hawaii team to confirm current program availability and submission details.</p><a class="btn-main" href="/find-a-contractor">Contact Fujitsu support</a></article></div>'
);

echo "Optimized live copy import complete. Updated structured posts: {$updated_posts}\n";
