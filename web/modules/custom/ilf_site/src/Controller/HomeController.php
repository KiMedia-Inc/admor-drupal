<?php

declare(strict_types=1);

namespace Drupal\ilf_site\Controller;

use Drupal\Core\Controller\ControllerBase;

final class HomeController extends ControllerBase {

  public function home(): array {
    return [
      '#markup' => '',
      '#cache' => [
        'max-age' => 0,
      ],
    ];
  }

}
