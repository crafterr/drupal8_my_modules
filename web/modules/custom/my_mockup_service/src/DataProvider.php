<?php


namespace Drupal\my_mockup_service;


use Drupal\Core\Entity\EntityTypeManagerInterface;

class DataProvider {

  /**
   * @var EntityTypeManagerInterface
   */
  private $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  /**
   * @return \Drupal\Core\Entity\EntityInterface[]
   * @throws \Drupal\Component\Plugin\Exception\InvalidPluginDefinitionException
   * @throws \Drupal\Component\Plugin\Exception\PluginNotFoundException
   */
  public function getData(array $data) {
    return $this->entityTypeManager->getStorage('node')->loadMultiple($data);
  }
}