<?php

namespace Drupal\products\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\products\Entity\ProductInterface;

/**
 * Class ProductController.
 */
class ProductController extends ControllerBase {


  /**
   * Renderuje product entity
   * @param \Drupal\products\Entity\ProductInterface $product
   *
   * @return array
   */
  public function product(ProductInterface $product) {
   $builder = \Drupal::entityTypeManager()->getViewBuilder('product');
   return $builder->view($product,'full');
  }

  public function productList() {
    $listBuilder = \Drupal::entityTypeManager()->getListBuilder('product')->render();
    return $listBuilder;
  }

}
