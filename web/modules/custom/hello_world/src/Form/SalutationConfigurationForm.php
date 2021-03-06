<?php
namespace Drupal\hello_world\Form;

use Drupal\Core\Config\ConfigFactoryInterface;

use Drupal\Core\Form\FormStateInterface;
class SalutationConfigurationForm extends MyClass  {
use MyTrait;





  protected function getEditableConfigNames() {
    return ['hello_world_custom_salutation.settings'];
  }

  public function getFormId() {
    return 'salutation_configuration_form';
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   *
   * @return array
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('hello_world_custom_salutation.settings');
    parent::save();
    $this->save();
    $form['salutation'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Salutation'),
      '#description' => $this->t('Please provide the salutation you want to use.'),
      '#default_value' => $config->get('salutation'),
    );
    return parent::buildForm($form,$form_state);
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('hello_world_custom_salutation.settings')
      ->set('salutation',$form_state->getValue('salutation'))
      ->save();
    $this->logger->info('The Hello World salutation has been changed to @message.',['@message'=>$form_state->getValue('salutation')]);
    parent::submitForm($form, $form_state);
  }

  /**
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $salutation = $form_state->getValue('salutation');
    if (strlen($salutation) > 20) {
      $form_state->setErrorByName('salutation', $this->t('This salutation is too long'));
    }
    parent::validateForm($form, $form_state); // TODO: Change the autogenerated stub
  }

}