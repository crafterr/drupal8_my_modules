<?php

namespace Drupal\my_layout\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the my_layout module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "my_layout DefaultController's controller functionality",
      'description' => 'Test Unit for module my_layout and controller DefaultController.',
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
   * Tests my_layout functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module my_layout.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
