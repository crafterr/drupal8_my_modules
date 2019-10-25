<?php
/**
 * @file
 *  Abstract template suggestion.
 */

namespace Drupal\mytheme\Theme;


/**
 * Class AbstractThemeSuggestion
 * @package Drupal\cw_tool\Theme
 *
 * Responsibility is to handle altering theme suggestions.
 */
abstract class AbstractThemeSuggestion {

  /**
   * @var string[]
   */
  private $suggestions;

  /**
   * @var array
   */
  private $vars;

  /**
   * @var string
   */
  private $hook;

  /**
   * @param string[] $suggestions
   * @param array $vars
   * @param string $hook
   */
  private function __construct(array &$suggestions, array $vars, $hook) {
    $this->suggestions = &$suggestions;
    $this->vars = $vars;
    $this->hook = $hook;
    if ($this->isApplicable()) {
      $this->execute();
    }
  }

  /**
   * @param array $suggestions
   * @param array $vars
   * @param string $hook
   * @return static
   */
  public static function suggest(array &$suggestions, array $vars, $hook) {
    return new static($suggestions, $vars, $hook);
  }

  /**
   * Execute the suggestion alter behaviour.
   */
  abstract public function execute();

  /**
   * @return bool
   */
  abstract public function isApplicable();

  /**
   * Append a suggestion.
   *
   * @param string $suggestion
   */
  protected function appendSuggestion($suggestion) {
    $this->suggestions[] = $suggestion;
  }



  /**
   * @return string
   */
  public function getHook() {
    return $this->hook;
  }
}
