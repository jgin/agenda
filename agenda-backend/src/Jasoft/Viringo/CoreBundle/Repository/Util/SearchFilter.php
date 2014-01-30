<?php

namespace Jasoft\Viringo\CoreBundle\Repository\Util;

use Doctrine\ORM\Query\Expr\Comparison;

/**
 * Description of SearchFilter
 *
 * @author lvercelli
 */
class SearchFilter {
    
    /**
     * Mayor
     */
    const DATACOMPARISON_GT = 0;
    
    /**
     * Mayor o igual
     */
    const DATACOMPARISON_GTE = 1;
    
    /**
     * Menor
     */
    const DATACOMPARISON_LT = 2;
    
    /**
     * Menor o igual
     */
    const DATACOMPARISON_LTE = 3;
    
    /**
     * Igual
     */
    const DATACOMPARISON_EQ = 4;
    
    /**
     * Diferente
     */
    const DATACOMPARISON_NOTEQ = 5;
    
    /**
     * Like
     */
    const DATACOMPARISON_LIKE = 6;
    
    /**
     * not Like
     */
    const DATACOMPARISON_NOTLIKE = 7;
    
    /**
     * is Null
     */
    const DATACOMPARISON_ISNULL = 8;
    
    /**
     * is Null
     */
    const DATACOMPARISON_ISNOTNULL = 9;
    
    /**
     * in
     */
    const DATACOMPARISON_IN = 10;
    
    /**
     * not in
     */
    const DATACOMPARISON_NOTIN = 11;
    
    private static $dataComparisonArray = 
            array("gt", "gte", "lt", "lte", "eq", "noteq", "like", "_notlike_", "isnull", "_isnotnull_", "in", "notin");

    /**
     *
     * @var string
     */
    private $fieldName;
    
    /**
     *
     * @var integer
     */
    private $comparator;
    
    /**
     *
     * @var mixed
     */
    private $value;
    
    
    function __construct($fieldName=null, $comparator=null, $value=null) {
        $this->fieldName = $fieldName;
        $this->comparator = $comparator;
        $this->value = $value;
    }

    
    public static function getDataComparisonArray() {
        return self::$dataComparisonArray;
    }

    /**
     * 
     * @return string
     */
    public function getFieldName() {
        return $this->fieldName;
    }

    /**
     * 
     * @return integer
     */
    public function getComparator() {
        return $this->comparator;
    }

    /**
     * 
     * @return mixed
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * 
     * @param type $fieldName
     * @return \Jasoft\Viringo\CoreBundle\Repository\Util\SearchFilter
     */
    public function setFieldName($fieldName) {
        $this->fieldName = $fieldName;
        return $this;
    }

    /**
     * 
     * @param integer $comparator
     * @return \Jasoft\Viringo\CoreBundle\Repository\Util\SearchFilter
     */
    public function setComparator($comparator) {
        $this->comparator = $comparator;
        return $this;
    }

    /**
     * 
     * @param mixed $value
     * @return \Jasoft\Viringo\CoreBundle\Repository\Util\SearchFilter
     */
    public function setValue($value) {
        $this->value = $value;
        return $this;
    }
    
    public static function createEqFilter($fieldName, $value) {
        return new SearchFilter($fieldName, self::DATACOMPARISON_EQ, $value);
    }
    
    public static function createNotEqFilter($fieldName, $value) {
        return new SearchFilter($fieldName, self::DATACOMPARISON_NOTEQ, $value);
    }
    
    public static function createLikeFilter($fieldName, $value) {
        return new SearchFilter($fieldName, self::DATACOMPARISON_LIKE, $value);
    }
    
    public static function createIsNullFilter($fieldName) {
        return new SearchFilter($fieldName, self::DATACOMPARISON_ISNULL);
    }
    
    public static function createIsNotNullFilter($fieldName) {
        return new SearchFilter($fieldName, self::DATACOMPARISON_ISNOTNULL);
    }
    
    /**
     * 
     * @param string $str
     * @return integer
     */
    public static function getComparatorFromStr($str=null) {
        if (empty($str)) { return self::DATACOMPARISON_LIKE; }
        $key=array_search($str, self::$dataComparisonArray);
        if (false!==$key) {
            return $key;
        }
        return null;
    }
    
    
    public static function getSearchFiltersOfField($filters, $fieldName) {
        if (!empty($filters) || !is_array($filters) || count($filters)==0) { 
            return null;
        }
        $result=array();
        /* @var $sf static */
        foreach ($filters as $sf) {
            if (strcmp($sf->getFieldName(), $fieldName)==0) {
                $result[]=$sf;
            }
        }
        return $result;
    }

}
