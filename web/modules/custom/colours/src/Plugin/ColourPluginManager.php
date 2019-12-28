<?php

namespace Drupal\colours\Plugin;

use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;

/**
 * Provides the Colour plugin plugin manager.
 */
class ColourPluginManager extends DefaultPluginManager {


  /**
   * Constructs a new ColourPluginManager object.
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
    parent::__construct('Plugin/ColourPlugin', $namespaces, $module_handler, 'Drupal\colours\Plugin\ColourPluginInterface', 'Drupal\colours\Annotation\ColourPlugin');

    $this->alterInfo('colours_colour_plugin_info');
    $this->setCacheBackend($cache_backend, 'colours_colour_plugin_plugins');
  }

}
