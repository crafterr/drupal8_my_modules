<?php

namespace Drupal\my_custom_block\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {


  public function render() {
    $block_manager = \Drupal::service('plugin.manager.block');
    // You can hard code configuration or you load from settings.
    $config = [];
    $plugin_block = $block_manager->createInstance('copyright_block', $config);
    // Some blocks might implement access check.
    $access_result = $plugin_block->access(\Drupal::currentUser());
    // Return empty render array if user doesn't have access.
    // $access_result can be boolean or an AccessResult class
    if (is_object($access_result) && $access_result->isForbidden() || is_bool($access_result) && !$access_result) {
      // You might need to add some cache tags/contexts.
      return [];
    }
    $render = $plugin_block->build();
    // In some cases, you need to add the cache tags/context depending on
    // the block implemention. As it's possible to add the cache tags and
    // contexts in the render method and in ::getCacheTags and
    // ::getCacheContexts methods.
    return $render;
  }

}
