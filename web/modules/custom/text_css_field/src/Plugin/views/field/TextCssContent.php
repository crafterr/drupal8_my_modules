<?php

namespace Drupal\text_css_field\Plugin\views\field;

use Drupal\Core\Form\FormStateInterface;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;

/**
 * @ingroup views_field_handlers
 *
 * @ViewsField("text_css_content")
 */
class TextCSSContent extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function query() {

  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['text_css_content'] = ['default' => ''];;
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    $form['text_css_content'] = [
      '#type' => 'textarea',
      '#required' => TRUE,
      '#title' => $this->t('Text CSS field'),
      '#description' => $this->t('Use &#60;style&#62;&#60;/style&#62; tags to include your custom css styles.'),
      '#default_value' => $this->options['text_css_content'],
    ];
    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {

    $result = "";
   if (!empty($this->view->field['text_css_content'])) {
     $result = $this->view->field['text_css_content']->options['text_css_content'];
   }

    return [
      '#theme' => 'text_css_header',
      '#items' => $result,
    ];
    }

  /**
   * {@inheritdoc}
   */
  public function clickSort($order) {
    $this->query->addOrderBy('text_css_content', 'created', $order);
  }

}
