<?php

namespace Drupal\products\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Url;
use Drupal\products\Plugin\ImporterManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
/**
 * Class ImporterForm.
 */
class ImporterForm extends EntityForm {

  /**
   * @var \Drupal\products\Plugin\ImporterManager
   */
  protected $importerManager;

  /**
   * ImporterForm constructor.
   *
   * @param \Drupal\products\Plugin\ImporterManager $importerManager
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   */
  public function __construct(ImporterManager $importerManager, MessengerInterface $messenger) {
    $this->importerManager = $importerManager;
    $this->messenger = $messenger;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.importer'),
      $container->get('messenger')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    $importer = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $importer->label(),
      '#description' => $this->t("Label for the Importer."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $importer->id(),
      '#machine_name' => [
        'exists' => '\Drupal\products\Entity\Importer::load',
      ],
      '#disabled' => !$importer->isNew(),
    ];



    $definitions = $this->importerManager->getDefinitions();
    $options = [];
    foreach ($definitions as $id => $definition) {
      $options[$id] = $definition['label'];
    }

    $form['plugin'] = [
      '#type' => 'select',
      '#title' => $this->t('Plugin'),
      '#default_value' => $importer->getPluginId(),
      '#options' => $options,
      '#description' => $this->t('The plugin to be used with this importer.'),
      '#required' => TRUE,
      '#empty_option' => $this->t('Please select a plugin'),
      '#ajax' => array(
        'callback' => [$this, 'pluginConfigAjaxCallback'],
        'wrapper' => 'plugin-configuration-wrapper'
      ),
    ];

    $form['plugin_configuration'] = [
      '#type' => 'hidden',
      '#prefix' => '<div id="plugin-configuration-wrapper">',
      '#suffix' => '</div>',
    ];

    $plugin_id = NULL;
    if ($importer->getPluginId()) {
      $plugin_id = $importer->getPluginId();
    }
    if ($form_state->getValue('plugin') && $plugin_id !== $form_state->getValue('plugin')) {
      $plugin_id = $form_state->getValue('plugin');
    }
    if ($plugin_id) {
      /** @var \Drupal\products\Plugin\ImporterInterface $plugin */
      $plugin = $this->importerManager->createInstance($plugin_id, ['config' => $importer]);
      $form['plugin_configuration']['#type'] = 'details';
      $form['plugin_configuration']['#tree'] = TRUE;
      $form['plugin_configuration']['#open'] = TRUE;
      $form['plugin_configuration']['#title'] = $this->t('Plugin configuration for <em>@plugin</em>', ['@plugin' => $plugin->getPluginDefinition()['label']]);
      $form['plugin_configuration']['plugin'] = $plugin->getConfigurationForm($importer);
    }

    $form['update_existing'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Update existing'),
      '#description' => $this->t('Whether to update existing products if already imported.'),
      '#default_value' => $importer->updateExisting(),
    ];

    $form['source'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Source'),
      '#description' => $this->t('The source of the products.'),
      '#default_value' => $importer->getSource(),
    ];
    /* You will need additional form elements for your custom properties. */

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $importer = $this->entity;
    $importer->set('plugin_configuration', $importer->getPluginConfiguration()['plugin']);
    $status = $importer->save();

    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Importer.', [
          '%label' => $importer->label(),
        ]));
        break;

      default:
        $this->messenger()->addMessage($this->t('Saved the %label Importer.', [
          '%label' => $importer->label(),
        ]));
    }
    $form_state->setRedirectUrl($importer->toUrl('collection'));
  }


  /**
   * Ajax callback for the plugin configuration form elements.
   *
   * @param $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *
   * @return array
   */
  public function pluginConfigAjaxCallback($form, FormStateInterface $form_state) {

    return $form['plugin_configuration'];
  }

}
