<?php

namespace Jasoft\Viringo\MasterBundle\Repository;

/**
 * @author lvercelli
 */
class LdapRepository extends \Jasoft\Viringo\CoreBundle\Repository\EntityRepository
{
    /**
     * 
     * @param string $login
     * @return \Jasoft\Viringo\MasterBundle\Entity\Ldap
     */
    public function findByStaffLogin($login) {
        $qb=$this->createQueryBuilder('e');
        $qb
                ->join('e.staff', 's')
                ->where('s.login=?0')
                ->setParameters(array($login))
        ;
        try {
            return $qb->getQuery()->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $nre) {
            return null;
        }
    }
}
