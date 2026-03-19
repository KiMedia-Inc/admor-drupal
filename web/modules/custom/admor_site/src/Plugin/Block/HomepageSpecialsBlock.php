<?php

declare(strict_types=1);

namespace Drupal\admor_site\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;

#[Block(
  id: 'admor_site_homepage_specials',
  admin_label: new \Drupal\Core\StringTranslation\TranslatableMarkup('Admor homepage specials'),
)]
final class HomepageSpecialsBlock extends ResolverBlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    return [
      '#theme' => 'admor_site_teaser_block',
      '#eyebrow' => 'Specials & rebates',
      '#heading' => 'Promotions and limited-time offers',
      '#lead' => 'Published Specials & Rebates content appears here automatically.',
      '#items' => $this->resolver->getHomepageSection('specials'),
      '#empty_text' => 'No published Specials & Rebates content is available yet.',
      '#link_text' => 'Read more',
    ];
  }

}
