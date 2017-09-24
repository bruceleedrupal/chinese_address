<?php

/**
 * @file
 * Definition of chinese_address_handler_argument_field_list_string.
 */

/**
 *
 */
class chinese_address_handler_argument_field_list_string extends views_handler_argument_string {

  /**
   * Stores the allowed values of this field.
   *
   * @var array
   */
  public $allowedValues = NULL;

  /**
   *
   */
  public function init(&$view, &$options) {
    parent::init($view, $options);
    $this->allowedValues = _chinese_address_get_location();
  }

  /**
   *
   */
  public function option_definition() {
    $options = parent::option_definition();

    $options['summary']['contains']['human'] = array(
      'default' => FALSE,
      'bool' => TRUE,
    );

    return $options;
  }

  /**
   *
   */
  public function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);

    $form['summary']['human'] = array(
      '#title' => t('Display list value as human readable'),
      '#type' => 'checkbox',
      '#default_value' => $this->options['summary']['human'],
      '#dependency' => array(
        'radio:options[default_action]' => array(
          'summary',
        ),
      ),
    );
  }

  /**
   *
   */
  public function summary_name($data) {
    $value = $data->{$this->name_alias};
    // If the list element has a human readable name show it,.
    if (isset($this->allowedValues[$value]) && !empty($this->options['summary']['human'])) {
      return $this->case_transform(field_filter_xss($this->allowedValues[$value]), $this->options['case']);
    }
    // Else fallback to the key.
    else {
      return $this->case_transform(check_plain($value), $this->options['case']);
    }
  }

}
