<?php

namespace Drupal\my_menu\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Menu\MenuTreeParameters;
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

  public function renderMenu() {
    $menu_tree = \Drupal::menuTree();
    // Build the typical default set of menu tree parameters.
    $parameters = $menu_tree->getCurrentRouteMenuTreeParameters('test-menu');
    // Load the tree based on this set of parameters.
    $tree = $menu_tree->load('test-menu', $parameters);
    // Transform the tree using the manipulators you want.
    $manipulators = array(
      // Only show links that are accessible for the current user.
      array('callable' => 'menu.default_tree_manipulators:checkAccess'),
      // Use the default sorting of menu links.
      array('callable' => 'menu.default_tree_manipulators:generateIndexAndSort'),
    );
    $tree = $menu_tree->transform($tree, $manipulators);
    // Finally, build a renderable array from the transformed tree.
    $menu = $menu_tree->build($tree);



    return $menu;
  }

}
