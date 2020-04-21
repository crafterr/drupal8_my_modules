<?php

namespace Drupal\products\Plugin\views\field;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Component\Utility\Random;
use Drupal\products\Plugin\ImporterManager;
use Drupal\views\Plugin\views\field\FieldPluginBase;
use Drupal\views\ResultRow;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * A handler to provide a field that is completely custom by the administrator.
 *
 * @ingroup views_field_handlers
 *
 * @ViewsField("product_importer")
 */
class ProductImporter extends FieldPluginBase {

  /**
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * @var \Drupal\products\Plugin\ImporterManager
   */
  protected $importerManager;

  /**
   * ProductImporter constructor.
   *
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entityTypeManager
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, EntityTypeManagerInterface $entityTypeManager, ImporterManager $importerManager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entityTypeManager;
    $this->importerManager = $importerManager;
  }

  /**
   * @inheritDoc
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('plugin.manager.importer')
    );
  }

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
    // Do nothing -- to override the parent query.
  }

  /**
   * {@inheritdoc}
   */
  protected function defineOptions() {
    $options = parent::defineOptions();

    $options['hide_alter_empty'] = ['default' => FALSE];
    $options['importer'] = ['default' => 'entity'];
    return $options;
  }

  /**
   * {@inheritdoc}
   */
  public function buildOptionsForm(&$form, FormStateInterface $form_state) {
    $form['importer'] = [
      '#type' => 'select',
      '#title' => $this->t('Importer'),
      '#description' => $this->t('Which importer label to use?'),
      '#options' => [
        'entity' => $this->t('Entity'),
        'plugin' => $this->t('Plugin')
      ],
      '#default_value' => $this->options['importer'],
    ];

    parent::buildOptionsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function render(ResultRow $values) {
    // Return a random text, here you can include your custom logic.
    // Include any namespace required to call the method required to generate
    // the desired output.
    $product = $values->_entity;
    $source = $product->getSource();
    $importers = $this->entityTypeManager->getStorage('importer')->loadByProperties(['source' => $source]);
    if (!$importers) {
      return NULL;
    }

    // We'll assume one importer per source.
    /** @var \Drupal\products\Entity\ImporterInterface $importer */
    $importer = reset($importers);
    // If we want to show the entity label.
    if ($this->options['importer'] == 'entity') {
      return $this->sanitizeValue($importer->label());
    }

    // Otherwise we show the plugin label.
    $definition = $this->importerManager->getDefinition($importer->getPluginId());
    return $this->sanitizeValue($definition['label']);
  }

}
