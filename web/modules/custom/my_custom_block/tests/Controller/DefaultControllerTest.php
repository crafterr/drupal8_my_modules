<?php

namespace Drupal\my_custom_block\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the my_custom_block module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "my_custom_block DefaultController's controller functionality",
      'description' => 'Test Unit for module my_custom_block and controller DefaultController.',
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
   * Tests my_custom_block functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module my_custom_block.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
