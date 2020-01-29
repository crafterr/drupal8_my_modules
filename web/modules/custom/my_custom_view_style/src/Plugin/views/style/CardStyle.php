<?php
namespace Drupal\my_custom_view_style\Plugin\views\style;

use Drupal\views\Plugin\views\style\StylePluginBase;

/**
 * Style plugin for the cards view.
 *
 * @ViewsStyle(
 *   id = "cards_style",
 *   title = @Translation("Cards Style"),
 *   help = @Translation("Displays content in cards."),
 *   theme = "my_custom_view_style",
 *   display_types = {"normal"}
 * )
 */
class CardStyle extends StylePluginBase{
  /**
   * Specifies if the plugin uses row plugins.
   *
   * @var bool
   */
  protected $usesRowPlugin = TRUE;
}
