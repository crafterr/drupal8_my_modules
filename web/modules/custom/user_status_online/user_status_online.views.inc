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
function user_status_online_views_data() {

  $data['views']['table']['group'] = t('Custom Global');
  $data['views']['table']['join'] = [
    // #global is a special flag which allows a table to appear all the time.
    '#global' => [],
  ];

  $data['views']['show_online_status'] = [
      'group' => t('User'),
      'title' => t("Show the user's online status"),
      'help' => t("Show the user's online status"),
      'field' => [
          'id' => 'show_online_status',
      ],
  ];

  return $data;
}
