<?php


namespace Drupal\hello_world\Form;


use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\RequestContext;
use Symfony\Component\DependencyInjection\ContainerInterface;

trait MyTrait {

  protected $time;

  protected $entityTypeManager;

  protected $requestContext;

  public function __construct(TimeInterface $time, EntityTypeManagerInterface $entityTypeManager, RequestContext $requestContext) {
    $this->time = $time;
    $this->entityTypeManager = $entityTypeManager;
    $this->requestContext = $requestContext;
  }



  /**
   * @inheritDoc
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('datetime.time'),
      $container->get('entity_type.manager'),
      $container->get('router.request_context')
    );
  }

  public function save() {
    echo 'weszlo w trait';
  }
}