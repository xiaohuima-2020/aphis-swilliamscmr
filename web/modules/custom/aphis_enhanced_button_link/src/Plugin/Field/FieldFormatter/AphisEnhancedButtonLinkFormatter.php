<?php

namespace Drupal\aphis_enhanced_button_link\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Path\PathValidatorInterface;
use Drupal\Core\Utility\Token;
use Drupal\Core\Config\Config;
use Drupal\link\Plugin\Field\FieldFormatter\LinkFormatter;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\aphis_enhanced_button_link\AphisEnhancedButtonLinkInterface;

/**
 * Plugin implementation of the 'Enhanced Button Link' formatter.
 *
 * @FieldFormatter(
 *   id = "aphis_enhanced_button_link_formatter",
 *   label = @Translation("Enhanced Button Link"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class AphisEnhancedButtonLinkFormatter extends LinkFormatter {

  /**
   * The token replacement instance.
   *
   * @var \Drupal\Core\Utility\Token
   */
  protected $token;

  /**
   * Contains the aphis_enhanced_button_link.settings configuration object.
   *
   * @var \Drupal\Core\Config\Config
   */
  protected $aphisEnhancedButtonLinkConfigs;

  /**
   * Constructs a new AphisEnhancedButtonLinkFormatter.
   *
   * @param string $plugin_id
   *   The plugin_id for the formatter.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Field\FieldDefinitionInterface $field_definition
   *   The definition of the field to which the formatter is associated.
   * @param array $settings
   *   The formatter settings.
   * @param string $label
   *   The formatter label display setting.
   * @param string $view_mode
   *   The view mode.
   * @param array $third_party_settings
   *   Third party settings.
   * @param \Drupal\Core\Path\PathValidatorInterface $path_validator
   *   The path validator service.
   * @param \Drupal\Core\Utility\Token $token
   *   The token replacement instance.
   * @param \Drupal\Core\Config\Config $aphis_enhanced_button_link_configs
   *   The aphis_enhanced_button_link.settings configuration factory object.
   */
  public function __construct($plugin_id, $plugin_definition, FieldDefinitionInterface $field_definition, array $settings, $label, $view_mode, array $third_party_settings, PathValidatorInterface $path_validator, Token $token, Config $aphis_enhanced_button_link_configs) {
    parent::__construct($plugin_id, $plugin_definition, $field_definition, $settings, $label, $view_mode, $third_party_settings, $path_validator);
    $this->token = $token;
    $this->aphisEnhancedButtonLinkConfigs = $aphis_enhanced_button_link_configs;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
          $plugin_id,
          $plugin_definition,
          $configuration['field_definition'],
          $configuration['settings'],
          $configuration['label'],
          $configuration['view_mode'],
          $configuration['third_party_settings'],
          $container->get('path.validator'),
          $container->get('token'),
          $container->get('config.factory')->get('aphis_enhanced_button_link.settings')
      );
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'type' => 'usa-button',
      'status' => AphisEnhancedButtonLinkInterface::STATUS_ENABLED,
      'target' => AphisEnhancedButtonLinkInterface::TARGET_SAME_WINDOW,
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);
    $button_link_styles = $this->aphisEnhancedButtonLinkConfigs->get('button_link_styles');

    // Disable Link Formatter settings.
    $elements['trim_length']['#access'] = FALSE;
    $elements['url_only']['#access'] = FALSE;
    $elements['url_plain']['#access'] = FALSE;
    $elements['rel']['#access'] = FALSE;

    $elements['type'] = [
      '#type' => 'select',
      '#title' => $this->t('Type'),
      '#default_value' => $this->getSetting('type'),
      '#options' => $button_link_styles,
      '#required' => TRUE,
    ];

    $elements['status'] = [
      '#type' => 'select',
      '#title' => $this->t('Status'),
      '#default_value' => $this->getSetting('status'),
      '#options' => [
        AphisEnhancedButtonLinkInterface::STATUS_ENABLED => $this->t('Enabled'),
        AphisEnhancedButtonLinkInterface::STATUS_DISABLED => $this->t('Disabled'),
      ],
      '#required' => TRUE,
    ];

    $elements['target'] = [
      '#type' => 'select',
      '#title' => $this->t('Target'),
      '#default_value' => $this->getSetting('target'),
      '#options' => [
        AphisEnhancedButtonLinkInterface::TARGET_SAME_WINDOW => $this->t('Same Window'),
        AphisEnhancedButtonLinkInterface::TARGET_NEW_TAB => $this->t('New Tab'),
      ],
      '#required' => TRUE,
      '#weight' => 1,
    ];

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $summary[] = $this->t('Button Type: @text', ['@text' => $this->getSetting('type')]);
    $summary[] = $this->t('Button Status: @text', ['@text' => $this->getSetting('status')]);
    $summary[] = $this->t('Button Target: @text', ['@text' => $this->getSetting('target')]);

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $element = [];
    $settings = $this->getSettings();
    $entity = $items->getEntity();

    $override_type = (bool) $this->aphisEnhancedButtonLinkConfigs->get('override_type');
    $override_status = (bool) $this->aphisEnhancedButtonLinkConfigs->get('override_status');
    $override_target = (bool) $this->aphisEnhancedButtonLinkConfigs->get('override_target');

    foreach ($items as $delta => $item) {
      $url = $this->buildUrl($item);

      // Load links options.
      $options = $url->getOptions();

      // Load Link Title.
      $link_title = $this->token->replace($item->title, [$entity->getEntityTypeId() => $entity], ['clear' => TRUE]);

      $attributes = [];
      $btn_class = [];

      // Add button type.
      $button_link_type = (!$override_type || empty($options['type']) || $options['type'] == AphisEnhancedButtonLinkInterface::TYPE_DEFAULT) ? $settings['type'] : $options['type'];

      if (!empty($button_link_type)) {
        $btn_class += ['usa-button', $button_link_type];
      }

      // Add button status.
      $button_link_status = (!$override_status || empty($options['status']) || $options['status'] == AphisEnhancedButtonLinkInterface::STATUS_DEFAULT) ? $settings['status'] : $options['status'];

      // Disable button if set to be disabled.
      if ($button_link_status == AphisEnhancedButtonLinkInterface::STATUS_DISABLED) {
        $attributes['aria-disabled'] = 'true';
        $attributes['role'] = 'button';
        $btn_class[] = 'disabled';
      }

      // Add button target.
      $button_link_target = (!$override_target || empty($options['target']) || $options['target'] == AphisEnhancedButtonLinkInterface::TARGET_DEFAULT) ? $settings['target'] : $options['target'];

      // Add target to the link.
      if ($button_link_target == AphisEnhancedButtonLinkInterface::TARGET_NEW_TAB) {
        $attributes['target'] = '_blank';
      }
      else {
        $attributes['target'] = '';
      }

      // Add collected classes to attributes.
      if (!empty($btn_class)) {
        $attributes['class'] = implode(' ', $btn_class);
      }

      // Create output of the button link.
      $element[$delta] = [
        '#type' => 'link',
        '#title' => $link_title,
        '#url' => $url,
        '#options' => ['attributes' => $attributes],
      ];
    }

    // Adding component library.
    $element['#attached']['library'][] = 'aphis_enhanced_button_link/aphis_enhanced_button_link.field';

    // Adding caching tag for cleaning.
    $element['#cache']['tags'][] = 'aphis_enhanced_button_link__field_formatter';

    return $element;
  }

}
