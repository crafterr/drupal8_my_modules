<?php

namespace Drupal\products\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\products\Plugin\ImporterManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Zend\Feed\Reader\Http\Response;

/**
 * Class ImportController.
 */
class ImportController extends ControllerBase {

  /**
   * @var \Drupal\products\Plugin\ImporterManager
   */
  private $importerManager;

  /**
   * ImportController constructor.
   *
   * @param \Drupal\products\Plugin\ImporterManager $importerManager
   */
  public function __construct(ImporterManager $importerManager) {
    $this->importerManager = $importerManager;
  }


  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *
   * @return \Drupal\Core\Controller\ControllerBase|\Drupal\products\Controller\ImportController
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('plugin.manager.importer')
    );
  }

  public function execute($cid) {
    /**
     * @var \Drupal\products\Entity\Importer $config
     */
    $config = $this->entityTypeManager()->getStorage('importer')->load($cid);

    /**
     * @var \Drupal\products\Plugin\ImporterInterface $importer
     */

    $importer = $this->importerManager->createInstanceFromConfig($config);

    return $importer->import();
    if ($importer->import()) {
      $this->messenger()->addMessage($this->t('Created the %label Importer.'));
    }
    return [
      '#markup' => "<p>This is html markup</p>",
    ];
  }

}
