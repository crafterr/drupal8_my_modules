<?php

namespace Drupal\dynamic_tag_cloud\Plugin;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for Tag cloud plugins.
 */
abstract class TagCloudBase extends PluginBase implements TagCloudInterface {


  /**
   * @inheritDoc
   */
  public function build($tags) {
    $template = $this->getTemplatePath();
    $build = [
      '#type' => 'inline_template',
      '#template' => \Drupal::service('twig')
        ->loadTemplate($template)
        ->render(['tags' => $tags])
    ];

    foreach ($this->getPluginDefinition()['libraries'] as $library) {
      $build['#attached']['library'][] = $library;
    }

    return $build;
  }

  /**
   * Method to return tag cloud style template file path.
   *
   * @return string
   *   Template file path.
   */
  protected function getTemplatePath() {
    $template = $this->getPluginDefinition()['template'];

    return drupal_get_path(
        $template['type'],
        $template['name']
      ) . '/' . $template['directory'] . '/' . $template['file'] . '.html.twig';
  }

}
