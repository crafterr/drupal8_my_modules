<?php

namespace Drupal\view_tutorial_fruit\Plugin\views\area;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\views\Plugin\views\area\AreaPluginBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Views area MyCustomSiteArea handler.
 *
 * @ingroup views_area_handlers
 *
 * @ViewsArea("my_custom_site_area")
 */
class MyCustomSiteArea extends AreaPluginBase {

  protected $entityTypeManager;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entityTypeManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entityTypeManager;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager')
      );

  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();
    $options['my_option'] = ['default' => ''];
    return $options;
  }
  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    parent::buildOptionsForm($form, $form_state);
    $options = [
      'first option',
      'second option'
    ];
    $form['my_option'] = [
      '#type' => 'select',
      '#title' => $this->t('Select to options'),
      '#default_value' => $this->options['my_option'],
      '#description' => $this->t('The option to choose'),
      '#options' => $options,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function render($empty = FALSE) {
    if (!$empty || !empty($this->options['empty'])) {

      $output = array();
      if ($this->options['my_option']==1) {
        $output['articles'] = $this->getListArticles();
      }
      $output['text'] = [
        '#type' => 'processed_text',
        '#text' => '<p>' . $this->t('My custom site hardcoded text') . '</p>',
        '#format' => 'full_html',
      ];
      // My awesome return link to frontpage with custom classes.
      $output['link'] = [
        '#title' => $this->t('< Back to the front'),
        '#type' => 'link',
        '#url' => Url::fromRoute('<front>'),
        '#attributes' => [
          'class' => ['button', 'secondary']
        ]
      ];

      $output['bottom_text'] = [
        '#type' => 'processed_text',
        '#text' => '<p>' . $this->t('My custom site hardcoded text') .
          $this->t('My custom site hardcoded text').'</p>',
        '#format' => 'full_html',
      ];
      return $output;
    }

    return array();
  }

  /**
   * @inheritDoc
   */
  public function getListArticles() {
    $listBuilder = $this->entityTypeManager->getListBuilder('node')->render();
    return $listBuilder;
  }
}
