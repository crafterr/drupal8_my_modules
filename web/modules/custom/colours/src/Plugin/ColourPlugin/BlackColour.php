<?php
namespace Drupal\colours\Plugin\ColourPlugin;

use Drupal\colours\Annotation\ColourPlugin;
use Drupal\colours\Plugin\ColourPluginBase;

/**
 * Class BlackColour
 *
 * @ColourPlugin(
 *   id = "black",
 *   label = @Translation("Black Colour Plugin"),
 *   description = @Translation("Renderuje kolor czarny")
 * )
 */
class BlackColour extends ColourPluginBase {

}