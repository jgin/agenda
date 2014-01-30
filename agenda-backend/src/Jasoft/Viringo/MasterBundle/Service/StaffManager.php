<?php

namespace Jasoft\Viringo\MasterBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * Description of StaffManager
 *
 * @author lvercelli
 * 
 * @DI\Service(id="jasoft_viringo_master.manager.staff", parent="jasoft_viringo_master.manager.abstract")
 */
class StaffManager extends MasterAbstractManager {
    
    function __construct(\Doctrine\ORM\EntityManager $entityManager) {
        parent::__construct($entityManager, 'JasoftViringoMasterBundle:Staff');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\MasterBundle\Repository\StaffRepository
     */
    public function getRepository() {
        return parent::getRepository();
    }
    
    /*
     * @param string $login
     * @return \Jasoft\Viringo\MasterBundle\Entity\Staff
     */
    public function findStaffByLogin($login){
        return $this->getRepository()->findOneByLogin($login);
    }
    
    
}
