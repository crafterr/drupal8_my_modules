<?php

namespace Drupal\hello_world;

use Drupal\Core\Config\ConfigFactoryOverrideInterface;
use Drupal\Core\Config\StorageInterface;
use Drupal\Core\Cache\CacheableMetadata;
class HelloWorldConfigOverrides implements ConfigFactoryOverrideInterface {

  public function loadOverrides($names) {
    $overrides = [];
    if (in_array('system.maintenance', $names)) {
      $overrides['system.maintenance'] = ['message' => 'Our own message for the site maintenance mode.'];
    }

    return $overrides;
  }

  public function getCacheSuffix() {
    return 'HelloWorldConfigOverrider';
  }

  public function createConfigObject($name, $collection = StorageInterface::DEFAULT_COLLECTION) {
    return NULL;
  }

  public function getCacheableMetadata($name) {
    return new CacheableMetadata();
  }


}