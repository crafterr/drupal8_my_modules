<?php

namespace Drupal\my_cache\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the my_cache module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "my_cache DefaultController's controller functionality",
      'description' => 'Test Unit for module my_cache and controller DefaultController.',
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
   * Tests my_cache functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module my_cache.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
