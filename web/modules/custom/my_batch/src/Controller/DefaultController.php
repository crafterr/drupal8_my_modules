<?php

namespace Drupal\my_batch\Controller;

use Drupal\Core\Controller\ControllerBase;
use Zend\Feed\Reader\Http\Response;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {


  public function batch() {
    $this->records = [
      'adam','grzesiek','maciek'
    ];
    $this->action = '';
    $batch = [
      'title' => t('Applying action  to selected employees', ['@action' => $this->action]),
      'operations' => [
        [
          'Drupal\my_batch\Controller\DefaultController::performBatchAction',
          [$this->records],
        ],
      ],
      'finished' => 'Drupal\my_batch\Controller\DefaultController::onFinishBatchCallback',
    ];

    batch_set($batch);
    return batch_process('user');
    return [

    ];
   // return $this->redirect('sports.teams.list');
  }

  public static function performBatchAction(array $record, &$context) {

    $context['results'] = $record;

  }

  public static function onFinishBatchCallback() {
    $message = t('Finished with an error.');
    drupal_set_message($message, 'error');
  }

}
