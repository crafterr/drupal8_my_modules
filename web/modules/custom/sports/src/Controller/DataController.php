<?php

namespace Drupal\sports\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * Class DataController.
 */
class DataController extends ControllerBase {

  /**
   * Callback for the API.
   */
  public function json() {

    return new JsonResponse($this->getResults());
  }

  /**
   * A helper function returning results.
   */
  public function getResults() {
    return [
      'teams' => [
        [
          "name" => "Team from migration 1",
          "description" => "Helpful for many things 1.",
        ],

        [
          "name" => "Team from migration 2",
          "description" => "Helpful for many things 2.",
        ],
        [
          "name" => "Team from migration 3",
          "description" => "Helpful for many things. 3",
        ],
      ]
    ];
  }

}
