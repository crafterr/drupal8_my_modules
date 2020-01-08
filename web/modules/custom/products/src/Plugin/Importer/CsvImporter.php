<?php
namespace Drupal\products\Plugin\Importer;

use Drupal\products\Annotation\Importer;
use Drupal\products\Plugin\ImporterBase;

/**
 * Class CsvImporter
 *
 * @Importer(
 *   id = "csv",
 *   label = @Translation("CSV Importer")
 * )
 */
class CsvImporter extends ImporterBase {

  /**
   * Import all data from csv file
   * @return bool
   */
  public function import() {
    //@todo napisac funkcjoność importu dla csv
  }



}