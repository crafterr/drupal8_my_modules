<?php

namespace Drupal\my_service_decorator\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the my_service_decorator module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "my_service_decorator DefaultController's controller functionality",
      'description' => 'Test Unit for module my_service_decorator and controller DefaultController.',
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
   * Tests my_service_decorator functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module my_service_decorator.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
