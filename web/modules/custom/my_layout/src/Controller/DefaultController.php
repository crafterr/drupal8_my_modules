<?php

namespace Drupal\my_layout\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Layout\LayoutInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {


  public function renderLayout() {
    $layoutPluginManager = \Drupal::service('plugin.manager.core.layout');
    /**
     * @var LayoutInterface $layout
     */
    $layout = $layoutPluginManager->createInstance('two_column');

    $regions = [
      'left' => [
        '#markup' => 'my left content',
      ],
      'right' => [
        '#markup' => 'my right content',
      ],
    ];

  return $layout->build($regions);
  }

}
