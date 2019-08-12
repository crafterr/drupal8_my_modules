<?php

namespace Drupal\hello_world\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the hello_world module.
 */
class HelloWorldControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "hello_world HelloWorldController's controller functionality",
      'description' => 'Test Unit for module hello_world and controller HelloWorldController.',
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
   * Tests hello_world functionality.
   */
  public function testHelloWorldController() {
    // Check that the basic functions of module hello_world.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
