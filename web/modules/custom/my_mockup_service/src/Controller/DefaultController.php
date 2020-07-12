<?php

namespace Drupal\my_mockup_service\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\my_mockup_service\ServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  /**
   * @var \Drupal\my_mockup_service\ServiceInterface
   */
  private $service;

  public function __construct(ServiceInterface $service) {
    $this->service = $service;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('my_cokup_service.service')
    );
  }

  public function render() {
    dump($this->service->getCurrentUserDetails()); die();
  }

}
