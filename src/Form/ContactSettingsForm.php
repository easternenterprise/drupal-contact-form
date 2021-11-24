<?php

namespace Drupal\contact_form\Form;

/**
 * @file
 * Contains \Drupal\contact_form\Form\ContactSettingsForm.
 */

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Contact form.
 */
class ContactSettingsForm extends ConfigFormBase {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'contact_form.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'contact_form_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);
    // Contact form Configuration which list all the fields.
    $form['contact_fields'] = [
      '#type' => 'details',
      '#title' => $this->t('Contact form fields configuration.'),
    ];
    $contact_form = \Drupal::formBuilder()->getForm('Drupal\contact_form\Form\ContactForm');
    $fields = $this->getContactFormFields();
    foreach ($fields as $field) {
      $form['contact_fields'][$field] = [
        '#type' => 'checkbox',
        '#title' => $contact_form[$field]['#title']->render(),
        '#description' => $this->t('Check this checkobx to show field %field_name on contact form', ['%field_name' => $contact_form[$field]['#title']->render()]),
        '#default_value' => $config->get($field),
      ];
    }
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $fields = $this->getContactFormFields();
    $editable = $this->configFactory->getEditable(static::SETTINGS);
    foreach ($fields as $field) {
      $editable->set($field, $form_state->getValue($field));
    }
    $editable->save();
    parent::submitForm($form, $form_state);
  }

  /**
   * Get contact field list in array.
   */
  public function getContactFormFields() {
    $contact_form = \Drupal::formBuilder()->getForm('Drupal\contact_form\Form\ContactForm');
    $contact_form_fields = array_keys($contact_form);
    // Remove first element which is always attribute.
    array_shift($contact_form_fields);
    // First 4 items for the array are fields
    // This can be made dynamic to pull only fields
    // from array instead of sliceing it to 4.
    $fields = array_slice($contact_form_fields, 0, 4);
    return $fields;
  }

}
