<?php

namespace Drupal\dynamic_tag_cloud\Plugin;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\Environment;

/**
 * Base class for Tag cloud plugins.
 */
abstract class TagCloudBase extends PluginBase implements TagCloudInterface, ContainerFactoryPluginInterface {

  /**
   * @var \Drupal\Core\Template\TwigEnvironment
   */
  protected $twig;

  /**
   * TagCloudBase constructor.
   *
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param \Twig\Environment $twig
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, Environment $twig) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('twig')
    );
  }

  /**
   * @inheritDoc
   */
  public function build($tags) {
    $build = [
      '#theme' => 'dynamic_tag_cloud',
      '#tags' => $tags
    ];

    foreach ($this->getPluginDefinition()['libraries'] as $library) {
      $build['#attached']['library'][] = drupal_get_path('module', 'dynamic_tag_cloud') . '/' .$library;
    }

    return $build;
  }



}
