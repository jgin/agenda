<?php

namespace Jasoft\Viringo\CoreBundle\Manager;

/**
 * @author lvercelli
 */
class SystemSecurityGroupManager extends \Jasoft\Viringo\CoreBundle\Manager\AbstractManager {
    
    /**
     *
     * @var SystemSecurityGroupRoleManager
     */
    private $systemSecurityGroupRoleManager;
    
    /**
     *
     * @var SystemSecurityRoleManager
     */
    private $systemSecurityRoleManager;
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    function __construct($entityManager) {
        parent::__construct($entityManager, 'JasoftViringoCoreBundle:SystemSecurityGroup');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Repository\SystemSecurityGroupRepository
     */
    public function getRepository() {
        return parent::getRepository();
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup $systemSecurityGroup
     * @throws \Jasoft\Viringo\CoreBundle\Exception\DuplicateEntityException
     */
    public function validateDuplicate($systemSecurityGroup, $exclude=true) {
        /* @var $found \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup */
        $found=$this->getRepository()->findOneByGroupName($systemSecurityGroup->getGroupName());
        if (empty($found)) { return; }
        if (!$exclude && $systemSecurityGroup->getId()==$found->getId()) { return; }
        throw new \Jasoft\Viringo\CoreBundle\Exception\DuplicateEntityException('No se puede registrar este grupo porque ya existe.');
    }
    
    public function register($entity) {
        $this->validateDuplicate($entity);
        return parent::register($entity);
    }

    public function update($entity) {
        $this->validateDuplicate($entity, false);
        return parent::update($entity);
    }

    /**
     * 
     * @param string $groupName
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup
     */
    public function getByName($groupName) {
        return $this->getRepository()->findOneByGroupName($groupName);
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Util\PageRequestData $pageRequestData
     * @return \Jasoft\Viringo\CoreBundle\Util\DataPage
     */
    public function findSecurityItemPage($pageRequestData, $query=null) {
        if (!empty($query)) {
            $filters=$pageRequestData->getFilters();
            $filters[]=\Jasoft\Viringo\CoreBundle\Repository\Util\SearchFilter::createLikeFilter('groupName', $query);
            $pageRequestData->setFilters($filters);
        }
        
        $page=$this->findPageFrom($pageRequestData);
        $result=array();
        /* @var $ssg \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup */
        foreach ($page->getData() as $ssg) {
            $ssi=new Domain\SystemSecurityItem();
            $ssi
                ->setId($ssg->getId())
                ->setName($ssg->getGroupName())
            ;
            $result[]=$ssi;
        }
        $page->setData($result);

        return $page;
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroup $systemSecurityGroup
     * @param integer[] $roles
     */
    public function saveGrantedSecurityGroupRoles($systemSecurityGroup, $roles) {
        $this->getSystemSecurityGroupRoleManager()->resetAllSecurityRolesOfGroup($systemSecurityGroup);
        if (is_array($roles)) {
            $registeredIds=$this->getSystemSecurityGroupRoleManager()->getAllOrderedSecurityRolesIdsOfGroup($systemSecurityGroup);
//            sort($registeredIds);
//            sort($roles);
            
            $toInsert=array();
            $toActivate=array();
            foreach ($roles as $regId) {
                $pos=\Jasoft\Viringo\CoreBundle\Util\ArrayUtil::binarySearch($registeredIds, $regId, \Jasoft\Viringo\CoreBundle\Util\ArrayUtil::COMPARE_NUMBER);
                if (isset($pos)) {
                    $toActivate[]=$regId;
                } else {
                    $toInsert[]=$regId;
                }
            }
            
            if (count($toActivate)>0) {
                $this->getSystemSecurityGroupRoleManager()->activateSecurityRolesOf($systemSecurityGroup, $toActivate);
            }
            
            if (count($toInsert)>0) {
                foreach ($toInsert as $roleId) {
                    $ssgr=new \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityGroupRole();
                    $systemSecRole=$this->getSystemSecurityRoleManager()->findById($roleId);
                    $ssgr
                            ->setGroup($systemSecurityGroup)
                            ->setRole($systemSecRole)
                    ;
                    $this->getSystemSecurityGroupRoleManager()->register($ssgr);
                }
            }
        }
        
        $this->flushEntityManager();
    }
    
    

    public function getSystemSecurityGroupRoleManager() {
        return $this->systemSecurityGroupRoleManager;
    }

    public function setSystemSecurityGroupRoleManager(SystemSecurityGroupRoleManager $systemSecurityGroupRoleManager) {
        $this->systemSecurityGroupRoleManager = $systemSecurityGroupRoleManager;
    }

    public function getSystemSecurityRoleManager() {
        return $this->systemSecurityRoleManager;
    }

    public function setSystemSecurityRoleManager(SystemSecurityRoleManager $systemSecurityRoleManager) {
        $this->systemSecurityRoleManager = $systemSecurityRoleManager;
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
