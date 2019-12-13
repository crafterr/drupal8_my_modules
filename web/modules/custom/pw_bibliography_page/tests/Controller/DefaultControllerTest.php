<?php

namespace Drupal\pw_bibliography_page\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the pw_bibliography_page module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "pw_bibliography_page DefaultController's controller functionality",
      'description' => 'Test Unit for module pw_bibliography_page and controller DefaultController.',
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
   * Tests pw_bibliography_page functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module pw_bibliography_page.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
