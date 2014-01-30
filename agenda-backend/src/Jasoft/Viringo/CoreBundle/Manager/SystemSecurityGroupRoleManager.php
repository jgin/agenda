<?php

namespace Jasoft\Viringo\CoreBundle\Manager;

/**
 * @author lvercelli
 */
class SystemSecurityGroupRoleManager extends AbstractManager {
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    function __construct($entityManager) {
        parent::__construct($entityManager, 'JasoftViringoCoreBundle:SystemSecurityGroupRole');
    }
    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Repository\SystemSecurityGroupRoleRepository
     */
    public function getRepository() {
        return parent::getRepository();
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup $systemSecurityGroup
     */
    public function resetAllSecurityRolesOfGroup($systemSecurityGroup) {
        $this->getRepository()->resetAllSecurityRolesOfGroup($systemSecurityGroup);
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup $systemSecurityGroup
     */
    public function getAllSecurityRolesIdsOfGroup($systemSecurityGroup) {
        $data=$this->getRepository()->getAllSecurityRolesIdsOfGroup($systemSecurityGroup);
        $result=array();
        foreach ($data as $row) {
            $result[]=$row['id'];
        }
        return $result;
    }

    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup $systemSecurityGroup
     * @param array $roleIds
     */
    public function activateSecurityRolesOf($systemSecurityGroup, array $roleIds) {
        $this->getRepository()->activateSecurityRolesOf($systemSecurityGroup, $roleIds);
    }

//
//    
//    /**
//     * 
//     * @param type $usename
//     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup
//     */
//    public function getSystemSecurityGroupByName($usename) {
//        return $this->getRepository()->findOneBy(array('username'=>$usename));
//    }
//    
}
