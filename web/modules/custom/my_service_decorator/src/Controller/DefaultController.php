<?php

namespace Drupal\my_service_decorator\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\my_service_decorator\DefaultServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  /**
   * @var DefaultServiceInterface
   */
  private $service;

  public function __construct(DefaultServiceInterface $service)
  {
    $this->service = $service;
  }

  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('my_service_decorator.default')
    );
  }

  public function render() {
    $this->service->setName('Adam');
    dump($this->service->getName());

    die();
  }

}
