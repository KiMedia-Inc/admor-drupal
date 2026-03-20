<?php

declare(strict_types=1);

namespace Drupal\admor_site\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;

#[Block(
  id: 'admor_site_homepage_testimonials',
  admin_label: new \Drupal\Core\StringTranslation\TranslatableMarkup('Admor homepage testimonials'),
)]
final class HomepageTestimonialsBlock extends ResolverBlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    return [
      '#theme' => 'admor_site_testimonials_block',
      '#items' => $this->resolver->getHomepageSection('testimonials'),
      '#attached' => ['library' => ['admor/homepage']],
    ];
  }

}
