<?php

namespace Drupal\common_theme_hooks\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;

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

  public function links() {
    $links = [
      [
        'title' => 'Link 1',
        'url' => Url::fromRoute('common_theme_hooks.default_controller_links'),
      ],
      [
        'title' => 'Link 1',
        'url' => Url::fromRoute('common_theme_hooks.default_controller_hello'),
      ]
    ];

    return [
      '#theme' => 'links',
      '#links' => $links,
      '#set_active_class' => true,
    ];
  }

  public function table() {
    $header = ['Column 1', 'Column 2'];
    $rows = [
      ['Row 1, Column 1', 'Row 1, Column 2'],
      ['Row 2, Column 1', 'Row 2, Column 2']
    ];

    return [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    ];
  }

}
