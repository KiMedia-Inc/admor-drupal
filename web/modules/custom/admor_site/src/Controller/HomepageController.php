<?php

declare(strict_types=1);

namespace Drupal\admor_site\Controller;

/**
 * Returns the Admor homepage route.
 */
final class HomepageController {

  /**
   * Builds the homepage route content.
   */
  public function build(): array {
    return [
      '#markup' => '',
    ];
  }

}
