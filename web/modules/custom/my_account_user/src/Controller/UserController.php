<?php

namespace Drupal\my_account_user\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Session\AccountInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Access\AccessResult;
/**
 * Class UserController.
 */
class UserController extends ControllerBase {




  public function render() {

    $accountProxy = \Drupal::currentUser();
    $user = $this->entityTypeManager()
      ->getStorage('user')
      ->load($accountProxy->id());


    dump($accountProxy);
    dump($user);
    dump($accountProxy->getAccount()->getAccountName());
    $account = $accountProxy->getAccount();
    dump($account->isAnonymous());
    dump($account->isAuthenticated());
    dump($accountProxy->getRoles());
    die();
  }

  /**
   * Handles the access checking.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *
   * @return \Drupal\Core\Access\AccessResultInterface
   */
  public function access(AccountInterface $account) {
    /**
     * AccessResultAllowed
       AccessResultNeutral
       AccessResultForbidden
     */
    return in_array('editor', $account->getRoles()) ? AccessResult::forbidden() : AccessResult::allowed();
  }
}
