<?php


namespace Drupal\hello_world;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Component\Datetime\Time;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class HelloWorldSalutation implements HelloWorldSalutationInterface{
  use StringTranslationTrait;

  /**
   * @var TimeInterface
   */
  private $time;

  /**
   * @var ConfigFactoryInterface
   */
  private $configFactory;

  /**
   * @var \Symfony\Component\EventDispatcher\EventDispatcherInterface
   */
  private $eventDispatcher;

  public function __construct(TimeInterface $time, ConfigFactoryInterface $configFactory, EventDispatcherInterface $eventDispatcher) {
    $this->time = $time;
    $this->configFactory = $configFactory;
    $this->eventDispatcher = $eventDispatcher;
  }

  public function getSalutation() {
    $config = $this->configFactory->get('hello_world.custom_salutation');
    $salutation = $config->get('salutation');
    if ($salutation != "") {
      $event = new SalutationEvent();
      $event->setValue($salutation);
      $event = $this->eventDispatcher->dispatch(SalutationEvent::EVENT,$event);
      return $event->getValue();
      //return $salutation;
    }
    $time = new DrupalDateTime();
    if ((int) $time->format('G') >= 00 && (int) $time->format('G') < 12) {
      return $this->t('Good morning world');
    }
    if ((int) $time->format('G') >= 12 && (int) $time->format('G') < 18) {
      return $this->t('Good afternoon world');
    }

    if ((int) $time->format('G') >= 18) {
      return $this->t('Good evening world');
    }
  }
}