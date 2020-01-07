<?php

namespace Drupal\address_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'address_default_widget' widget.
 *
 * @FieldWidget(
 *   id = "address_default_widget",
 *   module = "address_field",
 *   label = @Translation("Address default widget"),
 *   field_types = {
 *     "Address"
 *   }
 * )
 */
class AddressDefaultWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
        'placeholder' => '',
        'city_size' => 60,
        'street_size' => 60,
        'fieldset_state' => 'open',
        'add_custom_flag' => FALSE,
      ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    $elements['city_size'] = [
      '#type' => 'number',
      '#title' => $this->t('Size of city textfield'),
      '#default_value' => $this->getSetting('city_size'),
      '#required' => TRUE,
      '#min' => 1,
      '#max' => $this->getFieldSetting('city_max_length'),
    ];

    $elements['street_size'] = [
      '#type' => 'number',
      '#title' => $this->t('Size of street textfield'),
      '#default_value' => $this->getSetting('street_size'),
      '#required' => TRUE,
      '#min' => 1,
      '#max' => $this->getFieldSetting('street_max_length'),
    ];

    $elements['fieldset_state'] = [
      '#type' => 'select',
      '#title' => $this->t('Fieldset default state'),
      '#options' => [
        'open' => $this->t('Open'),
        'closed' => $this->t('Closed')
      ],
      '#default_value' => $this->getSetting('fieldset_state'),
      '#description' => $this->t('The default state of the fieldset which contains the two plate fields: open or closed')
    ];

    $elements['add_custom_flag'] = [
      '#type' => 'checkbox',
      '#title' => t('Add Custom Flag'),
      '#collapsible' => TRUE,
      '#collapsed' => TRUE,
      '#weight' => 10,
      '#default_value' => $this->getSetting('add_custom_flag'),
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $summary[] = $this->t('City size: @city_size (for number) and @street_size (for code)', ['@city_size' => $this->getSetting('city_size'), '@street_size' => $this->getSetting('street_size')]);

    $summary[] = $this->t('Fieldset state: @state', ['@state' => $this->getSetting('fieldset_state')]);
    $summary[] = $this->t('Add custom flag: @flag', ['@flag' => ($this->getSetting('add_custom_flag'))?'yes':'no']);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {

    $element['details'] = $element + [
        '#type' => 'details',
        '#title' => $element['#title'],
        '#open' => $this->getSetting('fieldset_state') == 'open' ? TRUE : FALSE,
        '#description' => $element['#description'],
      ];

    $element['details']['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => isset($items[$delta]->city) ? ($this->getSetting('add_custom_flag'))?'[PL] '.$items[$delta]->city:$items[$delta]->city : NULL,
      '#size' => $this->getSetting('city_size'),
      '#maxlength' => $this->getFieldSetting('city_max_length'),
      '#description' => '',
      '#required' => $element['#required'],
    ];

    $element['details']['street'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Street'),
      '#default_value' => isset($items[$delta]->street) ? $items[$delta]->street : NULL,
      '#size' => $this->getSetting('street_size'),
      '#maxlength' => $this->getFieldSetting('street_max_length'),
      '#description' => '',
      '#required' => $element['#required'],
    ];
    return $element;
  }

  /**
   * @inheritDoc
   */
  public function massageFormValues(array $values, array $form, FormStateInterface $form_state) {
    foreach ($values as &$value) {
      $value['street'] = $value['details']['street'];
      $value['city'] = $value['details']['city'];

      unset($value['details']);
    }

    return $values;
  }

}
