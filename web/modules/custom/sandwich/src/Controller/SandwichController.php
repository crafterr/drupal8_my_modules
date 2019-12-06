<?php

/**
 * @file
 * Contains \Drupal\sandwich\Controller\SandwichController.
 */

namespace Drupal\sandwich\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for sandwich module routes.
 */
class SandwichController extends ControllerBase {

  /**
   * Builds a sandwich.
   */
  public function build() {



    $render = [
      '#type' => 'sandwich',
      '#contextual_links' => [
        'sandwich' => [
          'route_parameters' => []
        ],
      ],

      '#attributes' => [
        'id' => 'best-sandwich2',
        'class' => ['menu--lefter', 'clearfix'],
      ],
      '#isActive' => false,


      '#cheese' => $this->t('Gruyère'),
      '#veggies' => [
        $this->t('Avocado'),
        $this->t('Red onion'),
        $this->t('Romaine'),
      ],
      '#protein' => $this->t('Chicken'),

    ];

    $render['#name']['#markup'] = $this->t('Chickado');

    return $render;


  }

  public function build2() {
    $render = [
      '#theme' => 'sandwich_test',
      '#service' => [
      '#contextual_links' => [
        'sandwich' => [
          'route_parameters' => []
        ],
      ],
      ],

    ];
    $render['#service']['#markup'] = 'dupa';
    return $render;
  }

}
