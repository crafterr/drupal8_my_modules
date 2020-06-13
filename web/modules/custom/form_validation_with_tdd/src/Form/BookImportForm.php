<?php

namespace Drupal\form_validation_with_tdd\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Session\AccountProxy;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class BookImportForm.
 */
class BookImportForm extends FormBase {

  private $currentUser;

  public function __construct(AccountInterface $user) {
    $this->currentUser = $user;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('current_user')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'form_validation_book_import';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['csv'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Book List'),
      '#upload_validators' => [
        'file_validate_extension' => ['csv'],
        'form_validation_validate_csv' => []
      ]
    ];


    if ($this->currentUser->hasPermission('administer books')) {
      $form['reset'] = [
        '#type' => 'checkbox',
        '#title' => $this->t('Reset all books')
      ];
    }

    $form['actions']['#type'] = 'actions';

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary'
    ];

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
