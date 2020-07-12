<?php
namespace Drupal\Tests\my_module_browser_test\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * Test basic functionality of My Module.
 *
 * @group mymodulebrowsertest
 */
class LoadTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  public static $modules = [
    // Module(s) for core functionality.
    'node',
    'views',

    // This custom module.
    'my_module_browser_test',
  ];

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    // Make sure to complete the normal setup steps first.
    parent::setUp();

    // Set the front page to "/node".
    \Drupal::configFactory()
      ->getEditable('system.site')
      ->set('page.front', '/')
      ->save(TRUE);
  }

  /**
   * Make sure everything works to this point.
   */
  public function testTheSiteStillWorks() {
    // Load the front page.
    $this->drupalGet('<front>');

    // Confirm that the site didn't throw a server error or something else.
    $this->assertSession()->statusCodeEquals(200);

    // Confirm that the front page contains the standard text.
    //$this->assertText('Welcome to Drupal');
  }
}