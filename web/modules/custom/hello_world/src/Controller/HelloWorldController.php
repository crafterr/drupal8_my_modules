<?php

namespace Drupal\hello_world\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;

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
  public function helloWorld(NodeInterface $node) {
    dump($node); die();
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: helloWorld')
    ];
  }

  public function helloWorldSimple() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: helloWorld')
    ];
  }
}
