<?php

namespace Drupal\mytheme\Theme;


use Drupal\Core\Url;

/**
 * Class NodeThemeSuggestion
 *
 * Provides template suggestions for nodes.
 *
 * @package Drupal\heni_francis_bacon\Theme
 */
class NodeThemeSuggestion extends AbstractThemeSuggestion {

  const HENI_FRANCIS_BACON_CORE_PAGE_URL_BIBLIOGRAPHY = 'mytest/test';
  // Theme hook.
  const THEME_HOOK = 'node';

  /**
   * @var \Drupal\node\Entity\Node
   */
  private $node;


  /**
   * @var string
   */
  private $route;

  /**
   * {@inheritdoc}
   */
  public function execute() {

    if ($this->node = \Drupal::request()->attributes->get('node')) {
      $this->setSuggestions();
    }
  }

  /**
   * @return array
   */
  private function getNodeSuggestionsMapping() {
    return [
      self::HENI_FRANCIS_BACON_CORE_PAGE_URL_BIBLIOGRAPHY => '__bibliography',
    ];
  }

  private function setSuggestions() {
    $currentNode = \Drupal::routeMatch()->getParameter('node');

    if (!$currentNode || !is_object($currentNode)) {
      return;
    }
    $urlObject = $this->getNodeUrlObject($currentNode->id());
    $this->route = isset($urlObject) ? $urlObject->toString() : '';
    $this->setNodeFrontSuggestion();
    $this->setNodeSuggestion($this->getNodeSuggestionsMapping());
  }

  private function setNodeSuggestion($nodeSuggestionsMapping) {

    foreach ($nodeSuggestionsMapping as $key => $mapping) {

      if ($this->route !== '/' . $key) {
        continue;
      }

      $this->appendSuggestion($this->getHook() . '__' . $this->node->getType() . $mapping);
    }
  }

  private function setNodeFrontSuggestion() {

    if (!\Drupal::service('path.matcher')->isFrontPage()) {
      return;
    }
    $this->appendSuggestion($this->getHook() . '__' . $this->node->getType() . '__front');
  }

  /**
   * {@inheritdoc}
   */
  public function isApplicable() {
    return $this->getHook() === self::THEME_HOOK;
  }


  public function getNodeUrlObject($id) {
    return Url::fromRoute('entity.node.canonical', ['node' => $id]);
  }
}