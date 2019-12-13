<?php

namespace Drupal\typed_data\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the typed_data module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "typed_data DefaultController's controller functionality",
      'description' => 'Test Unit for module typed_data and controller DefaultController.',
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
   * Tests typed_data functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module typed_data.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
