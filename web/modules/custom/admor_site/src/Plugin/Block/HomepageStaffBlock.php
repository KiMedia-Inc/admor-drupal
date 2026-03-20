<?php

declare(strict_types=1);

namespace Drupal\admor_site\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;

#[Block(
  id: 'admor_site_homepage_staff',
  admin_label: new \Drupal\Core\StringTranslation\TranslatableMarkup('Admor homepage staff'),
)]
final class HomepageStaffBlock extends ResolverBlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    return [
      '#theme' => 'admor_site_staff_block',
      '#groups' => $this->resolver->getHomepageSection('staff_groups'),
      '#theme_path' => $this->themePath(),
    ];
  }

}
