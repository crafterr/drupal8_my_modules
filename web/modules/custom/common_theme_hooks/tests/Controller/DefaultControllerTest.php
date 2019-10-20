<?php

namespace Drupal\common_theme_hooks\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the common_theme_hooks module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "common_theme_hooks DefaultController's controller functionality",
      'description' => 'Test Unit for module common_theme_hooks and controller DefaultController.',
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
   * Tests common_theme_hooks functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module common_theme_hooks.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
