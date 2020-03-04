<?php


namespace Drupal\my_style_filter_to_ckeditor\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * @Filter(
 *   id = "filter_celebrate",
 *   title = @Translation("Celebrate Filter"),
 *   description = @Translation("Help this text format celebrate good times!"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */

class FilterCelebrate extends FilterBase {
  public function process($text, $langcode) {
    $replace = '<span class="celebrate-filter">' . $this->t('Good Times!') . '</span>';
    $new_text = str_replace('adam ma kota', $replace, $text);
    return new FilterProcessResult($new_text);
  }
}
