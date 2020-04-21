<?php
namespace Drupal\products\Plugin\Importer;

use Drupal\Core\DependencyInjection\DependencySerializationTrait;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\products\Annotation\Importer;
use Drupal\products\Plugin\ImporterBase;
use Drupal\Core\Batch\BatchBuilder;

/**
 * Class JsonImporter
 *
 * @Importer(
 *   id = "json",
 *   label = @Translation("JSON Importer")
 * )
 */
class JsonImporter extends ImporterBase {
  use StringTranslationTrait;
  use DependencySerializationTrait;
  /**
   * Import all data from json file
   * @return bool
   */
  public function import() {
    $data = $this->getData();
    if (!$data) {
      return false;
    }
    if (!isset($data->products)) {
      return false;
    }

    $products = $data->products;

    /*foreach ($products as $product) {
      $this->persistProduct($product);
    }*/
    $batch_builder = (new BatchBuilder())
      ->setTitle($this->t('Importing products'))
      ->setFinishCallback([$this, 'importProductsFinished']);

    $batch_builder->addOperation([$this, 'firstOperation']);
    $batch_builder->addOperation([$this, 'clearMissing'], [$products]);
    $batch_builder->addOperation([$this, 'importProducts'], [$products]);

    batch_set($batch_builder->toArray());
    return batch_process('admin/structure/importer');
  }

  public function firstOperation(&$context) {
    if (!isset($context['results']['files'])) {
      $context['results']['files'] = [];
    }
    $data = ['file1','file2','file3','file4','file5'];


    $sandbox = &$context['sandbox'];
    if (!$sandbox) {
      $sandbox['progress'] = 0;
      $sandbox['max'] = count($data);
      $sandbox['data'] = $data;
    }

    $slice = array_splice($sandbox['data'], 0, 1);
    foreach ($slice as $f) {
      $file = file_save_data((new \DateTime())->format('Y-m-d h:i:s'), "public://my_file_$f.txt", \Drupal\Core\File\FileSystemInterface::EXISTS_REPLACE);
      $context['message'] = $this->t('Created file @name', ['@name' => $f]);
      sleep(1);

      $context['results']['files'][] = $f;
      $sandbox['progress']++;

    }
    $context['finished'] = $sandbox['progress'] / $sandbox['max'];


  }

  /**
   * Batch operation to remove the products which are no longer in the list of
   * products coming from the JSON file.
   *
   * @param $products
   * @param $context
   */
  public function clearMissing($products, &$context) {
    if (!isset($context['results']['cleared'])) {
      $context['results']['cleared'] = [];
    }

    if (!$products) {
      return;
    }

    $ids = [];
    foreach ($products as $product) {
      $ids[] = $product->id;
    }

    $ids = $this->entityTypeManager->getStorage('product')->getQuery()
      ->condition('remote_id', $ids, 'NOT IN')
      ->execute();
    if (!$ids) {
      $context['results']['cleared'] = [];
      return;
    }

    $entities = $this->entityTypeManager->getStorage('product')->loadMultiple($ids);

    /** @var \Drupal\products\Entity\ProductInterface $entity */
    foreach ($entities as $entity) {
      $context['results']['cleared'][] = $entity->getName();
    }
    $context['message'] = $this->t('Removing @count products', ['@count' => count($entities)]);
    $this->entityTypeManager->getStorage('product')->delete($entities);
  }

  /**
   * Batch operation to import the products from the JSON file.
   *
   * @param $products
   * @param $context
   */
  public function importProducts($products, &$context) {

    if (!isset($context['results']['imported'])) {
      $context['results']['imported'] = [];
    }

    if (!$products) {
      return;
    }

   $sandbox = &$context['sandbox'];
    if (!$sandbox) {
      $sandbox['progress'] = 0;
      $sandbox['max'] = count($products);
      $sandbox['products'] = $products;
    }

    $slice = array_splice($sandbox['products'], 0, 1);
    /*
       foreach ($slice as $product) {
         $context['message'] = $this->t('Importing product @name', ['@name' => $product->name]);
         sleep(1);
         $this->persistProduct($product);
         $context['results']['imported'][] = $product->name;
         $sandbox['progress']++;
       }

       $context['finished'] = $sandbox['progress'] / $sandbox['max'];*/


    foreach ($slice as $product) {

      $context['message'] = $this->t('Importing product @name', ['@name' => $product->name]);
      sleep(1);
       $this->persistProduct($product);

      $context['results']['imported'][] = $product->name;
      $sandbox['progress']++;

     }
    $context['finished'] = $sandbox['progress'] / $sandbox['max'];
  }

  /**
   * Callback for when the batch processing completes.
   *
   * @param $success
   * @param $results
   * @param $operations
   */
  public function importProductsFinished($success, $results, $operations) {
    if (!$success) {
      drupal_set_message($this->t('There was a problem with the batch'), 'error');
      return;
    }

    $files = count($results['files']);
    if ($files == 0) {
      drupal_set_message($this->t('No files to be created.'));
    }
    else {
      drupal_set_message($this->formatPlural($files, '1 file has created.', '@count files had to be created.'));
    }

    $cleared = count($results['cleared']);
    if ($cleared == 0) {
      drupal_set_message($this->t('No products had to be deleted.'));
    }
    else {
      drupal_set_message($this->formatPlural($cleared, '1 product had to be deleted.', '@count products had to be deleted.'));
    }

    $imported = count($results['imported']);
    if ($imported == 0) {
      drupal_set_message($this->t('No products found to be imported.'));
    }

    else {
      drupal_set_message($this->formatPlural($imported, '1 product imported.', '@count products imported.'));
    }
  }

  /**
   * Retrieve data from json file
   * @return json
   */
  public function getData() {
    /** @var \Drupal\products\Entity\ImporterInterface $config */
    /** @var ImporterInterface $importer_config */
    $importer_config = $this->configuration['config'];
    $config = $importer_config->getPluginConfiguration();
    $url = isset($config['url']) ? $config['url'] : NULL;
    if (!$url) {
      return NULL;
    }
    $request = $this->httpClient->get($url);
    $string = $request->getBody();
    return json_decode($string);
  }

  public function persistProduct($data) {

    /** @var \Drupal\products\Entity\ImporterInterface $config */
    $config = $this->configuration['config'];

    $existing = $this->entityTypeManager->getStorage('product')->loadByProperties(['remote_id' => $data->id]);


    if (!$existing) {
      $values = [
        'remote_id' => $data->id,
        'source' => $config->getSource()
      ];
      /** @var \Drupal\products\Entity\ProductInterface $product */
      $product = $this->entityTypeManager->getStorage('product')->create($values);
      $product->setName($data->name);
      $product->setProductNumber($data->number);
      $product->setProductKeygen($data->keygen);
      $product->setSource($data->source);
      $product->save();
      return;
    }

    if (!$config->updateExisting()) {
      return;
    }

    /** @var \Drupal\products\Entity\ProductInterface $product */
    $product = reset($existing);
    $product->setName($data->name);
    $product->setProductNumber($data->number);
    $product->setSource($config->getSource());
    $product->save();
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