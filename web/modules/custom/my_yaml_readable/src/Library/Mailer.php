<?php


namespace Drupal\my_yaml_readable\Library;


class Mailer {
  public function mail($recipient, $content)
  {
    return $recipient.' '.$content;
  }
}