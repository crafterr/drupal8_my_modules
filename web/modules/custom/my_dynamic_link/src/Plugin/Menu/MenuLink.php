<?php

namespace Drupal\my_dynamic_link\Plugin\Menu;
use Drupal\Core\Menu\MenuLinkDefault;
use Symfony\Component\DependencyInjection\ContainerInterface;

use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
class MenuLink extends MenuLinkDefault implements ContainerFactoryPluginInterface
{
}
