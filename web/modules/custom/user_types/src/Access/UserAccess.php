<?php
namespace Drupal\user_types\Access;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Entity\EntityTypeManager;
use Drupal\Core\Routing\Access\AccessInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\Routing\Route;

class UserAccess implements AccessInterface{

  /**
   * @var \Drupal\Core\Entity\EntityTypeManager
   */
  protected $entityTypeManager;

  /**
   * UserTypesAccess constructor.
   *
   * @param \Drupal\Core\Entity\EntityTypeManager $entityTypeManager
   */
  public function __construct(EntityTypeManager $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * @param \Drupal\Core\Session\AccountInterface $account
   * @param \Symfony\Component\Routing\Route $route
   *
   * @return \Drupal\Core\Access\AccessResultAllowed|\Drupal\Core\Access\AccessResultForbidden
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   *
   * We'll go into this example with the assumption that the user entity has a field called field_user_type already on it;
   * that we have users of three types: board_member, manager, and employee; and that we have the following four route definitions:
   */
  public function access(AccountInterface $account, Route $route) {

    $user_types = $route->getOption('_user_types');
    if (!$user_types) {
      return AccessResult::forbidden();
    }
    if ($account->isAnonymous()) {
      return AccessResult::forbidden();
    }
    $user = $this->entityTypeManager->getStorage('user')->load($account->id());
    $type = $user->get('field_user_type')->value;

    return in_array($type, $user_types) ? AccessResult::allowed() : AccessResult::forbidden();
  }
}