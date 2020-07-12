<?php
namespace Drupal\my_form_batch\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\my_form_batch\DefaultService;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ConfigurationForm extends ConfigFormBase {

  protected $service;

  public function __construct(ConfigFactoryInterface $config_factory, DefaultService $service) {
    parent::__construct($config_factory);
    $this->service = $service;
  }

  /**
   * @inheritDoc
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('config.factory'),
      $container->get('my_form_batch.service')
    );
  }

  protected function getEditableConfigNames() {
    return ['my_form_batch_text.settings'];
  }

  public function getFormId() {
    return 'configuration_form';
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   *
   * @return array
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('my_form_batch_text.settings');
    $form['text'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('My text field'),
      '#description' => $this->t('Please provide text field.'),
      '#default_value' => $config->get('salutation'),
    );
    return parent::buildForm($form,$form_state);
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
      return $this->service->process($form_state->getValues());
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {

  }

}