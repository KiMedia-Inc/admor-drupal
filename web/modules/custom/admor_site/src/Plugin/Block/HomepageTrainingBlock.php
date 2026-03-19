<?php

declare(strict_types=1);

namespace Drupal\admor_site\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;

#[Block(
  id: 'admor_site_homepage_training',
  admin_label: new \Drupal\Core\StringTranslation\TranslatableMarkup('Admor homepage training'),
)]
final class HomepageTrainingBlock extends ResolverBlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    return [
      '#theme' => 'admor_site_teaser_block',
      '#eyebrow' => 'Training & events',
      '#heading' => 'Upcoming sessions across the islands',
      '#lead' => 'Training & Events nodes are ordered by Event start when available.',
      '#items' => $this->resolver->getHomepageSection('training'),
      '#empty_text' => 'No published Training & Events content is available yet.',
      '#link_text' => 'Read more',
    ];
  }

}
