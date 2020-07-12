<?php

namespace Drupal\colours_yaml\Controller;

use Drupal\colours_yaml\ColourYamlManager;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
/**
 * Class ColourController.
 */
class ColourController extends ControllerBase {

  /**
   * @var \Drupal\colours\Plugin\ColourPluginManager
   */
  private $colourPluginManager;

  /**
   * The event dispatcher service.
   *
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  protected $eventDispatcher;

  public function __construct(ColourYamlManager  $colourPluginManager, EventDispatcherInterface $eventDispatcher) {
    $this->colourPluginManager = $colourPluginManager;
    $this->eventDispatcher = $eventDispatcher;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.colour_yaml'),
      $container->get('event_dispatcher')
    );
  }

  public function render($plugin_id) {


    /**
     * @var \Drupal\colours\Plugin\ColourPluginInterface $plugin
     */
   // $plugin = $this->colourPluginManager->createInstance($plugin_id);

   // dump($plugin); die();

   // return $plugin->render();
   foreach ($this->colourPluginManager->getDefinitions() as $definition) {

     echo $definition['label'];
    }
die();

  }

}
