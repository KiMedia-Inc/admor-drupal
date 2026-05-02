<?php

declare(strict_types=1);

use Drupal\redirect\Entity\Redirect;

$csv = dirname(__DIR__) . '/data/migration/wordpress-public-inventory.csv';
if (!is_readable($csv)) {
  throw new RuntimeException('Missing migration inventory CSV: ' . $csv);
}

$corrections = [
  '/category/home' => '/',
  '/category/uncategorized' => '/updates',
  '/commercials' => '/commercials',
  '/2019/04/20/2014-coolingcancer-charity-golf-tournament' => '/updates/2014-cooling-cancer-charity-golf-tournament',
  '/2019/04/20/donations-cool-schools' => '/updates/donations-to-cool-schools',
  '/2019/04/21/2015-coolingcancer-golf-tournament' => '/updates/2015-cooling-cancer-golf-tournament',
  '/2019/04/21/2016-coolingcancer-golf-tournament' => '/updates/2016-cooling-cancer-golf-tournament',
  '/2019/04/21/2017-coolingcancer-golf-tournament' => '/updates/2017-cooling-cancer-golf-tournament',
  '/2019/04/21/coolingcancer-donates-45k' => '/updates/cooling-cancer-donates-45k',
  '/2019/04/21/coolingcancer-donates-50k' => '/updates/cooling-cancer-donates-50k',
  '/2019/04/21/fujitsus-infinite-comfort-app' => '/updates/fujitsu-infinite-comfort-app',
  '/2019/04/21/w-oahu-schools-receive-donation' => '/updates/west-oahu-schools-receive-donation',
  '/2019/04/22/commercials' => '/commercials',
  '/2019/04/22/updates' => '/updates',
  '/2019/04/23/fujitsus-gym-dog' => '/commercials/fujitsus-gym-dog',
  '/2019/04/23/wangs-world-of-fujitsu' => '/commercials/wangs-world-of-fujitsu-brand-story',
  '/2019/04/23/wangs-world-of-fujitsu-2' => '/commercials/wangs-world-of-fujitsu-local-comfort',
  '/2019/05/28/coolingcancer-donates-70k-2' => '/updates/cooling-cancer-donates-70k',
  '/2024/06/06/fujitsu-generals-procore-high-corrosion-resistant-techonology' => '/updates/fujitsu-procore-corrosion-resistant-technology',
];

$pdf_redirects = [
  '/wp-content/uploads/2021/04/2021_Full_Line_Brochure_FG2028.pdf' => '/sites/default/files/fujitsu-pdfs/full-line-brochure.pdf',
  '/wp-content/uploads/2021/05/fujitsu2019-Troubleshooting-Guide.pdf' => '/sites/default/files/fujitsu-pdfs/fujitsu-410a-mini-split-troubleshooting-guide.pdf',
  '/wp-content/uploads/2020/06/2020_hawaii_energy_1500_rebate.pdf' => '/sites/default/files/fujitsu-pdfs/hawaii-energy-rebates.pdf',
  '/files/products/fujitsu-2018-full-line-brochure.pdf' => '/sites/default/files/fujitsu-pdfs/2018-fujitsu-full-line-catalog.pdf',
  '/files/products/J_IIS_Series_Sell_Sheet.pdf' => '/sites/default/files/fujitsu-pdfs/airstage-j-iis-series-sell-sheet.pdf',
  '/files/products/aou45rlxfz-june-2016-ad.pdf' => '/sites/default/files/fujitsu-pdfs/aou45rlxfz-5-zone-sell-sheet.pdf',
  '/files/products/multi-zone-brochure-april-2016.pdf' => '/sites/default/files/fujitsu-pdfs/2016-multi-zone-brochure.pdf',
  '/files/products/auto-louver-grille-kit-halcyon.pdf' => '/sites/default/files/fujitsu-pdfs/halcyon-auto-louver-grille-kit.pdf',
  '/files/products/hybrid-flex-inverter-48000.pdf' => '/sites/default/files/fujitsu-pdfs/hybrid-flex-inverter-48-000-btu-8-zone-sell-sheet.pdf',
  '/files/products/fujitsu-9&4-rl2.pdf' => '/sites/default/files/fujitsu-pdfs/fujitsu-4rl2-and-9rl2-sell-sheet.pdf',
  '/files/products/fujitsu-18rulx-24rulx-36rslx.pdf' => '/sites/default/files/fujitsu-pdfs/fujitsu-18rulx-24rulx-36rslx-sell-sheet.pdf',
  '/files/products/fujitsu-454-18-24-36-42rclx.pdf' => '/sites/default/files/fujitsu-pdfs/fujitsu-18rclx-24rclx-36rclx-42rclx-sell-sheet.pdf',
  '/files/products/fujitsi-mini-split-flipbook.pdf' => '/sites/default/files/fujitsu-pdfs/fujitsu-mini-split-flipbook.pdf',
  '/files/products/fujitsu-advantages.pdf' => '/sites/default/files/fujitsu-pdfs/fujitsu-advantages.pdf',
  '/files/products/fujitsu-cooling-systems.pdf' => '/sites/default/files/fujitsu-pdfs/fujitsu-cooling-systems.pdf',
  '/files/products/heat-pump-savings-brochure.pdf' => '/sites/default/files/fujitsu-pdfs/heat-pump-savings-brochure.pdf',
];

$redirects = [];
$handle = fopen($csv, 'rb');
$headers = fgetcsv($handle);
while (($row = fgetcsv($handle)) !== FALSE) {
  $item = array_combine($headers, $row);
  $source = normalize_source_path($item['source_path']);
  $target = $corrections[$source] ?? ($item['target_alias'] ?: '/');
  if ($source && $target && $source !== '/' && normalize_source_path($target) !== $source) {
    $redirects[$source] = $target;
  }
}
fclose($handle);

foreach ($corrections + $pdf_redirects as $source => $target) {
  $redirects[normalize_source_path($source)] = $target;
}
unset($redirects['/home']);
if ($home_redirect = load_redirect('/home')) {
  $home_redirect->delete();
}
foreach (array_keys($redirects) as $source) {
  if (normalize_source_path($redirects[$source]) === $source) {
    unset($redirects[$source]);
  }
}
foreach (['/products', '/resources', '/commercials', '/friends-family', '/maintenance-tips', '/tech-tips', '/locate-a-fujitsu-contractor'] as $identity_path) {
  if ($identity_redirect = load_redirect($identity_path)) {
    $identity_redirect->delete();
  }
}

$created = 0;
$updated = 0;
foreach ($redirects as $source => $target) {
  $redirect = load_redirect($source) ?: Redirect::create();
  $is_new = $redirect->isNew();
  $redirect->setSource(ltrim($source, '/'));
  $redirect->setRedirect($target);
  $redirect->setStatusCode(301);
  $redirect->save();
  $is_new ? $created++ : $updated++;
}

echo "Redirects created: $created\n";
echo "Redirects updated: $updated\n";

function normalize_source_path(string $path): string {
  $path = parse_url(trim($path), PHP_URL_PATH) ?: trim($path);
  $path = '/' . trim($path, '/');
  return $path === '/' ? '/' : rtrim($path, '/');
}

function load_redirect(string $source): ?Redirect {
  $ids = \Drupal::entityQuery('redirect')
    ->condition('redirect_source.path', ltrim($source, '/'))
    ->accessCheck(FALSE)
    ->range(0, 1)
    ->execute();
  return $ids ? Redirect::load(reset($ids)) : NULL;
}
