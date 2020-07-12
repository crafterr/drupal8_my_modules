<?php
namespace Drupal\my_mockup_service\Strategy;

interface RenderInterface {
  public function render(array $nodes):array;
}