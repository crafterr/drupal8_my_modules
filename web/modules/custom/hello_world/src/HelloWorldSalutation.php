<?php


namespace Drupal\hello_world;

use Drupal\Component\Datetime\TimeInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\Component\Datetime\Time;

class HelloWorldSalutation implements HelloWorldSalutationInterface{
  use StringTranslationTrait;

  /**
   * @var \Drupal\Component\Datetime\TimeInterface
   */
  private $time;

  public function __construct(TimeInterface $time) {
    $this->time = $time;
  }

  public function getSalutation() {
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