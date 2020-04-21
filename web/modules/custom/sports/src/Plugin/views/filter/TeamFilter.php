<?php
namespace Drupal\sports\Plugin\views\filter;

use Drupal\Core\Database\Connection;
use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\InOperator;
use Drupal\views\ViewExecutable;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Filters by given list of node title options.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("team_filter")
 */
class TeamFilter extends InOperator{

  /**
   * @var Drupal\Core\Database\Connection;
   */
  private $database;

  /**
   * TeamFilter constructor.
   *
   * @param array $configuration
   * @param $plugin_id
   * @param $plugin_definition
   * @param \Drupal\Core\Database\Database $database
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, Connection $database) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->database = $database;
  }

  /**
   * @inheritDoc
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database')
      );

  }

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->valueTitle = t('Teams');
    $this->definition['options callback'] = array($this, 'getTeams');
  }

  /**
   * Generates the list of teams that can be used in the filter.
   */
  public function getTeams() {
    $result = $this->database->query("SELECT * FROM {teams}")->fetchAll();

    if (!$result) {
      return [];
    }
    $tmp = [];
    $count = count($result);
    $i = 0;
    while($i<$count) {
      $tmp[$result[$i]->name] = $result[$i]->name;
      $i++;
    }
    return $tmp;
  }
}