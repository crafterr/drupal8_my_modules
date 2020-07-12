<?php

namespace Drupal\my_mockup_service\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the my_mockup_service module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "my_mockup_service DefaultController's controller functionality",
      'description' => 'Test Unit for module my_mockup_service and controller DefaultController.',
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
   * Tests my_mockup_service functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module my_mockup_service.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
