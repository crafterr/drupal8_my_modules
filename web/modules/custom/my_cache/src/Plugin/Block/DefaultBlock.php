<?php

namespace Drupal\my_cache\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'DefaultBlock' block.
 *
 * @Block(
 *  id = "default_block",
 *  admin_label = @Translation("Default block"),
 * )
 */
class DefaultBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $count = rand(1,10);
    $build = [
      '#theme' => 'my_cache',
      '#name' => $count,
      /*'#cache' => [
       // 'keys' => ['special-key-for-block'],
        //'contexts' => ['url.path']
        'max-age' => 0
      ],*/
    ];

    return $build;
  }



}
