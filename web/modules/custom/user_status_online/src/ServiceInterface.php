<?php
namespace Drupal\user_status_online;

use Drupal\user\UserInterface;

/**
 * Interface ServiceInterface.
 */
interface ServiceInterface {

  /**
   * @param UserInterface $user
   * @return string
   */
  public function getStatus(UserInterface $user);

}
