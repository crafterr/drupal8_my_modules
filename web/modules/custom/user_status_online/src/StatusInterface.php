<?php

namespace Drupal\user_status_online;

use Drupal\user_status_online\StatusStrategy\StatusStrategy;
use Drupal\user\UserInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Interface StatusInterface
 */
interface StatusInterface {

  /**
   * @param StatusStrategy $strategy
   *
   * @return mixed
   */
  public function addStrategy(StatusStrategy $strategy);

  /**
   * @return string
   */
  public function getStatus();

  /**
   * @return UserInterface
   */
  public function getUser();

  /**
   * @return RequestStack
   */
  public function getRequest();
}