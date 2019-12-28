<?php

namespace Drupal\colours\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for Colour plugin plugins.
 */
interface ColourPluginInterface extends PluginInspectionInterface {

  /**
   * @return array of
   */
  public function render();

  public function getDescription();


}
