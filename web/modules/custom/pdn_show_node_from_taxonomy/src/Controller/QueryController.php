<?php

namespace Drupal\pdn_show_node_from_taxonomy\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\entity_queries\ServiceInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class QueryController.
 */
class QueryController extends ControllerBase {

  /**
   * @var ServiceInterface
   */
  private $service;

  public function __construct(ServiceInterface $service) {
    $this->service = $service;
  }

  /**
   * @param ContainerInterface $container
   * @return $this
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_queries.service')
    );
  }

  public function query() {
      $articles = $this->service->getArticles();
      $articlesByConditions = $this->service->getArticlesByConditionGroup();

      $configurationForDisplayPluginPage = $this->service->getConfigurationForAllViews();

      $loadByProperties = $this->service->loadByProperties(['type'=>'article']);

      $node = $this->service->load(13);

      dump($node->get('field_tags')->entity); die();

    /** @var \Drupal\node\NodeViewBuilder $builder */
    $builder = \Drupal::entityTypeManager()->getViewBuilder('node');

    //return $listBuilder = \Drupal::entityTypeManager()->getListBuilder('node')->render();

    $build = $builder->view($node);

    return $build;

    $node_type = $this->service->getNodeType('article');



      //dump($node_type);

      $title = $node->get('title');
      //dump($title->value);

      //get array of referenced list

      //dump($node->get('field_tags')->referencedEntities());
      //dump($node->get('field_tags')->getValue());
    //for field with many cardinality
    /*  dump($node->get('field_list_of_items')->getValue());
    foreach ($node->get('field_list_of_items')->getValue() as $value) {
      echo $value['value'];
    }*/

    /**
     * for field with one cardinarity
     */
    /*foreach ($node->get('field_my_text_simple')->getValue() as $value) {
      echo $value['value'];
    }
    or
    echo $node->get('field_my_text_simple')->value;
    */

    /**
     * the best method to retrieve data
     * If the field has only one value
     */
    //$title = $node->get('title')->value;
    //$id = $node->get('field_referencing_some_entity')->target_id;
    //$entity = $node->get('field_referencing_some_entity')->entity;

    /**
     * the best method to retrieve data
     * If the field has many multiple
     */
    //$names = $node->get('field_names')->getValue();
    //$tags = $node->get('field_tags')->referencedEntities();

    /**
     * if we have field that have only one value (cardinality = 1)
     * then we can use
     */
    //$node->set('title', 'new title');
    //$node->setTitle('title','new title');

    /**
     * But if we have field that have many values cardinality > 1
     * then we have to use
     */
    //$values = $node->get('field_multiple')->getValue();
    //$values[] = ['value' => 'extra value'];
    //$node->set('field_multiple', $values);

    //or

    //$node->get('field_multiple')->get(1)->setValue('changed value');

    $values = $node->get('field_list_of_items')->getValue();

    array_push($values,['value'=>'extra_value']);

    $node->set('field_list_of_items',$values);
    //dump( $node->get('field_list_of_items')->getValue()); die();

    /**
     * and save
     */
    //$node->save();
    //\Drupal::entityTypeManager()->getStorage('node')->save($node);


    /**
     * if we have changed configuration data for example for node_type then we can
     *
     */
    /** @var \Drupal\node\Entity\NodeType $type */
    //$type = \Drupal::entityTypeManager()->getStorage('node_type')->load('article');
    //$type->set('name', 'News');
    //$type->save();


    $this->service->createArticle();
    return new Response();

  }

  /**
   *
   */
  public function renderContent() {
    /** @var \Drupal\node\NodeViewBuilder $builder */
    $builder = $this->service->getNodeViewBuilder();
    $node = $this->service->load(13);
    //for one node
    $build = $builder->view($node,'tiles');
    //for many nodes
    //$build = $builder->viewMultiple($nodes,'tiles');
    //add suggestion
    $build['#theme'] = $build['#theme'] . '__my_suggestion';
    return $build;
  }




  /**
   * @param array $array
   *
   * @return array
   */
  private function renderToArray(array $array) {
    $arr = [];

    /**
     * @var \Drupal\node\NodeInterface $article
     */
    foreach ($array as $index => $article) {
      $title = $article->getTitle();
      $arr[$index] = [
        'title' => $title
      ];
      $tagsReference = $article->get('field_tags')->referencedEntities();
      $arr[$index]['tags'] = [];
      /**
       * @var \Drupal\taxonomy\Entity\Term $tag
       */
      foreach ($tagsReference as $tag) {
        $arr[$index]['tags'][] = $tag->getName();
      }
    }
    return $arr;
  }

  public function test() {
    $database = \Drupal::database();
    $results = $database->query("SELECT id, `data` FROM {players}")->fetchAllAssoc();
    dump($results);
  }

}
