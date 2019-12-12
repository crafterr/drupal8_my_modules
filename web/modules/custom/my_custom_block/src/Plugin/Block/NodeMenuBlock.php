<?php

namespace Drupal\my_custom_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'NodeMenuBlock' block.
 *
 * @Block(
 *  id = "node_menu_block",
 *  admin_label = @Translation("Node menu block"),
 *  category = @Translation("My Group"),
 *  context = {
 *    "node" = @ContextDefinition(
 *      "entity:node",
 *      label = @Translation("Current Node")
 *    )
 *  }
 * )
 */
class NodeMenuBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $node = $this->getContextValue('node');
    $build = [
      '#theme' => 'node_menu_block',
      '#attributes' => [
        'class' => ['node_menu_block'],
        'id' => 'node-menu-block',
      ],
      '#node' => $node,
      '#cache' => [
        'max-age' => 0
      ],
    ];

    return $build;
  }

}
