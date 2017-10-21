<?php

namespace Drupal\chinese_address;

/**
 *
 */
class chineseAddressHelper
{
    const CHINESE_ADDRESS_ROOT_INDEX = 1;
    const CHINESE_ADDRESS_NULL_INDEX = 0;
    const CHINESE_ADDRESS_NAME_HIDE = "市辖区";

    /**
   *
   */
    public static function chinese_address_get_location($parentId = self::CHINESE_ADDRESS_ROOT_INDEX, $excludeNone = FALSE, $limitIds = array()) 
    {
      $query=db_select('chinese_address', 'c')->fields('c')->condition('c.parent_id ', $parentId);
      if($limitIds)
        $result =$query->condition('c.id ', $limitIds ,'in');
        
        $result = $query->execute()->fetchAllKeyed(0, 2);
        if (!$excludeNone) {
          $result[self::CHINESE_ADDRESS_NULL_INDEX] = '--- 无----';
          ksort($result);
        }
        return $result;
    }

    /**
   *
   */
    public static  function chinese_address_get_siblings($regionId = 1) 
    {
        $subquery = db_select('chinese_address', 'ca')->fields(
            'ca', [
            'parent_id',
            ]
        )->condition('ca.id', $regionId);

        $result = db_select('chinese_address', 'c')->fields('c')->condition('c.parent_id ', $subquery, 'in')->execute()->fetchAllKeyed(0, 2);
        return $result;
    }

    /**
   *
   */
    public static function chinese_address_get_region_index($address) 
    {

        foreach ($address as $i => $a) {
            if (!in_array($i, ['province', 'city', 'county', 'street'])) {
                unset($address[$i]);
            }
        }
        $result = db_select('chinese_address', 'c')->fields('c')->condition('id', $address, 'IN')->execute()->fetchAllKeyed(0, 2);

        return $result;
    }
    
    /**
     *
     */
    public static function chinese_address_get_parent($ids =array())
    {
      $result = db_select('chinese_address', 'c')->fields('c')->condition('id', $ids, 'IN')->execute()->fetchAllKeyed(0, 1);      
      return $result;
    }
      
    
    public static function chinese_address_filter_none_option($address =array())
    {
      if(isset($address[self::CHINESE_ADDRESS_NULL_INDEX]))
          unset($address[self::CHINESE_ADDRESS_NULL_INDEX]);
      return $address;
    }

}