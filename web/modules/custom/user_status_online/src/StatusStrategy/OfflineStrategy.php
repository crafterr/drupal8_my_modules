<?php
namespace Drupal\user_status_online\StatusStrategy;

class OfflineStrategy extends StatusStrategy {

  protected  $statusName = 'Offline';

  /**
   * @inheritDoc
   */
  public function isValidate(): bool {
    $last = $this->getStatus()->getUser()->getLastAccessedTime();
    $now = $this->getStatus()->getRequest()->getCurrentRequest()->server->get('REQUEST_TIME');

    return !(($last < ($now - 400)) && $last > ($now - 800)) && !($last >= ($now - 400)) ;
  }



}