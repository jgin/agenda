<?php

namespace Jasoft\Viringo\CoreBundle\Repository;

/**
 * UserTypeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SystemUserTypeRepository extends \Jasoft\Viringo\CoreBundle\Repository\EntityRepository
{
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemUserType $entity
     * @return boolean
     */
    public function exists($entity) {
        $qb=$this->createQueryBuilder('e');
        $qb->select('count(e)')
                ->where('e.name=:name')
                ->setParameter('name', $entity->getName());
        return ($qb->getQuery()->getSingleScalarResult()>0);
    }
    
}
