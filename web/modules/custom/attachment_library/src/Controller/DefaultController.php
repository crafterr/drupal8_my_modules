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
    $some_variable = 'adam ma kota';
    /*return [
      '#theme' => 'attachment_library',
      '#some_variable' => $some_variable,
      '#attached' => [
        'library' => [
          'attachment_library/slick',
        ],
      ],
    ];*/
   /* return [
      '#theme' => 'item_list',
      '#items' => [

      ],
      '#title' => 'Moja item lista',
      '#empty' => 'Lista nie zawiera elementów'
    ];*/

   $x = 1;

   $this->count($x);

   dump($x);

   die();
  }

  function count(&$x) {
    $x++;
  }

}
