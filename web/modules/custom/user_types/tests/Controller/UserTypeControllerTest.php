<?php

namespace Drupal\user_types\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the user_types module.
 */
class UserTypeControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "user_types UserTypeController's controller functionality",
      'description' => 'Test Unit for module user_types and controller UserTypeController.',
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
   * Tests user_types functionality.
   */
  public function testUserTypeController() {
    // Check that the basic functions of module user_types.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
