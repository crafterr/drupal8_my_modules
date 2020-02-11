<?php

namespace Drupal\my_crone\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\file\Entity\File;
/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {


  public function save() {
    return [];
    $date = (new \DateTime())->format('Y-m-d h:i:s');
    $file = file_save_data((new \DateTime())->format('Y-m-d h:i:s'), "public://my_file_$date.txt", \Drupal\Core\File\FileSystemInterface::EXISTS_REPLACE);
    if ($file) {
      echo 'dane zostaly zapisane';
    }
    die();
  }

}
