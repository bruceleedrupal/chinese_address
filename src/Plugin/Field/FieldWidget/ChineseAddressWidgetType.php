<?php

namespace Drupal\chinese_address\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'chinese_address_widget_type' widget.
 *
 * @FieldWidget(
 *   id = "chinese_address_widget_type",
 *   label = @Translation("Chinese Address Widget"),
 *   field_types = {
 *     "chinese_address_field_type"
 *   }
 * )
 */
class ChineseAddressWidgetType extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = $element + [
      '#type' => 'chinese_address',
      '#default_value' => $items[$delta]->getValue() ? $items[$delta]->getValue() : NULL,
    ];
    return $element;
  }

}
