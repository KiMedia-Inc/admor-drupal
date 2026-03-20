<?php

declare(strict_types=1);

namespace Drupal\admor_site\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;

#[Block(
  id: 'admor_site_homepage_categories',
  admin_label: new \Drupal\Core\StringTranslation\TranslatableMarkup('Admor homepage categories'),
)]
final class HomepageCategoriesBlock extends ResolverBlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    return [
      '#theme' => 'admor_site_categories_block',
      '#items' => $this->resolver->getHomepageSection('categories'),
    ];
  }

}
