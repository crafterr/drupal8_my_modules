<?php

namespace Drupal\sports\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the sports module.
 */
class TeamControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "sports TeamController's controller functionality",
      'description' => 'Test Unit for module sports and controller TeamController.',
      'group' => 'Other',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests sports functionality.
   */
  public function testTeamController() {
    // Check that the basic functions of module sports.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
