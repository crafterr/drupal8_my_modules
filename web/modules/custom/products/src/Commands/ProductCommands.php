<?php

namespace Drupal\products\Commands;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drush\Commands\DrushCommands;
use Symfony\Component\Console\Input\InputOption;
use Drupal\products\Plugin\ImporterManager;

/**
 * Drush commands for products.
 */
class ProductCommands extends DrushCommands{

  /**
   * @var \Drupal\products\Plugin\ImporterManager
   */
  protected $importerManager;

  /**
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * ProductCommands constructor.
   *
   * @param \Drupal\products\Plugin\ImporterManager $importerManager
   */
  public function __construct(ImporterManager $importerManager, EntityTypeManagerInterface $entityTypeManager) {
    $this->importerManager = $importerManager;
    $this->entityTypeManager = $entityTypeManager;

  }

  /**
   * Imports the Products
   *
   * @option importer
   *   The importer config ID to use.
   *
   * @command products-import-run
   * @aliases pir
   *
   * @param array $options
   *   The command options.
   */
  public function import($options = ['importer' => InputOption::VALUE_OPTIONAL]) {
    $importer = $options['importer'];
    /**
     * @var \Drupal\products\Entity\Importer $config
     */
    $config = $this->entityTypeManager->getStorage('importer')->load($importer);
    if ($importer=='all') {
      //run all importers
      $plugins = $this->importerManager->createInstanceFromAllConfigs();
      if (!$plugins) {
        $this->logger()->log('error', t('There are no importers to run.'));
        return;
      }

      foreach ($plugins as $plugin) {
        $this->runPluginImport($plugin);
      }
      return;
    }
    if (!is_null($importer)) {
      $plugin = $this->importerManager->createInstanceFromConfig($config);
      if (is_null($plugin)) {
        $this->logger()->log('error', t('The specified importer does not exist.'));
        return;
      }

      $this->runPluginImport($plugin);
    }



    return;
  }

  public function runPluginImport(\Drupal\products\Plugin\ImporterInterface $plugin) {
    /**
     * @var \Drupal\products\Plugin\ImporterInterface $plugin
     */
    $result = $plugin->import();
    $message_values = ['@importer' => $plugin->getConfig()->label()];
    if ($result) {
      $this->logger()->log('status', t('The "@importer" importer has been run.', $message_values));
      return;
    }

    $this->logger()->log('error', t('There was a problem running the "@importer" importer.', $message_values));
  }

  /**
   * Show all Products
   * The importer config ID to use.
   *
   * @command show-products
   * @aliases sp
   *
   */
  public function showProducts() {
    $products = $this->entityTypeManager->getStorage('product')->loadMultiple();
    $i = 0;
    foreach ($products as $product) {
      /**
       * @var \Drupal\products\Entity\ProductInterface $product
       */
      $i++;
      echo $i.'. '.$product->getName(). PHP_EOL;
    }
    return;
  }
}