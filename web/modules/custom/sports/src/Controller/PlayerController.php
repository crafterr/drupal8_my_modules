<?php

namespace Drupal\sports\Controller;

use Drupal;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Drupal\Core\Form\FormBuilder;
use Drupal\Core\Database\Connection;
/**
 * Class PlayerController.
 */
class PlayerController extends ControllerBase {

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

  public function getTitle($team) {
    return  'Teams Dashboard for '.$team->name;
  }


  public function listPlayers($team = null) {
    $this->team = $team;
    $content = [];
    $player_table_form_instance = $this->formBuilder->getForm('Drupal\sports\Form\PlayerTableForm', $team);

    $content['table'] = $player_table_form_instance;
    $content['pager'] = [
      '#type' => 'pager',
    ];
    $content['#attached'] = ['library' => ['core/drupal.dialog.ajax']];
    return $content;
  }

  /**
   * To view an team details.
   */
  public function viewPlayer($player = NULL) {

    if ($player == 'invalid') {
      $this->messenger()->addMessage($this->t('Invalid Team record'), 'error');
      return new RedirectResponse(Drupal::url('sports.players.list'));
    }
    $rows = [
      [
        ['data' => 'Id', 'header' => TRUE],
        $player->id,
      ],
      [
        ['data' => 'Name', 'header' => TRUE],
        $player->name,
      ],
     /* [
        ['data' => 'Description', 'header' => TRUE],
        $team->description,
      ],*/

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
      '#url' => Url::fromRoute('sports.players.edit', ['player' => $player->id]),
    ];
    $content['delete'] = [
      '#type' => 'link',
      '#title' => 'Delete',
      '#attributes' => ['class' => ['button']],
      '#url' => Url::fromRoute('sports.players.delete', ['player' => $player->id]),
    ];
    $content['return'] = [
      '#type' => 'link',
      '#title' => 'Return',
      '#attributes' => ['class' => ['button']],
      '#url' => Url::fromRoute('sports.players.list'),
    ];
    return $content;

  }

}
