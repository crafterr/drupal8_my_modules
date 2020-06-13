<?php
namespace Drupal\user_types;

final class MyStatus {

  const CRITICAL = 20;
  const RED = 15;
  const YELLOW = 10;
  const GREEN = 5;
  const UNKNOWN = 1;

  /**
   * Get all the statuses as text constants keyed by numeric status.
   *
   * This method provides a canonical text version of the status, useful for
   * theme variables and other places so you can avoid a large switch statement.
   *
   * @return array
   *   An array of text constants keyed by status.
   */
  public static function getTextConstants() {
    return [
      self::CRITICAL    => 'my_critical_status',
      static::RED       => 'my_red_status',
      static::YELLOW    => 'my_yellow_status',
      static::GREEN     => 'my_green_status',
      static::UNKNOWN   => 'my_unknown_status',
    ];
  }

  /**
   * Get all the statuses keyed by text constant.
   *
   * @return array
   *   An array of statuses keyed by text constant.
   */
  public static function getAsArrayByConstants() {
    return [
      'my_critical_status'  => static::CRITICAL,
      'my_red_status'       => static::RED,
      'my_yellow_status'    => static::YELLOW,
      'my_green_status'     => static::GREEN,
      'my_unknown_status'   => static::UNKNOWN,
    ];
  }

  /**
   * Gets the numeric status given the text constant.
   *
   * @param string $status_text
   *   A string containing a status text constant.
   *
   * @return bool|int
   *   The numeric status if found, FALSE otherwise.
   */
  public static function constantToNumeric($status_text) {
    $statuses = static::getAsArrayByConstants();
    return isset($statuses[$status_text]) ? $statuses[$status_text] : FALSE;
  }

  /**
   * Gets the status as a text constant given the numeric value.
   *
   * @param int $status
   *   The numeric status value.
   *
   * @return bool|string
   *   The status as a text constant if found, FALSE otherwise.
   */
  public static function numericToConstant($status) {
    $statuses = static::getTextConstants();
    return isset($statuses[$status])?$statuses[$status]: FALSE;
  }


}