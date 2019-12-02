<?php

namespace Drupal\temp_contains_temp\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  /**
   * Hello.
   *
   * @return string
   *   Return Hello string.
   */
  public function hello() {
    $list = [
      'Adam',
      'Maciek',
      'Grzegorz'
    ];
    $icon = ['<span class=icon></span>'];
    $build = [
      '#theme' => 'container_theme',
      '#list' => $list,
      '#icon' => $icon,
    ];

    return $build;
  }

}
