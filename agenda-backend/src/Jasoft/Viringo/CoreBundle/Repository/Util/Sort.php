<?php

namespace Jasoft\Viringo\CoreBundle\Repository\Util;

/**
 * Description of Sort
 *
 * @author lvercelli
 */
class Sort {
    
    private $fieldName;
    
    private $orderDirection;
    
    function __construct($fieldName, $orderDirection) {
        $this->fieldName = $fieldName;
        $this->orderDirection = $orderDirection;
    }

    public function getFieldName() {
        return $this->fieldName;
    }

    public function getOrderDirection() {
        return $this->orderDirection;
    }

    public function setFieldName($fieldName) {
        $this->fieldName = $fieldName;
    }

    public function setOrderDirection($orderDirection) {
        $this->orderDirection = $orderDirection;
    }


}
