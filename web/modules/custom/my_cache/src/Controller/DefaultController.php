<?php

namespace Drupal\my_cache\Controller;

use Drupal\Component\Utility\Random;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  /**
   * Hello world/
   *
   * @return string
   *   Return Hello string.
   */
  public function render($id) {
    Cache::invalidateTags(['moj_tag']);
    $count = rand(1,10);
    $build = [
      '#theme' => 'my_cache',
      '#name' => $count,
      '#cache' => [

        // 'keys' => ['special-key'],
         //'contexts' => ['url.path'],
         'max-age' => 0
      ],
    ];

    return [];
  }

  public function api(NodeInterface $node) {
    Cache::invalidateTags(['moj_tag']);
    die();
    $cache = \Drupal::cache('render');
    //$cache->set('my_renderer_cache',[1,2,3,4,5,6],CacheBackendInterface::CACHE_PERMANENT);
   // dump($cache->get('my_renderer_cache')->data); die();
    //cache sie przeladuje dla node_id = 1 przy updacie wpisu
    //$cache->set('my_cache_entry_cid', $node->getTitle(), CacheBackendInterface::CACHE_PERMANENT, ['node:1']);
    /**
     * We essentially make it dependent on changes to the Node with the ID of 10. This means that when that node changes,
     * our entry (together with all other entries in all other bins that have the same tag) becomes invalid. Simple as that.
     */
    dump($cache->get('my_cache_entry_cid')->data); die();
  }
}
