<?php

namespace Drupal\sports\Form;

use Drupal;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Url;
use Drupal\Core\Form\FormStateInterface;
use Drupal\employee\EmployeeStorage;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\sports\TeamStorage;

/**
 * Confirm team delete form.
 */
class TeamDeleteForm extends ConfirmFormBase {

  protected $team;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'team_delete';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return t('Are you sure you want to delete team %id?', ['%id' => $this->team->name]);
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return t('Delete');
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
  public function buildForm(array $form, FormStateInterface $form_state, $team = NULL) {

    if (!$team) {
      $this->messenger()->addMessage($this->t('Invalid team record'), 'error');
      return new RedirectResponse(Url::fromRoute('sports.teams.list'));
    }
    $this->team = $team;
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    TeamStorage::delete($this->team->id);
    $this->messenger()->addMessage($this->t('Team %id has been deleted.', ['%id' => $this->team->id]));
    $form_state->setRedirect('sports.teams.list');
  }

}
