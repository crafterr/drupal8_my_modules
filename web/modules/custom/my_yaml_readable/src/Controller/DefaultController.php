<?php

namespace Drupal\my_yaml_readable\Controller;

use Drupal\my_yaml_readable\Library\UserManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Yaml\Yaml;
use Drupal\Core\Controller\ControllerBase;

/**
 * Class DefaultController.
 */
class DefaultController extends ControllerBase {

  /**
   * @var \Drupal\my_yaml_readable\Library\UserManager
   */
  private $userManager;

  public function __construct(UserManager $userManager) {
    $this->userManager = $userManager;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('my_yaml_readable.user_manager')
    );
  }

  /**
   * Dsafads.
   *
   * @return string
   *   Return Hello string.
   */
  public function read() {
    $file_path = DRUPAL_ROOT.'/modules/custom/my_yaml_readable/config/my_yaml_readable.config.yml';
    if (file_exists($file_path)) {
      $file_contents = file_get_contents($file_path);
      $yaml = Yaml::parse($file_contents);
      dump($yaml); die();
    }

  }

  public function userManager() {
    dump($this->userManager->register("adam@onet.pl","fender"));
  }

}
