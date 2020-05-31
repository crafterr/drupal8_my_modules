<?php


namespace Drupal\my_style_filter_to_ckeditor\Plugin\Filter;

use Drupal\Core\Entity\EntityTypeBundleInfoInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;
use Drupal\node\Entity\NodeType;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @Filter(
 *   id = "filter_celebrate",
 *   title = @Translation("Celebrate Filter"),
 *   description = @Translation("Help this text format celebrate good times!"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 *   settings = {
 *     "allowed_node_types" = {},
 *   },
 * )
 */

class FilterCelebrate extends FilterBase implements ContainerFactoryPluginInterface{


  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;


  /**
   * The entity type bundle info service.
   *
   * @var \Drupal\Core\Entity\EntityTypeBundleInfoInterface
   */
  protected $entityTypeBundleInfo;


  public function __construct(array $configuration, $plugin_id, $plugin_definition,EntityTypeManagerInterface $entity_type_manager,EntityTypeBundleInfoInterface $bundle_info) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->entityTypeManager = $entity_type_manager;
    $this->entityTypeBundleInfo = $bundle_info;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('entity_type.manager'),
      $container->get('entity_type.bundle.info')
    );
  }

  public function process($text, $langcode) {
    $node = \Drupal::routeMatch()->getParameter('node');
    $anynomus = \Drupal::currentUser()->isAnonymous();
    if ($node) {
      if (in_array($node->bundle(), array_values($this->settings['allowed_node_types']))) {
        if ($anynomus) {
          //pobierz z konfiguracji wszystkie linki ktore tam sobie je wpisali
          //jezeli w tekscie $text znajdziesz takink wtedy
          $replace = '<span class="celebrate-filter">wypierdalaj na logowanie</span>';
          $new_text = str_replace('adam ma kota', $replace, $text);
          return new FilterProcessResult($new_text);
        }


      }
    }
    return new FilterProcessResult($text);
  }

  /**
   * @param array $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *
   * @return array
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

    $bundles = $this->entityTypeBundleInfo->getBundleInfo('node');
    // If you need to display them in a drop down:
    $bundle_options = array_map(function ($item) {
      return $item['label'];
    }, $bundles);


    $form['allowed_node_types'] = array(
      '#type' => 'checkboxes',
      '#options' => $bundle_options,
      '#default_value' => $this->settings['allowed_node_types'],
      '#description' => $this->t('If none are selected, all will be allowed.'),
      '#element_validate' => [[static::class, 'validateOptions']],
    );
    $form['links'] = array(
      '#type' => 'textarea',
      '#default_value' => $this->settings['links'],
      '#description' => $this->t('Here put the links after comma.'),
      '#element_validate' => [[static::class, 'validateOptions']],
    );
    return $form;
  }

  /**
   * Form element validation handler.
   *
   * @param array $element
   *   The allowed_view_modes form element.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   */
  public static function validateOptions(array &$element, FormStateInterface $form_state) {
    // Filters the #value property so only selected values appear in the
    // config.
    $form_state->setValueForElement($element, array_filter($element['#value']));
  }
}
