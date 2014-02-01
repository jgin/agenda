<?php

namespace Jasoft\Viringo\CoreBundle\Service\Domain;

/**
 *
 * @author lvercelli
 */
class SystemEntityUtil {
    
    public static function getLastPartName($entityName) {
        $pos=strrpos($entityName, '\\');
        $result=$entityName;
        if ($pos!==false) {
            $result=substr($entityName, $pos+1);
        }
        return $result;
    }
}
