<?php

namespace Drupal\mytheme\Theme;

/**
 * Class PageThemeSuggestion
 *
 * Provides template suggestions for pages.
 *
 * @package Drupal\heni_francis_bacon\Theme
 */
class PageThemeSuggestion extends AbstractThemeSuggestion {

  // Theme hook.
  const THEME_HOOK = 'page';

  /**
   * @var \Drupal\node\Entity\Node
   */
  private $node;

  /**
   * @var AppManager
   */
  protected $appManager;

  /**
   * {@inheritdoc}
   */
  public function execute() {
    if ($this->node = \Drupal::request()->attributes->get('node')) {
      if (is_object($this->node)) {
        $this->setNodeTypeSuggestion();
      }

      $this->setNodeTypeAndRouteTitleSuggestion();
    }
  }

  private function setNodeTypeSuggestion() {
    $this->appendSuggestion($this->getHook() . '__type__' . $this->node->getType());
  }

  private function setNodeTypeAndRouteTitleSuggestion() {

    $route = \Drupal::routeMatch()->getParameter('node');
    if (!$route) {
      return;
    }

    $title = str_replace("_", "-", strtolower($route->getTitle()));
    $this->appendSuggestion($this->getHook() . '__type__' . $this->node->getType() . '__' . $title);
  }

  /**
   * {@inheritdoc}
   */
  public function isApplicable() {
    return $this->getHook() === self::THEME_HOOK;
  }

}