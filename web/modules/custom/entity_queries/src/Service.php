<?php

namespace Drupal\entity_queries;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeInterface;
use Drupal\taxonomy\Entity\Term;
use Drupal\views\Entity\View;
use Drupal\views\Views;

/**
 * Class Service.
 */
class Service implements ServiceInterface {

  /**
   * EntityTypeManagerInterface definition.
   *
   * @var EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs a new Service object.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * @inheritDoc
   */
  public function getArticles() {
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $query
      ->condition('type','article')
      //->condition('type', ['article', 'page'], 'IN')
      ->condition('status',true)
      ->range(0,10)
      ->sort('created','DESC');

    $ids = $query->execute();

    $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($ids);

    return $nodes;
  }

  /**
   * @inheritDoc
   */
  public function getArticlesByConditionGroup() {
    $query = $this->entityTypeManager->getStorage('node')->getQuery();
    $query
      ->condition('type','article')
      ->condition('status',true);
    $or = $query->orConditionGroup()
      ->condition('title','Drupal','CONTAINS')
      ->condition('field_tags.entity.name','Drupal','CONTAINS');
    $query->condition($or);


    $ids = $query->execute();

    $nodes = $this->entityTypeManager->getStorage('node')->loadMultiple($ids);

    return $nodes;
  }

  /**
   * @inheritDoc
   */
  public function loadByProperties(array $type) {
    return $this->entityTypeManager->getStorage('node')->loadByProperties($type);
  }

  /**
   * @inheritDoc
   */
  public function load(int $id): NodeInterface {
    return $this->entityTypeManager->getStorage('node')->load($id);
  }

  /**
   * @inheritDoc
   */
  public function getNodeType(string $type) {
    return $this->entityTypeManager->getStorage('node_type')->load($type);
  }

  /**
   * @inheritDoc
   */
  public function createArticle() {
    $values = [
      'type' => 'article',
      'title' => 'My sweet article'
    ];
    /**
     * @var NodeInterface $node
     */
    $node = $this->entityTypeManager->getStorage('node')->create($values);
    //add new term
    $new_term = Term::create([
      'vid' => "tags",
      'name' => "Sarterer2",
    ]);
    $node->set('body','jakies tam body');
    $node->set('field_list_of_items',['hehehe','hahaha','hihihi']);
    $node->set('field_my_text_simple','any simple text');
    $node->set('field_tags',[1,2,$new_term]);


   // $node->save();
  }

  /**
   * @inheritDoc
   */
  public function getConfigurationForAllViews() {
    $query = $this->entityTypeManager->getStorage('view')->getQuery();
    $or = $query->orConditionGroup()
      ->condition('display.*.display_plugin', 'page')
      ->condition('display.*.display_plugin', 'block');
    $query->condition($or);

    $ids = $query->execute();
    return $ids;
  }

  public function getView(string $id) {
    $view = Views::getView($id);
    $view->execute();
    return $view;
    //return $view->result;
  }


}
