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

    $fh = fopen($file->getFilename(),'r');

    //Analyze the file format. We should get 2 columns
    $row = fgetcsv($fh);

    //$row = explode(';',$row[0]);

    if (empty($row) || count($row) < 1 ){

      $errors[] = $this->t('The CSV format is incorrect');

    }
    $c =0;
    if($fh){
      while(!feof($fh)){
        $content = fgets($fh);
        if($content)    $c++;
      }
    }
    if ($c==0) {
      $errors[] = $this->t('The CSV has no data');
    }
    fclose($fh);

    return $errors;
  }

}
