INTRODUCTION
------------
Module provides View field to views and Pseudo field to display user online status


This module provide a status based on strategy pattern and default display three different strategy: 
if user is online then display: online status
if user is offline then display: offline status
if user is only absent then display: absent status

You can easily add new own strategy created a new php class but I am going to move that functionality to admin ui.

All functionality is based on oop pattern so you can easily use that code somewhere in your module using:

REQUIREMENTS
------------
This module requires the following modules:
 * Views (https://www.drupal.org/project/views)
 
INSTALLATION
------------
 
* Install as you would normally install a contributed Drupal module. Visit
https://www.drupal.org/docs/8/extending-drupal-8/installing-drupal-8-modules
for further information

CONFIGURATION
-------------

The module has no menu or modifiable settings. There is no configuration. When
enabled pseudo field and view field is available to use.
After install you can clear caches.
You can use that module and put a status to your module.
For example if you can put a status message to the user.html.twig 

```
<?php
function bootstrap_subtheme_front_office_old_preprocess_user(&$variables) {
  $user = $variables['user'];
  $user_status_service = \Drupal::service('user_status_online.service');
  $status = $user_status_service->getStatus($user);
  $variables['status'] = t($status);
}
?>
```
and in your template user.html.twig you can get a status variable:
```
<div>
{{ status }}
</div>
```

MAINTAINERS
-----------
Current maintainers:
 * Adam Pietras (crafter) - https://www.drupal.org/u/crafter




