<?php

namespace App;

class Common
{
    public static function getAddressWithoutCountry($address){
        $split_address = explode(", ", $address);
        $new_split_address = $split_address;
        foreach ($split_address as $valueKey => $value) {
            
            if($value == 'Queensland' || $value == 'South Australia' || $value == 'Tasmania' || $value == 'New South Wales' || $value == 'Victoria' || $value == 'Western Australia' || (is_numeric($value) && strlen($value) == 4) || $value == 'Australia' || $value == 'NSW' || $value == 'ACT' || $value == 'VIC' || $value == 'QLD' || $value == 'SA' || $value == 'WA' || $value == 'TAS' || $value == 'NT'){
                //delete this particular object from the $array
                unset($new_split_address[$valueKey]);
                
            } 
            if ($valueKey > 0) {
                $split_value = explode(" ", $value);
                $processed = false;
                foreach ($split_value as $splitvalueKey => $singlevalue) {
                    if($singlevalue == 'Queensland' || $singlevalue == 'South Australia' || $singlevalue == 'Tasmania' || $singlevalue == 'New South Wales' || $singlevalue == 'Victoria' || $singlevalue == 'Western Australia' || (is_numeric($singlevalue) && strlen($singlevalue) == 4) || $singlevalue == 'Australia' || $singlevalue == 'NSW' || $singlevalue == 'ACT' || $singlevalue == 'VIC' || $singlevalue == 'QLD' || $singlevalue == 'SA' || $singlevalue == 'WA' || $singlevalue == 'TAS' || $singlevalue == 'NT'){
                        //dd($singlevalue);
                        unset($split_value[$splitvalueKey]);
                        $processed = true;
                    }
                }
                if($processed){
                    $new_split_address[$valueKey] = implode(" ", $split_value);
                }
            }
        }
        // var_dump($new_split_address);
        // exit;
        $address = implode(", ", $new_split_address);
        $address = str_replace(",,", ",", $address);
        if(substr($address, -2, 2) == ', ') {
          $address = substr($address, 0, -2);
        }
        if(substr($address, -1, 1) == ',') {
          $address = substr($address, 0, -1);
        }
        return $address;
    }
}
