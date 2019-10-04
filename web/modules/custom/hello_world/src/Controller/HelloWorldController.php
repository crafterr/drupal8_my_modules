<?php

namespace Drupal\hello_world\Controller;

use Drupal\Console\Bootstrap\Drupal;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\hello_world\HelloWorldSalutationInterface;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class HelloWorldController.
 */
class HelloWorldController extends ControllerBase {


  /**
   * @var HelloWorldSalutationInterface
   */
  protected $salutation;

  /**
   * HelloWorldController constructor.
   *
   * @param HelloWorldSalutationInterface $salutation
   */
  public function __construct(HelloWorldSalutationInterface $salutation) {
    $this->salutation = $salutation;
  }

  /**
   * @param ContainerInterface $container
   *
   * @return HelloWorldController
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('hello_world.salutation')
    );
  }

  /**
   * Helloworld.
   *
   * @return string
   *   Return Hello string.
   */
  public function helloWorld(NodeInterface $node) {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: helloWorld')
    ];
  }

  public function helloForm() {
    $builder = \Drupal::formBuilder();
    return [
      '#theme' => 'hello_world_form',
      '#form' => $builder->getForm('Drupal\hello_world\Form\SalutationConfigurationForm')
    ];
  }

  public function helloWorldSimple() {
    return [
      '#type' => 'markup',
      '#markup' => $this->salutation->getSalutation()
    ];
  }

  /**
   *
   */
  public function urlSample() {
    //url object
    $url = Url::fromRoute('hello_world.hello.url');

    //get link from url object
    /**
     * @var \Drupal\Core\Utility\LinkGeneratorInterface $linkGeneratorService
     */
    $linkGeneratorService = \Drupal::service('link_generator');
    $link = $linkGeneratorService->generate('My link',$url);

    //or faster
    $link = Link::fromTextAndUrl('My link',$url);


    //the same way
    $link = $link->toString();
    //or
    $link = $linkGeneratorService->generateFromLink($link);

    echo $link; die();
    return [];

  }
}
