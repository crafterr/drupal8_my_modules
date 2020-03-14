<?php

namespace Drupal\my_yaml_readable\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the my_yaml_readable module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "my_yaml_readable DefaultController's controller functionality",
      'description' => 'Test Unit for module my_yaml_readable and controller DefaultController.',
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
   * Tests my_yaml_readable functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module my_yaml_readable.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
