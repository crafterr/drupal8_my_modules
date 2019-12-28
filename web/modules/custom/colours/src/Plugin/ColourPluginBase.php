<?php

namespace Drupal\colours\Plugin;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for Colour plugin plugins.
 */
abstract class ColourPluginBase extends PluginBase implements ColourPluginInterface {


  public function getDescription() {
    return $this->pluginDefinition['description'];
  }

  public function render() {
    return [
      '#markup' => $this->getDescription()
    ];
  }

}
