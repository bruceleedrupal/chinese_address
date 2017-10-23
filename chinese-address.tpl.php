<?php

/**
 * @file
 */
foreach($address as $i => $a) {
    if($a == CHINESE_ADDRESS_NAME_HIDE) {
        unset($address[$i]);
    }
}

echo implode('', $address);
