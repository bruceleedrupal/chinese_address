<?php

/**
 * @file
 * 定义类 chinese_address_handler_filter_field_list.
 */

/**
 * Filter handler which uses list-fields as options.
 *
 * @ingroup views_filter_handlers
 */
class chinese_address_handler_filter_field_list extends views_handler_filter_many_to_one {

  /**
   *
   */
  public function init(&$view, &$options) {
    parent::init($view, $options);
    if ($this->options['operator'] == 'in') {
      $this->options['operator'] = 'or';
    }
    if ($this->options['operator'] == 'not in') {
      $this->options['operator'] = 'not';
    }

    $this->operator = $this->options['operator'];
  }

  /**
   *
   */
  public function get_value_options() {
    $this->value_options = _chinese_address_get_location(CHINESE_ADDRESS_ROOT_INDEX,TRUE);
  }

}
