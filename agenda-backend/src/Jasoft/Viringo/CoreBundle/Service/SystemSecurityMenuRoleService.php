<?php

namespace Jasoft\Viringo\CoreBundle\Service;

/**
 * @author lvercelli
 */
class SystemSecurityMenuRoleService extends \Jasoft\Viringo\CoreBundle\Service\AbstractService {
    
    /**
     *
     * @var \Jasoft\Viringo\CoreBundle\Service\SystemMenuService
     */
    private $systemMenuService;
    
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
     * @param Domain\RoleCapable $roleCapable
     * @return Domain\GrantedSystemSecurityMenuRole
     */
    public function getVerifiedMenuRoles($roleCapable) {
        /* @var $rootMenu \Jasoft\Viringo\CoreBundle\Entity\SystemSecurityEntityRole[] */
        $rootMenu=$this->systemMenuService->getRootMenu();
        
        $result=$this->recursiveVerifySystemMenu($rootMenu, $roleCapable);
        
        return $result;
    }
    
    /**
     * 
     * @param \Jasoft\Viringo\CoreBundle\Entity\SystemMenu $systemMenu
     * @param Domain\RoleCapable $roleCapable
     * @return \Jasoft\Viringo\CoreBundle\Service\Domain\GrantedSystemSecurityMenuRole
     */
    private function recursiveVerifySystemMenu($systemMenu, $roleCapable) {
        $result=new Domain\GrantedSystemSecurityMenuRole();
        
        $result->setMenuTitle($systemMenu->getText());
        $roleName=$systemMenu->getRoleName();
        if (!empty($roleName)) {
            $ssr=$this->systemSecurityRoleManager->getPersisted($roleName);
            $result
                ->setRoleId($ssr->getId())
                ->setGranted($this->security->itemHasRole($roleCapable, $systemMenu->getRoleName()))
            ;
        } else {
            $result->setGranted(true);
        }
        $result
            ->setIconCls($systemMenu->getIconCls())
            ->setLeaf($systemMenu->isLeaf())
            ->setExpanded($systemMenu->isExpanded())
        ;
        $children=$systemMenu->getChildren();
        if (!empty($children)) {
            foreach ($children as $submenu) {
                $result->addChild($this->recursiveVerifySystemMenu($submenu, $roleCapable));
            }
        }
        
        return $result;
    }
    
    
    
    public function getSystemMenuService() {
        return $this->systemMenuService;
    }

    public function setSystemMenuService(\Jasoft\Viringo\CoreBundle\Service\SystemMenuService $systemMenuService) {
        $this->systemMenuService = $systemMenuService;
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
