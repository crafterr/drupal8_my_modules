<?php

namespace Drupal\view_tutorial_fruit\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Random;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * A handler to provide a field that is completely custom by the administrator.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("fruit_weight")
 */
class Weight extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function usesGroupBy() {
    return FALSE;
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    parent::query();
    // Do nothing -- to override the parent query.
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    $options['hide_alter_empty'] = ['default' => FALSE];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    // Let's not play smart about the conversion.. A hardcoded constant will do
    // it.
    $lbs_to_kg = 0.4535924;
    // Since our primary column is weight, we can get its value without
    // supplying the 2nd argument into the ::getValue() method.
    $absolute_weight = $this->getValue($values);
    //dump($this->getValue($values,'fruit_weight_unit'));
    //dump($this->getValue($values,'field_'))
    // To retrieve a value of an additional field, just use the construction as
    // below. The 'units' key of $this->additional_fields is the name of
    // additional field whose value we intend to retrieve from $values. In fact
    // $this->additional_fields['units'] will get us alias of the additional
    // field 'units' under which it was included into the SELECT query.
    $units = $this->getValue($values, $this->additional_fields['units']);
    $label = $this->getValue($values, $this->additional_fields['label']);

    // If the actual value is in lbs, convert it to kilograms.
    if ($units == 'lb') {
      $absolute_weight *= $lbs_to_kg;
    }
    // Now it all reduces to just pretty-printing the kilogram amount. This is
    // the actual content Views will display for our field.
    return $this->t('@weight kg', [
      '@weight' => round($absolute_weight, 2),
    ]);

  }

}
