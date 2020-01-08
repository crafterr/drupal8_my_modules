<?php


namespace Drupal\sports\Form;

use Drupal;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Component\Utility\Html;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Form\FormBase;
use Drupal\sports\PlayerStorage;
use Drupal\Core\Datetime\DrupalDateTime;
class PlayerForm extends FormBase {

  protected $team;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'player_add';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $player = NULL, $team = NULL) {

    if ($team) {
      $this->team = $team;
    }
    if ($player) {
      if ($player == 'invalid') {
        $this->messenger()->addMessage(t('Invalid player record'), 'error');
        return new RedirectResponse(Drupal::url('sports.players.list'));
      }
      $form['eid'] = [
        '#type' => 'hidden',
        '#value' => $player->id,
      ];
    }

    $form['team_id'] = [
      '#type' => 'hidden',
      '#value' => $team->id,
    ];

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
      '#default_value' => ($player) ? $player->name : '',
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
      'team_id' => (int) $form_state->getValue('team_id'),
    ];
    if (!empty($id) && PlayerStorage::exists($id)) {
      PlayerStorage::load($id);
      PlayerStorage::update($id, $fields);
      $message = 'Team updated sucessfully';
    }
    else {
      PlayerStorage::add($fields);

      // $this->dispatchEmployeeWelcomeMailEvent($new_employee_id);
      $message = 'Player created sucessfully';
    }
    $this->messenger()->addMessage($message);
    $form_state->setRedirect('sports.players.list',['team'=>$this->team->id]);
  }


}