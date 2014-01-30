<?php

namespace Jasoft\Viringo\CoreBundle\Manager;

/**
 * Description of SystemUserManager
 *
 * @author gin
 */
class SystemUserManager extends AbstractManager {
    
    const SUPER_ADMIN_USER_NAME='sa';
    
    /**
     *
     * @var SystemUserTypeManager
     */
    private $systemUserTypeManager;
    
    /**
     *
     * @var SystemSecurityGroupManager
     */
    private $systemSecurityGroupManager;
    
    /**
     *
     * @var SystemSecurityUserGroupManager
     */
    private $systemSecurityUserGroupManager;
    
    
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    function __construct($entityManager) {
        parent::__construct($entityManager, 'JasoftViringoCoreBundle:SystemUser');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Repository\SystemUserRepository
     */
    public function getRepository() {
        return parent::getRepository();
    }
    
//    private function addIgnoreHiddenFilter(&$filters) {
//        $filters[]=\Jasoft\Viringo\CoreBundle\Repository\Util\SearchFilter::createNotEqFilter('hidden', true);
//        $filters[]=\Jasoft\Viringo\CoreBundle\Repository\Util\SearchFilter::createIsNullFilter('hidden');
//    }

    public function findPage($active = true, $filters = null, $sorting = null, $pageNumber = null, $pageSize = null) {
//        $this->addIgnoreHiddenFilter($filters);
        return parent::findPage($active, $filters, $sorting, $pageNumber, $pageSize);
    }

    public function select($active = true, $filters = null, $sorting = null) {
//        $this->addIgnoreHiddenFilter($filters);
        return parent::select($active, $filters, $sorting);
    }

    
    /**
     * 
     * @param type $username
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemUser
     */
    public function getSystemUserByName($username) {
        try {
            return $this->getRepository()->findOneBy(array('username'=>$username));
        } catch (\Doctrine\ORM\NoResultException $nre) {
            return null;
        }
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemUser $entity
     * @return type
     */
    public function register($entity) {
        $masterSystemUserType=$this->systemUserTypeManager->getPersisted(SystemUserTypeManager::USER_TYPE_MASTER);
        
        $ut=$entity->getUserType();
        if (empty($ut)) {
            $entity->setUserType($masterSystemUserType);
        }
        
        $result=parent::register($entity);
        return $result;
    }
    
    /**
     * 
     * @param type $systemUser
     */
    public function verifyDuplicate($systemUser) {
        
    }
    
    public function registerSuperAdmin() {
        if (!$this->getSystemUserByName(self::SUPER_ADMIN_USER_NAME)) {
            $systemUser=new \Jasoft\Viringo\CoreBundle\Entity\SystemUser();
            $systemUser->setUsername(self::SUPER_ADMIN_USER_NAME);
            $this->registerAndFlush($systemUser);
        }
    }

    /**
     * 
     * @param integer $systemUserId
     * @return array Array de integers
     */
    public function listSystemSecurityGroupMembership($systemUserId) {
        /* @var $systemUser \Jasoft\Viringo\CoreBundle\Entity\SystemUser */
        $systemUser=$this->findById($systemUserId);
        $result=array();
        /* @var $sg \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityUserGroup */
        foreach ($systemUser->getSecurityGroups() as $sg) {
            if ($sg->isActive()) {
                $result[]=$sg->getGroup()->getId();
            }
        }
        return $result;
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemUser $systemUser
     * @param array $groupIds Id de los grupos a asignar
     */
    public function setSystemUserGroups($systemUser, array $groupIds) {
        /* @var $sg \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityUserGroup */
        foreach ($systemUser->getSecurityGroups() as $sg) {
            $pos=array_search($sg->getGroup()->getId(), $groupIds);
            if (false===$pos) {
                $sg->setActive(false);
            } else {
                $sg->setActive(true);
                unset($groupIds[$pos]);
            }
        }
        
        foreach ($groupIds as $groupId) {
            $systemSecurityUserGroupMembership=$this->systemSecurityUserGroupManager
                    ->getPersisted($systemUser, $this->systemSecurityGroupManager->findById($groupId));
            $systemUser->addSecurityGroup($systemSecurityUserGroupMembership);
        }
        $this->updateAndFlush($systemUser);
    }
    
    /**
     * 
     * @return SystemUserTypeManager
     */
    public function getSystemUserTypeManager() {
        return $this->systemUserTypeManager;
    }

    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Manager\SystemUserTypeManager $systemUserTypeManager
     */
    public function setSystemUserTypeManager(SystemUserTypeManager $systemUserTypeManager) {
        $this->systemUserTypeManager = $systemUserTypeManager;
    }

    public function getSystemSecurityGroupManager() {
        return $this->systemSecurityGroupManager;
    }

    public function setSystemSecurityGroupManager(SystemSecurityGroupManager $systemSecurityGroupManager) {
        $this->systemSecurityGroupManager = $systemSecurityGroupManager;
    }

    public function getSystemSecurityUserGroupManager() {
        return $this->systemSecurityUserGroupManager;
    }

    public function setSystemSecurityUserGroupManager(SystemSecurityUserGroupManager $systemSecurityUserGroupManager) {
        $this->systemSecurityUserGroupManager = $systemSecurityUserGroupManager;
    }

}
