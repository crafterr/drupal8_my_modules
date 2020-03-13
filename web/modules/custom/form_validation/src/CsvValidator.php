<?php

namespace Drupal\form_validation;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\file\FileInterface;

/**
 * Class CsvValidator.
 */
class CsvValidator implements CsvValidatorInterface {

  use StringTranslationTrait;

  public  function validate(FileInterface $file) {
    $errors = [];
    $errors[] = $this->t('The CSV format is incorrect. Use commas');
    return $errors;
  }

}
