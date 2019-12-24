<?php

/**
 * @file
 * Contains my_module_view_field\my_module_view_field.views.inc..
 * Provide a custom views field data that isn't tied to any other module.
 *
 */


/**
* Implements hook_views_data().
*/
function view_tutorial_fruit_views_data() {

  $views_data = [];
  $views_data['fruit']['table'] = [
    'group' => t('Fruit.'),
    // This is a base table, so we declare it to Views.
    'base' => [
      // The primary key of this table. Views utilizes it for various internal
      // tasks. In fact, Views module requires all base tables to have a single-
      // column primary key.
      'field' => 'id',
      'title' => t('Fruit Table.'),
      'help' => t('A little more verbose description of this table, also visible in the views UI.'),
    ]
  ];

  $views_data['fruit_opinions']['table'] = [
    'title' => t('Opinions fruit'),
    'group' => t('We would probably want to place this table into the same group as its base table for consistency in the UI.'),
    // Watch out! This is not a base table, so we use a different key and
    // explain to Views how this table can be JOINed to our base table of
    // 'fruit'.
    'join' => [
      // We are explaining Views how 'fruit_opinions' can be JOINed to 'fruit'.
      // By the way, you do not necessarily have to JOIN onto a base table. You
      // may as well JOIN in chain a few non-base tables. Although for a table
      // to become visible in Views UI, it must be connected one way or another
      // to a base table on which the view is being built.
      'fruit' => [
        // Column from 'fruit' table which will participate in the JOIN clause.
        'left_field' => 'id',
        // Column from 'fruit_opinions' table that will participate in the JOIN
        // clause.
        'field' => 'fruit_id',
      ]
    ]
  ];

  // As we describe the Views field 'label' that belongs to 'fruit' table, we
  // nest it respectively within $views_data array.
  $views_data['fruit']['label'] = [
    // Human friendly name of your Views field.
    'title' => t('Fruit label'),
    // A little more verbose description of your Views field.
    'help' => t('Name of the fruit.'),
    // Apart from field we could also describe sorting, filtering on this
    // column, but for now let's just stick to the 'field' part.
    'field' => [
      // In the 'id' key we place the name of Views field plugin that is
      // responsible for operating our 'label' column. The id "standard"
      // corresponds to \Drupal\views\Plugin\views\field\Standard class. It is
      // an extremely simplistic straightforward field plugin that appends the
      // column into SELECT query (see ::query() method) and then displays the
      // fetched column as field output (see ::render() method).
      'id' => 'standard',
    ],
    // So let's tell Views sorting by this column is actually possible.
    'sort' => [
      // The id "standard" corresponds to
      // \Drupal\views\Plugin\views\sort\Standard class. It is a dead straight
      // forward implementation of sorting that blindly sorts like:
      // "ORDER BY [column name] [sort direction, i.e. ASC/DESC]". This is just
      // good enough given we want to sort by fruit label alphabetically.
      'id' => 'standard',
    ],
    // By declaring 'filter' key we communicate to Views that this column can be
    // filtered on.
    'filter' => [
      // The id "string" corresponds to
      // \Drupal\views\Plugin\views\filter\StringFilter which according to its
      // documentation is a reasonable filter for columns that contain strings.
      'id' => 'string',
    ],
  ];

  $views_data['fruit']['weight'] = [
    'title' => t('Fruit weight'),
    'help' => t('Weight of the fruit casted to kilograms.'),
    'field' => [
      // Note that now in the 'id' key we are using ID of the Views field plugin
      // we have just coded.
      'id' => 'fruit_weight',
      // As our custom 'fruit_weight' plugin requires additional definition,
      // let's properly supply to it name of the column that holds units of
      // weight.
      'additional fields' => [
        'units' => 'weight_unit',
        'label' => 'label'
      ],
    ],
    'sort' => [
      // Observe that we tell Views to use our custom sort handler for sorting
      // by this column.
      'id' => 'fruit_weight',
      // As our sort handler expects 2 additional definition items, let us
      // provide them correspondingly.
      'unit_column' => 'weight_unit',
      'lb_to_kg' => 0.4535924,
    ],
  ];

  $views_data['fruit']['custom_field'] = [
    'title' => t('Fruit Custom Field'),
    'help' => t('Weight Something else.'),
    'field' => [
      'id' => 'fruit_custom_field',
    ],
  ];



  return $views_data;
}
