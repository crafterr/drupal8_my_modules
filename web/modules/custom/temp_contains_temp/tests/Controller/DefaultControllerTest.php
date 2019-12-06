<?php

namespace Drupal\temp_contains_temp\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the temp_contains_temp module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "temp_contains_temp DefaultController's controller functionality",
      'description' => 'Test Unit for module temp_contains_temp and controller DefaultController.',
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
   * Tests temp_contains_temp functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module temp_contains_temp.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
