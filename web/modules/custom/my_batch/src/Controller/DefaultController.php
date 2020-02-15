<?php

namespace Drupal\my_batch\Controller;

use Drupal\Core\Batch\BatchBuilder;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Zend\Feed\Reader\Http\Response;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {


  public function link() {
    $build['linkme'] = [
      '#type' => 'link',
      '#title' => 'Link Me to run Batch',
      '#attributes' => [
        'class' => 'link-class',
      ],
      '#url' => Url::fromRoute('my_batch.default_controller_run'),
    ];
    return $build;
  }

  /**
   * @return \Symfony\Component\HttpFoundation\RedirectResponse|null
   */
  public function run() {
    $batch_builder = (new BatchBuilder())
      ->setTitle($this->t('Batch is progressing'))
      ->setFinishCallback([$this, 'justFinish']);

    $batch_builder->addOperation([$this, 'firstOperation']);

    batch_set($batch_builder->toArray());
    return batch_process('/my_batch/link');
  }

  /**
   * @param $context
   *
   * @throws \Exception
   */
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
