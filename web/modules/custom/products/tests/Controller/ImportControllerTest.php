<?php

namespace Drupal\products\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the products module.
 */
class ImportControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "products ImportController's controller functionality",
      'description' => 'Test Unit for module products and controller ImportController.',
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
   * Tests products functionality.
   */
  public function testImportController() {
    // Check that the basic functions of module products.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
