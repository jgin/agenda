<?php

namespace Jasoft\Viringo\CoreBundle\Repository;


/**
 * SystemSecurityEntityRoleRepository
 *
 */
class SystemSecurityEntityRoleRepository extends \Jasoft\Viringo\CoreBundle\Repository\EntityRepository
{
    /**
     * 
     * @param string $entityName
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityEntityRole
     */
    public function getByEntityName($entityName) {
        $qb=$this->createQueryBuilder('sser');
        $literalValue=$qb->expr()->literal($entityName);
        $qb
            ->join('sser.systemEntity', 'ent')
            ->where($qb->expr()->eq('ent.name', $literalValue))
        ;
        $result=$qb->getQuery()->getSingleResult();
        return $result;
    }
}
