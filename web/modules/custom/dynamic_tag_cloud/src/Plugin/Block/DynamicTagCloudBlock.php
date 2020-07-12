<?php

namespace Drupal\dynamic_tag_cloud\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'DynamicTagCloudBlock' block.
 *
 * @Block(
 *  id = "dynamic_tag_cloud_block",
 *  admin_label = @Translation("Dynamic tag cloud block"),
 * )
 */
class DynamicTagCloudBlock extends BlockBase {

  /**
   * @return array
   */
  public function defaultConfiguration() {
    return [
      'style' => 0,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    // Get block configuration.
    $config = $this->getConfiguration();
    // Initiate tag cloud plugin manager.
    $tag_cloud_manager = \Drupal::service('plugin.manager.tag_cloud');
    // Create instance of user selected tag cloud plugin style and execute build method.
    return $tag_cloud_manager
      ->createInstance($config['style'])
      ->build(['adam','marek','grzesiek']);
  }

  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();
    // Get all defined plugins of plugin type tag_cloud. Where the definition is simply annotation value.
    $tag_cloud_plugin_definitions = \Drupal::service('plugin.manager.tag_cloud')->getDefinitions();
    $tag_cloud_styles = [];
    // Create form select option array with key as plugin id.
    foreach ($tag_cloud_plugin_definitions as $plugin_id => $plugin_definition) {
      $tag_cloud_styles[$plugin_id] = $plugin_definition['label']->render();
    }
    $form['style'] = [
      '#type' => 'select',
      '#title' => t('Style'),
      '#options' => $tag_cloud_styles,
      '#default_value' => isset($config['style']) ? $config['style'] : 0,
    ];
    return $form;

  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['style'] = $form_state->getValue('style');
  }

}
