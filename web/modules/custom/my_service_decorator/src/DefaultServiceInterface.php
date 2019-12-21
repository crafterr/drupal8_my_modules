<?php

namespace Drupal\my_service_decorator;

/**
 * Interface DefaultServiceInterface.
 */
interface DefaultServiceInterface {

  public function setName(string $name);
  public function getName():string;
}
