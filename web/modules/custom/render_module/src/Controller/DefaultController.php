<?php

namespace Drupal\render_module\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  public function hello($name) {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('Implement method: hello with parameter(s): %name',['%name'=>'adam']),
    ];
  }

  public function table() {
    return [
      '#type' => 'table',
      '#header' => ['id','name'],
      '#rows' => [
        [1,'adam']
        ],
      '#attributes' => array('class'=>array('my-table')),
    ];
  }

  public function urlType() {
    return [
      '#type' => 'url',
      '#title' => $this->t('Home Page'),
      '#size' => 30,
      '#pattern' => '*.example.com',
    ];
  }

  public function itemList() {
    $url1 = \Drupal\Core\Url::fromRoute('render_module.default_controller_table');
    $url2 = \Drupal\Core\Url::fromRoute('render_module.default_controller_url');
    return [
      '#theme' => 'item_list',
      '#list_type' => 'ul',
      '#wrapper_attributes' => [
        'class' => [
          'wrapper',
        ],
      ],
      '#attributes' => [
        'class' => [
          'wrapper__links',
        ],
      ],
      '#items' => [
        [
          '#markup' => \Drupal::l(t('Url 1'), $url1),
          '#wrapper_attributes' => [
            'class' => [
              'wrapper__links__link',
            ],
          ],
        ],
        [
          '#markup' => \Drupal::l(t('Url 2'), $url2),
          '#wrapper_attributes' => [
            'class' => [
              'wrapper__links__link',
            ],
          ],
        ],
      ],
    ];
  }

  public function itemListP() {
    return [
      '#theme' => 'item_list',
      '#wrapper_attributes' => [
        'class' => [
          'wrapper',
        ],
      ],
      '#attributes' => [
        'class' => [
          'wrapper__links',
        ],
      ],
      '#items' => [
        [
          '#markup' => $this->t('adam ma kota kot ma adama')
        ],
        [
          '#markup' => $this->t('adam ma kota kot ma adama2')
        ],

      ],
    ];
  }

  public function timetheme() {

    return [
      '#theme' => 'time',
      '#timestamp' => (new \DateTime())->getTimestamp(),
      '#text' => 'czas'
    ];

  }

}
