<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class HelloWorldController.
 */
class HelloWorldController extends ControllerBase {

  /**
   * Helloworld.
   *
   * @return string
   *   Return Hello string.
   */
  public function helloWorld() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: helloWorld')
    ];
  }

}
