<?php

namespace Drupal\aphis_custom_functions\Controller;

use Symfony\Component\HttpFoundation\Response;

/**
 * Aphis Custom Functions.
 *
 * @category Class
 * @package Aphis
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link http://www.cmrignite.com/
 */
class AphisCustomFunctionsController {

  /**
   * Returns a response.
   */
  public function aphisCustomFunctions() {
    return new Response('Hello to Aphis Custom Functions');
  }

}
