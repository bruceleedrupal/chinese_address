<?php

namespace Drupal\chinese_address\Plugin\Field\FieldType;


use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\TypedData\DataDefinition;
use Drupal\chinese_address\chineseAddressHelper;
use Drupal\chinese_address\ChineseAddressComputed;
/**
 * Plugin implementation of the 'chinese_address_field_type' field type.
 *
 * @FieldType(
 * id = "chinese_address_field_type",
 * label = @Translation("Chinese Address"),
 * description = @Translation("Chinese Address Field"),
 * module = "chinese_address",
 * default_widget = "chinese_address_widget_type",
 * default_formatter = "chinese_address_formatter_type"
 * )
 */
class ChineseAddressFieldType extends FieldItemBase {

  /**
   *
   * {@inheritdoc}
  
  public static function defaultStorageSettings() {
    return [
      'max_length' => 255,
      'is_ascii' => FALSE,
      'case_sensitive' => FALSE
    ] + parent::defaultStorageSettings();
  }
 */
  /**
   *
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Prevent early t() calls by using the TranslatableMarkup.
    $properties= [
    'province' => DataDefinition::create('integer')->setLabel(t('Province')),
    'city' => DataDefinition::create('integer') -> setLabel(t('City')),
    'county' => DataDefinition::create('integer')  ->setLabel(t('County')),
    'street'=>  DataDefinition::create('integer') ->setLabel(t('Street')),
    'detail'=>  DataDefinition::create('string')->setLabel(t('Detail')),
    ];
    return $properties;
  }

  /**
   *
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = [
      'columns' => [
        'province' => array(
          'type' => 'int',
          'size' => 'big',
          'not null' => TRUE,
          'default' => chineseAddressHelper::CHINESE_ADDRESS_NULL_INDEX
        ),
        'city' => array(
          'type' => 'int',
          'size' => 'big',
          'not null' => TRUE,
          'default' => chineseAddressHelper::CHINESE_ADDRESS_NULL_INDEX
        ),
        'county' => array(
          'type' => 'int',
          'size' => 'big',
          'not null' => TRUE,
          'default' => chineseAddressHelper::CHINESE_ADDRESS_NULL_INDEX
        ),
        'street' => array(
          'type' => 'int',
          'size' => 'big',
          'not null' => TRUE,
          'default' => chineseAddressHelper::CHINESE_ADDRESS_NULL_INDEX
        ),
        'detail' => array(
          'type' => 'varchar',
          'length' => 255,
          'not null' => TRUE
        )
      ],
      'indexes' => array(
        'province' => array(
          'province'
        ),
        'city' => array(
          'city'
        ),
        'county' => array(
          'county'
        ),
        'street' => array(
          'street'
        )
      )
    ];
    
    return $schema;
  }

  /**
   *
   * {@inheritdoc}

  public function getConstraints() {
    $constraints = parent::getConstraints();
    
    if ($max_length = $this->getSetting('max_length')) {
      $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
      $constraints[] = $constraint_manager->create('ComplexData', [
        'value' => [
          'Length' => [
            'max' => $max_length,
            'maxMessage' => t('%name: may not be longer than @max characters.', [
              '%name' => $this->getFieldDefinition()->getLabel(),
              '@max' => $max_length
            ])
          ]
        ]
      ]);
    }
    
    return $constraints;
  }
   */
  /**
   *
   * {@inheritdoc}

  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {
    $random = new Random();
    $values['value'] = $random->word(mt_rand(1, $field_definition->getSetting('max_length')));
    return $values;
  }
   */
/*
   *
   * {@inheritdoc}
*/
  public function isEmpty() {
    $value = $this->get('province')->getValue();
    return $value ==chineseAddressHelper::CHINESE_ADDRESS_NULL_INDEX ;
  } 
}
