<?php
namespace Drupal\form_validation\Tests\Units;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\file\FileInterface;
use Drupal\form_validation\CsvValidator;
use Drupal\Tests\UnitTestCase;

class CsvValidationTest extends UnitTestCase {
use StringTranslationTrait;

  public function setUp() {
    parent::setUp();
    require_once __DIR__.'/../../../form_validation.module';
    $container = new ContainerBuilder();
    $validator = new CsvValidator();
    $container->register('form_validation.csv_validator',$validator);
    $translations = $this->getMockBuilder(TranslationInterface::class)->getMock();
    $container->set('string_translation',$translations);
    \Drupal::setContainer($container);
  }

  public function testValidation() {
    $file = $this->getMockBuilder(FileInterface::class)->getMock();
    $file->expects($this->any())
      ->method('getFileUri')
      ->will($this->returnValue(__DIR__.'/../../fixtures/book.incorrect_form.csv'));


    $this->assertEquals(
      [$this->t('The CSV format is incorrect. Use commas')],
      form_validation_validate_csv($file)
    );
  }

  public function testCsvExist() {
    $path = __DIR__.'/../../fixtures/book.incorrect_form.csv';
    $this->assertFileExists($path);

  }
}