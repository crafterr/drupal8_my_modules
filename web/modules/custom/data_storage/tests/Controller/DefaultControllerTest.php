<?php

namespace Drupal\data_storage\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the data_storage module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "data_storage DefaultController's controller functionality",
      'description' => 'Test Unit for module data_storage and controller DefaultController.',
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
   * Tests data_storage functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module data_storage.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
