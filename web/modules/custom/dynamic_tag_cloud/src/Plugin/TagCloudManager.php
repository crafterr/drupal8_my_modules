<?php

namespace Drupal\dynamic_tag_cloud\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Tag cloud plugin manager.
 */
class TagCloudManager extends DefaultPluginManager {


  /**
   * Constructs a new TagCloudManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct('Plugin/TagCloud', $namespaces, $module_handler, 'Drupal\dynamic_tag_cloud\Plugin\TagCloudInterface', 'Drupal\dynamic_tag_cloud\Annotation\TagCloud');

    $this->alterInfo('dynamic_tag_cloud_tag_cloud_info');
    $this->setCacheBackend($cache_backend, 'dynamic_tag_cloud_tag_cloud_plugins');
  }

}
