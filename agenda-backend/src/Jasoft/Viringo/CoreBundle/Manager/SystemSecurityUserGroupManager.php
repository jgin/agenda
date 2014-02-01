<?php

namespace Jasoft\Viringo\CoreBundle\Manager;

/**
 * Description of SystemSecurityUserGroupManager
 *
 * @author gin
 */
class SystemSecurityUserGroupManager extends \Jasoft\Viringo\CoreBundle\Manager\AbstractManager {
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    function __construct($entityManager) {
        parent::__construct($entityManager, 'JasoftViringoCoreBundle:SystemSecurityUserGroup');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Repository\SystemSecurityUserGroupRepository
     */
    public function getRepository() {
        return parent::getRepository();
    }

    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemUser $systemUser
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup $systemSecurityGroup
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityUserGroup
     */
    public function getPersisted($systemUser, $systemSecurityGroup) {
        $ssug=$this->getRepository()->findOneBy(array('user'=>$systemUser, 'group'=>$systemSecurityGroup));
        if (empty($ssug)) {
            $ssug=new \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityUserGroup();
            $ssug
                    ->setUser($systemUser)
                    ->setGroup($systemSecurityGroup)
            ;
            $this->register($ssug);
        }
        return $ssug;
    }

}
