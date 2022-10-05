<?php

namespace Drupal\aphis_enhanced_button_link\Form;

use Drupal\Core\Cache\Cache;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\aphis_enhanced_button_link\AphisEnhancedButtonLinkInterface;
use Drupal\aphis_enhanced_button_link\AphisEnhancedButtonLinkHelper;
use Drupal\aphis_enhanced_button_link\AphisEnhancedButtonLinkParseException;

/**
 * Defines a form that configures enhanced button link settings.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'aphis_enhanced_button_link_admin_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'aphis_enhanced_button_link.settings',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $configs = $this->config('aphis_enhanced_button_link.settings');
    $button_link_styles_options = $configs->get('button_link_styles');
    $button_link_styles_value = AphisEnhancedButtonLinkHelper::makeValueFromConfigs($button_link_styles_options);

    // Get number of style options.
    $rows_number = count($button_link_styles_options);

    $form['button_link_styles'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Button Link Styles'),
      '#default_value' => $button_link_styles_value,
      '#rows' => $rows_number,
      '#description' => $this->t('Put here available button link styles options. There should be pairs of bootstrap button classes and their titles in format: bootstrap-class|Style Title, for example: btn-primary|Primary button.'),
    ];

    $form['override'] = [
      '#type' => 'fieldset',
      '#title' => $this->t('Override Options'),
      '#description' => $this->t('Specify here which button link options should be overridable in the field widget.'),
    ];

    $form['override']['type'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Type'),
      '#default_value' => $configs->get('override_type'),
    ];

    $form['override']['size'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Size'),
      '#default_value' => $configs->get('override_size'),
    ];

    $form['override']['status'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Status'),
      '#default_value' => $configs->get('override_status'),
    ];

    $form['override']['target'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Target'),
      '#default_value' => $configs->get('override_target'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    $values = $form_state->getValues();

    try {
      $button_link_styles_options = AphisEnhancedButtonLinkHelper::parseConfigsFromValue($values['button_link_styles']);
    }
    catch (AphisEnhancedButtonLinkParseException $e) {
      switch ($e->getCode()) {
        case AphisEnhancedButtonLinkInterface::EXC_CODE_PARSE_PAIR:
          $form_state->setErrorByName('button_link_styles', $this->t('Styles options must be entered in format: bootstrap-class|Title, for example: btn-primary|Primary button. One per line.'));
          break;

        case AphisEnhancedButtonLinkInterface::EXC_CODE_PARSE_CSS_CLASS:
          $form_state->setErrorByName('button_link_styles', $this->t("Some css class doesn\'t corresponds to correct format."));
          break;

        case AphisEnhancedButtonLinkInterface::EXC_CODE_PARSE_NAME:
          $form_state->setErrorByName('button_link_styles', $this->t('Some style option name has special characters.'));
          break;
      }

      return;
    }

    $form_state->setValue('button_link_styles_options', $button_link_styles_options);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    $this->config('aphis_enhanced_button_link.settings')
      ->set('button_link_styles', $values['button_link_styles_options'])
      ->set('override_type', $values['type'])
      ->set('override_size', $values['size'])
      ->set('override_status', $values['status'])
      ->set('override_target', $values['target'])
      ->save();

    // Cleaning cache where Enhanced Button Link formatter was used.
    Cache::invalidateTags(['aphis_enhanced_button_link__field_formatter']);

    parent::submitForm($form, $form_state);
  }

}
