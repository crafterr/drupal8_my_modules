<?php

/**
 * Implements hook_views_data().
 */
  function text_css_field_views_data() {
  $data['views']['text_css_header'] = array(
    'title' => t('Unfiltered Text/CSS area field'),
    'help' => t('Add unrestricted, custom text or CSS markup.'),
    'area' => array(
      'id' => 'text_css_header',
    ),
  );
  $data['views']['text_css_content'] = [   // global group
    'field' => [
      'title' => t('Unfiltered Text/CSS content field'),
      'help' => t('Unfiltered text or CSS markup.'),
      'id' => 'text_css_content',
      'click sortable' => FALSE,
    ],
  ];
  return $data;
}
