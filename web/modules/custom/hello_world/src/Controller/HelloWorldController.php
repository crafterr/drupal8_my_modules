<?php

namespace Drupal\hello_world\Controller;

use Drupal\Component\Render\FormattableMarkup;
use Drupal\Console\Bootstrap\Drupal;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Link;
use Drupal\Core\Logger\LoggerChannelInterface;
use Drupal\Core\Url;
use Drupal\hello_world\HelloWorldSalutationInterface;
use Drupal\node\NodeInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class HelloWorldController.
 */
class HelloWorldController extends ControllerBase {


  /**
   * @var HelloWorldSalutationInterface
   */
  protected $salutation;

  /**
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  private $loggerChannel;

  /**
   * @var \Drupal\Core\Logger\LoggerChannelInterface
   */
  private $loggerChannelHello;

  /**
   * HelloWorldController constructor.
   *
   * @param HelloWorldSalutationInterface $salutation
   */
  public function __construct(HelloWorldSalutationInterface $salutation, LoggerChannelInterface $loggerChannel, LoggerInterface $loggerChannelHello) {
    $this->salutation = $salutation;
    $this->loggerChannel = $loggerChannel;
    $this->loggerChannelHello = $loggerChannelHello;
  }

  /**
   * @param ContainerInterface $container
   *
   * @return HelloWorldController
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('hello_world.salutation'),
      $container->get('hello_world.logger.channel.hello_world'),
      $container->get('hello_world.logger.hello_world')
    );
  }

  /**
   * Helloworld.
   *
   * @return string
   *   Return Hello string.
   */
  public function helloWorld(NodeInterface $node) {

    $salutation_replace_title =  \Drupal::token()->replace('The salutation text is: [customtoken:body]',['node'=>$node]);

    return [
      '#type' => 'markup',
      '#markup' => $salutation_replace_title
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
   /* return [
      '#theme' => 'hello_world_salutation',
      '#salutation' => $this->salutation->getSalutation(),
      '#wrapper_attribute' => [
        'class' => ['salutation'],
      ]
    ];*/

   return $this->salutation->getSalutation();
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
   // $link = $link->toString();
    //or
    $link = $linkGeneratorService->generateFromLink($link);

    echo $link;
    return [];

  }

  public function loggerSample() {

    //\Drupal::logger('hello_world')->error('This is my error message');
    //$log = \Drupal::service('logger.factory')->get('hello_world');
    $this->loggerChannel->error('adam ma kota');
    $this->loggerChannelHello->log(3,'hello to ja',[]);
    $variable = [':variable' => 'http://www.onet.pl'];
    $markup = new FormattableMarkup('<a href=":variable">link text</a>', [
      ':variable'=>'http://onet.pl',

    ]);
    $config = \Drupal::configFactory()->getEditable('system.mail');
    $mail_plugins = $config->get('interface');
  //  dump($mail_plugins); die();
    return new Response("poszlo");
  }

  public function tokenSample() {
    $replace = \Drupal::token()->replace('The user that was logged in: [current-user:name].',['current-user' => \Drupal::currentUser()]);
    $salutation_replace =  \Drupal::token()->replace('The salutation text is: [hello_world:salutation2]');
    dump($salutation_replace);
  }
}
