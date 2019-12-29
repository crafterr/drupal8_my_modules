<?php

namespace Drupal\sports\ParamConverter;

use Drupal\Core\ParamConverter\ParamConverterInterface;
use Symfony\Component\Routing\Route;
use Drupal\sports\TeamStorage;

/**
 * Param converter for url param of type {team}.
 */
class TeamParamConverter implements ParamConverterInterface {

  /**
   * {@inheritdoc}
   */
  public function convert($value, $definition, $name, array $defaults) {

    if (!TeamStorage::exists($value)) {
      return 'invalid';
    }
    return TeamStorage::load($value);
  }

  /**
   * {@inheritdoc}
   */
  public function applies($definition, $name, Route $route) {
    return (!empty($definition['type']) && $definition['type'] == 'team');
  }
}