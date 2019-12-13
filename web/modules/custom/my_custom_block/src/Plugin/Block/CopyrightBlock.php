<?php

namespace Drupal\my_custom_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'CopyrightBlock' block.
 *
 * @Block(
 *  id = "copyright_block",
 *  admin_label = @Translation("Copyright block"),
 * )
 */
class CopyrightBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $date = new \DateTime();
    $build = [
      '#theme' => 'copyright_block',
      '#attributes' => [
        'class' => ['copyright'],
        'id' => 'copyright-block',
      ],
      '#date' => $date,
      '#cache' => [
        'max-age' => 0
      ],
    ];


    return $build;
  }

}
