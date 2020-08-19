<?php

namespace Drupal\my_condition\Plugin\Condition;

use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Plugin\Context\ContextDefinition;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Provides a 'Example condition' condition to enable a condition based in module selected status.
 *
 * @Condition(
 *   id = "example_condition",
 *   label = @Translation("Example condition"),
 *   context = {
 *     "node" = @ContextDefinition("entity:node", required = TRUE , label = @Translation("node"))
 *   }
 * )
 *
 */
class ExampleCondition extends ConditionPluginBase implements ContainerFactoryPluginInterface {

  /**
   * The request stack.
   *
   * @var \Symfony\Component\HttpFoundation\RequestStack
   */
  protected $requestStack;

  /**
   * Constructs a Page not found condition plugin.
   *
   * @param \Symfony\Component\HttpFoundation\RequestStack $request_stack
   *   The request stack.
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param array $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(RequestStack $request_stack, array $configuration, $plugin_id, array $plugin_definition)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->requestStack = $request_stack;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static(
      $container->get('request_stack'),
      $configuration,
      $plugin_id,
      $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    return ['page_not_found' => '','page_not_found_title'=>''] + parent::defaultConfiguration();
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface $form_state) {
    $form['prefix'] = ['#markup' => '<h5>Page Not Found</h5>'];
    $form['page_not_found'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Show in page not found'),
      '#default_value' => $this->configuration['page_not_found'],
    ];
    $form['page_not_found_title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#default_value' => $this->configuration['page_not_found_title'],
    ];
    return $form + parent::buildConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
    $this->configuration['page_not_found'] = $form_state->getValue('page_not_found');
    $this->configuration['page_not_found_title'] = $form_state->getValue('page_not_found_title');
    parent::submitConfigurationForm($form, $form_state);
  }



  /**
   * Evaluates the condition and returns TRUE or FALSE accordingly.
   *
   * @return bool
   *   TRUE if the condition has been met, FALSE otherwise.
   */
  public function evaluate() {
    $page_not_found_checked = $this->configuration['page_not_found'];
    $page_not_found_title = $this->configuration['page_not_found_title'];
    if ($page_not_found_checked == 1) {
      $status = $this->requestStack->getCurrentRequest()->attributes->get('exception');
      $node = $this->getContextValue('node');
      if ($status && $status->getStatusCode() == 404 && $node->title->value==$page_not_found_title) {
        return TRUE;
      } else {
        return FALSE;
      }
    } else {
      return TRUE;
    }
  }

  /**
   * Provides a human readable summary of the condition's configuration.
   */
  public function summary() {
    if (!empty($this->configuration['negate'])) {
      return $this->t('Do not return true on the following page not found.');
    }
    return $this->t('Return true on the following page not found.');
  }

}
