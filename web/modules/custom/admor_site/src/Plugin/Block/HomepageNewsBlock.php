<?php

declare(strict_types=1);

namespace Drupal\admor_site\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;

#[Block(
  id: 'admor_site_homepage_news',
  admin_label: new \Drupal\Core\StringTranslation\TranslatableMarkup('Admor homepage news'),
)]
final class HomepageNewsBlock extends ResolverBlockBase {

  /**
   * {@inheritdoc}
   */
  public function build(): array {
    return [
      '#theme' => 'admor_site_teaser_block',
      '#eyebrow' => 'Latest post',
      '#heading' => 'Stay updated with Admor',
      '#lead' => 'Publish Articles to drive blog and news updates on the homepage.',
      '#items' => $this->resolver->getHomepageSection('news'),
      '#empty_text' => 'No published Article content is available yet.',
      '#link_text' => 'Read more',
    ];
  }

}
