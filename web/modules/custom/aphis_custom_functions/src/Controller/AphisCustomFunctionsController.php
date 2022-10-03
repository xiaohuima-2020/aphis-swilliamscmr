<?php


namespace Drupal\aphis_custom_functions\Controller;

use Symfony\Component\HttpFoundation\Response;

class AphisCustomFunctionsController {

  public function aphis_custom_functions() {
    return new Response('Hello to Aphis Custom Functions');
  }

}