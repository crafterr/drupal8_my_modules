<?php

namespace Drupal\sports\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\core\Form\FormStateInterface;


/**
 * Configuration settings form.
 */
class SettingsForm extends ConfigFormBase {



  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'sport_admin_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'sports.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('sports.settings');

    $form['page_limit_for_team'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Page Limit for Team'),
      '#default_value' => $config->get('page_limit_for_team'),
    ];

    $form['page_limit_for_player'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Page Limit for Player'),
      '#default_value' => $config->get('page_limit_for_player'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $limit_for_team = $form_state->getValue('page_limit_for_team');

    if (!empty($limit_for_team)) {
      if (filter_var($limit_for_team, FILTER_VALIDATE_INT) === FALSE) {
        $form_state->setErrorByName('page_limit_for_team', t('Page limit must be an integer'));
      }
      if ($limit_for_team > 25) {
        $form_state->setErrorByName('page_limit_for_team', t('Page limit must be less than @page_length',
          ['@page_length' => 25]));
      }
    }

    $limit_for_player = $form_state->getValue('page_limit_for_player');
    if (!empty($limit_for_player)) {
      if (filter_var($limit_for_player, FILTER_VALIDATE_INT) === FALSE) {
        $form_state->setErrorByName('page_limit_for_player', t('Page limit must be an integer'));
      }
      if ($limit_for_player > 25) {
        $form_state->setErrorByName('page_limit_for_player', t('Page limit must be less than @page_length',
          ['@page_length' => 25]));
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Retrieve the configuration.
    $this->config('sports.settings')
      // Set the submitted configuration setting.
      ->set('page_limit_for_team', $form_state->getValue('page_limit_for_team'))
      ->set('page_limit_for_player', $form_state->getValue('page_limit_for_player'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
