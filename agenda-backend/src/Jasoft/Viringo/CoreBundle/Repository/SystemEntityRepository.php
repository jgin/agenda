<?php

namespace Jasoft\Viringo\CoreBundle\Repository;

/**
 * SystemEntityRepository
 */
class SystemEntityRepository extends EntityRepository
{
    public function resetAllEntities() {
        $qb=$this->createQueryBuilder('e');
        $qb
            ->update($this->getEntityName(), 'e')
            ->set('e.active', $qb->expr()->literal(false))
        ;
        $qb->getQuery()->execute();
    }
}
