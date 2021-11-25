<?php

namespace Drupal\contact_form\Form;

/**
 * @file
 * Contains \Drupal\contact_form\Form\ContactForm.
 */

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Drupal\Core\Database\Database;
use GuzzleHttp\Exception\GuzzleException;

/**
 * Contact form.
 */
class ContactForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'contact_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Check if field is enable then only show it else select type as hidden.
    $config = \Drupal::config('contact_form.settings');
    $form['first_name'] = [
      '#type' => $config->get('first_name') ? 'textfield' : 'hidden',
      '#title' => $this->t('First Name'),
      '#pattern' => '[A-Za-z]+',
    ];
    $form['last_name'] = [
      '#type' => $config->get('last_name') ? 'textfield' : 'hidden',
      '#title' => $this->t('Last Name'),
      '#pattern' => '[A-Za-z]+',
    ];
    $form['email_address'] = [
      '#type' => $config->get('email_address') ? 'email' : 'hidden',
      '#title' => $this->t('Email'),
      '#pattern' => '[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$',
    ];
    $form['message'] = [
      '#type' => $config->get('message') ? 'textarea' : 'hidden',
      '#title' => $this->t('Message'),
      '#size' => 6,
    ];

    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
      '#button_type' => 'primary',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $conn = Database::getConnection();
    try {
      // Save data in contacts table.
      $conn->insert('contacts')->fields(
            [
              'first_name' => $form_state->getValue('first_name'),
              'last_name' => $form_state->getValue('last_name'),
              'email' => $form_state->getValue('email_address'),
              'message' => $form_state->getValue('message'),
            ]
        )->execute();
      $url = Url::fromRoute('contact_form.thankyou');
    }
    catch (GuzzleException $e) {
      // Redirect to error page.
      \Drupal::logger('contact_form')->error('Error in submission.');
      $url = Url::fromRoute('contact_form.errorpage');
    }
    $form_state->setRedirectUrl($url);
  }

}
