<?php

namespace Drupal\colours\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the colours module.
 */
class ColourControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "colours ColourController's controller functionality",
      'description' => 'Test Unit for module colours and controller ColourController.',
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
   * Tests colours functionality.
   */
  public function testColourController() {
    // Check that the basic functions of module colours.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
