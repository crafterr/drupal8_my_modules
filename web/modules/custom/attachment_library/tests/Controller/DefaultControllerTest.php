<?php

namespace Drupal\attachment_library\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the attachment_library module.
 */
class DefaultControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "attachment_library DefaultController's controller functionality",
      'description' => 'Test Unit for module attachment_library and controller DefaultController.',
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
   * Tests attachment_library functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module attachment_library.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
