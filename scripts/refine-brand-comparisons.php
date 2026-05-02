<?php

declare(strict_types=1);

use Drupal\Core\Entity\Entity\EntityFormDisplay;
use Drupal\Core\Entity\Entity\EntityViewDisplay;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;
use Drupal\taxonomy\Entity\Term;
use Drupal\taxonomy\Entity\Vocabulary;

$allowed = ['Mitsubishi', 'Daikin', 'LG', 'Gree', 'Panasonic', 'Samsung'];
$required = ['Mitsubishi', 'Daikin', 'LG', 'Gree', 'Panasonic'];

$vocab = Vocabulary::load('competitor_brand') ?: Vocabulary::create(['vid' => 'competitor_brand']);
$vocab->set('name', 'Competitor Brand');
$vocab->save();

foreach ($allowed as $weight => $name) {
  $term = term_by_name('competitor_brand', $name) ?: Term::create(['vid' => 'competitor_brand', 'name' => $name]);
  $term->setWeight($weight);
  $term->save();
}

$blocked = ['Carrier', 'Trane', 'Lennox', 'Rheem', 'York'];
$terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree('competitor_brand');
foreach ($terms as $term_info) {
  if (!in_array($term_info->name, $allowed, TRUE)) {
    if ($term = Term::load($term_info->tid)) {
      $term->delete();
    }
  }
}

$type = NodeType::load('brand_comparison') ?: NodeType::create(['type' => 'brand_comparison']);
$type->set('name', 'HVAC Brand Comparison');
$type->set('description', 'Fujitsu comparison pages focused on direct ductless and mini-split competitors in Hawaii.');
$type->set('new_revision', TRUE);
$type->save();
if (!FieldConfig::loadByName('node', 'brand_comparison', 'body')) {
  node_add_body_field($type, 'Comparison content');
}

add_field('node', 'brand_comparison', 'field_competitor_brand', 'Competitor brand', 'entity_reference', ['target_type' => 'taxonomy_term'], [
  'handler' => 'default:taxonomy_term',
  'handler_settings' => ['target_bundles' => ['competitor_brand' => 'competitor_brand']],
], 1, TRUE, 'Select the direct ductless / mini-split competitor being compared.');
add_field('node', 'brand_comparison', 'field_comparison_summary', 'SEO summary', 'text_long', [], [], 1, FALSE, 'Short summary used by editors for SEO positioning.');
add_field('node', 'brand_comparison', 'field_sort_order', 'Sort order', 'integer', [], [], 1, FALSE, 'Lower numbers appear first.');

$form = EntityFormDisplay::load('node.brand_comparison.default') ?: EntityFormDisplay::create([
  'targetEntityType' => 'node',
  'bundle' => 'brand_comparison',
  'mode' => 'default',
  'status' => TRUE,
]);
$form
  ->setComponent('title', ['type' => 'string_textfield', 'weight' => 0])
  ->setComponent('field_competitor_brand', ['type' => 'options_select', 'weight' => 1])
  ->setComponent('field_comparison_summary', ['type' => 'text_textarea', 'weight' => 2])
  ->setComponent('body', ['type' => 'text_textarea_with_summary', 'weight' => 3])
  ->setComponent('field_sort_order', ['type' => 'number', 'weight' => 4])
  ->setComponent('path', ['type' => 'path', 'weight' => 20])
  ->save();

$view = EntityViewDisplay::load('node.brand_comparison.default') ?: EntityViewDisplay::create([
  'targetEntityType' => 'node',
  'bundle' => 'brand_comparison',
  'mode' => 'default',
  'status' => TRUE,
]);
$view
  ->setComponent('field_competitor_brand', ['type' => 'entity_reference_label', 'label' => 'hidden', 'weight' => 0])
  ->setComponent('field_comparison_summary', ['type' => 'text_default', 'label' => 'hidden', 'weight' => 1])
  ->setComponent('body', ['type' => 'text_default', 'label' => 'hidden', 'weight' => 2])
  ->save();

$comparisons = [
  'Mitsubishi' => [
    'alias' => '/fujitsu-vs-mitsubishi',
    'summary' => 'Fujitsu vs Mitsubishi mini split systems for Hawaii buyers comparing premium ductless comfort, local support, coastal durability, and warranty confidence.',
    'intro' => 'Mitsubishi is the strongest premium competitor in the mini-split conversation, so this is the page for buyers who already have a serious Mitsubishi quote. The strategic question in Hawaii is not whether Mitsubishi is credible. It is whether Fujitsu gives you the better Hawaii-specific ownership path: local Fujitsu demand, Admor-backed contractor support, corrosion-aware product guidance, and a warranty story that is easy to explain before the estimate is signed.',
    'cards' => [
      ['title' => 'Premium vs premium', 'text' => 'Mitsubishi competes hard on premium reputation and cold-climate heat pump technology. In Hawaii, where cooling, humidity control, salt air, and service support matter more than subzero heating, Fujitsu can be positioned around the conditions homeowners actually live with every day.'],
      ['title' => 'Local support is the tiebreaker', 'text' => 'When both brands are acceptable, the better question is which one your Hawaii contractor can source, register, troubleshoot, and support with confidence. Fujitsu has a direct local distribution story through Admor that Mitsubishi cannot claim through this website.'],
      ['title' => 'Airstage / VRF decisions', 'text' => 'For larger homes and commercial spaces, compare Fujitsu Airstage against Mitsubishi commercial/VRF options by asking who will support design questions, parts access, and contractor follow-through locally after installation.'],
    ],
    'difference_title' => 'Where Fujitsu pulls ahead against Mitsubishi',
    'differences' => [
      'Mitsubishi is a respected premium option, so Fujitsu should win on Hawaii relevance rather than generic brand prestige.',
      'Fujitsu can pair premium ductless comfort with the local Admor support story, which is more concrete for Hawaii buyers than a national brand promise.',
      'The sales message is easier for a homeowner to remember: ask for Fujitsu by name, then use a certified local contractor who can support it.',
    ],
    'verdict' => 'If the decision is Fujitsu vs Mitsubishi, do not stop at equipment reputation. Ask which brand has the clearer local support path in Hawaii, which contractor can stand behind the system, and which warranty story is easiest to manage over the life of the installation. For many Hawaii buyers, Fujitsu is the more confidence-building choice because it connects premium ductless comfort with a local support network.',
    'make_sense' => 'Mitsubishi may make sense when a trusted contractor specializes in Mitsubishi, has local access to the exact equipment, and can clearly explain warranty, parts, and service support for your island.',
    'sort' => 10,
  ],
  'Daikin' => [
    'alias' => '/fujitsu-vs-daikin',
    'summary' => 'Fujitsu vs Daikin Hawaii comparison for mini-split, multi-zone, and Airstage / VRF buyers focused on local support and practical ownership.',
    'intro' => 'Daikin is a large global HVAC manufacturer with strong VRV/VRF recognition. That can be a strength for commercial projects, but homeowners and small businesses in Hawaii need a simpler question answered: which brand will be easiest for my contractor to quote correctly, install cleanly, register, service, and support with parts in island conditions?',
    'cards' => [
      ['title' => 'Big-system reputation vs local clarity', 'text' => 'Daikin is often associated with broad HVAC and VRV capability. Fujitsu can compete by making the buyer journey clearer for ductless and multi-zone comfort: choose Fujitsu, find a local contractor, and lean on Hawaii-based distributor support.'],
      ['title' => 'Coastal ownership questions', 'text' => 'For homes near salt air, ask whether the proposed Daikin configuration includes the right corrosion-aware guidance for the exact site. Fujitsu gives the site a stronger story around blue fin, ProCore messaging, warranty confidence, and local contractor education.'],
      ['title' => 'Airstage vs VRV/VRF', 'text' => 'Daikin VRV is a serious commercial competitor. Fujitsu Airstage should be positioned as the Hawaii-ready alternative when the project needs scalable comfort plus a local support partner contractors can reach after the sale.'],
    ],
    'difference_title' => 'Where Fujitsu pulls ahead against Daikin',
    'differences' => [
      'Daikin can feel like a large commercial HVAC ecosystem; Fujitsu can feel more direct and memorable for homeowners asking a contractor for a mini-split by name.',
      'Fujitsu has a clearer local pull-through message for Hawaii: homeowners request it, contractors install it, and Admor supports the channel.',
      'For residential and light commercial buyers, Fujitsu can keep the conversation focused on comfort, warranty confidence, and support instead of broad product complexity.',
    ],
    'verdict' => 'If the decision is Fujitsu vs Daikin, ask whether the quote is optimized for your actual Hawaii home or business rather than just backed by a large HVAC name. Fujitsu is the stronger choice when the buyer wants a clear ductless comfort path, local distributor support, and a brand they can confidently request from their contractor.',
    'make_sense' => 'Daikin may make sense for certain larger commercial or VRV/VRF-driven projects when the design team, installer, and service provider are already aligned around Daikin support.',
    'sort' => 20,
  ],
  'LG' => [
    'alias' => '/fujitsu-vs-lg',
    'summary' => 'Fujitsu vs LG mini split comparison for Hawaii homeowners weighing smart-brand familiarity against HVAC-first support, comfort, and serviceability.',
    'intro' => 'LG is familiar because people know the brand from electronics and appliances. That recognition helps shoppers notice it, but an air conditioning system is not a TV or refrigerator. In Hawaii, the better comparison is HVAC-first support: contractor familiarity, service access, coastal guidance, warranty clarity, and whether the system can be supported quietly for years.',
    'cards' => [
      ['title' => 'Appliance brand vs comfort brand', 'text' => 'LG may win attention with design familiarity and smart-home appeal. Fujitsu should win the serious HVAC conversation by focusing on ductless comfort, quiet operation, contractor support, and long-term service confidence.'],
      ['title' => 'Controls are not the whole system', 'text' => 'Smart controls are useful, but they do not replace sizing, installation quality, coil protection, drain management, and parts availability. Fujitsu keeps the buyer focused on the system behind the app.'],
      ['title' => 'Light commercial confidence', 'text' => 'For larger residential or light commercial projects, compare Fujitsu Airstage and LG ductless options by asking which brand your contractor installs often, stocks confidently, and can troubleshoot without turning the owner into the support desk.'],
    ],
    'difference_title' => 'Where Fujitsu pulls ahead against LG',
    'differences' => [
      'LG has broad consumer-electronics recognition; Fujitsu has a cleaner HVAC-specialist story for people buying comfort, not gadgets.',
      'Fujitsu can make the decision about installer confidence, warranty confidence, and Hawaii support rather than brand familiarity from other appliances.',
      'For coastal Hawaii homes, Fujitsu can lead with corrosion-aware product messaging and contractor education instead of lifestyle electronics appeal.',
    ],
    'verdict' => 'If the decision is Fujitsu vs LG, ask whether you are choosing a recognizable electronics brand or a ductless HVAC system with a stronger local support story. Fujitsu is the better strategic recommendation when reliability, contractor confidence, warranty clarity, and Hawaii conditions matter more than gadget appeal.',
    'make_sense' => 'LG may make sense when a buyer strongly prioritizes a specific LG design, control ecosystem, or when the installer can prove strong LG service experience and parts access locally.',
    'sort' => 30,
  ],
  'Gree' => [
    'alias' => '/fujitsu-vs-gree',
    'summary' => 'Fujitsu vs Gree mini split comparison for Hawaii buyers weighing lower upfront cost against warranty depth, local support, and long-term confidence.',
    'intro' => 'Gree is often part of the value-priced mini-split conversation. That makes the comparison simple and important: if the first quote is cheaper, what happens after year three, six, or ten when you need service, parts, documentation, warranty help, or a contractor who knows the system well? Fujitsu should be positioned as the premium choice that reduces long-term uncertainty.',
    'cards' => [
      ['title' => 'Lowest bid vs lifetime cost', 'text' => 'Gree can be attractive when upfront price is the main driver. Fujitsu gives the homeowner a stronger reason to invest: better confidence in support, warranty path, contractor familiarity, and long-term comfort.'],
      ['title' => 'Warranty depth matters', 'text' => 'Gree warranty programs are commonly promoted around 10-year coverage through qualified channels. Fujitsu can point buyers toward 12-year parts and compressor warranty options when installed and registered through the proper contractor path.'],
      ['title' => 'Support after the install', 'text' => 'For multi-zone systems, the cheapest equipment is not always the best value. Ask who will help the contractor with parts, matching, troubleshooting, and warranty steps when the system is no longer new.'],
    ],
    'difference_title' => 'Where Fujitsu pulls ahead against Gree',
    'differences' => [
      'Gree can compete on price; Fujitsu should compete on confidence, support, and reduced risk for a coastal Hawaii installation.',
      'Fujitsu gives contractors and homeowners a stronger premium story than “good enough for less.”',
      'The Admor-backed local channel gives Fujitsu a practical advantage when the buyer cares about serviceability after the sale.',
    ],
    'verdict' => 'If the decision is Fujitsu vs Gree, the key question is whether saving money up front is worth giving up the stronger premium support story. Fujitsu is the better fit when the homeowner wants a system they can feel confident requesting, registering, maintaining, and servicing in Hawaii.',
    'make_sense' => 'Gree may make sense for a highly price-sensitive project where the contractor has proven Gree support and the buyer understands the tradeoff between lowest upfront cost and premium ownership confidence.',
    'sort' => 40,
  ],
  'Panasonic' => [
    'alias' => '/fujitsu-vs-panasonic',
    'summary' => 'Fujitsu vs Panasonic ductless comparison for Hawaii homeowners comparing familiar brand recognition against HVAC-specific local support.',
    'intro' => 'Panasonic is a trusted household name, especially in Hawaii, but familiarity is not the same as ductless HVAC support. The buyer should ask a practical question: which brand has the stronger local contractor pathway, clearer product resources, better parts story, and more focused mini-split presence for Hawaii homes and businesses?',
    'cards' => [
      ['title' => 'Familiar name vs focused HVAC path', 'text' => 'Panasonic brand familiarity can create comfort at first glance. Fujitsu gives the site a more focused air-conditioning story: product brochures, contractor locator flow, warranty messaging, resources, and Hawaii-specific support.'],
      ['title' => 'Ask what contractors actually support', 'text' => 'Before choosing Panasonic, ask whether the contractor regularly installs, registers, services, and sources Panasonic ductless systems locally. Fujitsu gives the buyer a clearer path to contractors already connected to the brand.'],
      ['title' => 'Commercial and multi-zone clarity', 'text' => 'For larger comfort needs, Fujitsu Airstage gives the site a stronger commercial/multi-zone story that can be tied directly to Admor support and Hawaii contractor resources.'],
    ],
    'difference_title' => 'Where Fujitsu pulls ahead against Panasonic',
    'differences' => [
      'Panasonic may be familiar, but Fujitsu can own the dedicated mini-split and contractor-support conversation on this site.',
      'Fujitsu has a clearer Hawaii demand-generation strategy: homeowners ask for it by name and contractors have a local support channel behind them.',
      'The website can give Fujitsu more proof points, resources, brochures, warranty messaging, and contractor pathways than a generic familiar-brand comparison.',
    ],
    'verdict' => 'If the decision is Fujitsu vs Panasonic, do not choose based on household name recognition alone. Fujitsu is the better strategic choice when the buyer wants a ductless AC brand with a clearer local contractor path, stronger Hawaii support story, and more focused product resources.',
    'make_sense' => 'Panasonic may make sense when an installer has a specific Panasonic configuration they support well and can provide clear local parts, warranty, and service answers.',
    'sort' => 50,
  ],
  'Samsung' => [
    'alias' => '/fujitsu-vs-samsung',
    'summary' => 'Fujitsu vs Samsung mini split comparison for Hawaii shoppers comparing tech-forward features against HVAC support and serviceability.',
    'intro' => 'Samsung may appear attractive to shoppers who value technology, connected controls, and modern product design. For air conditioning in Hawaii, those features should come after the basics: contractor experience, parts support, warranty handling, corrosion-aware installation, and reliable comfort in humid coastal conditions.',
    'cards' => [
      ['title' => 'Tech features vs HVAC fundamentals', 'text' => 'Samsung can compete on connected features and brand awareness. Fujitsu should steer the decision back to HVAC fundamentals: sizing, installation quality, service access, and local support.'],
      ['title' => 'Serviceability is the real feature', 'text' => 'A smart interface does not help much if the contractor cannot quickly diagnose or source what the system needs. Fujitsu has the stronger local support story through Admor-backed contractors.'],
      ['title' => 'Multi-zone confidence', 'text' => 'For multi-zone or light commercial applications, ask which brand has the most practical local path for design help, parts access, and warranty guidance after installation.'],
    ],
    'difference_title' => 'Where Fujitsu pulls ahead against Samsung',
    'differences' => [
      'Samsung can be positioned around technology; Fujitsu can be positioned around dependable ductless comfort and support.',
      'Fujitsu gives Hawaii homeowners a clearer contractor-driven ownership path than a consumer-electronics-style decision.',
      'For AC in Hawaii, serviceability, corrosion guidance, and parts support are more persuasive than app-forward feature language.',
    ],
    'verdict' => 'If the decision is Fujitsu vs Samsung, choose the brand that makes the system easier to install, support, and service in Hawaii. Fujitsu is the stronger fit when the buyer wants HVAC confidence first and connected features second.',
    'make_sense' => 'Samsung may make sense when a buyer specifically values Samsung controls or connected features and the contractor can support the system confidently after installation.',
    'sort' => 60,
  ],
];

foreach ($comparisons as $brand => $data) {
  $title = "Fujitsu vs $brand Mini Split Systems in Hawaii";
  $node = node_by_title('brand_comparison', $title) ?: Node::create(['type' => 'brand_comparison', 'title' => $title]);
  $node->setPublished(in_array($brand, $required, TRUE));
  $node->set('field_competitor_brand', term_by_name('competitor_brand', $brand)?->id());
  $node->set('field_comparison_summary', $data['summary']);
  $node->set('field_sort_order', $data['sort']);
  $node->set('body', [
    'value' => comparison_body($brand, $data),
    'format' => 'full_html',
  ]);
  $node->set('path', ['alias' => $data['alias']]);
  $node->save();
}

$irrelevant = ['Carrier', 'Trane', 'Lennox', 'Rheem', 'York'];
$ids = \Drupal::entityQuery('node')
  ->condition('type', 'brand_comparison')
  ->accessCheck(FALSE)
  ->execute();
foreach (Node::loadMultiple($ids) as $node) {
  foreach ($irrelevant as $brand) {
    if (stripos($node->label(), $brand) !== FALSE) {
      $node->setUnpublished();
      $node->save();
    }
  }
}

update_page_links();

echo "Focused competitor comparison system updated.\n";

function term_by_name(string $vid, string $name): ?Term {
  $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadByProperties(['vid' => $vid, 'name' => $name]);
  return $terms ? reset($terms) : NULL;
}

function add_field(string $entity_type, string $bundle, string $field_name, string $label, string $type, array $storage_settings = [], array $field_settings = [], int $cardinality = 1, bool $required = FALSE, string $description = ''): void {
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

function node_by_title(string $bundle, string $title): ?Node {
  $ids = \Drupal::entityQuery('node')
    ->condition('type', $bundle)
    ->condition('title', $title)
    ->accessCheck(FALSE)
    ->range(0, 1)
    ->execute();
  return $ids ? Node::load(reset($ids)) : NULL;
}

function comparison_body(string $brand, array $data): string {
  $brand_escaped = htmlspecialchars($brand, ENT_QUOTES | ENT_HTML5);
  $intro = htmlspecialchars($data['intro'], ENT_QUOTES | ENT_HTML5);
  $difference_title = htmlspecialchars($data['difference_title'], ENT_QUOTES | ENT_HTML5);
  $verdict = htmlspecialchars($data['verdict'], ENT_QUOTES | ENT_HTML5);
  $make_sense = htmlspecialchars($data['make_sense'], ENT_QUOTES | ENT_HTML5);
  $cards = '';
  foreach ($data['cards'] as $card) {
    $title = htmlspecialchars($card['title'], ENT_QUOTES | ENT_HTML5);
    $text = htmlspecialchars($card['text'], ENT_QUOTES | ENT_HTML5);
    $cards .= "<article><h2>$title</h2><p>$text</p></article>\n";
  }
  $differences = '';
  foreach ($data['differences'] as $difference) {
    $difference = htmlspecialchars($difference, ENT_QUOTES | ENT_HTML5);
    $differences .= "<li>$difference</li>\n";
  }
  return <<<HTML
<section class="ilf-comparison-intro">
  <p>$intro</p>
</section>
<section class="ilf-comparison-points">
$cards
</section>
<section class="ilf-comparison-advantage">
  <h2>$difference_title</h2>
  <ul>
$differences
  </ul>
</section>
<section class="ilf-comparison-choice">
  <article>
    <h2>Who should choose Fujitsu?</h2>
    <p>Choose Fujitsu if you want a ductless or multi-zone system selected for Hawaii conditions, supported by a local contractor path, and backed by clear warranty, parts, and Admor distributor support.</p>
  </article>
  <article>
    <h2>When $brand_escaped might make sense</h2>
    <p>$make_sense</p>
  </article>
</section>
<section class="ilf-listing-cta ilf-listing-cta--comparison">
  <div><strong>Use the comparison before the quote is final.</strong><span>Ask your contractor to include Fujitsu and explain the support, warranty, and service path for your island.</span></div>
  <p><a class="btn-main" href="/find-a-fujitsu-contractor">Find a Fujitsu Dealer</a><a class="btn-main btn-outline" href="/why-fujitsu-hawaii">Why Fujitsu for Hawaii</a></p>
</section>
<section class="ilf-comparison-hawaii">
  <h2>What matters in Hawaii</h2>
  <ul>
    <li><strong>Salt air and corrosion:</strong> coastal installations need corrosion-aware product guidance; Fujitsu gives buyers clear blue fin and ProCore talking points to discuss with the installer.</li>
    <li><strong>Humidity and constant use:</strong> the system should be sized and installed for real island conditions, not only brochure efficiency ratings.</li>
    <li><strong>Warranty confidence:</strong> Fujitsu warranty programs, including 12-year parts and compressor options through the proper contractor and registration path, help reduce buyer hesitation.</li>
    <li><strong>Local support:</strong> Admor backs Fujitsu contractors in Hawaii with product knowledge, inventory, parts access, and training resources.</li>
  </ul>
</section>
<section class="ilf-comparison-faq">
  <h2>Fujitsu vs $brand_escaped FAQs</h2>
  <details open><summary>Is Fujitsu better than $brand_escaped?</summary><p>Fujitsu is often the stronger choice when the buyer values Hawaii-specific support, corrosion-aware product guidance, warranty confidence, and a clear local contractor path. $brand_escaped can still make sense in some cases, so compare the full quote, not only the logo.</p></details>
  <details><summary>Which AC lasts longer in Hawaii?</summary><p>Longevity depends on sizing, installation quality, coastal exposure, cleaning, maintenance, warranty registration, and parts support. Fujitsu gives Hawaii buyers a strong long-term ownership story when installed and supported through qualified local contractors.</p></details>
</section>
<section class="ilf-comparison-verdict">
  <h2>Bottom line: Fujitsu vs $brand_escaped</h2>
  <p>$verdict</p>
  <p><a class="btn-main" href="/find-a-fujitsu-contractor">Find a Fujitsu Dealer</a> <a class="btn-main btn-outline" href="/products">Explore Fujitsu Products</a></p>
</section>
HTML;
}

function update_page_links(): void {
  $products = node_by_title('page', 'Fujitsu Products');
  if ($products) {
    $body = $products->body->value ?: '';
    if (!str_contains($body, '/fujitsu-vs-mitsubishi')) {
      $body .= '<section class="ilf-callout"><h2>Compare Fujitsu to other mini-split brands</h2><p>Choosing between Fujitsu, Mitsubishi, Daikin, LG, Gree, or Panasonic? Review Hawaii-focused ductless comparisons before you ask for an estimate.</p><p><a class="btn-main" href="/fujitsu-vs-mitsubishi">Fujitsu vs Mitsubishi</a> <a class="btn-main btn-outline" href="/fujitsu-vs-daikin">Fujitsu vs Daikin</a></p></section>';
      $products->set('body', ['value' => $body, 'format' => 'full_html']);
      $products->save();
    }
  }
}
