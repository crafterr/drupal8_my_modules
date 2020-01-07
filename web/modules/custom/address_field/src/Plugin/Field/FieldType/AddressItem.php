<?php

namespace Drupal\address_field\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Annotation\Translation;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'Address' field type.
 *
 * @FieldType(
 *   id = "Address",
 *   label = @Translation("Address"),
 *   description = @Translation("Stores an address"),
 *   category = @Translation("Custom"),
 *   default_widget = "address_default_widget",
 *   default_formatter = "address_default_formatter"
 * )
 */
class AddressItem extends FieldItemBase {
use StringTranslationTrait;
  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    return [
      'street_max_length' => 255,
      'city_max_length' => 255
    ] + parent::defaultStorageSettings();
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    $properties = [];

    $properties['street'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('Street'));

    $properties['city'] = DataDefinition::create('string')
      ->setLabel(new TranslatableMarkup('City'));

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
        'street' => [
          'type' => 'char',
          'length' => (int) $field_definition->getSetting('street_max_length')
        ],
        'city' => [
          'type' => 'char',
          'length' => (int) $field_definition->getSetting('city_max_length')
        ],
      ],
    ];

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  public function getConstraints() {
    $constraints = parent::getConstraints();
    $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
    $city_max_length = $this->getSetting('city_max_length');
    $street_max_length = $this->getSetting('street_max_length');
    $constraints[] = $constraint_manager->create('ComplexData', [
      'city' => [
        'Length' => [
          'max' => $city_max_length,
          'maxMessage' => $this->t('%name: may not be longer than @max characters.', [
            '%name' => $this->getFieldDefinition()->getLabel() . ' (number)',
            '@max' => $city_max_length
          ]),
        ],
      ],
      'street' => [
        'Length' => [
          'max' => $street_max_length,
          'maxMessage' => $this->t('%name: may not be longer than @max characters.', [
            '%name' => $this->getFieldDefinition()->getLabel() . ' (code)',
            '@max' => $street_max_length
          ]),
        ],
      ],
    ]);

    return $constraints;
  }

  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {
    $random = new Random();
    $values['street'] = $random->word(mt_rand(1, $field_definition->getSetting('street_max_length')));
    $values['city'] = $random->word(mt_rand(1, $field_definition->getSetting('city_max_length')));

    return $values;
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $elements = [];

    $elements['street_max_length'] = [
      '#type' => 'number',
      '#title' => $this->t('Street maximum length'),
      '#default_value' => $this->getSetting('street_max_length'),
      '#required' => TRUE,
      '#description' => $this->t('Maximum length for the street number in characters.'),
      '#min' => 1,
      '#disabled' => $has_data,
    ];

    $elements['city_max_length'] = [
      '#type' => 'number',
      '#title' => $this->t('City maximum length'),
      '#default_value' => $this->getSetting('city_max_length'),
      '#required' => TRUE,
      '#description' => $this->t('Maximum length for the city in characters.'),
      '#min' => 1,
      '#disabled' => $has_data,
    ];

    return $elements; // + parent::storageSettingsForm($form, $form_state, $has_data);
  }

  /**
   * {@inheritdoc}
   */
  public function isEmpty() {

    $isEmpty =
      empty($this->get('street')->getValue()) &&
      empty($this->get('city')->getValue());


    return $isEmpty;
  }

}
