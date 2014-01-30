<?php

namespace Jasoft\Viringo\CoreBundle\Repository\Util;

/**
 * Description of QueryBuilderUtil
 *
 * @author lvercelli
 */
class QueryBuilderUtil {

    /**
     * 
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param string $alias
     * @param array $filters array de SearchFilter
     * @param array $sorting array de Sort
     * @param int $pageNumber
     * @param int $pageSize
     */
    public static function addDefaultQueryCriteria($qb, $alias, $filters=null, $sorting=null, $pageNumber=null, $pageSize=null) {
        $aliasMapping=self::addRequiredJoins($qb, $alias, $filters, $sorting);
        if (!empty($filters) && is_array($filters) && count($filters)>0) {
            self::addQueryFilter($qb, $aliasMapping, $filters);
        }
        if (!empty($sorting) && is_array($sorting) && count($sorting)>0) {
            self::addQuerySort($qb, $aliasMapping, $sorting);
        }
        if (!empty($pageNumber) && !empty($pageSize)) {
            self::paginateQuery($qb, $pageNumber, $pageSize);
        }
    }
    
    /**
     * 
     * @param array $filters
     * @param array $sorting
     * @return array
     */
    private static function getAllFieldNames($filters=null, $sorting=null) {
        $fieldNames=array();
        
        if (!empty($filters) && is_array($filters) && count($filters)>0) {
            foreach ($filters as $searchFilter) {
                if ($searchFilter instanceof SearchFilter) {
                    $fieldNames[] = $searchFilter->getFieldName();
                } else {
                    throw new \InvalidArgumentException('Los filtros deben ser instancias de "SearchFilter"');
                }
            }
        }
        
        if (!empty($sorting) && is_array($sorting) && count($sorting)>0) {
            foreach ($sorting as $sort) {
                if ($sort instanceof Sort) {
                    $fieldNames[] = $sort->getFieldName();
                } else {
                    throw new \InvalidArgumentException('Los ordenamientos deben ser instancias de "Sort"');
                }
            }
        }
        
        return $fieldNames;
    }
    
    /**
     * 
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param string $alias
     * @param array $filters
     * @param array $sorting
     * @return array Mapeo de los alias con las rutas de los atributos
     */
    public static function addRequiredJoins($qb, $alias, $filters=null, $sorting=null) {
        $fieldNames=self::getAllFieldNames($filters, $sorting);
        $aliasMapping=self::mapAliasFromFilters($alias, $fieldNames);
        
        foreach ($aliasMapping as $path=>$joinAlias) {
            if (!empty($path)) {
                list($attrPath, $attrName)=self::getAttributePathAndName($path);
                if (empty($attrPath)) {
                    $qb->leftJoin($alias . '.' . $path, $joinAlias);
                } else {
                    $qb->leftJoin($aliasMapping[$attrPath] . '.' . $attrName, $joinAlias);
                }
            }
        }
        
        return $aliasMapping;
    }
    
    
    
    /**
     * 
     * @param string $alias Alias de la entidad principal
     * @param array $fieldNames Nombres completos de los campos
     * @return array
     * @throws \InvalidArgumentException
     */
    public static function mapAliasFromFilters($alias, $fieldNames) {
        $aliasMapping=array(''=>$alias);
        
        foreach ($fieldNames as $fieldName) {
            list($attrPath, $attrName)=self::getAttributePathAndName($fieldName);
            if (!array_key_exists($attrPath, $aliasMapping)) {
                $pathArray=preg_split('/\./', $attrPath);

                if (count($pathArray)>0) {
                    $tmpPath=$pathArray[0];

                    $i=0; $count=count($pathArray);
                    while (true) {
                        if (!array_key_exists($tmpPath, $aliasMapping)) {
                            $aliasMapping[$tmpPath]=$alias.(count($aliasMapping));
                        }
                        $i++;
                        if (array_key_exists($i, $pathArray)) {
                            $tmpPath.='.'.$pathArray[$i];
                        } else {
                            break;
                        }
                    }
                }
            }
        }
        return $aliasMapping;
    }
    
    /**
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param array $aliasMapping
     * @param array $filters Array de SearchFilter
     * @throws \InvalidArgumentException
     */
    public static function addQueryFilter($qb, $aliasMapping, $filters) {
        foreach ($filters as $searchFilter) {
            if ($searchFilter instanceof SearchFilter) {
                $qb->andWhere(self::parseFilterToQueryExpression($qb, $aliasMapping, $searchFilter));
            } else {
                throw new \InvalidArgumentException('Los filtros deben ser instancias de "SearchFilter"');
            }
        }
    }
    
    /**
     * 
     * @param type $attr
     * @return array
     */
    public static function getAttributePathAndName($attr) {
        $attrName=substr(strrchr($attr, '.'), 1);
        if (false === $attrName) {
            return array('', $attr);
        }
        $attrPath=substr($attr, 0, strlen($attr)-strlen($attrName)-1);
        return array($attrPath, $attrName);
    }
    
    /**
     * 
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param array $aliasMapping Mapeo de alias con atributo de filtro (alias de los joins)
     * @param SearchFilter $filter
     * @return \Doctrine\ORM\Query\Expr
     */
    public static function parseFilterToQueryExpression($qb, $aliasMapping, $filter) {
        $result=null;
        $dc=$filter->getComparator();
        $exp=$qb->expr();
        
        list($attrPath, $attrName)=self::getAttributePathAndName($filter->getFieldName());
        $fieldName=$aliasMapping[$attrPath] . '.' . $attrName;
        
        $value=$filter->getValue();
        if ('string'===gettype($value)) {
            if (SearchFilter::DATACOMPARISON_LIKE === $dc) {
                $value='%'.$value.'%';
            }
        }
        $literalValue=$exp->literal($value);
        
        if (SearchFilter::DATACOMPARISON_EQ === $dc) {
            $result=$exp->eq($fieldName, $literalValue);
        } else if (SearchFilter::DATACOMPARISON_NOTEQ === $dc) {
            $result=$exp->neq($fieldName, $literalValue);
        } else if (SearchFilter::DATACOMPARISON_GT === $dc) {
            $result=$exp->gt($fieldName, $literalValue);
        } else if (SearchFilter::DATACOMPARISON_GTE === $dc) {
            $result=$exp->gte($fieldName, $literalValue);
        } else if (SearchFilter::DATACOMPARISON_LT === $dc) {
            $result=$exp->lt($fieldName, $literalValue);
        } else if (SearchFilter::DATACOMPARISON_LTE === $dc) {
            $result=$exp->lte($fieldName, $literalValue);
        } else if (SearchFilter::DATACOMPARISON_ISNULL === $dc) {
            $result=$exp->isNull($fieldName);
        } else if (SearchFilter::DATACOMPARISON_ISNOTNULL === $dc) {
            $result=$exp->isNotNull($fieldName);
        } else if (SearchFilter::DATACOMPARISON_IN === $dc) {
            $result=$exp->in($fieldName, $literalValue);
        } else if (SearchFilter::DATACOMPARISON_NOTIN === $dc) {
            $result=$exp->notIn($fieldName, $literalValue);
        } else if (SearchFilter::DATACOMPARISON_LIKE === $dc) {
            $result=$exp->like($fieldName, $literalValue);
        } else if (SearchFilter::DATACOMPARISON_NOTLIKE === $dc) {
            $result=$exp->notLike($fieldName, $literalValue);
        }
        
        return $result;
    }
    
    /**
     * 
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param array $aliasMapping
     * @param array $sorting Array de Sort
     */
    public static function addQuerySort($qb, $aliasMapping, $sorting) {
        $orderByExpr=new \Doctrine\ORM\Query\Expr\OrderBy();
        foreach ($sorting as $sort) {
            if ($sort instanceof Sort) {
                if ('ASC' === $sort->getOrderDirection()
                        || 'DESC' === $sort->getOrderDirection()) {
//                    $orderings[$alias.'.'.$sort->getFieldName()]=$sort->getOrderDirection();
                    list($attrPath, $attrName)=self::getAttributePathAndName($sort->getFieldName());
                    $fieldName=$aliasMapping[$attrPath] . '.' . $attrName;
                    $orderByExpr->add($fieldName, $sort->getOrderDirection());
                }
            } else {
                throw new \InvalidArgumentException('Los ordenamientos deben ser instancias de "Sort"');
            }
        }
        $qb->orderBy($orderByExpr);
    }
    
    /**
     * 
     * @param \Doctrine\ORM\QueryBuilder $qb
     * @param integer $pageNumber
     * @param integer $pageSize
     */
    public static function paginateQuery($qb, $pageNumber, $pageSize) {
        $qb->setFirstResult(($pageNumber-1)*$pageSize)
                ->setMaxResults($pageSize);
    }
    
    /**
     * 
     * @param \Doctrine\ORM\QueryBuilder $qb
     */
    public static function unpaginateQuery($qb) {
        $qb->setFirstResult(null)
                ->setMaxResults(null);
    }
}
