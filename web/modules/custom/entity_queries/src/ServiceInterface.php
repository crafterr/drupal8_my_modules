<?php

namespace Drupal\entity_queries;

use Drupal\node\NodeInterface;
use Drupal\node\Entity\NodeType;
/**
 * Interface ServiceInterface.
 */
interface ServiceInterface {

  public function getArticles();

  public function getArticlesByConditionGroup();

  public function getConfigurationForAllViews();

  /**
   * @var array $type
   * @return array of nodes
   */
  public function loadByProperties(array $type);

  /**
   * @var int $id
   * @return NodeInterface
   */
  public function load(int $id): NodeInterface;

  /**
   * @var string $article
   * @return  NodeType $type
   */
  public function getNodeType(string $type);

  public function createArticle();

  public function getView(string $id);

  public function getNodeViewBuilder();

}
