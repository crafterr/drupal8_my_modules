<?php

/**
 * @file
 * Definition of Drupal\d8views\Plugin\views\field\NodeTypeFlagger
 */

namespace Drupal\user_status_online\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\NodeType;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * Field handler to flag the node type.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("moje_jakies_pole")
 */
class MojeJakiesPole extends FieldPluginBase {

  /**
   * @{inheritdoc}
   */
  public function query() {
    // Leave empty to avoid a query on this field.
  }

  /**
   * Define the available options
   * @return array
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['node_type'] = array('default' => 'article');

    return $options;
  }

  /**
   * Provide the options form.
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    $types = NodeType::loadMultiple();
    $options = [];
    foreach ($types as $key => $type) {
      $options[$key] = $type->label();
    }
    $form['node_type'] = array(
      '#title' => $this->t('Which node type should be flagged?'),
      '#type' => 'select',
      '#default_value' => $this->options['node_type'],
      '#options' => $options,
    );

    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * @{inheritdoc}
   */
  public function render(ResultRow $values) {
    $node = $values->_entity;
    return $this->t('Moje jakies pole');
  }
}