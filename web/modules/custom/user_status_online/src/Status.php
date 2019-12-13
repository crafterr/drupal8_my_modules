<?php
namespace Drupal\user_status_online;

use Drupal\user\UserInterface;
use Drupal\user_status_online\StatusStrategy\StatusStrategy;
use Drupal\user_status_online\StatusStrategy\StrategyInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class Status implements StatusInterface {

  /**
   * @var UserInterface
   */
  protected $user;

  /**
   * @var RequestStack
   */
  protected $request;


  /**
   * @var array
   */
  private $strategies = [];


  /**
   * Status constructor.
   *
   * @param UserInterface $user
   * @param RequestStack $request
   */
  public function __construct(UserInterface $user, RequestStack $request) {
    $this->user = $user;
    $this->request = $request;
  }

  /**
   * @inheritDoc
   */
  public function addStrategy(StatusStrategy $strategy) {
    if (in_array($strategy, $this->strategies, true)) {
      return;
    }
    array_push($this->strategies, $strategy);
  }


  /**
   * @inheritDoc
   */
  public function getStatus() {
    /**
     * @var StatusStrategy $strategy
     */
    foreach ($this->strategies as $strategy) {
      $strategy->setStatus($this);

      if ($strategy->isValidate()) {
        return $strategy->getStatusName();
      }
    }
    return '';

  }

  /**
   * @inheritDoc
   */
  public function getUser() {
    return $this->user;
  }

  /**
   * @inheritDoc
   */
  public function getRequest() {
    return $this->request;
  }


}