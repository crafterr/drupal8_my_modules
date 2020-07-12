<?php

namespace Drupal\dynamic_tag_cloud\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Tag cloud item annotation object.
 *
 * @see \Drupal\dynamic_tag_cloud\Plugin\TagCloudManager
 * @see plugin_api
 *
 * @Annotation
 */
class TagCloud extends Plugin {


  /**
   * The plugin ID.
   *
   * @var string
   */
  public $id;

  /**
   * The label of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $label;

}
