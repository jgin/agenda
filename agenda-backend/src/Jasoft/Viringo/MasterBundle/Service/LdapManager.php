<?php

namespace Jasoft\Viringo\MasterBundle\Service;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * Description of LdapManager
 *
 * @author lvercelli
 * 
 * @DI\Service(id="jasoft_viringo_master.manager.ldap", parent="jasoft_viringo_master.manager.abstract")
 */
class LdapManager extends MasterAbstractManager {
    
    function __construct(\Doctrine\ORM\EntityManager $entityManager) {
        parent::__construct($entityManager, 'JasoftViringoMasterBundle:Ldap');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\MasterBundle\Repository\LdapRepository
     */
    public function getRepository() {
        return parent::getRepository();
    }
    
    /*
     * @param string $login
     * @return \Jasoft\Viringo\MasterBundle\Entity\Ldap
     */
    public function findLdapByStaffLogin($login){
        return $this->getRepository()->findByStaffLogin($login);
    }
    
}
