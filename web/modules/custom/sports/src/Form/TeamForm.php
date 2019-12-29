<?php


namespace Drupal\sports\Form;

use Drupal;
use Drupal\Core\Form\FormInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Component\Utility\Html;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Form\FormBase;
use Drupal\sports\TeamStorage;
use Drupal\Core\Datetime\DrupalDateTime;
class TeamForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'employee_add';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $team = NULL) {

    if ($team) {
      if ($team == 'invalid') {
        $this->messenger()->addMessage(t('Invalid employee record'), 'error');
        return new RedirectResponse(Drupal::url('sports.teams.list'));
      }
      $form['eid'] = [
        '#type' => 'hidden',
        '#value' => $team->id,
      ];
    }
    $form['#attributes']['novalidate'] = '';
    $form['general'] = [
      '#type' => 'details',
      "#title" => "General Details",
      '#open' => TRUE,
    ];
    $form['general']['name'] = [
      '#type' => 'textfield',
      '#title' => t('Name'),
      '#required' => TRUE,
      '#default_value' => ($team) ? $team->name : '',
    ];
    $form['general']['description'] = [
      '#type' => 'textfield',
      '#title' => t('Description'),
      '#required' => TRUE,
      '#default_value' => ($team) ? $team->description : '',
    ];

    $form['general']['created'] = [
      '#type' => 'datetime',
      '#title' => $this->t('Time'),
      '#size' => 20,
      '#default_value' => ($team) ? DrupalDateTime::createFromTimestamp($team->created) : ''
    ];

    $form['general']['status'] = [
      '#type' => 'checkbox',
      '#title' => t('Active?'),
      '#default_value' => ($team) ? $team->status : 1,
    ];


    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => 'Save',
    ];
    $form['actions']['cancel'] = [
      '#type' => 'link',
      '#title' => 'Cancel',
      '#attributes' => ['class' => ['button', 'button--primary']],
      '#url' => Url::fromRoute('sports.teams.list'),
    ];
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement validateForm() method.
  }

  /**
   * Submit Form
   *
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *
   * @throws \Exception
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $id = $form_state->getValue('eid');
    /**
     * @var DrupalDateTime $created
     */

    $fields = [
      'name' => Html::escape($form_state->getValue('name')),
      'description' => Html::escape($form_state->getValue('description')),
      'status' => $form_state->getValue('status'),
      'created' => (is_null($form_state->getValue('created'))) ? (new \DateTime())->getTimestamp() : $form_state->getValue('created')->getTimestamp()
    ];
    if (!empty($id) && TeamStorage::exists($id)) {
      TeamStorage::load($id);
      TeamStorage::update($id, $fields);
      $message = 'Team updated sucessfully';
    }
    else {
      TeamStorage::add($fields);

      // $this->dispatchEmployeeWelcomeMailEvent($new_employee_id);
      $message = 'Employee created sucessfully';
    }
    $this->messenger()->addMessage($message);
    $form_state->setRedirect('sports.teams.list');
  }


}