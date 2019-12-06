<?php

/**
 * @file
 * Contains my_module_view_field\my_module_view_field.views.inc..
 * Provide a custom views field data that isn't tied to any other module. */


/**
* Implements hook_views_data().
*/
function my_module_view_field_views_data() {

    $data['views']['table']['group'] = t('Custom Global');
    $data['views']['table']['join'] = [
      // #global is a special flag which allows a table to appear all the time.
      '#global' => [],
    ];



    $data['views']['my_module_views_field'] = [
        'group' => t('Content'),
        'title' => t('My module views field'),
        'help' => t('My awesome custom views field plugin.'),
        'field' => [
            'id' => 'my_module_views_field',
        ],
    ];

  $data['views']['decorated_user_name'] = [
    'group' => t('User'),
    'title' => t('Decorated User name'),
    'help' => t('Plugin render username in span'),
    'field' => [
      'id' => 'decorated_user_name',
    ],
  ];
    return $data;
}
