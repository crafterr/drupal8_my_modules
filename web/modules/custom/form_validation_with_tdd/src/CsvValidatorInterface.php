<?php

namespace Drupal\form_validation_with_tdd;

use Drupal\file\FileInterface;

/**
 * Interface CsvValidatorInterface.
 */
interface CsvValidatorInterface {

  public function validate(FileInterface $file);
}
