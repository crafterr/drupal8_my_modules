<?php

namespace Drupal\my_style_filter_to_ckeditor\Plugin\Filter;

use Drupal\Component\Utility\Html;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * Makes the tables in the content show up using Bootstrap styling.
 *
 * @Filter(
 *   id = "table_style_filter",
 *   title = @Translation("Table styles"),
 *   description = @Translation("Adds the necessary markup to tables to render
 *   them via Bootstrap styling."),
 *   type = \Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 * )
 */
class TableStyleFilter extends FilterBase {

  public function process($text, $langcode) {
    $dom = Html::load($text);


    $elements = $dom->getElementsByTagName('table');
    if ($elements->length === 0) {
      return new FilterProcessResult(Html::serialize($dom));
    }

    /** @var \DOMElement $element */
    foreach ($elements as $element) {
      $classes = explode(' ', $element->getAttribute('class'));
      $bootstrap_classes = [
        'table',
        'table-sm',
        'table-striped',
        'table-hover'
      ];

      foreach ($bootstrap_classes as $class) {
        $classes[] = $class;
      }

      $new_element = clone $element;
      $new_element->setAttribute('class', join(' ', array_unique($classes)));

      $wrapper = $dom->createElement('div');
      $wrapper->setAttribute('class', 'table-responsive');
      $wrapper->appendChild($new_element);
      $element->parentNode->replaceChild($wrapper, $element);
    }

    return new FilterProcessResult(Html::serialize($dom));

  }

}
