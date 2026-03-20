<?php

declare(strict_types=1);

namespace Drupal\admor_site\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;

#[Block(
  id: 'admor_site_homepage_cta',
  admin_label: new \Drupal\Core\StringTranslation\TranslatableMarkup('Admor homepage CTA'),
)]
final class HomepageCtaBlock extends ResolverBlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    return ['#theme' => 'admor_site_cta_block'];
  }

}
