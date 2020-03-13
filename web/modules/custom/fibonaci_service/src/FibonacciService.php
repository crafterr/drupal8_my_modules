<?php

namespace Drupal\drupalup_fibo;

/**
 * A service that lets us generate Fibonacci sequences.
 */
class FibonacciService {

  protected $fiboSequence = [0, 1];

  /**
   * Generates certain ammount of Fibonacci numbers.
   */
  public function calcSomeFibos($numberOfNumbers) {
    if (count($this->fiboSequence) == $numberOfNumbers) {
      return $this->fiboSequence;
    }
    else {
      $this->fiboSequence[] = $this->getPreceding(1) + $this->getPreceding(2);
      return $this->calcSomeFibos($numberOfNumbers);
    }
  }

  /**
   * Getting the preceding number.
   */
  private function getPreceding($preceding = 1) {
    return $this->fiboSequence[count($this->fiboSequence) - $preceding];
  }

}
