<?php

namespace Jasoft\Viringo\MasterBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * Description of CompanyManager
 *
 * @author lvercelli
 * 
 * @DI\Service(id="jasoft_viringo_master.manager.company", parent="jasoft_viringo_master.manager.abstract")
 */
class CompanyManager extends MasterAbstractManager {
    
    function __construct(\Doctrine\ORM\EntityManager $entityManager) {
        parent::__construct($entityManager, 'JasoftViringoMasterBundle:Company');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\MasterBundle\Repository\CompanyRepository
     */
    public function getRepository() {
        return parent::getRepository();
    }
    
    /*
     * @param string $query
     * @return DataPage
     */
    public function findCompanyByPattern($pageNumber,$pageSize,$query){
        return $this->getRepository()->findCompanyByPattern($pageNumber,$pageSize,"%".$query."%");
    }
    
    
}
