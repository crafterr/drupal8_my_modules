<?php

namespace Drupal\simple_configuration\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the simple_configuration module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "simple_configuration DefaultController's controller functionality",
      'description' => 'Test Unit for module simple_configuration and controller DefaultController.',
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
   * Tests simple_configuration functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module simple_configuration.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
