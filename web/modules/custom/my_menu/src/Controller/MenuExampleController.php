<?php

namespace Drupal\my_menu\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\my_menu\Utility\DescriptionTemplateTrait;

/**
 * Class MenuExampleController.
 */
class MenuExampleController extends ControllerBase {

  use DescriptionTemplateTrait;

  protected function getModuleName() {
    return 'my_menu';
  }

  public function test() {
    $build = [
      '#params' => [1,2,3,4,5],
      '#theme' => 'mytest',
    ];
    return $build;
  }

  public function subscription() {
    $template_path = $this->getSubscriptionTemplatePath();
    $template = file_get_contents($template_path);

    return [
      'dupa' => [
        '#type' => 'inline_template',
        '#template' => $template,
        '#context' => [
          'params' => [
            'person' => [
              [
                'name' => 'Adam',
                'age' => 33
              ],
              [
                'name' => 'Grzegprz',
                'age' => 35

              ]
             ]

          ]
        ],
      ]
    ];
  }


}
