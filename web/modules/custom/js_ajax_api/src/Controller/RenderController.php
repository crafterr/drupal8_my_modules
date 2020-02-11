<?php

namespace Drupal\js_ajax_api\Controller;

use Drupal\Core\Ajax\AlertCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RemoveCommand;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class RenderController.
 */
class RenderController extends ControllerBase {


  public function render() {
    $time = new \DateTime();
    $render['#theme'] = 'js_ajax_api';
    $render['#target'] = $this->t('world');
    $render['#attached'] = [
      'library' => [
        'js_ajax_api/clock'
      ]
    ];
    $render['#attached']['drupalSettings']['js_ajax_api']['js_ajax_api_clock']['render'] = TRUE;
    return $render;
  }

  public function showMeLink() {
    $build[] = [
      '#theme' => 'container',
      '#children' => [
        '#markup' => 'this is what I think',
      ]
    ];

    $url = Url::fromRoute('js_ajax_api.hide_block');
    $url->setOption('attributes', ['class' => 'use-ajax']);
    $build[] = [
      '#type' => 'link',
      '#url' => $url,
      '#title' => $this->t('Remove'),
    ];

    return $build;
  }

  /**
   * Route callback for hiding the Salutation block.
   * Only works for Ajax calls.
   *
   * @param \Symfony\Component\HttpFoundation\Request $request
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   */
  public function hideBlock(Request $request) {
    if (!$request->isXmlHttpRequest()) {
      throw new NotFoundHttpException();
    }

    $response = new AjaxResponse();
    $command = new RemoveCommand('.block-hello-world');
    $command2 = new AlertCommand('Hello my '.__CLASS__);
    $response->addCommand($command);
    $response->addCommand($command2);
    return $response;
  }
}
