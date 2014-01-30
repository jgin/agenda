<?php

namespace Jasoft\Viringo\CoreBundle\Util;

/**
 * Description of DataPage
 *
 * @author lvercelli
 */
class DataPage {
    
    private $data;
    
    private $totalRecords;
    
    function __construct($data=null, $totalRecords=null) {
        $this->data = $data;
        $this->totalRecords = $totalRecords;
    }

    public function getData() {
        return $this->data;
    }

    public function getTotalRecords() {
        return $this->totalRecords;
    }

    public function setData($data) {
        $this->data = $data;
    }

    public function setTotalRecords($totalRecords) {
        $this->totalRecords = $totalRecords;
    }
}
