<?php

namespace Drupal\chinese_address\Element;


use Drupal\Component\Utility\NestedArray;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Element\FormElement;
use Drupal\chinese_address\chineseAddressHelper;
use Symfony\Component\HttpFoundation\Request;


/**
 *
 *
 * @FormElement("chinese_address")
 */
class ChineseAddress extends FormElement {
  
  /**
   * {@inheritdoc}
   */
  public function getInfo() {
    $class = get_class($this);
    return [
    '#input' => TRUE,
    '#tree'=>TRUE,
    '#process' => [
    [$class, 'processChineseAddress'],
    ],
    '#element_validate' => [
    [$class, 'validateChineseAddress'],
    ],
    '#theme_wrappers' => ['form_element','chinese_address_element'], 
    "#has_detail"=>TRUE,
    '#attached' => [
    'library' => ['chinese_address/drupal.chineseAddress'],
    ],
    ];
  }
  
  /**
   * {@inheritdoc}
   */
  public static function valueCallback(&$element, $input, FormStateInterface $form_state) {
   
    // Find the current value of this field.
    if ($input !== FALSE) {
      return $input;
    }
    else {
      $default_value=[
      'province' => chineseAddressHelper::CHINESE_ADDRESS_NULL_INDEX,
      ];
      
      if(isset($element['#default_value']))
        $value=$element['#default_value'];
        else
          $value=$default_value;
          return $value;
    }
  }
  
  /**
   * #ajax callback for managed_file upload forms.
   *
   * This ajax callback takes care of the following things:
   *   - Ensures that broken requests due to too big files are caught.
   *   - Adds a class to the response to be able to highlight in the UI, that a
   *     new file got uploaded.
   *
   * @param array $form
   *   The build form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The form state.
   * @param \Symfony\Component\HttpFoundation\Request $request
   *   The current request.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   The ajax response of the ajax upload.
   */
  public static function _chinese_address_change_callback(&$form, FormStateInterface &$form_state, Request $request) {  
      $triggering_element = $form_state->getTriggeringElement();
      $parents = $triggering_element['#array_parents'];
      array_pop($parents); 
      $element =  NestedArray::getValue($form, $parents);
      if (isset($element['_weight'])) {
        hide($element['_weight']);
      }

    $response = new AjaxResponse();
    return $response->addCommand(new ReplaceCommand(NULL, $element));
  }
  
  /**
   * Render API callback: Expands the managed_file element type.
   *
   * Expands the file type to include Upload and Remove buttons, as well as
   * support for a default value.
   */
  public static function processChineseAddress(&$element, FormStateInterface $form_state, &$complete_form) {
    

    $class = ChineseAddress::class;
    $address_value=$element['#value'];
    

    $parents_prefix = implode('_', $element['#array_parents']);

    $city = array();
    if (isset($address_value['province'])) {
      $city = chineseAddressHelper::_chinese_address_get_location($address_value['province']);
      if (!isset($address_value['city']) || !array_key_exists($address_value['city'], $city)) {
        $address_value['city'] = key($city);
      }
    }
    else {
      $city = chineseAddressHelper::_chinese_address_get_siblings($address_value['city']);
    }
    
    $county = chineseAddressHelper::_chinese_address_get_location($address_value['city']);
    if (!isset($address_value['county']) || !array_key_exists($address_value['county'], $county)) {
      $address_value['county'] = key($county);
    }
    
    $street =chineseAddressHelper:: _chinese_address_get_location($address_value['county']);
    if (!isset($address_value['street']) || !array_key_exists($address_value['street'], $street)) {
      $address_value['street'] = key($street);
    }

    $element['province'] = array(
    '#type' => 'select',
    '#theme_wrappers' => array(),
    '#attributes' => array(
    'class' => array(
    'chinese-address-province',
    ),
    ),
    '#default_value' => $address_value['province'],
    '#options' => chineseAddressHelper::_chinese_address_get_location(),
    '#ajax' => array(
    'callback' => [$class,'_chinese_address_change_callback'],
    'wrapper' => $element['#id'],
    'progress' => array(
    'type' => 'none',
    ),
    ),
    );
    
    $element['city'] = array(
    '#type' => 'select',
    "#access" =>!empty($city),
    '#validated' => TRUE,
    '#theme_wrappers' => array(),
    '#options' => $city,
    '#value' => $address_value['city'],
    '#attributes' => array(
    'class' => array(
    'chinese-address-city',
    ),
    
    ),
    '#ajax' => array(
    'callback' => [$class,'_chinese_address_change_callback'],
    'wrapper' => $element['#id'],
    'progress' => array(
    'type' => 'none',
    ),
    ),
    );
    
    $element['county'] = array(
    '#type' => 'select',
    '#theme_wrappers' => array(),
    "#access" => !empty($county),
    '#options' => $county,
    '#validated' => TRUE,
    '#default_value' => $address_value['county'],
    '#ajax' => array(
    'callback' => [$class,'_chinese_address_change_callback'],
    'wrapper' => $element['#id'],
    'progress' => array(
    'type' => 'none',
    ),
    ),
    '#attributes' => array(
    'class' => array(
    'chinese-address-county',
    ),
    ),
    );

    $element['street'] = array(
    '#type' => 'select',
    '#theme_wrappers' => array(),
    "#access" => !empty($street),
    '#options' => $street,
    '#validated' => TRUE,
    '#default_value' => $address_value['street'],
    '#attributes' => array(
    'class' => array(
    'chinese-address-street',
    ),
    ),
    );
    
    if ($element['#has_detail']) {
      $element['detail'] = array(
      '#type' => 'textfield',
      '#theme_wrappers' => array(),
      '#access'=>!empty($city),
      '#size' => 20,
      '#default_value' => $address_value['detail'],
      '#maxlength' => 60,
      '#attributes' => array(
      'class' => array(
      'chinese-address-detail',
      ),
      ),
      );
    }

    return $element;
  }
  
  public static function validateChineseAddress(&$element, FormStateInterface $form_state, &$complete_form) {
    $values = $element['#value'];
    $values += array(
    'province' => chineseAddressHelper::CHINESE_ADDRESS_NULL_INDEX,
    'city' => chineseAddressHelper::CHINESE_ADDRESS_NULL_INDEX,
    'county' => chineseAddressHelper::CHINESE_ADDRESS_NULL_INDEX,
    'street' => chineseAddressHelper::CHINESE_ADDRESS_NULL_INDEX,
    'detail'=>'',
    );
    $form_state->setValueForElement($element, $values);
    }
  
  
}


