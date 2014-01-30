<?php

namespace Jasoft\Viringo\CoreBundle\Manager;

/**
 * Description of SystemSecurityEntityRoleManager
 *
 * @author gin
 */
class SystemSecurityEntityRoleManager extends AbstractManager {
    
    private static $listRoleNameTemplate='ROLE_ENTITY_%s_LIST';
    private static $createRoleNameTemplate="ROLE_ENTITY_%s_CREATE";
    private static $updateRoleNameTemplate="ROLE_ENTITY_%s_UPDATE";
    private static $deleteRoleNameTemplate="ROLE_ENTITY_%s_DELETE";
    private static $exportRoleNameTemplate="ROLE_ENTITY_%s_EXPORT";
//    private static $viewRoleNameTemplate="ROLE_ENTITY_%s_VIEW";
    
    /**
     *
     * @var \Jasoft\Viringo\CoreBundle\Manager\SystemEntityManager
     */
    private $systemEntityManager;
    
    /**
     *
     * @var SystemSecurityRoleManager
     */
    private $systemSecurityRoleManager;
    
    /**
     *
     * @var SystemSecurityService
     */
    private $security;
    
    /**
     * 
     * @param \Doctrine\ORM\EntityManager $entityManager
     */
    function __construct($entityManager) {
        parent::__construct($entityManager, 'JasoftViringoCoreBundle:SystemSecurityEntityRole');
    }
    
    /**
     * 
     * @return \Jasoft\Viringo\CoreBundle\Repository\SystemSecurityEntityRoleRepository
     */
    public function getRepository() {
        return parent::getRepository();
    }

    /**
     * Registra todos los roles de seguridad por defecto de todas las entidades
     * del sistema registradas en la base de datos
     */
    public function registerDefaultSecurityRolesForAllEntities() {
        $systemEntityArray=$this->getSystemEntityManager()->select();
        
        /* @var $systemEntity \Jasoft\Viringo\CoreBundle\Entity\SystemEntity */
        foreach ($systemEntityArray as $systemEntity) {
            if (!$this->findBySystemEntity($systemEntity)) {
                $sser=$this->createNewSystemSecurityEntityRole($systemEntity->getName());
                $this->register($sser);
            }
        }
        
        $this->flushEntityManager();
    }
    
    /**
     * 
     * @param string $entityName
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityEntityRole
     */
    protected function createNewSystemSecurityEntityRole($entityName) {
        $systemSecurityEntityRole=new \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityEntityRole();
        $systemSecurityEntityRole
                ->setSystemEntity($this->systemEntityManager->getPersisted($entityName))
                ->setListRole($this->getSystemSecurityRoleForEntity(self::$listRoleNameTemplate, $entityName))
                ->setCreateRole($this->getSystemSecurityRoleForEntity(self::$createRoleNameTemplate, $entityName))
                ->setUpdateRole($this->getSystemSecurityRoleForEntity(self::$updateRoleNameTemplate, $entityName))
                ->setDeleteRole($this->getSystemSecurityRoleForEntity(self::$deleteRoleNameTemplate, $entityName))
                ->setExportRole($this->getSystemSecurityRoleForEntity(self::$exportRoleNameTemplate, $entityName))
        ;
        return $systemSecurityEntityRole;
    }
    
    /**
     * 
     * @param string $templateRoleName Stringa tratarse con la función sprintf
     * @param string $entityName
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole
     */
    protected function getSystemSecurityRoleForEntity($templateRoleName, $entityName) {
        $roleName=sprintf($templateRoleName, $entityName);
        return $this->systemSecurityRoleManager->getPersisted($roleName);
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemEntity $systemEntity
     * @return \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityEntityRole
     */
    public function findBySystemEntity($systemEntity) {
        return $this->getRepository()->findBySystemEntity($systemEntity);
    }
    
    /**
     * 
     * @param Domain\RoleCapable $roleCapable
     * @return Domain\GrantedSystemSecurityEntityRole[]
     */
    public function getVerifiedEntityRoles($roleCapable) {
        /* @var $result Domain\GrantedSystemSecurityEntityRole[] */
        $result=array();
        /* @var $allActiveSystemEntityRoles \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityEntityRole[] */
        $allActiveSystemEntityRoles=$this->select();
        foreach ($allActiveSystemEntityRoles as $sser) {
            if ($sser->getSystemEntity()->isActive()) {
                $result[]=$this->getGrantedSystemSecurityEntityRole($sser, $roleCapable);
            }
        }
        
        return $result;
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityEntityRole $systemSecurityEntityRole
     * @param Domain\RoleCapable $roleCapable
     * @return Domain\GrantedSystemSecurityEntityRole
     */
    private function getGrantedSystemSecurityEntityRole($systemSecurityEntityRole, $roleCapable) {
        $gsser=new Domain\GrantedSystemSecurityEntityRole();
        if ($systemSecurityEntityRole!=null && $systemSecurityEntityRole->isActive()) {
            $gsser->setTitle($systemSecurityEntityRole->getSystemEntity()->getCaption());
            $gsser
                ->setList($this->getGrantedSecurityRoleFrom($systemSecurityEntityRole->getListRole(), $roleCapable))
                ->setCreate($this->getGrantedSecurityRoleFrom($systemSecurityEntityRole->getCreateRole(), $roleCapable))
                ->setUpdate($this->getGrantedSecurityRoleFrom($systemSecurityEntityRole->getUpdateRole(), $roleCapable))
                ->setDelete($this->getGrantedSecurityRoleFrom($systemSecurityEntityRole->getDeleteRole(), $roleCapable))
                ->setExport($this->getGrantedSecurityRoleFrom($systemSecurityEntityRole->getExportRole(), $roleCapable))
            ;
        } else {
            $granted=new Domain\GrantedSystemSecurityRole(0, true);
            $gsser
                ->setList($granted)
                ->setCreate($granted)
                ->setUpdate($granted)
                ->setDelete($granted)
                ->setExport($granted)
            ;
        }
        return $gsser;
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityRole $systemSecurityRole
     * @param Domain\RoleCapable $roleCapable
     * @return Domain\GrantedSystemSecurityRole
     */
    private function getGrantedSecurityRoleFrom($systemSecurityRole, $roleCapable) {
        $gssr=new Domain\GrantedSystemSecurityRole();
        $gssr->setRoleId($systemSecurityRole->getId());
        $gssr->setGranted($this->security->itemHasRole($roleCapable, $systemSecurityRole->getRoleName()));
        return $gssr;
    }
    
    public function getSystemEntityManager() {
        return $this->systemEntityManager;
    }

    public function setSystemEntityManager(\Jasoft\Viringo\CoreBundle\Manager\SystemEntityManager $systemEntityManager) {
        $this->systemEntityManager = $systemEntityManager;
    }
    
    public function getSystemSecurityRoleManager() {
        return $this->systemSecurityRoleManager;
    }

    public function setSystemSecurityRoleManager(SystemSecurityRoleManager $systemSecurityRoleManager) {
        $this->systemSecurityRoleManager = $systemSecurityRoleManager;
    }

    public function getSecurity() {
        return $this->security;
    }

    public function setSecurity(SystemSecurityService $security) {
        $this->security = $security;
    }
}
