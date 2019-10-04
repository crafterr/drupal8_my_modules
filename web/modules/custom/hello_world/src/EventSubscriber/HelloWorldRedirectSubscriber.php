<?php


namespace Drupal\hello_world\EventSubscriber;

use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\Routing\LocalRedirectResponse;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Url;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class HelloWorldRedirectSubscriber implements EventSubscriberInterface {

  /**
   * @var AccountProxyInterface
   */
  protected $currentUser;

  /**
   * @var \Drupal\Core\Routing\CurrentRouteMatch
   */
  private $currentRouteMatch;


  /**
   * HelloWorldRedirectSubscriber constructor.
   *
   * @param AccountProxyInterface $currentUser
   */
  public function __construct(AccountProxyInterface $currentUser, CurrentRouteMatch $currentRouteMatch) {
    $this->currentUser = $currentUser;
    $this->currentRouteMatch = $currentRouteMatch;
  }

  /**
   * @return array|mixed
   */
  public static function getSubscribedEvents() {
    //kernel.request
    $events[KernelEvents::REQUEST][] = ['onRequest',0];
    return $events;
  }

  /**
   * @param GetResponseEvent $event
   */
  public function onRequest(GetResponseEvent $event) {
   /* $request = $event->getRequest();
    $path = $request->getPathInfo();
    if ($path == '/hello/url') {
      return;
    }*/
    $route_name = $this->currentRouteMatch->getRouteName();
    if ($route_name !== 'hello_world.hello.url') {
      return;
    }
    $url = Url::fromUri('internal:/');
    $event->setResponse(new LocalRedirectResponse($url->toString()));
    //$event->setResponse(new RedirectResponse('/'));
   // return;
  }

}