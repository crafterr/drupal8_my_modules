<?php

namespace Drupal\dynamic_tag_cloud\Plugin;

use Drupal\Component\Plugin\PluginInspectionInterface;

/**
 * Defines an interface for Tag cloud plugins.
 */
interface TagCloudInterface extends PluginInspectionInterface {


  public function build($tags);

}
