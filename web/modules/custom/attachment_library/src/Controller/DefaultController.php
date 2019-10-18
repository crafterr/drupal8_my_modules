<?php

namespace Drupal\attachment_library\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {


  /**
   * attach the library 1 way
   * @return array
   *
   */
  public function hello() {
    $some_variable = [1,2,3,4,5];
    return [
      '#theme' => 'attachment_library',
      '#some_variable' => $some_variable,
      '#attached' => [
        'library' => [
          'attachment_library/slick',
        ],
      ],
    ];
  }

}
