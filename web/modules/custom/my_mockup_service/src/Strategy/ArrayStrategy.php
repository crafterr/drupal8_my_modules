<?php
namespace Drupal\my_mockup_service\Strategy;

class ArrayStrategy implements RenderInterface {

  public function render(array $nodes):array {
    return [];
  }

}