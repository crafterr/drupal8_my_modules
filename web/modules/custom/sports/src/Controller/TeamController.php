<?php

namespace Drupal\sports\Controller;

use Drupal;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\OpenModalDialogCommand;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Core\Form\FormBuilder;
use Drupal\sports\Form\TeamTableForm;
use Drupal\Core\Database\Connection;
use Drupal\file\Entity\File;
/**
 * Class TeamController.
 */
class TeamController extends ControllerBase {

  /**
  * The Form builder.
  *
  * @var \Drupal\Core\Form\FormBuilder
  */
  protected $formBuilder;
  /**
   * Databse Connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $db;
  /**
   * Request.
   *
   * @var Symfony\Component\HttpFoundation\RequestStack
   */
  protected $request;
  /**
   * Constructs the EmployeeController.
   *
   * @param \Drupal\Core\Form\FormBuilder $form_builder
   *   The Form builder.
   * @param \Drupal\Core\Database\Connection $con
   *   The database connection.
   * @param \Symfony\Component\HttpFoundation\RequestStack $request
   *   Request stack.
   */
  public function __construct(FormBuilder $form_builder,
                              Connection $con,
                              RequestStack $request) {
    $this->formBuilder = $form_builder;
    $this->db = $con;
    $this->request = $request;
  }
  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('form_builder'),
      $container->get('database'),
      $container->get('request_stack')
    );
  }


  public function listTeams() {
    $content = [];

    $team_table_form_instance = $this->formBuilder->getForm('Drupal\sports\Form\TeamTableForm');
    $content['table'] = $team_table_form_instance;
    $content['pager'] = [
      '#type' => 'pager',
    ];
    $content['#attached'] = ['library' => ['core/drupal.dialog.ajax']];
    return $content;
  }

  /**
   * To view an team details.
   */
  public function viewTeam($team = NULL) {

    if ($team == 'invalid') {
      $this->messenger()->addMessage($this->t('Invalid Team record'), 'error');
      return new RedirectResponse(Drupal::url('sports.teams.list'));
    }
    $rows = [
      [
        ['data' => 'Id', 'header' => TRUE],
        $team->id,
      ],
      [
        ['data' => 'Name', 'header' => TRUE],
        $team->name,
      ],
      [
        ['data' => 'Description', 'header' => TRUE],
        $team->description,
      ],

    ];



    $content['details'] = [
      '#type' => 'table',
      '#rows' => $rows,
      '#attributes' => ['class' => ['team-detail']],
    ];
    $content['edit'] = [
      '#type' => 'link',
      '#title' => 'Edit',
      '#attributes' => ['class' => ['button button--primary']],
      '#url' => Url::fromRoute('sports.teams.edit', ['team' => $team->id]),
    ];
    $content['delete'] = [
      '#type' => 'link',
      '#title' => 'Delete',
      '#attributes' => ['class' => ['button']],
      '#url' => Url::fromRoute('sports.teams.delete', ['team' => $team->id]),
    ];
    $content['return'] = [
      '#type' => 'link',
      '#title' => 'Return',
      '#attributes' => ['class' => ['button']],
      '#url' => Url::fromRoute('sports.teams.list'),
    ];
    return $content;

  }

  public function getQuery(Request $request) {

    $param = $request->query->get('name');


    $result = $this->db->select('teams', 't')
      ->fields('t')
      ->condition('id', $param, '=')
      ->execute()
      ->fetchObject();
    dump($result); die();
  }

}
