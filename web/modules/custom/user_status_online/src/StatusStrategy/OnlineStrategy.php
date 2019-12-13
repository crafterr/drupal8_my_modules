<?php
namespace Drupal\user_status_online\StatusStrategy;

class OnlineStrategy extends StatusStrategy {

  protected $statusName = 'Online';

  /**
   * @inheritDoc
   */
  public function isValidate(): bool {
    $last = $this->getStatus()->getUser()->getLastAccessedTime();
    $now = $this->getStatus()->getRequest()->getCurrentRequest()->server->get('REQUEST_TIME');
    return ($last >= ($now - 400));
  }



}