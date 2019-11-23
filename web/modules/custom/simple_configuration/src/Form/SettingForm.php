<?php

namespace Drupal\simple_configuration\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingForm.
 */
class SettingForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'simple_configuration.setting',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'simple_configuration_setting_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('simple_configuration.setting');
    $form['param1'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Param 1'),
      '#description' => $this->t('Set Param 1'),
      '#default_value' => $config->get('param1'),

    ];

    $form['param2'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Param 2'),
      '#description' => $this->t('Set Param 2'),
      '#default_value' => $config->get('param2'),

    ];

    $form['param3'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Param 3'),
      '#description' => $this->t('Set Param 3'),
      '#default_value' => $config->get('param3'),

    ];


    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    $this->config('simple_configuration.setting')
      ->set('param1',$form_state->getValue('param1'))
      ->set('param2',$form_state->getValue('param2'))
      ->set('param3',$form_state->getValue('param3'))
      ->save();
    parent::submitForm($form, $form_state);

  }

}
