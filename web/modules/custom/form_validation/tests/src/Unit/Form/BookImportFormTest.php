<?php
namespace Drupal\form_validation\Tests\Units\Form;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Form\FormState;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\form_validation\Form\BookImportForm;
use Drupal\Tests\UnitTestCase;

class BookImportFormTest extends UnitTestCase{
  use StringTranslationTrait;

  /**
   *
   */
  public function setUp() {
    parent::setUp();
    $container = new ContainerBuilder();
    $translations = $this->getMockBuilder(TranslationInterface::class)->getMock();
    $container->set('string_translation',$translations);
    \Drupal::setContainer($container);
  }

  public function testFormBuilding() {
    $importForm = new BookImportForm();
    $form = $importForm->buildForm([], new FormState());
    $this->assertArrayNotHasKey('reset',$form);

  }


}
