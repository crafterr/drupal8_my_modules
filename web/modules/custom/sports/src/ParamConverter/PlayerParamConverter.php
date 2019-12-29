<?php

namespace Drupal\sports\ParamConverter;

use Drupal\Core\ParamConverter\ParamConverterInterface;
use Symfony\Component\Routing\Route;
use Drupal\sports\PlayerStorage;

/**
 * Param converter for url param of type {player}.
 */
class PlayerParamConverter implements ParamConverterInterface {

  /**
   * {@inheritdoc}
   */
  public function convert($value, $definition, $name, array $defaults) {

    if (!PlayerStorage::exists($value)) {
      return 'invalid';
    }
    return PlayerStorage::load($value);
  }

  /**
   * {@inheritdoc}
   */
  public function applies($definition, $name, Route $route) {
    return (!empty($definition['type']) && $definition['type'] == 'player');
  }
}