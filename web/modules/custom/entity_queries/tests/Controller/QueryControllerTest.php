<?php

namespace Drupal\entity_queries\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the entity_queries module.
 */
class QueryControllerTest extends WebTestBase {


  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return [
      'name' => "entity_queries QueryController's controller functionality",
      'description' => 'Test Unit for module entity_queries and controller QueryController.',
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
   * Tests entity_queries functionality.
   */
  public function testQueryController() {
    // Check that the basic functions of module entity_queries.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via Drupal Console.');
  }

}
