<?php

declare(strict_types=1);

namespace Drupal\admor_site\Plugin\Block;

use Drupal\admor_site\Service\ContentResolver;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Shared base class for homepage resolver blocks.
 */
abstract class ResolverBlockBase extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Constructs the block.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, protected readonly ContentResolver $resolver) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition): static {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('admor_site.content_resolver'),
    );
  }

  /**
   * Returns the active theme relative path.
   */
  protected function themePath(): string {
    return base_path() . \Drupal::service('extension.list.theme')->getPath('admor');
  }

}
