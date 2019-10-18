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
      '#theme' => 'some_theme_hook',
      '#some_variable' => $some_variable,
      '#attached' => [
        'library' => [
          'my_module/my-library',
        ],
      ],
    ];
  }

}
