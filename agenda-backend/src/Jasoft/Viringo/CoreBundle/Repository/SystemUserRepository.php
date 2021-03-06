<?php

namespace Jasoft\Viringo\CoreBundle\Repository;
use Jasoft\Viringo\CoreBundle\Repository\Util\QueryBuilderUtil;


/**
 * SystemUserRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SystemUserRepository extends \Jasoft\Viringo\CoreBundle\Repository\EntityRepository
{
    public function findData($filters = null, $sorting = null, $ignoreHiddens=true) {
        $qb=$this->createQueryBuilder('e');
        if ($ignoreHiddens) {
            $this->addIgnoreHiddenPredicate($qb, 'e');
        }
        
        QueryBuilderUtil::addDefaultQueryCriteria($qb, 'e', $filters, $sorting);
        
        $data=$qb->getQuery()->getResult();
        
        return $data;
    }

    public function findPage($filters = null, $sorting = null, $pageNumber = null, $pageSize = null, $ignoreHiddens=true) {
        $qb=$this->createQueryBuilder('e');
        if ($ignoreHiddens) {
            $this->addIgnoreHiddenPredicate($qb, 'e');
        }
        
        QueryBuilderUtil::addDefaultQueryCriteria($qb, 'e', $filters, $sorting);
        QueryBuilderUtil::paginateQuery($qb, $pageNumber, $pageSize);
        $data=$qb->getQuery()->getResult();
        
        $totalRecords=0;
        if (!empty($data) || count($data)>0) {
            $qb
                ->select($qb->expr()->count('e'))
                ->resetDQLPart('orderBy')
            ;
            
            QueryBuilderUtil::unpaginateQuery($qb);
            $totalRecords=$qb->getQuery()->getSingleScalarResult();
        }
        
        return new \Jasoft\Viringo\CoreBundle\Util\DataPage($data, $totalRecords);
    }

    /**
     * 
     * @param \Doctrine\ORM\QueryBuilder $qb
     */
    private static function addIgnoreHiddenPredicate($qb, $alias) {
        $qb->where("not $alias.hidden = true or $alias.hidden is null");
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemUser $user
     */
    public function exists($user) {
        $qb=$this->createQueryBuilder('u');
        $qb->select('count(u)')
            ->where('u.username = ?1')
            ->setParameters(array($user->getUsername()));
        return ($qb->getQuery()->getSingleScalarResult()>0);
    }
    
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemUser $systemUser
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole[]
     */
    public function getAllOrderedSecurityRolesOf($systemUser) {
        $dql='select distinct ssr '
            .   'from JasoftViringoCoreBundle:SystemSecurityRole ssr '
            .       'where ssr in ('
            .           'select r '
            .               'from JasoftViringoCoreBundle:SystemSecurityGroupRole ssgr '
            .                   'join ssgr.role r '
            .                   'join ssgr.group g '
            .               'where g in ('
            .                   'select userGrp '
            .                       'from JasoftViringoCoreBundle:SystemSecurityUserGroup ssug '
            .                           'join ssug.group userGrp '
            .                       'where ssug.user = :systemUser '
                                    .   'and ssug.active = true '
            .               ') '
                            . 'and ssgr.active = true '
            .       ') '
            .   'order by ssr.roleName asc'
        ;

        $query=$this->getEntityManager()->createQuery($dql);
        $query->setParameter('systemUser', $systemUser);
        return $query->getResult();
    }
    
}
