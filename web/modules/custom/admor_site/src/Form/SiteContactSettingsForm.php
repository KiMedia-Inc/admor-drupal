<?php

declare(strict_types=1);

namespace Drupal\admor_site\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Contact settings form for Admor site chrome.
 */
final class SiteContactSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames(): array {
    return ['admor_site.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'admor_site_contact_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $config = $this->config('admor_site.settings');

    $form['phone'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Phone'),
      '#default_value' => $config->get('phone'),
      '#required' => TRUE,
    ];

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
      '#default_value' => $config->get('email'),
      '#required' => TRUE,
    ];

    $form['hours'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Hours'),
      '#default_value' => $config->get('hours'),
      '#required' => TRUE,
    ];

    $form['location'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Location'),
      '#default_value' => $config->get('location'),
      '#required' => TRUE,
    ];

    $form['topbar_note'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Topbar note'),
      '#default_value' => $config->get('topbar_note'),
    ];

    $form['footer_summary'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Footer summary'),
      '#default_value' => $config->get('footer_summary'),
      '#rows' => 4,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $this->configFactory()->getEditable('admor_site.settings')
      ->set('phone', $form_state->getValue('phone'))
      ->set('email', $form_state->getValue('email'))
      ->set('hours', $form_state->getValue('hours'))
      ->set('location', $form_state->getValue('location'))
      ->set('topbar_note', $form_state->getValue('topbar_note'))
      ->set('footer_summary', $form_state->getValue('footer_summary'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
