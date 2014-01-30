<?php

namespace Jasoft\Viringo\CoreBundle\Repository;

/**
 * EntityRepository
 *
 */
class EntityRepository extends \Doctrine\ORM\EntityRepository
{
    
    public function findData($filters=null, $sorting=null) {
        $qb=$this->createQueryBuilder('e');
        Util\QueryBuilderUtil::addDefaultQueryCriteria($qb, 'e', $filters, $sorting);
        
        $data=$qb->getQuery()->getResult();
        
        return $data;
    }
    
    public function findPage($filters=null, $sorting=null, $pageNumber=null, $pageSize=null) {
        $qb=$this->createQueryBuilder('e');
        
        Util\QueryBuilderUtil::addDefaultQueryCriteria($qb, 'e', $filters, $sorting);
        Util\QueryBuilderUtil::paginateQuery($qb, $pageNumber, $pageSize);
        $data=$qb->getQuery()->getResult();
        
        $totalRecords=0;
        if (!empty($data) || count($data)>0) {
            $qb
                ->select($qb->expr()->count('e'))
                ->resetDQLPart('orderBy')
            ;
            
            Util\QueryBuilderUtil::unpaginateQuery($qb);
            $totalRecords=$qb->getQuery()->getSingleScalarResult();
        }
        
        return new \Jasoft\Viringo\CoreBundle\Util\DataPage($data, $totalRecords);
    }

}
