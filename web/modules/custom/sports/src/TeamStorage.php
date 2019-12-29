<?php

namespace Drupal\sports;

/**
 * DAO class for employee table.
 */
class TeamStorage {
  /**
   * To get multiple team records.
   *
   * @param int $limit
   *   The number of records to be fetched.
   * @param string $orderBy
   *   The field on which the sorting to be performed.
   * @param string $order
   *   The sorting order. Default is 'DESC'.
   *
   * @return
   */
  public static function getAll($limit = NULL, $orderBy = NULL, $order = 'DESC') {
    $query = \Drupal::database()->select('teams', 't')
      ->fields('t');
    if ($limit) {
      $query->range(0, $limit);
    }
    if ($orderBy) {
      $query->orderBy($orderBy, $order);
    }
    $result = $query->execute()
      ->fetchAll();
    return $result;
  }

  /**
   * @param $id int
   *   The team id
   *
   * @return bool
   *   return boolean
   */
  public static function exists($id) {
    $result = \Drupal::database()->select('teams', 't')
      ->fields('t', ['id'])
      ->condition('id', $id, '=')
      ->execute()
      ->fetchField();
    return (bool) $result;
  }

  /**
   * To load an team record.
   *
   * @param int $id
   *   The team ID.
   *
   * @return
   */
  public static function load($id) {
    $result = \Drupal::database()->select('teams', 't')
      ->fields('t')
      ->condition('id', $id, '=')
      ->execute()
      ->fetchObject();
    return $result;
  }

  /**
   * To insert a new team record.
   *
   * @param array $fields
   *   An array conating the team data in key value pair.
   *
   * @return \Drupal\Core\Database\StatementInterface|int|null
   * @throws \Exception
   */
  public static function add(array $fields) {
    return \Drupal::database()->insert('teams')->fields($fields)->execute();
  }

  /**
   * To update an existing team record.
   *
   * @param int $id
   *   The team ID.
   * @param array $fields
   *   An array conating the team data in key value pair.
   * @return
   *   Drupal db execute
   */
  public static function update($id, array $fields) {
    return \Drupal::database()->update('teams')->fields($fields)
      ->condition('id', $id)
      ->execute();
  }
  /**
   * To delete a specific employee record.
   *
   * @param int $id
   *   The employee ID.
   *
   * @return
   *   Drupal db execute
   *
   */
  public static function delete($id) {
    $record = self::load($id);

    return \Drupal::database()->delete('teams')->condition('id', $id)->execute();
  }
  /**
   * To activate/ block the employee record.
   *
   * @param int $id
   *   The employee ID.
   * @param int $status
   *   Set 1 for activatng and 0 for blocking.
   *
   * @return
   *
   */
  public static function changeStatus($id, $status) {
    return self::update($id, ['status' => ($status) ? 1 : 0]);
  }
}