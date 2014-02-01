<?php

namespace Jasoft\Viringo\CoreBundle\Util;

/**
 * Description of ArrayUtil
 *
 * @author lvercelli
 */
class ArrayUtil {
    
    const ORDER_ASC=1;
    const ORDER_DESC=-1;
    
    const COMPARE_STRING='string';
    const COMPARE_NUMBER='number';
    
    /**
     * 
     * @param array $input
     * @param mixed $value
     * @param string $compareType
     * @param integer $ordering
     * @return int|null
     */
    public static function binarySearch(array $input, $value, $compareType=self::COMPARE_STRING, $ordering=self::ORDER_ASC) {
        if (empty($input) || count($input)==0) {
            return null;
        }
        
        $low=0;
        $high=count($input)-1;
        while ($high>=$low) {
            $probe=floor(($high+$low)/2);
            $comparison=$ordering*self::compare($compareType, $value, $input[$probe]);
            if ($comparison<0) {
                $high=$probe-1;
            } else if ($comparison>0) {
                $low=$probe+1;
            } else {
                return $probe;
            }
        }
        
        return null;
    }
    
    /**
     * Inserta un elemento en un array en su lugar de acuerdo a su orden utilizando
     * búsqueda binaria
     * @param array $input
     * @param mixed $value
     * @param string $compareType
     * @param integer $ordering
     * @return int|null
     */
    public static function binaryInsertIfNoExists(array &$input, $value, $compareType=self::COMPARE_STRING, $ordering=self::ORDER_ASC) {
        $low=0;
        $high=count($input)-1;
        $pos=0;
        $found=false;
        while ($high>=$low) {
            $pos=floor(($high+$low)/2);
            $comparison=$ordering*self::compare($compareType, $value, $input[$pos]);
            if ($comparison<0) {
                $high=$pos-1;
            } else if ($comparison>0) {
                $low=$pos+1;
            } else {
                $found=true;
                return $pos;
            }
        }
        if (!$found) {
            if ($low>=count($input)) {
                $input[]=$value;
            } else {
                self::insertInArray($input, $value, $low);
            }
        }
    }
    
    /**
     * 
     * @param array $array
     * @param mixed $value
     * @param integer $pos
     */
    public static function insertInArray(array &$array, $value, $pos=null) {
        if (isset($pos) && $pos<count($array)) {
            array_splice($array, $pos, 0, $value);
        } else {
            $array[]=$value;
        }
    }
    
    private static function compare($type, $a, $b) {
        if ('string'==$type) {
            return self::compareStrings($a, $b);
        } else if ('number'==$type) {
            return self::compareNumbers($a, $b);
        }
    }

    private static function compareStrings($a, $b) {
        return strcasecmp($a, $b);
    }
    
    private static function compareNumbers($a, $b) {
        return $a-$b;
    }
}
