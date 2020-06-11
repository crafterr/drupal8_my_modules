<?php
namespace Drupal\form_validation_with_tdd;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\file\FileInterface;

class CsvValidator {
use StringTranslationTrait;

  /**
   * @inheritDoc
   */
    public function validate(FileInterface $file) {
      $errors = [];
      $fh = fopen($file->getFileUri(),'r');

      //Analyze the file format. We should get 2 columns.
      $row = fgetcsv($fh);
      if (empty($row) || count($row) < 2) {
        return [
          $this->t('The CSV format is incorrect. Use commas.')
        ];
      }

      $i = 0;
      while ($row = fgetcsv($fh)) {
        $i++;
        @list($title,$author) = $row;
        if (empty($title)) {
          $errors[] = $this->t('The book title on line @line is empty. You must provide a title for each book.',['@line'=>$i]);
        }
        if (empty($author)) {
          $errors[] = $this->t('The author on line @line is empty. You must provide at least one author.',['@line'=>$i]);
        }
      }
      return $errors;
    }
}