<?php

namespace Jasoft\Viringo\ReportBundle\Domain;

/**
 * Description of Report
 *
 * @author lvercelli
 */
class Report {
    
    /**
     *
     * @var string
     */
    private $fileName;
    
    /**
     *
     * @var array
     */
    private $parameters;
    
    function __construct($fileName) {
        $this->fileName = $fileName;
        $this->parameters=array();
    }
    
    public function getFileName() {
        return $this->fileName;
    }

    public function setFileName($fileName) {
        $this->fileName = $fileName;
        return $this;
    }

    public function getParameters() {
        return $this->parameters;
    }

    public function setParameters($parameters) {
        $this->parameters = $parameters;
        return $this;
    }
    
    public function getParameterValue($param) {
        return $this->parameters[$param];
    }
    
    public function setParamaterValue($param, $value) {
        $this->parameters[$param]=$value;
        return $this;
    }
}
