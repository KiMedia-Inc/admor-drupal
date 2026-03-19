<?php

declare(strict_types=1);

namespace Drupal\admor_site\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;

#[Block(
  id: 'admor_site_homepage_hero',
  admin_label: new \Drupal\Core\StringTranslation\TranslatableMarkup('Admor homepage hero'),
)]
final class HomepageHeroBlock extends ResolverBlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    return [
      '#theme' => 'admor_site_hero_block',
      '#items' => $this->resolver->getHomepageSection('hero_products'),
      '#theme_path' => $this->themePath(),
      '#attached' => ['library' => ['admor/homepage']],
    ];
  }

}
