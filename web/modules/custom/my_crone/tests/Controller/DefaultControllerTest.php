<?php

namespace Drupal\my_crone\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the my_crone module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "my_crone DefaultController's controller functionality",
      'description' => 'Test Unit for module my_crone and controller DefaultController.',
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
   * Tests my_crone functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module my_crone.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
