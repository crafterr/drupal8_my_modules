<?php


namespace Drupal\hello_world\EventSubscriber;

use Drupal\Core\Routing\CurrentRouteMatch;
use Drupal\Core\Routing\LocalRedirectResponse;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Url;
use Drupal\hello_world\SalutationEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class HelloWorldSalutationSubscriber implements EventSubscriberInterface {


  /**
   * @return array|mixed
   */
  public static function getSubscribedEvents() {
    //kernel.request
    $events[SalutationEvent::EVENT][] = ['onRequest',0];
    return $events;
  }


  public function onRequest(SalutationEvent $event) {
    $event->setValue('Zmieniam tresc tego komunkatu');
  }

}