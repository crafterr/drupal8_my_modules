<?php
namespace Drupal\Tests\user_types\Unit;


use Drupal\Tests\UnitTestCase;
use Drupal\user_types\MyStatus;

/**
 * Unit tests for the MyStatus utility class.
 *
 * @group my_status
 */
class MyStatusTest extends UnitTestCase {

  public function setUp() {
    parent::setUp();
  }

  public function testConstantToNumeric() {
    $this->assertEquals(MyStatus::CRITICAL,MyStatus::constantToNumeric('my_critical_status'));
    $this->assertEquals(MyStatus::RED,MyStatus::constantToNumeric('my_red_status'));
    $this->assertEquals(MyStatus::YELLOW,MyStatus::constantToNumeric('my_yellow_status'));
    $this->assertEquals(MyStatus::GREEN,MyStatus::constantToNumeric('my_green_status'));
    $this->assertEquals(MyStatus::UNKNOWN,MyStatus::constantToNumeric('my_unknown_status'));

    $this->assertFalse(MyStatus::constantToNumeric('my_unknown_statuser'));
  }

  public function testNumericToConstant() {
    $this->assertEquals('my_critical_status',MyStatus::numericToConstant(MyStatus::CRITICAL));
    $this->assertEquals('my_red_status',MyStatus::numericToConstant(MyStatus::RED));
    $this->assertEquals('my_yellow_status',MyStatus::numericToConstant(MyStatus::YELLOW));
    $this->assertEquals('my_green_status',MyStatus::numericToConstant(MyStatus::GREEN));
    $this->assertEquals('my_unknown_status',MyStatus::numericToConstant(MyStatus::UNKNOWN));

    $this->assertFalse(MyStatus::constantToNumeric('blargle_blargle_blah'));
  }


}