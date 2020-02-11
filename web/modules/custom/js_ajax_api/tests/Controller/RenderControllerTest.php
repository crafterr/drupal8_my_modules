<?php

namespace Drupal\js_ajax_api\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the js_ajax_api module.
 */
class RenderControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "js_ajax_api RenderController's controller functionality",
      'description' => 'Test Unit for module js_ajax_api and controller RenderController.',
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
   * Tests js_ajax_api functionality.
   */
  public function testRenderController() {
    // Check that the basic functions of module js_ajax_api.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
