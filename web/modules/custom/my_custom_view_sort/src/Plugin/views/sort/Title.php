<?php
namespace Drupal\my_custom_view_sort\Plugin\views\sort;

use Drupal\views\Plugin\views\sort\SortPluginBase;

/**
 * Basic sort handler for Events.
 *
 * @ViewsSort("title")
 */
class Title extends SortPluginBase
{
  public function query()
  {
 // dump($this->view->exposed_raw_input['sort_order']);
    $this->ensureMyTable();
    $this->query->addOrderBy($this->tableAlias, $this->realField, $this->options['order']);
  }
}
