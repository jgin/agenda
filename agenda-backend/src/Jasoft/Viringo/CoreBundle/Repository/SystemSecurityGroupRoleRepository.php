<?php

namespace Jasoft\Viringo\CoreBundle\Repository;


/**
 * 
 */
class SystemSecurityGroupRoleRepository extends \Jasoft\Viringo\CoreBundle\Repository\EntityRepository
{
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup $systemSecurityGroup
     */
    public function resetAllSecurityRolesOfGroup($systemSecurityGroup) {
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb
            ->update($this->getEntityName(), 'e')
            ->set('e.active', $qb->expr()->literal(false))
            ->where($qb->expr()->eq('e.group', $systemSecurityGroup->getId()))
        ;
        $qb->getQuery()->execute();
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup $systemSecurityGroup
     * @return integer[]
     */
    public function getAllSecurityRolesIdsOfGroup($systemSecurityGroup) {
        $qb=$this->createQueryBuilder('e');
        $qb
            ->select('r.id')
            ->join('e.group', 'g')
            ->join('e.role', 'r')
            ->where($qb->expr()->eq('g.id', $systemSecurityGroup->getId()))
        ;
        return $qb->getQuery()->getScalarResult();
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup $systemSecurityGroup
     * @param array $roleIds
     */
    public function activateSecurityRolesOf($systemSecurityGroup, array $roleIds) {
        $qb=$this->getEntityManager()->createQueryBuilder();
        $qb
            ->update($this->getEntityName(), 'e')
            ->set('e.active', $qb->expr()->literal(true))
            ->where($qb->expr()->eq('e.group', $systemSecurityGroup->getId()))
            ->andWhere($qb->expr()->in('e.role', $roleIds))
        ;
        $qb->getQuery()->execute();
    }
}
