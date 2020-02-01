<?php

namespace Drupal\my_account_user\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the my_account_user module.
 */
class UserControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "my_account_user UserController's controller functionality",
      'description' => 'Test Unit for module my_account_user and controller UserController.',
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
   * Tests my_account_user functionality.
   */
  public function testUserController() {
    // Check that the basic functions of module my_account_user.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
