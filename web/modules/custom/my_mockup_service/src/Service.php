<?php

namespace Drupal\my_mockup_service;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\my_mockup_service\Strategy\RenderInterface;
use Drupal\Core\Session\AccountProxy;
/**
 * Class Service.
 */
class Service implements ServiceInterface {

  /**
   * Drupal\Core\Session\AccountProxy definition.
   *
   * @var \Drupal\Core\Session\AccountProxy
   */
  protected $currentUser;
  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new Service object.
   */
  public function __construct(AccountProxy $current_user, EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
    $this->currentUser = $current_user;
  }

  function getCurrentUserDetails(){
    $details = [];
    $user = $this->entityTypeManager->getStorage('user')
      ->load($this->currentUser->id());
    if($user){
      $details = [
        'name' => $user->getDisplayName(),

      ];
    }
    return $details;
  }

}
