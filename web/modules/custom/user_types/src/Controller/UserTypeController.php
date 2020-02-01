<?php

namespace Drupal\user_types\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class UserTypeController.
 */
class UserTypeController extends ControllerBase implements UserTypeInterface{

  public function boardMember() {
    return [
      '#markup' => '<p>' . $this->t('This is board Member route') . '</p>',
      '#description' => $this->t('Example of using #markup'),
    ];
  }

  public function manager() {
    return [
      '#markup' => '<p>' . $this->t('This is board Manager route') . '</p>',
      '#description' => $this->t('Example of using #markup'),
    ];
  }

  public function employee() {
    return [
      '#markup' => '<p>' . $this->t('This is board Employee route') . '</p>',
      '#description' => $this->t('Example of using markup'),
    ];
  }

  public function leadership() {
    return [
      '#markup' => '<p>' . $this->t('This is board Leadership route') . '</p>',
      '#description' => $this->t('Example of using markup'),
    ];
  }


}
