<?php

namespace Drupal\colours\Controller;

use Drupal\colours\Event\Event;
use Drupal\colours\Event\MyEvent;
use Drupal\colours\Plugin\ColourPluginManager;
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

  public function __construct(ColourPluginManager $colourPluginManager, EventDispatcherInterface $eventDispatcher) {
    $this->colourPluginManager = $colourPluginManager;
    $this->eventDispatcher = $eventDispatcher;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.colour_plugin'),
      $container->get('event_dispatcher')
    );
  }

  public function render($plugin_id) {
    dump($this->colourPluginManager->getDefinitions()); die();
    foreach ($this->colourPluginManager->getDefinitions() as $export_type => $definition) {
      dump($definition);
    }


  }

}
