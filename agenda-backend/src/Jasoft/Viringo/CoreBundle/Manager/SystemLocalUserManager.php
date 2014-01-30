<?php

namespace Jasoft\Viringo\CoreBundle\Manager;

/**
 * Description of SystemLocalUserManager
 *
 * @author gin
 */
class SystemLocalUserManager extends AbstractManager {
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    function __construct($entityManager) {
        parent::__construct($entityManager, 'JasoftViringoCoreBundle:SystemLocalUser');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Repository\SystemLocalUserRepository
     */
    public function getRepository() {
        return parent::getRepository();
    }

    
    /**
     * 
     * @param type $usename
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemLocalUser
     */
    public function getSystemLocalUserByName($usename) {
        return $this->getRepository()->findOneBy(array('username'=>$usename));
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemLocalUser $entity
     * @return type
     */
    public function register($entity) {
        $masterSystemLocalUserType=$this->systemUserTypeManager->getPersisted(SystemLocalUserTypeManager::USER_TYPE_MASTER);
        $entity->setUserType($masterSystemLocalUserType);
        
        $result=parent::register($entity);
        return $result;
    }
    
    /**
     * 
     * @param type $systemUser
     */
    public function verifyDuplicate($systemUser) {
        
    }

    /**
     * 
     * @return SystemLocalUserTypeManager
     */
    public function getSystemLocalUserTypeManager() {
        return $this->systemUserTypeManager;
    }

    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Service\SystemLocalUserTypeManager $systemUserTypeManager
     */
    public function setSystemLocalUserTypeManager(SystemLocalUserTypeManager $systemUserTypeManager) {
        $this->systemUserTypeManager = $systemUserTypeManager;
    }

}
