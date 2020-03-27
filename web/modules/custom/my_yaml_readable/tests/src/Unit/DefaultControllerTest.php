<?php
namespace Drupal\my_yaml_readable\Tests\Units;
use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\StringTranslation\TranslationInterface;
use Drupal\file\FileInterface;
use Drupal\my_yaml_readable\Library\UserManager;
use Drupal\Tests\UnitTestCase;
class DefaultControllerTest extends UnitTestCase{

  public function setUp() {
    parent::setUp();
    $container = new ContainerBuilder();
    $userManager = new UserManager();
    $container->register('my_yaml_readable.user_manager',$userManager);
    $container = new ContainerBuilder();
    $translations = $this->getMockBuilder(TranslationInterface::class)->getMock();
    $container->set('string_translation',$translations);
    \Drupal::setContainer($container);
  }

  public function testUserManager() {



    $this->assertEquals(
      [$this->us],
      form_validation_validate_csv($file)
    );
  }


}
