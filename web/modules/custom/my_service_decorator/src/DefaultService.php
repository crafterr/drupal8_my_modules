<?php

namespace Drupal\my_service_decorator;

/**
 * Class DefaultService.
 */
class DefaultService implements DefaultServiceInterface {
  private $name;

  public function setName(string $name)
  {
    $this->name = $name;
  }


  public function getName():string
  {
    return $this->name;
  }


}
