<?php
namespace Drupal\my_account_user\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;

class UserAccess implements AccessInterface{

  /**
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * HelloWorldAccess constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $configFactory
   */
  public function __construct(ConfigFactoryInterface $configFactory) {
    $this->configFactory = $configFactory;
  }

  /**
   * Handles the access checking.
   *
   * @param AccountInterface $account
   *
   * @return AccessResult
   */
  public function access(AccountInterface $account) {
    $salutation = $this->configFactory->get('hello_world.custom_salutation')->get('salutation');

    return in_array('editor', $account->getRoles()) && $salutation != "" ? AccessResult::forbidden() : AccessResult::allowed();
  }
}