<?php

namespace Drupal\my_yaml_readable\Controller;

use Symfony\Component\Yaml\Yaml;
use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {



  /**
   * Dsafads.
   *
   * @return string
   *   Return Hello string.
   */
  public function read() {
    $file_path = DRUPAL_ROOT.'/modules/custom/my_yaml_readable/config/my_yaml_readable.config.yml';
    if (file_exists($file_path)) {
      $file_contents = file_get_contents($file_path);
      $yaml = Yaml::parse($file_contents);
      dump($yaml); die();
    }

  }

}
