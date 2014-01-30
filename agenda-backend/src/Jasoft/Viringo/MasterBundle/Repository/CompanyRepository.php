<?php

namespace Jasoft\Viringo\MasterBundle\Repository;

/**
 * @author lvercelli
 */
class CompanyRepository extends \Jasoft\Viringo\CoreBundle\Repository\EntityRepository
{
    /**
     * Lista por Nombre de compañia
     * @param string $query cadena ingresada para la busqueda
     * @return DataPage
     */
    public function findCompanyByPattern($pageNumber,$pageSize,$query) {
        $qb=$this->createQueryBuilder('c');
        $qb ->where('c.companyName LIKE :query')
            ->setFirstResult(($pageNumber-1)*$pageSize)
            ->setMaxResults($pageSize)
            ->setParameter('query',$query);
        $data=$qb->getQuery()->getResult();
        $qb->select($qb->expr()->count('c'));
        $qb->setFirstResult(null)->setMaxResults(null);
        $totalRecords=$qb->getQuery()->getSingleScalarResult();
        return new \Jasoft\Viringo\CoreBundle\Util\DataPage($data, $totalRecords);
    }  
}
