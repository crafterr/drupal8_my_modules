<?php

namespace Drupal\my_batch\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the my_batch module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "my_batch DefaultController's controller functionality",
      'description' => 'Test Unit for module my_batch and controller DefaultController.',
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
   * Tests my_batch functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module my_batch.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
