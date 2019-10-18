<?php
/**
 * Created by PhpStorm.
 * User: adampietras
 * Date: 17/08/2019
 * Time: 19:45
 */

namespace Drupal\sandwich\Element;
use Drupal\Core\Render\Element\RenderElement;
use Drupal\Core\StringTranslation\StringTranslationTrait;

/**
 * Provides an example element.
 *
 * @RenderElement("sandwich")
 */
class Sandwich extends RenderElement {
  use StringTranslationTrait;
  /**
   * @return array
   */
  public function getInfo() {
    $class = get_class($this);
    return [
      '#pre_render' => [
        [$class, 'preRenderSandwich'],
      ],
      '#theme' => 'sandwich'
    ];
  }

  public static function preRenderSandwich($element) {

    $element['#bread'] = 'hahaha';
    return $element;
  }

}