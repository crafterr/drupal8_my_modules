<?php

namespace Drupal\sports\Form;

use Drupal;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\sports\TeamStorage;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\Session;

/**
 * Team bulk action form.
 */
class TeamBulkActionForm extends ConfirmFormBase {

  /**
   * The action name.
   *
   * @var string
   */

  private $action;

  /**
   * The request.
   *
   * @var Symfony\Component\HttpFoundation\RequestStack
   */

  protected $session;

  /**
   * The records on which the action to be performed.
   *
   * @var mixed
   */

  private $records;

  /**
   * Constructs the EmployeeController.
   *
   * @param \Symfony\Component\HttpFoundation\Session\Session $session
   *   The session service.
   */
  public function __construct(Session $session) {
    $this->session = $session;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('session')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'team_bulk_action';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure you want to %action selected teams?',
      ['%action' => $this->action]);
  }



  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('Confirm');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelRoute() {
    return new Url('sports.teams.list');
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('sports.teams.list');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $action = NULL) {

    $this->action = $action;
    $session_employee = $this->session->get('teams');
    $this->records = $session_employee['selected_items'];

      $form['teams'] = [
        '#theme' => 'item_list',
        '#items' => $session_employee['selected_items'],
      ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $request = \Drupal::request();

    $batch = [
      'title' => t('Applying action @action to selected employees', ['@action' => $this->action]),
      'operations' => [
        [
          'Drupal\sports\Form\TeamBulkActionForm::performBatchAction',
          [$this->records, $this->action],
        ],
      ],
      'finished' => 'Drupal\sports\Form\TeamBulkActionForm::onFinishBatchCallback',
    ];
    batch_set($batch);
    $this->session->remove('teams');
    $form_state->setRedirect('sports.teams.list');
  }

  /**
   * Batch operation callback.
   */
  public static function performBatchAction($records, $action, &$context) {
    switch ($action) {
      case 'delete':
        $message = "Deleting the employees";
        break;

      case 'activate':
        $message = "Activating the employees";
        break;

      case 'block':
        $message = "Blocking the employees";
        break;

      default:
        $message = "Deleting the employees";
    }

    foreach ($records as $id => $name) {

      switch ($action) {
        case 'delete':
          $result = TeamStorage::delete($id);
          break;

        case 'activate':
          $result = TeamStorage::changeStatus($id, 1);
          break;

        case 'block':
          $result = TeamStorage::changeStatus($id, 0);
          break;

        default:
          $result = TeamStorage::delete($id);
      }
      $results[] = $result;
    }
    $context['message'] = $message;
    $context['results'] = $results;
  }

  /**
   * Finish callback for batch process.
   */
  public static function onFinishBatchCallback($success, $results, $operations) {
    if ($success) {
      $message = \Drupal::translation()->formatPlural(
        count($results),
        'One employee record processed.', '@count employee records processed.'
      );
      drupal_set_message($message);
    }
    else {
      $message = t('Finished with an error.');
      drupal_set_message($message, 'error');
    }
  }

}
