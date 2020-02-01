<?php


namespace Drupal\user_types\Controller;


interface UserTypeInterface {
  public function boardMember();
  public function manager();
  public function employee();
  public function leadership();
}