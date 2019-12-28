<?php

namespace Drupal\colours\Controller;

use Drupal\colours\Plugin\ColourPluginManager;
use Drupal\Core\Controller\ControllerBase;
use function PHPSTORM_META\type;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ColourController.
 */
class ColourController extends ControllerBase {

  /**
   * @var \Drupal\colours\Plugin\ColourPluginManager
   */
  private $colourPluginManager;

  public function __construct(ColourPluginManager $colourPluginManager) {
    $this->colourPluginManager = $colourPluginManager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.colour_plugin')
    );
  }

  public function render($plugin_id) {
    /**
     * @var \Drupal\colours\Plugin\ColourPluginInterface $plugin
     */
    $plugin = $this->colourPluginManager->createInstance($plugin_id,['options'=>[1,2,3,4]]);

    dump($plugin->render()); die();
    return $plugin->render();

   /* foreach ($this->colourPluginManager->getDefinitions() as $definition) {
      $p = $this->colourPluginManager->createInstance($definition['id']);
      echo $p->render();
    }*/


  }

}
