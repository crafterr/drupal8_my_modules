<?php

namespace Drupal\my_layout\Controller;

use Drupal\block\Entity\Block;
use Drupal\block_content\Entity\BlockContent;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Layout\LayoutInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {


  public function renderLayout() {


    //Plugin blocks
    $block_manager = \Drupal::service('plugin.manager.block');
    $config = [];
    $plugin_block = $block_manager->createInstance('hello_world_salutation_block', $config);
    $access_result = $plugin_block->access(\Drupal::currentUser());
    $build =  $plugin_block->build();

    //content block
    $block = BlockContent::load(1);
    $build2 = \Drupal::entityTypeManager()->
    getViewBuilder('block_content')->view($block);



    $layoutPluginManager = \Drupal::service('plugin.manager.core.layout');
    /**
     * @var LayoutInterface $layout
     */
    $layout = $layoutPluginManager->createInstance('two_column');
    $regions = [
      'left' => [
        $build,
      ],
      'right' => [
        $build2
      ],
    ];

  return $layout->build($regions);
  }

}
