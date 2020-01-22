<?php


namespace Drupal\sports;


class QueriesStorage {

  public function simpleQuery() {

    $database = \Drupal::database();
    $result = $database->query("SELECT * FROM {players} WHERE id = :id", [':id' => 1]);

    $records = $result->fetchAll();
  }

  public function queryBuilder() {
    $database = \Drupal::database();
    $result = $database->select('players', 'p')
      ->fields('p')
      ->condition('id', 1)
      ->execute();

    $records = $result->fetchAll();
  }

  public function moreComplexQuery() {
    $database = \Drupal::database();
    $result = $database->query("SELECT * FROM {players} p JOIN {teams} t ON t.id = p.team_id WHERE p.id = :id", [':id' => 1]);
  }

  public function moreComplexQueryByQueryBuilder() {
    $database = \Drupal::database();
    $query = $database->select('players', 'p');
    $query->join('teams', 't');
    $query->addField('p', 'name', 'player_name');
    $query->addField('t', 'name', 'team_name');
    $query->addField('t', 'description', 'team_description');
    $result = $query
      ->fields('p', ['id', 'data'])
      ->condition('p.id', 1)
      ->execute();

    $records = $result->fetchAll();
  }

  public function rangeQuery() {
    $database = \Drupal::database();
    $result = $database->queryRange("SELECT * FROM {players}", 0, 10);

    //or using query builder
    $result = $database->select('players', 'p')
      ->fields('p')
      ->range(0, 10)
      ->execute();
  }

  /**
   * pagers
   */
  public function playersWithPager() {
    $limit = 5; // The number of items per page.
    $database = \Drupal::database();
    $query = $database->select('players', 'p')
      ->fields('p')
      ->extend('\Drupal\Core\Database\Query\PagerSelectExtender')
      ->limit($limit);
    $result = $query->execute()->fetchAll();
    $header = [$this->t('Name')];
    $rows = [];

    foreach ($result as $row) {
      $rows[] = [
        $row->name
      ];
    }

    $build = [];
    $build[] = [
      '#theme' => 'table',
      '#header' => $header,
      '#rows' => $rows,
    ];

    return $build;
  }

  public function insert() {
    $database = \Drupal::database();
    $database->insert('players');
    $fields = ['name' => 'Diego M', 'data' => serialize(['known for' => 'Hand of God'])];
    $id = $database->insert('players')
      ->fields($fields)
      ->execute();

    /**
     * we can also run
     *
     */
    $values = [
      ['name' => 'Novak D.', 'data' => serialize(['sport' => 'tennis'])],
      ['name' => 'Micheal P.', 'data' => serialize(['sport' => 'swimming'])]
    ];
    $fields = ['name', 'data'];
    $query =  $database->insert('players')
      ->fields($fields);
    foreach ($values as $value) {
      $query->values($value);
    }
    $result = $query->execute();
  }


  public function update() {
    $database = \Drupal::database();
    $result = $database->update('players')
      ->fields(['data' => serialize([
        'sport' => 'swimming',
        'feature' => 'This guy can swim'
      ])])
      ->condition('name', 'Micheal P.')
      ->execute();
  }


  public function delete() {
    $database = \Drupal::database();
    $result = $database->delete('players')
      ->condition('name', 'Micheal P.')
      ->execute();
  }

  public function transaction() {
    $database = \Drupal::database();
    $transaction = $database->startTransaction();
    try {
      $database->update('players')
        ->fields(['data' => serialize(['sport' => 'tennis', 'feature' => 'This guy can play tennis'])])
        ->condition('name', 'Novak D.')
        ->execute();
    }
    catch (\Exception $e) {
      $transaction->rollback();
      watchdog_exception('my_type', $e);
    }
  }
}