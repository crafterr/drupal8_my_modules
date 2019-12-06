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
    $render = [
      '#theme' => 'hello_world_salutation',
      '#salutation' => [
        '#contextual_links' => [
          'hello_world' => [
            'route_parameters' => []
          ],
        ],
      ],
      '#wrapper_attribute' => [
        'class' => ['salutation'],
      ]
    ];
    $render['#overridden'] = TRUE;
    $config = $this->configFactory->get('hello_world.custom_salutation');
    $salutation = $config->get('salutation');

    if ($salutation != "") {
     $event = new SalutationEvent();
      $event->setValue($salutation);
      $event = $this->eventDispatcher->dispatch(SalutationEvent::EVENT,$event);

      $render['#salutation'] = $event->getValue();

      return $render;
    }
    $time = new DrupalDateTime();
    $render['#target'] = $this->t('world');
    if ((int) $time->format('G') >= 00 && (int) $time->format('G') < 12) {

      $render['#salutation']['#markup']  = $this->t('Good morning');
      return $render;
    }
    if ((int) $time->format('G') >= 12 && (int) $time->format('G') < 18) {
      $render['#salutation']['#markup'] = $this->t('Good afternoon');
      return $render;
    }

    if ((int) $time->format('G') >= 18) {
      $render['#salutation']['#markup'] = $this->t('Good eveningg');

      return $render;
    }


  }
}