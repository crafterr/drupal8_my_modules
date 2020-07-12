<?php

namespace Drupal\my_form_batch;

use Drupal\Core\Batch\BatchBuilder;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Class DefaultService.
 */
class DefaultService {
use StringTranslationTrait;
  public function process() {
    $batch_builder = (new BatchBuilder())
      ->setTitle($this->t('Batch is progressing'))
      ->setFinishCallback([$this, 'justFinish']);
    $data = [2043,2044,2042];


    foreach ($data as $id) {
      $batch_builder->addOperation([$this, 'firstOperation'],[$id]);
    }


    batch_set($batch_builder->toArray());
  }

  /**
   * @param $context
   *
   * @throws \Exception
   */
  public function firstOperation($id) {
    $entityTypeManager = \Drupal::service('entity_type.manager');
        $node = $entityTypeManager->getStorage('node')->load($id);
        $node->setTitle('my title 2');
        $node->save();

  }


  public function justFinish($success, $results, $operations) {
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
  }

}
