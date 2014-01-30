<?php

namespace Jasoft\Viringo\ReportBundle\Domain;

/**
 * Description of ReportParameter
 *
 * @author lvercelli
 */
class ReportParameter {

    /**
     *
     * @var string
     */
    private $name;

    /**
     *
     * @var string
     */
    private $type;
    
    /**
     *
     * @var type 
     */
    private $controlType;
    
    /**
     *
     * @var type 
     */
    private $promtText;
    
    /**
     *
     * @var type 
     */
    private $helpText;
    
    /**
     *
     * @var type 
     */
    private $required;
    
    /**
     *
     * @var type 
     */
    private $hidden;
    
    /**
     *
     * @var type 
     */
    private $defaultValue;
    
    /**
     *
     * @var type 
     */
    private $selectionListValue;
    
    /**
     *
     * @var type 
     */
    private $selectionListLabel;
    
    public function getName() {
        return $this->name;
    }

    public function getType() {
        return $this->type;
    }

    public function getControlType() {
        return $this->controlType;
    }

    public function getPromtText() {
        return $this->promtText;
    }

    public function getHelpText() {
        return $this->helpText;
    }

    public function getRequired() {
        return $this->required;
    }

    public function getHidden() {
        return $this->hidden;
    }

    public function getDefaultValue() {
        return $this->defaultValue;
    }

    public function getSelectionListValue() {
        return $this->selectionListValue;
    }

    public function getSelectionListLabel() {
        return $this->selectionListLabel;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setControlType(type $controlType) {
        $this->controlType = $controlType;
    }

    public function setPromtText(type $promtText) {
        $this->promtText = $promtText;
    }

    public function setHelpText(type $helpText) {
        $this->helpText = $helpText;
    }

    public function setRequired(type $required) {
        $this->required = $required;
    }

    public function setHidden(type $hidden) {
        $this->hidden = $hidden;
    }

    public function setDefaultValue(type $defaultValue) {
        $this->defaultValue = $defaultValue;
    }

    public function setSelectionListValue(type $selectionListValue) {
        $this->selectionListValue = $selectionListValue;
    }

    public function setSelectionListLabel(type $selectionListLabel) {
        $this->selectionListLabel = $selectionListLabel;
    }

}
