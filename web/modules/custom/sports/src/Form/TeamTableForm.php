<?php

namespace Drupal\sports\Form;

use Drupal;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Database\Connection;
use Drupal\Component\Utility\Html;
use Drupal\sports\TeamStorage;
use Drupal\Core\Form\FormBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TeamTableForm extends FormBase {

  /**
   * Databse Connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $db;


  /**
   * Constructs the EmployeeTableForm.
   *
   * @param \Drupal\Core\Database\Connection $con
   *   The database connection.
   */
  public function __construct(Connection $con) {
    $this->db = $con;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   *
   * @return \Drupal\Core\Form\FormBase|\Drupal\sports\Form\TeamTableForm
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'team_table_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {

    // Table header.
    $header = [
      ['data' => t('ID'), 'field' => 't.id'],

      ['data' => t('Name'), 'field' => 't.name'],
      ['data' => t('Description'), 'field' => 't.description'],
      ['data' => t('Created at'),'field' => 't.created'],
      ['data' => t('Status')],
      'actions' => 'Operations',
    ];

    $query = $this->db->select('teams', 't')
      ->fields('t')
      ->extend('Drupal\Core\Database\Query\TableSortExtender')
      ->extend('Drupal\Core\Database\Query\PagerSelectExtender');
    $query->orderByHeader($header);
    $config = Drupal::config('sports.settings');
    $limit = ($config->get('page_limit')) ? $config->get('page_limit_for_team') : 10;
    $query->limit($limit);

    $results = $query->execute();
    $rows = [];
    foreach ($results as $row) {

      $view_url = Url::fromRoute('sports.teams.view',
        ['team' => $row->id]);

      $player_url = Url::fromRoute('sports.players.list',
        ['team' => $row->id]);

      $drop_button = [
        '#type' => 'dropbutton',
        '#links' => [
          'players' => [
            'title' => t('Players'),
            'url' => $player_url,
          ],
          'view' => [
            'title' => t('View'),
            'url' => $view_url,
          ],
          'edit' => [
            'title' => t('Edit'),
            'url' => Url::fromRoute('sports.teams.edit', ['team' => $row->id]),
          ],
          'delete' => [
            'title' => t('Delete'),
            'url' => Url::fromRoute('sports.teams.delete', ['team' => $row->id]),
          ],

        ],
      ];

      $rows[$row->id] = [
        [sprintf("%04s", $row->id)],
        [$row->name],
        [$row->description],
        [(new \DateTime())->setTimestamp($row->created)->format('Y-m-d H:i:s')],



        [($row->status) ? 'Active' : 'Blocked'],
        'actions' => [
          'data' => $drop_button,
        ],
      ];

    }
      $form['action'] = [
        '#type' => 'select',
        '#title' => t('Action'),
        '#options' => [
          'delete' => 'Delete Selected',
          'activate' => 'Activate Selected',
          'block' => 'Block Selected',
        ],
      ];
      $form['submit'] = [
        '#type' => 'submit',
        '#value' => 'Apply to selected items',
        '#prefix' => '<div class="form-actions js-form-wrapper form-wrapper">',
        '#suffix' => '</div>',
      ];
      $form['table'] = [
        '#type' => 'tableselect',
        '#header' => $header,
        '#rows' => $rows,
        '#options' => $rows,
        '#attributes' => [
          'id' => 'team-contact-table',
        ],
      ];
      return $form;

  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    // TODO: Implement validateForm() method.
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $selected_ids = array_filter($form_state->getValue('table'));
    $selected_ids = array_map(function ($val) {
      $record = TeamStorage::load($val);
      return $record->name;
    }, $selected_ids);
    if (!array_filter($selected_ids)) {
      drupal_set_message(t('No team record to selected'), 'error');
      $form_state->setRedirect('sports.teams.list');
      return;
    }
    else {
      $request = Drupal::request();
      $session = $request->getSession();
      $session->set('teams', [
        'selected_items' => $selected_ids,
      ]);
      $form_state->setRedirect('sports.teams.action', ['action' => $form_state->getValue('action')]);
      return;
    }
  }

}