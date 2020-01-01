<?php

namespace Drupal\colours\EventSubscriber;

use Drupal\colours\Event\Event;
use Drupal\colours\Event\MyEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;

class MyEventSubscriber implements EventSubscriberInterface{
use StringTranslationTrait;

  public static function getSubscribedEvents() {
    $events[Event::COLOURS_EVENT][] = 'doThat';
    return $events;
  }

  public function doThat(MyEvent $myEvent) {
    return [1,2,3,4,5];
  }

}
