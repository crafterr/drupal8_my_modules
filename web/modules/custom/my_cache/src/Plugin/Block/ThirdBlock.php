<?php

namespace Drupal\my_cache\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'DefaultBlock' block.
 *
 * @Block(
 *  id = "third_block",
 *  admin_label = @Translation("Third block"),
 * )
 */
class ThirdBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $count = rand(1,10);

    $build = [
      '#theme' => 'my_cache',
      '#name' => $count,
    ];

    return $build;
  }

  public function getCacheMaxAge() {
    return Cache::mergeMaxAges(parent::getCacheMaxAge(), Cache::PERMANENT);
  }

  public function getCacheContexts() {
    return Cache::mergeContexts(parent::getCacheContexts(),['url.path']);
  }

}
