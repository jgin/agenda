<?php

namespace Jasoft\Viringo\CoreBundle\Util;

/**
 * Description of StringUtil
 *
 * @author lvercelli
 */
class StringUtil {
    /*
     * @param string $string
     * @return string
     */
    public static function toUpperCase($string){
        $string = mb_strtoupper($string,'utf-8');
        return $string; 
    }  
}
