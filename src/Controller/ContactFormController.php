<?php

namespace Drupal\contact_form\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Provides route responses for the contact from.
 */
class ContactFormController extends ControllerBase {

  /**
   * Returns a success page after form submission.
   *
   * @return array
   *   Success submission page.
   */
  public function successPage() {
    $element = [
      '#markup' => 'Thanks for contacting us. We will review your request and get back to you.',
    ];
    return $element;
  }

  /**
   * Returns a error page after form submission.
   *
   * @return array
   *   Error submission page.
   */
  public function errorPage() {
    $element = [
      '#markup' => 'Error while submitting the form. Please try again.',
    ];
    return $element;
  }

  /**
   * Returns all contacts in JSON format.
   *
   * @return object
   *   Return json containing all contacts.
   */
  public function getDetailsInJson() {
    $db = \Drupal::database();
    $query = $db->select('contacts', 'n');
    $query->fields('n');
    $response = $query->execute()->fetchAll();
    return new JsonResponse($response);
  }

}
