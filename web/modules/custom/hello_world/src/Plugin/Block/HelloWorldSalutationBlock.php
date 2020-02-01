<?php

namespace Drupal\hello_world\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\hello_world\HelloWorldSalutationInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Provides a 'HelloWorldSalutationBlock' block.
 *
 * @Block(
 *  id = "hello_world_salutation_block",
 *  admin_label = @Translation("Hello world salutation block"),
 * )
 */
class HelloWorldSalutationBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\hello_world\HelloWorldSalutationInterface definition.
   *
   * @var \Drupal\hello_world\HelloWorldSalutationInterface
   */
  protected $helloWorldSalutation;

  /**
   * Constructs a new HelloWorldSalutationBlock object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\hello_world\HelloWorldSalutationInterface $hello_world_salutation
   *   The HelloWorldSalutationInterface definition.
   */
  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    HelloWorldSalutationInterface $hello_world_salutation
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->helloWorldSalutation = $hello_world_salutation;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('hello_world.salutation')
    );
  }

  /**
   * @return array
   */
  public function defaultConfiguration() {
    return [
      'enabled' => 1,
    ];
  }

  /**
   * @param $form
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *
   * @return array
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $config = $this->getConfiguration();
    $form['enabled'] = [
      '#type' => 'checkbox',
      '#title' => t('Enabled'),
      '#description' => t('Check this box if you want to enable this feature.'),
      '#default_value' => $config['enabled'],
    ];

    return $form;
  }

  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['enabled'] = $form_state->getValue('enabled');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    return [
      '#type' => 'markup',
      '#markup' =>  ((bool)$this->configuration['enabled']) ? $this->helloWorldSalutation->getSalutation():'ma enabled wlaczony'
    ];

  }

  public function blockAccess(AccountInterface $account) {

    $accountProxy = $account;
    $user = \Drupal::entityTypeManager()
      ->getStorage('user')
      ->load($accountProxy->id());

    if ($user->id()==1) {
      return AccessResult::allowed();
    } else {
      return AccessResult::forbidden();
    }

  }

}
