<?php


namespace Drupal\colours\Event;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\EventDispatcher\Event;

class MyEvent extends Event {

  /**
   * Body
   *
   * @var Drupal\Core\Controller\ControllerBase
   */
  protected $controller;

  /**
   * MyEvent constructor.
   *
   * @param \Drupal\Core\Controller\ControllerBase $controller
   */
  public function __construct(ControllerBase $controller) {
    $this->controller = $controller;
  }

  /**
   * Controller Object
   * @return \Drupal\Core\Controller\ControllerBase
   */
  public function getController() {
    return $this->controller;
  }

}
