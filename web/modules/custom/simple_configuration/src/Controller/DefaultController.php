<?php

namespace Drupal\simple_configuration\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  /**
   * @return array
   */
  public function hello() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method'),
    ];
  }

}
