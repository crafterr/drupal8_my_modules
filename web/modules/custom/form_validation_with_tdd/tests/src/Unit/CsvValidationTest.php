<?php
namespace Drupal\form_validation_with_tdd\Tests\Unit;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\file\FileInterface;
use Drupal\form_validation_with_tdd\CsvValidator;
use Drupal\Tests\UnitTestCase;

class CsvValidationTest extends UnitTestCase {
use StringTranslationTrait;

  public function setUp() {
    parent::setUp();
    require __DIR__ .'/../../../form_validation_with_tdd.module';
    $container = new ContainerBuilder();
    $validator = new CsvValidator();
    $container->register('form_validation_with_tdd.csv_validator',$validator);

    $translation = $this->getMockBuilder(TranslationInterface::class)->getMock();
    $container->set('string_translation',$translation);

    \Drupal::setContainer($container);
  }

  public function testIncorrectFormatValidation() {
    $file = $this->getMockBuilder(FileInterface::class)->getMock();
    $file->expects($this->any())
      ->method('getFileUri')
      ->will($this->returnValue(__DIR__.'/../../fixtures/books.incorrect_format.csv'));

    $this->assertEquals(
      [$this->t('The CSV format is incorrect. Use commas.')],
      form_validation_validate_csv($file)
    );

    $file = $this->getMockBuilder(FileInterface::class)->getMock();
    $file->expects($this->any())
      ->method('getFileUri')
      ->will($this->returnValue(__DIR__.'/../../fixtures/books.incorrect_data.csv'));

    $this->assertEquals(
      [
        $this->t('The author on line @line is empty. You must provide at least one author.',['@line'=>1]),
        $this->t('The book title on line @line is empty. You must provide a title for each book.',['@line'=>2])

      ],
      form_validation_validate_csv($file)
    );

    /**
     * correct
     */
    $file = $this->getMockBuilder(FileInterface::class)->getMock();
    $file->expects($this->any())
      ->method('getFileUri')
      ->will($this->returnValue(__DIR__.'/../../fixtures/books.correct.csv'));

    $this->assertEquals(
      [],
      form_validation_validate_csv($file)
    );
  }

}