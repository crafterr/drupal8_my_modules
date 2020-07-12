<?php
namespace Drupal\dynamic_tag_cloud\Plugin\TagCloud;

use Drupal\dynamic_tag_cloud\Plugin\TagCloudBase;

/**
 * Default tag cloud style.
 *
 * @TagCloud(
 *  id = "default_tag_cloud",
 *  label = @Translation("Default"),
 *  libraries = {
 *   "dynamictagclouds/default_tag_cloud"
 *  },
 *  template = {
 *    "type" = "module",
 *    "name" = "dynamic_tag_cloud",
 *    "directory" = "templates",
 *    "file" = "dynamic-tag-cloud"
 *  }
 * )
 */
class DefaultTagCloud extends TagCloudBase {

  /**
   * {@inheritdoc}
   */
  public function build($tags) {
    $build = parent::build($tags);

    return $build;
  }

}