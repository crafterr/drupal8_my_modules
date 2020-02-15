<?php
namespace Drupal\products\Plugin\Importer;

use Drupal\Core\StringTranslation\StringTranslationTrait;
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
  use StringTranslationTrait;
  /**
   * Import all data from csv file
   * @return bool
   */
  public function import() {
    //@todo napisac funkcjoność importu dla csv
  }

  /**
   * {@inheritdoc}
   */
  public function getConfigurationForm(\Drupal\products\Entity\ImporterInterface $importer) {
    $form = [];
    $config = $importer->getPluginConfiguration();
    $form['url'] = [
      '#type' => 'url',
      '#default_value' => isset($config['url']) ? $config['url'] : '',
      '#title' => $this->t('Url'),
      '#description' => $this->t('The URL to the import resource'),
      '#required' => TRUE,
    ];
    return $form;
  }

}