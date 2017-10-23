<?php

/**
 * @file
 * Chinese_address.views.inc.
 */

/**
 *
 */
function chinese_address_field_views_data($field) 
{
    $data = field_views_field_default_views_data($field);
    foreach ($data as $table_name => $table_data) {
        foreach ($table_data as $field_name => $field_data) {
            if (isset($field_data['filter']) && (strpos($field_name, "province")!==false)) {
                $data[$table_name][$field_name]['filter']['handler'] = 'chinese_address_handler_filter_field_list';
                $data[$table_name][$field_name]['argument']['handler'] = 'chinese_address_handler_argument_field_list_string';
            }
        }
    }
    return $data;
}
