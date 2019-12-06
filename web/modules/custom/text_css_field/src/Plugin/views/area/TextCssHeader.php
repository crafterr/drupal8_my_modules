<?php

namespace Drupal\text_css_field\Plugin\views\area;

use Drupal\views\Plugin\views\area\AreaPluginBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a views area plugin.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("text_css_header")
 */
class TextCssHeader extends AreaPluginBase {

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
    $options['text_css_header'] = ['default' => ''];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    $form['text_css_header'] = [
      '#type' => 'textarea',
      '#required' => TRUE,
      '#title' => $this->t('Text CSS field'),
      '#description' => $this->t('Use &#60;style&#62;&#60;/style&#62; tags to include your custom css styles.'),
      '#default_value' => $this->options['text_css_header'],
    ];
    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE) {
    return 'adadas';
    if (!$empty || !empty($this->options['empty'])) {
      $result = $this->options['text_css_header'];
    return [
      '#theme' => 'text_css_header',
      '#items' => $result,
    ];
}
  }
}
