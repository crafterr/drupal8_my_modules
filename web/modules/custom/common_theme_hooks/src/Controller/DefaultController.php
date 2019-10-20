<?php

namespace Drupal\common_theme_hooks\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  public function items() {
    $items = [
      'Item 1',
      'Item 2'
    ];
    return [
      '#theme' => 'item_list',
      '#items' => $items,
      '#list_type' => 'ol'
    ];
  }

}
