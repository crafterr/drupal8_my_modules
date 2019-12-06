<?php
namespace Drupal\my_dynamic_link\Plugin\Derivative;

use Drupal\Component\Plugin\Derivative\DeriverBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Plugin\Discovery\ContainerDeriverInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\node\Entity\Node;

class MenuLinkDerivative extends DeriverBase  implements ContainerDeriverInterface
{
use StringTranslationTrait;
  /**
   * The entity manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityManager;

  /**
   * Creates an FieldUiLocalTask object.
   *
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_manager
   *   The entity manager.
   */
  public function __construct(EntityTypeManagerInterface $entity_manager) {
    $this->entityManager = $entity_manager;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, $base_plugin_id) {
    return new static(
      $container->get('entity.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getDerivativeDefinitions($base_plugin_definition) {
    $links = array();
    // Get all nodes of type page.
    $nodeQuery = \Drupal::entityQuery('node');
    $nodeQuery->condition('type', 'page');
    $nodeQuery->condition('status', TRUE);
    $ids = $nodeQuery->execute();
    $ids = array_values($ids);
    $nodes = Node::loadMultiple($ids);

    foreach($nodes as $node) {
      $links['my_dynamic_link_menulink_' . $node->id()] = [
          'title' => $node->get('title')->getString(),
          'menu_name' => 'main',
          'route_name' => 'entity.node.canonical',
          'route_parameters' => [
            'node' => $node->id(),
          ],
        ] + $base_plugin_definition;
    }
    return $links;
  }
}
