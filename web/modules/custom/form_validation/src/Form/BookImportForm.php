<?php

namespace Drupal\form_validation\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Session\AccountProxy;

/**
 * Class BookImportForm.
 */
class BookImportForm extends FormBase {

  /**
   * @var \Drupal\Core\Session\AccountProxy
   */
  private $user;

  public function __construct(AccountProxy $user) {
    $this->user = $user;
  }

  public static function create(ContainerInterface $container) {
    return new self(
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'book_import_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['csv'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Book list'),
      '#upload_validators' => [
        'file_validate_extensions' => ['csv'],
        'form_validation_validate_csv' => []
      ]
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' =>   'primary'
    ];

    if (true) {
      $form['reset'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Reset all Books')
      ];
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    foreach ($form_state->getValues() as $key => $value) {
      // @TODO: Validate fields.
    }
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Display result.
    foreach ($form_state->getValues() as $key => $value) {
      \Drupal::messenger()->addMessage($key . ': ' . ($key === 'text_format'?$value['value']:$value));
    }
  }

}
