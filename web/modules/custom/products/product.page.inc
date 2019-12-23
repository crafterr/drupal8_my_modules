<?php

/**
 * @file
 * Contains product.page.inc.
 *
 * Page callback for Product entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Product templates.
 *
 * Default template: product.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_product(array &$variables) {
  // Fetch Product Entity Object.
  $product = $variables['elements']['#product'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
