<?php
namespace Drupal\user_status_online\StatusStrategy;

use Drupal\user_status_online\StatusInterface;

abstract class StatusStrategy {

  /**
   * @var StatusInterface
   */
  protected $status;

  /**
   * @var string
   */
  protected $statusName = 'Unknown';

  /**
   *
   * @return bool
   */
  abstract public function isValidate(): bool;

  /**
   * @return string
   */
  public function getStatusName() {
    return $this->statusName;
  }

  /**
   * @param StatusInterface $status
   */
  public function setStatus(StatusInterface $status) {
    $this->status = $status;
  }

  /**
   * @return StatusInterface
   */
  public function getStatus() {
    return $this->status;
  }
}