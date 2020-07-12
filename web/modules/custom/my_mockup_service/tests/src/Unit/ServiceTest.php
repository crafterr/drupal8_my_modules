<?php


namespace Drupal\Tests\my_mockup_service\Unit;

use Drupal\my_mockup_service\Service;
use Drupal\my_mockup_service\Strategy\ArrayStrategy;
use Drupal\Tests\UnitTestCase;
use Drupal\Core\Session\UserSession;
use Drupal\user_types\Access\UserAccess;
use Symfony\Component\Routing\Route;
/**
 * Tests the UserTypesAccess class methods.
 *
 * @group user_types
 */
class ServiceTest extends UnitTestCase {

  protected $currentUser;
  protected $entityTypeManager;
  protected $entityStorage;
  protected $service;
  public function setUp() {

    $methods = get_class_methods('Drupal\Core\Entity\ContentEntityNullStorage');
    $this->entityStorage = $this->getMockBuilder('Drupal\Core\Entity\ContentEntityNullStorage')
      ->disableOriginalConstructor()
      ->setMethods($methods)
      ->getMock();
    $this->currentUser = $this->getMockBuilder('Drupal\Core\Session\AccountProxy')
      ->disableOriginalConstructor()
      ->setMethods(['id','getDisplayName'])
      ->getMock();
    $methods = get_class_methods('Drupal\Core\Entity\EntityTypeManager');
    $this->entityTypeManager = $this->getMockBuilder('Drupal\Core\Entity\EntityTypeManager')
      ->disableOriginalConstructor()
      ->setMethods($methods)
      ->getMock();
    $this->entityTypeManager->expects($this->any())
      ->method('getStorage')
      ->willReturn($this->entityStorage);
    $this->service = new Service($this->currentUser, $this->entityTypeManager);
  }
  public function testGetCurrentUserDetails() {
    $this->currentUser->expects($this->any())
      ->method('getDisplayName')
      ->will($this->returnValue('administrator'));

    $this->entityStorage->expects($this->any())
      ->method('load')
      ->willReturn($this->currentUser);
    $this->assertArrayEquals(['name' => 'administrator'],$this->service->getCurrentUserDetails());
  }
}