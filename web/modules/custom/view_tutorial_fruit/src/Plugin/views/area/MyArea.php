<?php

namespace Drupal\view_tutorial_fruit\Plugin\views\area;

use Drupal\views\Plugin\views\area\AreaPluginBase;
/**
 * Defines a views area plugin.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("my_area")
 */
class MyArea extends AreaPluginBase {

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE) {
    if (!$empty || !empty($this->options['empty'])) {
      return array(
        '#markup' => 'test footer content',
      );
    }

    return array();
  }
}
