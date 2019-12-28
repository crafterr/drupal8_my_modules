<?php

namespace Drupal\colours\Annotation;

use Drupal\Component\Annotation\Plugin;

/**
 * Defines a Colour plugin item annotation object.
 *
 * @see \Drupal\colours\Plugin\ColourPluginManager
 * @see plugin_api
 *
 * @Annotation
 */
class ColourPlugin extends Plugin {


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

  /**
   * The description of the plugin.
   *
   * @var \Drupal\Core\Annotation\Translation
   *
   * @ingroup plugin_translatable
   */
  public $description;

}
