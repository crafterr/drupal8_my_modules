<?php

namespace Drupal\user_status_online\StatusStrategy;

/**
 * Class AbsentStrategy
 */
class AbsentStrategy extends StatusStrategy {

  protected  $statusName = 'Absent';

  /**
   * @inheritDoc
   */
  public function isValidate(): bool {
    $last = $this->getStatus()->getUser()->getLastAccessedTime();
    $now = $this->getStatus()->getRequest()->getCurrentRequest()->server->get('REQUEST_TIME');
    return (($last < ($now - 400)) && $last > ($now - 800));
  }
}