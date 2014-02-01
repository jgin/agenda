<?php

namespace Jasoft\Viringo\CoreBundle\Manager;

/**
 * Description of SystemSecurityRoleManager
 *
 * @author gin
 */
class SystemSecurityRoleManager extends \Jasoft\Viringo\CoreBundle\Manager\AbstractManager {
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    function __construct($entityManager) {
        parent::__construct($entityManager, 'JasoftViringoCoreBundle:SystemSecurityRole');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Repository\SystemSecurityRoleRepository
     */
    public function getRepository() {
        return parent::getRepository();
    }

    /**
     * 
     * @param string $roleName
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole
     */
    public function getPersisted($roleName) {
        $systemSecurityRole=$this->getRepository()->findOneByRoleName($roleName);
        if (empty($systemSecurityRole)) {
            $systemSecurityRole=new \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole();
            $systemSecurityRole->setRoleName($roleName);
            $this->registerAndFlush($systemSecurityRole);
        }
        return $systemSecurityRole;
    }
    
}
