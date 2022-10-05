<?php

namespace Drupal\editor_button_link\Plugin\Filter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Form\FormStateInterface;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * Convert data-drupal-button-link to classes for each link.
 *
 * @Filter(
 *   id = "editor_button_link_filter",
 *   title = @Translation("Button link styles"),
 *   description = @Translation("This filter will allow you to transform a link into a button via text Editor's link dialog"),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 *   settings = {
 *     "button_link_options" = "|Select",
 *     "button_link_size_options" = "",
 *     "button_link_style_options" = ""
 *   },
 *   weight = 1
 * )
 */
class EditorButtonLinkFilter extends FilterBase {

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $form['button_link_options'] = [
      '#type' => 'textarea',
      '#description' => $this->t('The possible values this option can contain. Enter one value per line, in the format key|label.'),
      '#title' => $this->t('Button type'),
      '#default_value' => $this->settings['button_link_options'],
      '#required' => TRUE,
    ];
    $form['button_link_size_options'] = [
      '#type' => 'textarea',
      '#description' => $this->t('The possible values this option can contain. Enter one value per line, in the format key|label.'),
      '#title' => $this->t('Button size'),
      '#default_value' => $this->settings['button_link_size_options'],
    ];
    $form['button_link_style_options'] = [
      '#type' => 'textarea',
      '#description' => $this->t('The possible values this option can contain. Enter one value per line, in the format key|label.'),
      '#title' => $this->t('Button style'),
      '#default_value' => $this->settings['button_link_style_options'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function process($text, $langcode) {
    $result = new FilterProcessResult($text);

    if (stristr($text, 'data-drupal-button-link') !== FALSE) {

      $dom = Html::load($text);
      $xpath = new \DOMXPath($dom);

      $button_link_elements = $xpath->query('//a[@data-drupal-button-link]');

      if (!is_null($button_link_elements)) {
        foreach ($button_link_elements as $element) {
          $setting_classes = [];

          if ($element->getAttribute('data-drupal-button-link')) {
            $setting_classes = array_merge($setting_classes, explode(' ', $element->getAttribute('data-drupal-button-link')));
          }
          if ($element->getAttribute('data-drupal-button-link-size')) {
            $setting_classes = array_merge($setting_classes, explode(' ', $element->getAttribute('data-drupal-button-link-size')));
          }
          if ($element->getAttribute('data-drupal-button-link-style')) {
            $setting_classes = array_merge($setting_classes, explode(' ', $element->getAttribute('data-drupal-button-link-style')));
          }
          if ($element->getAttribute('class')) {
            $setting_classes = array_filter(array_merge($setting_classes, explode(' ', $element->getAttribute('class'))));
          }

          // Sanitize all class names.
          $all_classes = array_map('Drupal\Component\Utility\Html::getClass', $setting_classes);

          // Remove any duplicate classes.
          $all_classes = array_unique($all_classes);

          // Convert array of classes to a string.
          $all_classes = implode(' ', $all_classes);

          $element->setAttribute('class', $all_classes);
        }
      }

      $result->setProcessedText(Html::serialize($dom));
    }

    return $result;
  }

}
