<?php

namespace Drupal\products\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the products module.
 */
class ProductControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "products ProductController's controller functionality",
      'description' => 'Test Unit for module products and controller ProductController.',
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
  public function testProductController() {
    // Check that the basic functions of module products.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
