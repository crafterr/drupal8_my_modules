<?php

namespace Drupal\form_validation_with_tdd\Tests\Unit\Form;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Form\FormState;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\form_validation_with_tdd\Form\BookImportForm;
use Drupal\Tests\UnitTestCase;
use Drupal\user\Entity\User;

class BookImportFormTest extends UnitTestCase {

  protected $user;

  public function setUp() {
    parent::setUp();
    $container = new ContainerBuilder();

    $translation = $this->getMockBuilder(TranslationInterface::class)->getMock();
    $container->set('string_translation',$translation);

    $this->user = $this->getMockBuilder(User::class)
      ->disableOriginalConstructor()->getMock();


    $container->set('current_user',$this->user);


    \Drupal::setContainer($container);
  }

  public function testFormBuilding() {
    $import_form = new BookImportForm($this->user);
    $form = $import_form->buildForm([],new FormState());
    $this->assertArrayNotHasKey('reset',$form);

    $user = \Drupal::currentUser();
    $user->expects($this->any())
      ->method('hasPermission')
      ->with($this->equalTo('administer books'))
      ->will($this->returnValue(TRUE));

    $form = $import_form->buildForm([],new FormState());
    $this->assertArrayHasKey('reset',$form);
  }
}