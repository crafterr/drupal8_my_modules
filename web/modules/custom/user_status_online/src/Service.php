<?php

namespace Drupal\user_status_online;

use Drupal\user\UserInterface;
use Drupal\user_status_online\StatusStrategy\AbsentStrategy;
use Drupal\user_status_online\StatusStrategy\OfflineStrategy;
use Drupal\user_status_online\StatusStrategy\OnlineStrategy;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Class Service.
 */
class Service implements ServiceInterface {

  /**
   * @var RequestStack
   */
  private $request;

  /**
   * Service constructor.
   * @param RequestStack $request
   */
  public function __construct(RequestStack $request) {
    $this->request = $request;
  }

  /**
   * @inheritDoc
   */
  public function getStatus(UserInterface $user) {
    $statusManager = new Status($user,$this->request);
    $statusManager->addStrategy(new OnlineStrategy());
    $statusManager->addStrategy(new OfflineStrategy());
    $statusManager->addStrategy(new AbsentStrategy());
    return $statusManager->getStatus();

  }


}
